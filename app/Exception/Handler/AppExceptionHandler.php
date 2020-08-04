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
namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends BaseHandler
{

    public function __construct($name = __CLASS__, $group = 'default')
    {
        parent::__construct($name, $group);
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        $this->logger->info(sprintf('%s[%s] in %s %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile(), $throwable->getTraceAsString()));
        return $response->withStatus(200)
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($this->getThrowableData($throwable)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
