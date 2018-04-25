# Config Read Write

## Description

A PHP package for reading and setting configuration fast and easy.

## Example

### Configuration File

```
APP_NAME=config-read
VERSION=1.0.0
```

### Config Reading

```php
<?php

require_once 'vendor/autoload.php';

use Senhung\Config\Configuration;

/* Set configuration file path */
Configuration::setPath('conf');

/* Initialize config array in Configuration class */
Configuration::initializeConfigs();

/* Read config APP_NAME */
echo Configuration::read('APP_NAME') . "\n";

/* Read config VERSION */
echo Configuration::read('VERSION') . "\n";

/* Set APP_NAME to config-write */
Configuration::set('APP_NAME', 'config-write');

/* Read APP_NAME again to see the changes */
echo Configuration::read('APP_NAME') . "\n";

```

Output:

```bash
config-read
1.0.0
config-write
```
