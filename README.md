# Easy-Instagram [![Build Status](https://travis-ci.org/Wellington475/easy-Instagram.svg)](https://travis-ci.org/jabranr/instagram-php-sdk)

PHP Easy Instagram API

> **Description:** Although this project is a great way to help you in the treatment of Instagram API, was dedsenvolvido order to custom. The package is provided as is, so please use for their own risks.
[Instagram](http://instagram.com) is product of Instagram/Facebook.


## Features

- Extremely simple, easy to understand.
- Clean code.
- It uses only native PHP codes.

## Requirements

- PHP 5.5.0+
- Apache Web Server or equivalent with mod rewrite support.
- Dependency manager [Composer](http://getcomposer.org) installed.
- Register client at [http://instagram.com/developer/clients/register/](http://instagram.com/developer/clients/register/) and get `client_id`, `client_secret` and `redirect_uri`.

## Goodies

Easy-Instagram comes with a file called Bootstrap.php, where you can change and customize their sets of variables.

## Quick-Start

#### Installation - Linux / Unix / OSX

if you have not installed, install `composer` ...

	php -r "readfile('https://getcomposer.org/installer');"

if you used Windows
	
	https://getcomposer.org/doc/00-intro.md#installation-windows
	
## Usage

+ Here is a basic use example:

```php
require('vendor/autoload.php');

use Instagram\Classe\Instagram as Instagram;

$config = array(
    'client_id' => 'CLIENT_ID',
	'client_secret' => 'CLIENT_SECRET',
	'redirect_uri' => 'http://example.com'
);
try {
	Instagram::init( $config );
}
catch (Exception $e) {
    echo $e->getMessage();
}

/**
 * Get a new OAuth access token with
 */
if ( isset($_GET['code']) ) {
	Instagram::getAccessToken( $_GET['code'] );

	$data = Instagram::getData();
	
	/**
	 *  Make API requests.
	 */
	print_r($data);
}
else{
	/**
     * Or display a login with Instagram link for redirect user for OAuth.
     */
    echo '<a href="' . Instagram::getOauthUri() . '">Login with Insgatram</a>';
}

```


## Documentation

Using other methods to order the Instagram API.


#### Get Popular Media

```php
try	{

	$media = Instagram::popularMedia((int) $count);
	print_r( $media );

}
catch(Exception $e) {
	echo $e->getMessage();
}
```


#### Search Media

```php

/**
 * Are necessary lat and lng.
 */

try {
	$media = Instagram::searchMedia(
					(float) $lat,
					(float) $lng,
					(UNIX_TIMESTAMP) $min_timestamp,
					(UNIX_TIMESTAMP) $max_timestamp,
					(int) $distance,
					(int) $count = 30 );

	print_r( $media );

}
catch(Exception $e) {
	echo $e->getMessage();
}

```


#### Get Media more liked

```php
try {
	$media = Instagram::likedMedia((int) $count );

	print_r( $media );

} catch(Exception $e) {
	echo $e->getMessage();
}
```

# License

This project is licensed under the [MIT License](http://opensource.org/licenses/MIT). This means you can use and modify it for free in private or commercial projects.

## Authors

- Renan Palmeira
- Wellington Eugenio