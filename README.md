# Simple Queue View

> View the queue, baby!

![example photo](demo.png)

## Installation

You can install the package via composer using the "VCS" link:

```bash
...
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/enginedigital/queue-ui"
    }
],
"require": {
    "enginedigital/queue-ui": "~1.0.0"
},
...
```

##### Composer Install

**TODO: publish to packagist**

##### Queue Support

**This only supports the database queue.**

## Usage

```bash
php artisan vendor:publish --tag=queue-ui-config
```

You can list commands in the config that will populate the dropdown in the UI. If you have arguments, you can pass them as an array. See the default config file for examples.

*Note:* if there are arguments defined, they are marked as `required` fields in the UI.

### Testing

```bash
composer run test
```

If you want to try using the package via the cloned repo:

```bash
...
"repositories": [
    {
        "type": "path",
        "url": "../path/to/queue-ui",
        "options": {
            "symlink": true
        }
    }
],
"minimum-stability": "dev",
"require": {
    "enginedigital/queue-ui": "dev-master"
},
...
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email james.doyle@enginedigital.com instead of using the issue tracker.

## Credits

- [James Doyle](https://github.com/enginedigital)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
