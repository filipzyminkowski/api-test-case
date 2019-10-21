<?php

namespace GlobeGroup\ApiTests\Exception;

use Exception;

class NoConfigurationException extends Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
