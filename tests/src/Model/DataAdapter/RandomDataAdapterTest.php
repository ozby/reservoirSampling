<?php
use RG\Model\DataAdapter\AbstractDataAdapter;
use RG\Model\DataAdapter\DataAdapterInterface;
use RG\Model\DataAdapter\RandomDataAdapter;

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 01/02/16
 * Time: 11:16
 */
class RandomDataAdapterTest extends PHPUnit_Framework_TestCase
{
    /** @var int */
    private static $length;

    /** @var DataAdapterInterface */
    private static $adapter;

    public static function setUpBeforeClass()
    {
        self::$length = rand(3, 200);
        self::$adapter = AbstractDataAdapter::getAdapterInstance(
            RandomDataAdapter::NAME,
            self::$length
        );
    }

    public static function tearDownAfterClass()
    {
        self::$adapter = null;
    }

    /**
     * @throws Exception
     */
    public function testInitialization()
    {
        $this->assertTrue(self::$adapter instanceof RandomDataAdapter);
    }

    /**
     * @throws Exception
     */
    public function testGetSize()
    {
        $this->assertEquals(
            self::$adapter->getSize(),
            self::$length
        );
    }

}