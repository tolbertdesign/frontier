<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Custom Booster Environment Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure custom Booster enviroment variables. These are
    | available throughout the application. The general format is
    | all capital letters and "_" between words (e.g. "VARIABLE_NAME").
    |
    */

    'trapper_url'               => env('TRAPPER_URL', 'https://local.boosterthon.com'),
    'app_env'                   => env('APP_ENV', 'production'),
    'titan_signup_killswitch'   => env('TITAN_SIGNUP_KILLSWITCH', false),
    'parent_dashboard_enabled'  => env('PARENT_DASHBOARD_ENABLED', true),
    's3_user_profile_images'    => env('S3_USER_PROFILE_IMAGES', 'user_profile_images/'),
    'facebook_access_token'     => env('FACEBOOK_ACCESS_TOKEN', ''),
    'beta_redirect_kill_switch' => env('BETA_REDIRECT_KILL_SWITCH', false),
    'feature_flag_driver'       => env('FEATURE_FLAG_DRIVER', 'booster_system_control'),
];
