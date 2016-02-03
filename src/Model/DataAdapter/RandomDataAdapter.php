<?php

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 31/01/16
 * Time: 12:55
 */
namespace RG\Model\DataAdapter;


class   RandomDataAdapter extends AbstractDataAdapter
    implements DataAdapterInterface
{
    const NAME = __CLASS__;

    /**
     * {@inheritdoc}
     */
    protected function fetchData()
    {
        $stream = $this->createNewStream();

        $size = $this->options[self::OPTION_BASE_LENGTH];
        for ($i = 0; $i < $size; $i++) {
            $randomLetter = rand(65, 90);
            fwrite($stream, chr($randomLetter));
        }
        rewind($stream);

        $this->setStream($stream);
    }

    public function getCreatedRandomBase()
    {

    }
}