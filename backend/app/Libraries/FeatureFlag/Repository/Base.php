<?php

namespace App\Libraries\FeatureFlag\Repository;

interface Base
{
    public function checkIfEntityFeatureEnabled($feature, $entity);
    public function checkIfGloballyEnabled($feature);
}
