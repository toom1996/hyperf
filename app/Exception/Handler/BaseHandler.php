<?php


namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Psr\Container\ContainerInterface;

class BaseHandler extends ExceptionHandler
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * BaseHandler constructor.
     *
     * @param $name
     * @param $group
     */
    public function __construct($name = __CLASS__, $group = 'default')
    {
        $this->logger = ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get($name, $group);
    }

    public function handle(Throwable $throwable, ResponseInterface $response) {}

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }

    protected function getThrowableData(Throwable $throwable)
    {
        return json_encode([
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage(),
        ], JSON_UNESCAPED_UNICODE);
    }
}