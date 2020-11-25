<?php

use app\models\User;

return [
    // valid user
    [
        'username'             => 'test',
        'auth_key'             => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
        'password_hash'        => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne', // password_0
        'password_reset_token' => 'RkD_Jw0_8HEedzLk7MM-ZKEFfYR7VbMr_1392559490',
        'email'                => 'test@example.com',
        'status'               => User::STATUS_WAIT,
        'created_at'           => '1392559490',
        'updated_at'           => '1392559490',
        'payment_type'         => User::PAYMENT_TYPE_PAYPAL,
        'payment_tariff'       => User::TARIFF_MONTH
    ],
    // deleted user
    [
        'username'       => 'test.deleted',
        'auth_key'       => 'O87GkY3_UfmMHYkyezZ7QLfmkKNsllzT',
        'password_hash'  => 'O87GkY3_UfmMHYkyezZ7QLfmkKNsllzT', // Test1234
        'email'          => 'test.deleted@example.com',
        'status'         => User::STATUS_DELETED,
        'created_at'     => '1548675330',
        'updated_at'     => '1548675330',
        'payment_type'   => User::PAYMENT_TYPE_PAYPAL,
        'payment_tariff' => User::TARIFF_MONTH,
    ],
];