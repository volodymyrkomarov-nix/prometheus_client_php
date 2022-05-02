<?php

namespace Prometheus\Storage;

use Prometheus\Exception\StorageException;
use Prometheus\MetricFamilySamples;

interface Adapter
{
    const COMMAND_INCREMENT_INTEGER = 1;
    const COMMAND_INCREMENT_FLOAT = 2;
    const COMMAND_SET = 3;

    /**
     * @return MetricFamilySamples[]
     */
    public function collect();

    /**
     * @param mixed[] $data
     * @return void
     */
    public function updateSummary(array $data);

    /**
     * @param mixed[] $data
     * @return void
     */
    public function updateHistogram(array $data);

    /**
     * @param mixed[] $data
     * @return void
     */
    public function updateGauge(array $data);

    /**
     * @param mixed[] $data
     * @return void
     */
    public function updateCounter(array $data);

    /**
     * Removes all previously stored metrics from underlying storage
     *
     * @throws StorageException
     * @return void
     */
    public function wipeStorage();
}
