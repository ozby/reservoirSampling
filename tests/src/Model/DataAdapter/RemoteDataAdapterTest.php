<?php
use RG\Model\DataAdapter\AbstractDataAdapter;
use RG\Model\DataAdapter\DataAdapterInterface;
use RG\Model\DataAdapter\RemoteDataAdapter;

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 01/02/16
 * Time: 12:16
 */
class RemoteDataAdapterTest extends PHPUnit_Framework_TestCase
{
    /** @var int */
    private static $length;
    /** @var DataAdapterInterface */
    private static $adapter = null;

    public static function setUpBeforeClass()
    {
        self::$length = rand(3, 20);
        self::$adapter = AbstractDataAdapter::getAdapterInstance(
            RemoteDataAdapter::NAME,
            self::$length
        );
    }

    public static function tearDownAfterClass()
    {
        self::$adapter = NULL;
    }

    /**
     * @throws Exception
     */
    public function testInitialization()
    {
        $this->assertTrue(self::$adapter instanceof RemoteDataAdapter);
    }

    /**
     * @throws Exception
     */
    public function testFetchData()
    {
        $this->assertEquals(self::$adapter->getSize(), self::$length);
    }

    /**
     * @throws Exception
     */
    public function testGetSize()
    {
        $this->assertEquals(self::$adapter->getSize(), self::$length);
    }
}