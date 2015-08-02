<?php

define('ENVIRONMENT', 'development');
date_default_timezone_set('America/Sao_Paulo');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
	ini_set('display_errors', 1);
	error_reporting(E_ALL | E_STRICT);
}

define('CLIENT_ID','be000232443747b699ffaabbb05b9ae0');
define('CLIENT_SECRET', '4e6ef1e5c70f47619d56dad1db4f4a3f');
define('REDIRECT_URI', 'http://localhost:8000/easy-instagram/');
define('SCOPE', 'likes');

define('GRANT_TYPE', 'authorization_code');
define('API_URI', 'https://api.instagram.com/');
define('ENDPOINT', 'v1/');
define('OAUTH_URI', 'oauth/authorize/');
define('ACCESS_TOKEN_URI','oauth/access_token');