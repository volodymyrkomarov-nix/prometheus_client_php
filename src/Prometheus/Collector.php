<?php

namespace Prometheus;

use InvalidArgumentException;
use Prometheus\Storage\Adapter;

abstract class Collector
{
    const RE_METRIC_NAME = '/^[a-zA-Z_:][a-zA-Z0-9_:]*$/';
    const RE_LABEL_NAME = '/^[a-zA-Z_][a-zA-Z0-9_]*$/';

    /**
     * @var Adapter
     */
    protected $storageAdapter;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $help;

    /**
     * @var string[]
     */
    protected $labels;

    /**
     * @param Adapter $storageAdapter
     * @param string $namespace
     * @param string $name
     * @param string $help
     * @param string[] $labels
     */
    public function __construct(Adapter $storageAdapter, $namespace, $name, $help, array $labels = [])
    {
        $this->storageAdapter = $storageAdapter;
        $metricName = ($namespace !== '' ? $namespace . '_' : '') . $name;
        self::assertValidMetricName($metricName);
        $this->name = $metricName;
        $this->help = $help;
        foreach ($labels as $label) {
            self::assertValidLabel($label);
        }
        $this->labels = $labels;
    }

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getLabelNames()
    {
        return $this->labels;
    }

    /**
     * @return string
     */
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return sha1($this->getName() . serialize($this->getLabelNames()));
    }

    /**
     * @param string[] $labels
     */
    protected function assertLabelsAreDefinedCorrectly(array $labels)
    {
        if (count($labels) !== count($this->labels)) {
            throw new InvalidArgumentException(sprintf('Labels are not defined correctly: %s', print_r($labels, true)));
        }
    }

    /**
     * @param string $metricName
     */
    public static function assertValidMetricName($metricName)
    {
        if (preg_match(self::RE_METRIC_NAME, $metricName) !== 1) {
            throw new InvalidArgumentException("Invalid metric name: '" . $metricName . "'");
        }
    }

    /**
     * @param string $label
     */
    public static function assertValidLabel($label)
    {
        if (preg_match(self::RE_LABEL_NAME, $label) !== 1) {
            throw new InvalidArgumentException("Invalid label name: '" . $label . "'");
        } else if (strpos($label, "__") === 0) {
            throw new InvalidArgumentException("Can't used a reserved label name: '" . $label . "'");
        }
    }
}
