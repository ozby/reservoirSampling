<?php

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 31/01/16
 * Time: 12:55
 */
namespace RG\Model\DataAdapter;

class StreamDataAdapter extends AbstractDataAdapter
    implements DataAdapterInterface
{
    const NAME = __CLASS__;

    /**
     * {@inheritdoc}
     */
    protected function fetchData()
    {
        $stream = $this->createNewStream();

        $sourceStream = $this->options[self::OPTION_STREAM];


        while (!feof($sourceStream)) {
            $line = trim(fread($this->options[self::OPTION_STREAM], 1024));
            if ($line) {
                fwrite($stream, $line);
            }
        }

        rewind($stream);
        $this->setStream($stream);

        return true;
    }
}