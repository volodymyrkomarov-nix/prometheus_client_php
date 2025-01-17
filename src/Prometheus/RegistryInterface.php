<?php

namespace Prometheus;

use Prometheus\Exception\MetricNotFoundException;
use Prometheus\Exception\MetricsRegistrationException;

interface RegistryInterface
{
    /**
     * Removes all previously stored metrics from underlying storage adapter
     *
     * @return void
     */
    public function wipeStorage();

    /**
     * @return MetricFamilySamples[]
     */
    public function getMetricFamilySamples();

    /**
     * @param string   $namespace e.g. cms
     * @param string   $name e.g. duration_seconds
     * @param string   $help e.g. The duration something took in seconds.
     * @param string[] $labels e.g. ['controller', 'action']
     *
     * @return Gauge
     * @throws MetricsRegistrationException
     */
    public function registerGauge($namespace, $name, $help, array $labels = []);

    /**
     * @param string $namespace
     * @param string $name
     *
     * @return Gauge
     * @throws MetricNotFoundException
     */
    public function getGauge($namespace, $name);

    /**
     * @param string   $namespace e.g. cms
     * @param string   $name e.g. duration_seconds
     * @param string   $help e.g. The duration something took in seconds.
     * @param string[] $labels e.g. ['controller', 'action']
     *
     * @return Gauge
     * @throws MetricsRegistrationException
     */
    public function getOrRegisterGauge($namespace, $name, $help, array $labels = []);

    /**
     * @param string   $namespace e.g. cms
     * @param string   $name e.g. requests
     * @param string   $help e.g. The number of requests made.
     * @param string[] $labels e.g. ['controller', 'action']
     *
     * @return Counter
     * @throws MetricsRegistrationException
     */
    public function registerCounter($namespace, $name, $help, array $labels = []);

    /**
     * @param string $namespace
     * @param string $name
     *
     * @return Counter
     * @throws MetricNotFoundException
     */
    public function getCounter($namespace, $name);

    /**
     * @param string   $namespace e.g. cms
     * @param string   $name e.g. requests
     * @param string   $help e.g. The number of requests made.
     * @param string[] $labels e.g. ['controller', 'action']
     *
     * @return Counter
     * @throws MetricsRegistrationException
     */
    public function getOrRegisterCounter($namespace, $name, $help, array $labels = []);

    /**
     * @param string   $namespace e.g. cms
     * @param string   $name e.g. duration_seconds
     * @param string   $help e.g. A histogram of the duration in seconds.
     * @param string[] $labels e.g. ['controller', 'action']
     * @param float[]    $buckets e.g. [100, 200, 300]
     *
     * @return Histogram
     * @throws MetricsRegistrationException
     */
    public function registerHistogram(
        $namespace,
        $name,
        $help,
        array $labels = [],
        array $buckets = null
    );

    /**
     * @param string $namespace
     * @param string $name
     *
     * @return Histogram
     * @throws MetricNotFoundException
     */
    public function getHistogram($namespace, $name);

    /**
     * @param string $namespace e.g. cms
     * @param string $name e.g. duration_seconds
     * @param string $help e.g. A histogram of the duration in seconds.
     * @param string[]  $labels e.g. ['controller', 'action']
     * @param float[]  $buckets e.g. [100, 200, 300]
     *
     * @return Histogram
     * @throws MetricsRegistrationException
     */
    public function getOrRegisterHistogram($namespace, $name, $help, array $labels = [], array $buckets = null);

    /**
     * @param string   $namespace e.g. cms
     * @param string   $name e.g. duration_seconds
     * @param string   $help e.g. A histogram of the duration in seconds.
     * @param string[] $labels e.g. ['controller', 'action']
     * @param int $maxAgeSeconds e.g. 604800
     * @param float[]|null $quantiles e.g. [0.01, 0.5, 0.99]
     *
     * @return Summary
     * @throws MetricsRegistrationException
     */
    public function registerSummary(
        $namespace,
        $name,
        $help,
        array $labels = [],
        $maxAgeSeconds = 86400,
        array $quantiles = null
    );

    /**
     * @param string $namespace
     * @param string $name
     *
     * @return Summary
     * @throws MetricNotFoundException
     */
    public function getSummary($namespace, $name);

    /**
     * @param string $namespace e.g. cms
     * @param string $name e.g. duration_seconds
     * @param string $help e.g. A histogram of the duration in seconds.
     * @param string[]  $labels e.g. ['controller', 'action']
     * @param int $maxAgeSeconds e.g. 604800
     * @param float[]|null $quantiles e.g. [0.01, 0.5, 0.99]
     *
     * @return Summary
     * @throws MetricsRegistrationException
     */
    public function getOrRegisterSummary($namespace, $name, $help, array $labels = [], $maxAgeSeconds = 86400, array $quantiles = null);
}
