<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

return [
    'app_name' => env('APP_NAME', 'skeleton'),
    'app_env' => env('APP_ENV', 'dev'),
    'scan_cacheable' => env('SCAN_CACHEABLE', false),
    StdoutLoggerInterface::class => [
        'log_level' => [
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::DEBUG,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ],
    ],
    'authManager' => [
        'assignmentTable' => 'admin_assignment',
        'itemTable' => 'admin_item',
        'itemChildTable' => 'admin_item_child',
        'ruleTable' => 'admin_rule',
        'skipRoutes' => [
            '/',
            '/v1/user/site/sign-up'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => \App\Model\AdminUserFrontend::class,
            'authClass' => \App\Components\auth\QueryParamsAuth::class,
            'secretKey' => 'toomhub'
        ],
        'wechat' => [
            'class' => 'App\Components\wechat\Wechat',
            'miniApp' => [
                'app_id' => 'wxa9a7f53bff2fc937',
                'secret' => '971869511ee44662c56bcf8a833bd679'
            ],
        ]
    ]
];
