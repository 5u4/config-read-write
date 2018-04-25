# Config Read Write

## Description

A PHP package for reading and setting configuration fast and easy.

## Example

### Configuration File

```
APP_NAME=config-read-write
VERSION=1.0.0

```

### Config Reading

```php
<?php

require_once 'vendor/autoload.php';

use Senhung\Config\Configuration;

Configuration::setPath('conf');

Configuration::initializeConfigs();

echo Configuration::read('APP_NAME') . "\n";

echo Configuration::read('VERSION') . "\n";

```

Output:

```bash
config-read-write
1.0.0

```
