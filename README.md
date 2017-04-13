# nia - CLI Routing Facade

CLI routing facade to simply add CLI routes to a given router.

## Installation

Require this package with Composer.

```bash
composer require nia/routing-facade-cli
```

## Tests
To run the unit test use the following command:

```bash
$ cd /path/to/nia/component/
$ phpunit --bootstrap=vendor/autoload.php tests/
```

## How to use
The following sample shows you how to use the CLI routing facade component for a common use case.

```php
$router = new Router();

// encapsulate the router into the facade.
$facade = new CliFacade($router);

// routes with additional conditions and filters.
// e.g.: bin/cli --update-inventory
$facade->cli($updateInventoryHandler, new ArgumentCondition('update-inventory'), $myFilters);

// cli fallback.
// e.g.: bin/cli
$facade->cli($showHelpHandler);
```
