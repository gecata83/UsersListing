<?php
/**
 * Created by PhpStorm.
 * User: gecata
 * Date: 25.02.18
 * Time: 11:10
 */

return [
    'view_manager' => [
        'display_exceptions' => true,
    ],
    'listing-config' => [
        'password' => 'hard',
        'username' => 'hard',
        'url'      => 'http://hiring.rewardgateway.net/list'
    ],
    'cache-options' => [
        'adapter' => [
            'name'    => 'filesystem',
            'options' => [
                'ttl' => 580,
                'namespace' => "georgiandreevgeorgiev",
//                'cacheDir' => __DIR__ . '/../../data/cache',
            ]
        ],
        'plugins' => [
            'exception_handler' => ['throw_exceptions' => false],
        ],
    ]
];