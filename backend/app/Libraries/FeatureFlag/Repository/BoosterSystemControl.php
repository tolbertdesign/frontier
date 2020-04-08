<?php

namespace App\Libraries\FeatureFlag\Repository;

use App\Libraries\FeatureFlag\Repository\Base;
use App\Libraries\SystemControl;

class BoosterSystemControl implements Base {
    protected $systemControl;

    public function __construct() {
        $this->systemControl = new SystemControl();
    }

    public function checkIfEntityFeatureEnabled($feature, $entity)
    {
        return $this->systemControl->featureStatus($feature, $entity);
    }

    public function checkIfGloballyEnabled($feature, $prefix = 'system_control:titan_dashboard:')
    {
        return $this->systemControl->checkIfGloballyOn($prefix . $feature);
    }
}
