# Release 0.1.0

First alpha release with base functionality and features.

## Added :sparkles:

- Permissions functionality for any model by using a trait `HasPermissions`.
- Roles functionality for any model by using a trait `HasRoles`.
- Mixed permissions and roles functionality for any model by using a trait `HasPermissionsAndRoles`.
- Laravel config file to control the package's behavior. (To publish run: `php artisan vendor:publish --provider="NorseBlue\Heimdall\HeimdallServiceProvider" --tag=config`)
- Laravel service provider to publish for your app if you prefer configuring permissions and roles by code. (To install it run: `php artisan heimdall:install`)
- Permission checks using Laravel Gates. This also allows the use of Blade directives `@can`, `@cannot` and `@canany`.

---

Previous: [Release 0.0.0](CHANGELOG-0.0.0.md)
