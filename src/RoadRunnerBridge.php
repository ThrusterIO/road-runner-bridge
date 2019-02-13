<?php

declare(strict_types=1);

namespace Thruster\RoadRunnerBridge;

use Psr\Http\Server\RequestHandlerInterface;
use Spiral\Goridge\RelayInterface;
use Spiral\Goridge\StreamRelay;
use Spiral\RoadRunner\PSR7Client;
use Spiral\RoadRunner\Worker;
use Thruster\HttpFactory\HttpFactoryProviderInterface;

/**
 * Class RoadRunnerBridge.
 *
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class RoadRunnerBridge
{
    /** @var RelayInterface */
    private $relay;

    /** @var Worker */
    private $worker;

    /** @var PSR7Client */
    private $psr7Client;

    /** @var RequestHandlerInterface|HttpFactoryProviderInterface */
    private $handler;

    public function __construct(RelayInterface $relay)
    {
        $this->relay = $relay;
    }

    public static function createCLI(): self
    {
        return new static(new StreamRelay(STDIN, STDOUT));
    }

    public function attach(RequestHandlerInterface $handler): self
    {
        $this->handler = $handler;

        return $this;
    }

    public function run(): void
    {
        $this->worker = new Worker($this->relay);

        $requestFactory = null;
        $streamFactory  = null;
        $uploadsFactory = null;
        if ($this->handler instanceof HttpFactoryProviderInterface) {
            $httpFactory = $this->handler->getHttpFactory();

            $requestFactory = $httpFactory->serverRequest();
            $streamFactory  = $httpFactory->stream();
            $uploadsFactory = $httpFactory->uploadedFile();
        }

        $this->psr7Client = new PSR7Client($this->worker, $requestFactory, $streamFactory, $uploadsFactory);

        while ($request = $this->psr7Client->acceptRequest()) {
            try {
                $this->psr7Client->respond(
                    $this->handler->handle($request)
                );
            } catch (\Throwable $e) {
                $this->psr7Client->getWorker()->error((string) $e);
            }
        }
    }
}
