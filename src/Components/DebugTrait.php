<?php

namespace GlobeGroup\ApiTests\Components;

trait DebugTrait
{
    public function dump()
    {
        var_dump(var_export($this->response->getContent(false), true));

        return $this;
    }

    public function measure()
    {
        throw new \Exception('Not implemented yet.');

        $this->doMeasurement = true;
    }

    private function start()
    {
        if (!$this->doMeasurement) {
            return;
        }
    }

    private function stop()
    {
        if (!$this->doMeasurement) {
            return;
        }

        $this->log();
    }

    private function log()
    {

    }

}
