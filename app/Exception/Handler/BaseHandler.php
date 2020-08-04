<?php


namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Psr\Container\ContainerInterface;

/**
 * Class BaseHandler
 *
 * @author: TOOM <1023150697@qq.com>
 */
class BaseHandler extends ExceptionHandler
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    protected $request;

    protected $logVars = [
        '_GET',
        '_POST',
        '_FILES',
        '_COOKIE',
        '_SESSION',
        '_SERVER',
    ];

    /**
     * BaseHandler constructor.
     *
     * @param $name
     * @param $group
     */
    public function __construct($name = __CLASS__, $group = 'default')
    {
        $this->logger = ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get($name, $group);
        $this->request = ApplicationContext::getContainer()->get(RequestInterface::class);
    }

    public function handle(Throwable $throwable, ResponseInterface $response) {}

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }

    /**
     *
     *
     * @param  \Throwable  $throwable
     *
     * @return string
     */
    protected function getThrowableData(Throwable $throwable)
    {
        return json_encode([
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage(),
        ], JSON_UNESCAPED_UNICODE);
    }

    protected function getLogVarsData()
    {
        foreach ($this->logVars as $k => $v) {

        }
    }

}