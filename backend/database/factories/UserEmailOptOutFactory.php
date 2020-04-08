<?php


$factory->define(App\Entities\UserEmailOptOut::class, function () {
    return [
        'email'             => '',
        'user_email_type_id'=> null,
    ];
});
