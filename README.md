# RoadRunnerBridge

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

[![Email][ico-email]][link-email]

The Thruster RoadRunnerBridge Bridge.


## Install

Via Composer

```bash
$ composer require thruster/road-runner-bridge
```

## Usage

Any class which implements PSR-15 `RequestHandlerInterface`.

```php
<?php

ini_set('display_errors', 'stderr');

require_once __DIR__ . '/../vendor/autoload.php';

use Thruster\RoadRunnerBridge\RoadRunnerBridge;
use Psr\Http\Server\RequestHandlerInterface;

$kernel = new class implements RequestHandlerInterface {
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response();
    }
};

RoadRunnerBridge::createCLI()
    ->attach($kernel)
    ->run();

```

## Testing

Run test cases

```bash
$ composer test
```

Run test cases with coverage (HTML format)


```bash
$ composer test-coverage
```

Run PHP style checker

```bash
$ composer check-style
```

Run PHP style fixer

```bash
$ composer fix-style
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/ThrusterIO/road-runner-bridge.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ThrusterIO/road-runner-bridge/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/ThrusterIO/road-runner-bridge.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/ThrusterIO/road-runner-bridge.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/thruster/road-runner-bridge.svg?style=flat-square
[ico-email]: https://img.shields.io/badge/email-team@thruster.io-blue.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/thruster/road-runner-bridge
[link-travis]: https://travis-ci.org/ThrusterIO/road-runner-bridge
[link-scrutinizer]: https://scrutinizer-ci.com/g/ThrusterIO/road-runner-bridge/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/ThrusterIO/road-runner-bridge
[link-downloads]: https://packagist.org/packages/thruster/road-runner-bridge
[link-email]: mailto:team@thruster.io
