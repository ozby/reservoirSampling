<?php
/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 30/01/16
 * Time: 22:57
 */

namespace RG\Command;

use RG\Model\DataAdapter\RemoteDataAdapter;

class RemoteSamplerCommand extends AbstractSamplerCommand
{
    protected $configuration
        = [
            self::CONFIG_ENABLED_BASE_LENGTH  => true,
            self::CONFIG_ADAPTER_NAME  => RemoteDataAdapter::NAME,
            self::CONFIG_COMMAND_NAME  => 'remote',
            self::CONFIG_COMMAND_DESC  => 'Get random representative from a REST API',
        ];
}
