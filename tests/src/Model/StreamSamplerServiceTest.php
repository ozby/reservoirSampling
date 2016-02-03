<?php
use RG\Model\DataAdapter\AbstractDataAdapter;
use RG\Model\DataAdapter\RandomDataAdapter;

/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 01/02/16
 * Time: 09:20
 */
class StreamSamplerServiceTest extends PHPUnit_Framework_TestCase
{
    public function testgetRandomSample()
    {
        $DataAdapter = $this->getMockBuilder(
            \RG\Model\DataAdapter\RandomDataAdapter::NAME
        )
            ->setConstructorArgs(
                array([RandomDataAdapter::OPTION_BASE_LENGTH => 4])
            )
            ->getMock();


        $DataAdapter->expects($this->any())
            ->method('getSize')
            ->will($this->returnValue(4));


        // Configure the stub.
        $DataAdapter->method('getByte')
            ->will(
                $this->onConsecutiveCalls(
                    'O',
                    'Z',
                    'B',
                    'Y'
                )
            );


        $streamSamplerService = new \RG\Model\StreamSamplerService();
        $this->assertEquals(
            'OZBY',
            $streamSamplerService->getRandomSample($DataAdapter, 4)
        );
    }

}
