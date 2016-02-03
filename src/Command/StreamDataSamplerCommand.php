<?php
/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 30/01/16
 * Time: 22:57
 */

namespace RG\Command;

use RG\Model\DataAdapter\StreamDataAdapter;

class StreamDataSamplerCommand extends AbstractSamplerCommand
{
    protected $configuration
        = [
            self::CONFIG_ENABLED_BASE_LENGTH  => false,
            self::CONFIG_ADAPTER_NAME  => StreamDataAdapter::NAME,
            self::CONFIG_COMMAND_NAME  => 'stream',
            self::CONFIG_COMMAND_DESC  => 'Get random representative from STDIN',
        ];
}
