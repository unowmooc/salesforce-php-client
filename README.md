# Salesforce PHP Client

Simple PHP client for [Salesforce API](https://developer.salesforce.com/)

## Installation

```
$ composer require unowmooc/salesforce-php-client
```

## Usage:

```php
<?php

use Salesforce\Salesforce;

$clientId = '...';
$secret = '...';
$username = '...';
$password = '...';

$client = new Salesforce($clientId, $secret, $username, $password);

$user = $client->user()->find('user_id');

$opportunities = $client->opportunity()->findAll('list_view_id', ['limit' => 25, 'offset' => 0]);


```

