<?php

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 31/01/16
 * Time: 13:03
 */
namespace RG\Model\DataAdapter;

use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDataAdapter implements DataAdapterInterface
{
    const OPTION_LENGTH = 'length';
    const OPTION_BASE_LENGTH = 'base_length';
    const OPTION_SIZE = 'size';
    const OPTION_STREAM = 'stream';

    protected $stream;
    protected $options;
    protected $size = 0;

    public function __construct($options)
    {
        $this->options = $options;
        $this->stream = null;

        $this->fetchData();
    }


    /**
     * @param string   $adapterName
     * @param int      $baseLength
     * @param resource $streamInput
     *
     * @return DataAdapterInterface
     * @throws \Exception
     */
    public static function getAdapterInstance(
        $adapterName,
        $baseLength = null,
        $streamInput = null
    ) {
        switch ($adapterName) {
            case StreamDataAdapter::NAME:
                if ($streamInput === null) {
                    $streamInput = STDIN;
                }

                return new StreamDataAdapter(
                    [StreamDataAdapter::OPTION_STREAM => $streamInput]
                );
                break;
            case RandomDataAdapter::NAME:
                return new RandomDataAdapter(
                    [RandomDataAdapter::OPTION_BASE_LENGTH => $baseLength]
                );
                break;
            case RemoteDataAdapter::NAME:
                return new RemoteDataAdapter(
                    [RemoteDataAdapter::OPTION_BASE_LENGTH => $baseLength]
                );

                break;
            default:
                throw new \Exception('Unknown Adapter : ' . $adapterName);
        }

    }

    /**
     * Create a new file on temp
     *
     * @return resource
     */
    protected function createNewStream()
    {
        $this->stream = tmpfile();

        return $this->stream;
    }

    /**
     * @return Resource
     */
    protected function getStream()
    {
        return $this->stream;
    }

    /**
     * @param Resource $stream
     *
     * @return Resource
     */
    protected function setStream($stream)
    {
        $this->stream = $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function printData(OutputInterface $output)
    {
        $stream = $this->getStream();
        rewind($stream);
        while (!feof($stream)) {
            $line = fread($stream, 1024);
            $output->write($line);
        }
        $output->write(PHP_EOL);

        return true;
    }

    abstract protected function fetchData();

    /**
     * {@inheritdoc}
     */
    public function getByte($byte)
    {
        $stream = $this->getStream();
        fseek($stream, $byte);

        $string = fread($stream, 6);
        $i = 1;
        while (!mb_check_encoding($string)) {
            if ($i > 6) {
                throw new \Exception('Charset error!');
            }
            fseek($stream, $byte - $i++);
            $string = fread($stream, 6);
        }

        return mb_substr($string, 0, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        if (!$this->size) {
            $streamMetaData = stream_get_meta_data($this->getStream());
            if (isset($streamMetaData['uri'])) {
                $this->size = filesize($streamMetaData['uri']);
            }
        }

        return $this->size;
    }
}