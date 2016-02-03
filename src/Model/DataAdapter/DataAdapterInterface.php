<?php

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 31/01/16
 * Time: 12:56
 */
namespace RG\Model\DataAdapter;

use Symfony\Component\Console\Output\OutputInterface;

interface DataAdapterInterface
{
    /**
     * Returns that byte from file
     *
     * @param int $byte
     *
     * @return mixed
     */
    function getByte($byte);

    /**
     * Size of the input
     *
     * @return mixed
     */
    function getSize();


    /**
     * Print data to console
     *
     * @param OutputInterface $output
     *
     * @return string
     */
    function printData(OutputInterface $output);

}