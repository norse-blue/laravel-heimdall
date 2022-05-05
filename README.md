<div align="center">
    <h1>Code-driven authorization system for Artisans</h1>
    <p align="center"> 
        <a href="https://packagist.org/packages/norse-blue/laravel-heimdall"><img alt="Stable Release" src="https://img.shields.io/packagist/v/norse-blue/laravel-heimdall.svg?style=flat-square&label=release&logo=packagist&logoColor=eceff4&colorA=4c566a&colorB=5e81ac"></a>
        <a href="https://github.com/norse-blue/laravel-heimdall/actions?query=workflow%3Arun-tests"><img alt="Build Status" src="https://img.shields.io/github/workflow/status/norse-blue/laravel-heimdall/run-tests.svg?style=flat-square&label=build&logo=github&logoColor=eceff4&colorA=4c566a&colorB=88c0d0"></a>
        <a href="https://php.net/releases"><img alt="PHP Version" src="https://img.shields.io/packagist/php-v/norse-blue/laravel-heimdall.svg?style=flat-square&label=php&logo=php&logoColor=eceff4&colorA=4c566a&colorB=b48ead"></a>
        <a href="https://codeclimate.com/github/norse-blue/laravel-heimdall"><img alt="Maintainability" src="https://img.shields.io/codeclimate/maintainability/norse-blue/laravel-heimdall.svg?style=flat-square&label=maintainability&logo=code-climate&logoColor=eceff4&colorA=4c566a&colorB=88c0d0"></a>
        <a href="https://codeclimate.com/github/norse-blue/laravel-heimdall"><img alt="Test Coverage" src="https://img.shields.io/codeclimate/coverage/norse-blue/laravel-heimdall.svg?style=flat-square&label=coverage&logo=code-climate&logoColor=eceff4&colorA=4c566a&colorB=88c0d0"></a>
        <a href="https://packagist.org/packages/norse-blue/laravel-heimdall"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/norse-blue/laravel-heimdall.svg?style=flat-square&label=downloads&logoColor=eceff4&colorA=4c566a&colorB=88c0d0"></a>
        <a href="https://github.com/norse-blue/laravel-heimdall/blob/master/LICENSE.md"><img alt="License" src="https://img.shields.io/github/license/norse-blue/laravel-heimdall.svg?style=flat-square&label=license&logoColor=eceff4&colorA=4c566a&colorB=a3be8c"></a>
    </p>
</div>
<hr>

**Heimdall** is a package that aims to be an easy to use code-driven authorization
system for Laravel. It is built upon the roles and permissions concepts.

## Installation

>Requirements:
>- [PHP 8.0+](https://php.net/releases)

Install this package using Composer:

```bash
composer require norse-blue/laravel-heimdall
```

You can publish the config file by running:
```bash
php artisan vendor:publish --provider="NorseBlue\Heimdall\HeimdallServiceProvider" --tag=heimdall-config
```

You can install the service provider by running:
```bash
php artisan heimdall:install
```

## Usage

To get more in-depth knowledge about this package, please refer to the [Official Documentation](#).

## Changelog

Please refer to the [CHANGELOG.md](CHANGELOG.md) file for more information about what has changed recently.

## Contributing

Contributions to this project are accepted and encouraged. Please read the [CONTRIBUTING.md](.github/CONTRIBUTING.md) file for details on contributions.

## Testing

To test this package run:

``` bash
composer test
```

To find out the test coverage run:

``` bash
composer coverage
```

To find issues by statically analyzing the code run:

``` bash
composer analyse
```

To get code insights run:

``` bash
composer insights
```

To fix styling issues run:

``` bash
composer format
```

## Credits

- [Axel Pardemann](https://github.com/axelitus)
- [All Contributors](../../contributors)

## Security Vulnerabilities

Please review our [security policy](../../security/policy) to know how to report security vulnerabilities within this package.

## Support the development

**Do you like this project? Support it by donating**

<a href="https://www.buymeacoffee.com/axelitus"><img src="docs/assets/images/buy-me-a-coffee.svg" width="180" alt="Buy me a coffee"></img></a>

## License

This package is open-sourced software licensed under the [MIT](LICENSE.md) license.
