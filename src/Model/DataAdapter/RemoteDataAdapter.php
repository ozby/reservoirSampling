<?php

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 31/01/16
 * Time: 12:55
 */
namespace RG\Model\DataAdapter;

class RemoteDataAdapter extends AbstractDataAdapter
    implements DataAdapterInterface
{
    const NAME = __CLASS__;

    /**
     * {@inheritdoc}
     */
    protected function fetchData()
    {
        if ($this->options[self::OPTION_BASE_LENGTH] > 20) {
            throw new \Exception(
                'Length can not be more than 20. (random.org restriction'
            );
        }

        $settings = [
            'num'        => 1,
            'len'        => $this->options[self::OPTION_BASE_LENGTH],
            'digits'     => 'off',
            'upperalpha' => 'on',
            'loweralpha' => 'off',
            'format'     => 'plain',
            'rnd'        => 'new'
        ];

        $source
            = 'https://www.random.org/strings/?' . http_build_query($settings);

        $stream = $this->createNewStream();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_WRITEFUNCTION,
            function ($ch, $string) use (&$stream) {
                $length = fwrite($stream, trim($string));

                return $length;
            }
        );
        curl_exec($ch);
        curl_close($ch);
        rewind($stream);

        $this->setStream($stream);

        return true;
    }
}