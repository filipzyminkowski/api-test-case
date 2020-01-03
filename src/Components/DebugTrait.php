<?php

namespace GlobeGroup\ApiTests\Components;

use Exception;

trait DebugTrait
{
    public function dump()
    {
        print_r($this->getResponseObject()->getContent(true));

        return $this;
    }
}
