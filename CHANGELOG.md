# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keep_a_changelog_url],
and this project adheres to [Semantic Versioning][semver_url].

## [Unreleased]



## [0.1.0] - 2020-11-06

First alpha release with base functionality and features.

### Added :sparkles:

- Permissions functionality for any model by using a trait `HasPermissions`.
- Roles functionality for any model by using a trait `HasRoles`.
- Mixed permissions and roles functionality for any model by using a trait `HasPermissionsAndRoles`.
- Laravel config file to control the package's behavior. (To publish run: `php artisan vendor:publish --provider="NorseBlue\Heimdall\HeimdallServiceProvider" --tag=heimdall-config`)
- Laravel service provider to publish for your app if you prefer configuring permissions and roles by code. (To install it run: `php artisan heimdall:install`)
- Permission checks using Laravel Gates. This also allows the use of Blade directives `@can`, `@cannot` and `@canany`.

[keep_a_changelog_url]: https://keepachangelog.com/en/1.0.0/
[semver_url]: https://semver.org/spec/v2.0.0.html
[0.1.0]: https://github.com/norse-blue/laravel-heimdall/compare/0.0.0...0.1.0
[Unreleased]: https://github.com/norse-blue/laravel-heimdall/compare/0.1.0...HEAD
