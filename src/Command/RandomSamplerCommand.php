<?php
/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 30/01/16
 * Time: 22:57
 */

namespace RG\Command;

use RG\Model\DataAdapter\RandomDataAdapter;

class RandomSamplerCommand extends AbstractSamplerCommand
{
    protected $configuration
        = [
            self::CONFIG_ENABLED_BASE_LENGTH  => true,
            self::CONFIG_ADAPTER_NAME  => RandomDataAdapter::NAME,
            self::CONFIG_COMMAND_NAME  => 'random',
            self::CONFIG_COMMAND_DESC  => 'Get random representative from random input within the language',
        ];
}
