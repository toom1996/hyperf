<?php


namespace App\Components\auth;


use App\Components\UnauthorizedHttpException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Throwable;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AuthException
 *
 * @author: TOOM <1023150697@qq.com>
 */
class AuthExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof UnauthorizedHttpException) {
            // 格式化输出
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
            ], JSON_UNESCAPED_UNICODE);

            // 阻止异常冒泡
            $this->stopPropagation();

            return $response->withStatus(200)->withAddedHeader('content-type', 'application/json; charset=utf-8')->withBody(new SwooleStream($data));
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