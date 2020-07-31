<?php


namespace App\Exception\Handler;


use App\Components\ForbiddenHttpException;
use App\Components\UnauthorizedHttpException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class ForbiddenExceptionHandler
 *
 * @author: TOOM <1023150697@qq.com>
 */
class ForbiddenExceptionHandler extends BaseHandler
{

    public function __construct($name = __CLASS__, $group = 'default')
    {
        parent::__construct($name, $group);
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof ForbiddenHttpException) {

            // 阻止异常冒泡
            $this->stopPropagation();
            $this->logger->info(sprintf('%s[%s] in %s %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile(), $throwable->getTraceAsString()));
            return $response->withStatus(200)
                ->withAddedHeader('content-type', 'application/json; charset=utf-8')
                ->withBody(new SwooleStream($this->getThrowableData($throwable)));
        }

        // 交给下一个异常处理器
        return $response;

        // 或者不做处理直接屏蔽异常
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}