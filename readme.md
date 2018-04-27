# Config Read Write

## Description

A PHP package for reading and setting configuration fast and easy.

## Setup

1. Add Dependency

```bash
$ composer require senhung/config-read-write
```

2. Add a Configuration File

Create a file and input the configurations

For example: 

```
APP_NAME->config-read
VERSION->1.0.2
```

3. Initialize Configuration

Add the following code in your program's main entry

```php
<?php

require_once 'vendor/autoload.php';

use Senhung\Config\Configuration;

/* Set configuration file path */
Configuration::setPath('<your-configuration-file-directory>');

/* You can set your own separator (default: '=') */
Configuration::setSeparator('->');

/* Initialize config array in Configuration class */
Configuration::initializeConfigs();

```

## How To Use

### Read Config

```php
Configuration::read('<config-you-want-to-read>') . "\n";
```

### Write Config

```php
Configuration::set('<config-you-want-to-write>', '<change-to>');
```

## Example

### Configuration File

```
APP_NAME=config-read
VERSION=1.0.2
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
1.0.2
config-write
```
