<?php
use RG\Model\DataAdapter\AbstractDataAdapter;
use RG\Model\DataAdapter\DataAdapterInterface;
use RG\Model\DataAdapter\StreamDataAdapter;

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 01/02/16
 * Time: 12:51
 */
class StreamDataAdapterTest extends PHPUnit_Framework_TestCase
{
    private static $testString;
    /** @var DataAdapterInterface */
    private static $adapter = null;
    /** @var Resource */
    private static $tmpStream = null;

    public static function setUpBeforeClass()
    {
        $testStrings
            = [
            'THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG',
            '{人口統計画像情報|千葉県|市原市}'
        ];
        self::$testString = $testStrings[rand(0, 1)];
        self::$tmpStream = tmpfile();
        fwrite(self::$tmpStream, self::$testString);
        rewind(self::$tmpStream);

        self::$adapter = AbstractDataAdapter::getAdapterInstance(
            StreamDataAdapter::NAME,
            null,
            self::$tmpStream
        );
    }

    public static function tearDownAfterClass()
    {
        self::$adapter = null;
        fclose(self::$tmpStream);
    }

    /**
     * @throws Exception
     */
    public function testInitialization()
    {
        $this->assertTrue(self::$adapter instanceof StreamDataAdapter);
    }

    /**
     * @throws Exception
     */
    public function testGetSize()
    {
        $this->assertEquals(
            self::$adapter->getSize(),
            strlen(self::$testString)
        );
    }
}