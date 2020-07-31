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
namespace App\Controller;

use App\Middleware\AccessControlMiddleware;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\Logger\LoggerFactory;

/**
 * @AutoController()
 * @Middleware(AccessControlMiddleware::class)
 */
class IndexController extends AbstractController
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function index(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory->get('log', 'default');
        $this->logger->info("Your log message.");
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
