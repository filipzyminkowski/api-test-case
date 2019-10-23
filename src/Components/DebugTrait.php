<?php

namespace GlobeGroup\ApiTests\Components;

trait DebugTrait
{
    public function dump()
    {
        var_dump($this->response->getContent(false));
        return $this;
    }
}
