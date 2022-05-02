<?php

namespace Prometheus;

use Prometheus\Storage\Adapter;

class Gauge extends Collector
{
    const TYPE = 'gauge';

    /**
     * @param double $value e.g. 123
     * @param string[] $labels e.g. ['status', 'opcode']
     */
    public function set($value, array $labels = [])
    {
        $this->assertLabelsAreDefinedCorrectly($labels);

        $this->storageAdapter->updateGauge(
            [
                'name' => $this->getName(),
                'help' => $this->getHelp(),
                'type' => $this->getType(),
                'labelNames' => $this->getLabelNames(),
                'labelValues' => $labels,
                'value' => $value,
                'command' => Adapter::COMMAND_SET,
            ]
        );
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE;
    }

    /**
     * @param string[] $labels
     */
    public function inc(array $labels = [])
    {
        $this->incBy(1, $labels);
    }

    /**
     * @param int|float $value
     * @param string[] $labels
     */
    public function incBy($value, array $labels = [])
    {
        $this->assertLabelsAreDefinedCorrectly($labels);

        $this->storageAdapter->updateGauge(
            [
                'name' => $this->getName(),
                'help' => $this->getHelp(),
                'type' => $this->getType(),
                'labelNames' => $this->getLabelNames(),
                'labelValues' => $labels,
                'value' => $value,
                'command' => Adapter::COMMAND_INCREMENT_FLOAT,
            ]
        );
    }

    /**
     * @param string[] $labels
     */
    public function dec(array $labels = [])
    {
        $this->decBy(1, $labels);
    }

    /**
     * @param int|float $value
     * @param string[] $labels
     */
    public function decBy($value, array $labels = [])
    {
        $this->incBy(-$value, $labels);
    }
}
