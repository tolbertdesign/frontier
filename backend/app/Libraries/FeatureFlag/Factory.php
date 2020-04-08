<?php

namespace App\Libraries\FeatureFlag;

use App\Libraries\FeatureFlag\Repository\BoosterSystemControl;
use InvalidArgumentException;
use Exception;

class Factory
{
    const ENV_FEATURE_FLAG_DRIVER         = 'booster.feature_flag_driver';

    const DRIVER_BOOSTER_SYSTEM_CONTROL   = 'booster_system_control';

    protected $stores = [];

    private function getViaConfig()
    {
        return $this->get(config(self::ENV_FEATURE_FLAG_DRIVER));
    }

    private function get($name)
    {
        $this->stores[$name] = $this->stores[$name] ?? $this->resolve($name);
        return $this->stores[$name];
    }

    public function checkIfGloballyEnabled($feature)
    {
        $driver = $this->getViaConfig();
        return $driver->checkIfGloballyEnabled($feature);
    }

    public function checkIfEntityFeatureEnabled($feature, $entity)
    {
        $driver = $this->getViaConfig();
        return $driver->checkIfEntityFeatureEnabled($feature, $entity);
    }

    public function resolve($name)
    {
        $selectedDriver = null;

        switch ($name) {
            case self::DRIVER_BOOSTER_SYSTEM_CONTROL:
                $selectedDriver = new BoosterSystemControl();
                break;
        }

        if (!isset($selectedDriver)) {
            throw new InvalidArgumentException("Feature flag driver not found.");
        }

        return $selectedDriver;
    }
}
