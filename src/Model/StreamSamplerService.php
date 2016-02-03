<?php
/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 30/01/16
 * Time: 22:42
 */
namespace RG\Model;

use RG\Model\DataAdapter\DataAdapterInterface;

class StreamSamplerService
{

    /**
     * @param DataAdapterInterface $data
     * @param int                  $length
     *
     * @return string
     */
    public function getRandomSample(DataAdapterInterface $data, $length)
    {
        $sample = '';
        $maxByte = $data->getSize() - 1;
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = mt_rand(0, $maxByte);
            $sample .= $data->getByte($randomIndex);
        }

        return $sample;
    }
}