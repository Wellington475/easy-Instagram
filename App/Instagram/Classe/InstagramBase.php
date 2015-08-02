<?php

namespace Instagram\Classe;

require_once(dirname(__DIR__).'..\Config\Bootstrap.php');

use Exception;

class InstagramBase
{
	private static $__options = array();
	protected static $__data = array();

	protected static function __start($config)
	{
		self::$__options = array(
			'client_id' => '',
			'client_secret' => '',
			'access_token' => '',
			'redirect_uri' => '',
			'api_uri' => '',
			'oauth_url' => '',
			'oauth_uri' => '',
			'access_token_uri' => '',
			'grant_type' => '',
			'scope' => '',
			'endpoint' => ''
		);

		if (!isset($config['client_id']) || (isset($config['client_id']) && empty($config['client_id'])))
			throw new Exception('Client ID is missing.');
		else if (!isset($config['client_secret']) || (isset($config['client_secret']) && empty($config['client_secret'])))
			throw new Exception('Client secret is missing.');
		else if (!isset($config['redirect_uri']) || (isset($config['redirect_uri']) && empty($config['redirect_uri'])))
			throw new Exception('Redirect URL is missing.');

		if (!isset($config['scope']) || (isset($config['scope']) && empty($config['scope'])))
			$config['scope'] = SCOPE;

		self::set('client_id', $config['client_id']);
		self::set('client_secret', $config['client_secret']);
		self::set('redirect_uri', $config['redirect_uri']);
		self::set('scope', $config['scope']);
		self::set('api_uri', API_URI);
		self::set('access_token_uri', API_URI . ACCESS_TOKEN_URI);
		self::set('oauth_url', API_URI . OAUTH_URI);
		
		$oauth_uri = self::get('oauth_url');
		$oauth_uri .= '?client_id=' . $config['client_id'];
		$oauth_uri .= '&redirect_uri=' . $config['redirect_uri'];
		$oauth_uri .= '&response_type=code';

		$oauth_uri .= empty($config['scope']) ? '' : '&scope=' . $config['scope'];

		self::set('oauth_uri', $oauth_uri);
		
		self::set('grant_type', GRANT_TYPE);
		self::set('endpoint', API_URI . ENDPOINT);

		return self::$__options;
	}

	protected static function get($option)
	{
		return self::$__options[$option];
	}
	
	protected static function set($option, $value)
	{
		if (array_key_exists($option, self::$__options)) {
			self::$__options[$option] = $value;
		}
	}

	protected static function curl($options = array())
	{
		if (!isset($options['url']) || (isset($options['url']) && empty($options['url'])))
			return false;

		$curl_options = array(
			CURLOPT_URL => $options['url'],
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
		);
		
		$curl = curl_init();
		
		curl_setopt_array($curl, $curl_options);
		
		if (isset($options['post']) && $options['post'] == true) {
			curl_setopt($curl, CURLOPT_POST, true);

			if (isset($options['postfields']) && $options['postfields'] && is_array($options['postfields']))
				curl_setopt($curl, CURLOPT_POSTFIELDS, $options['postfields']);
		}
		
		$output = curl_exec($curl);
		curl_close($curl);
		
		if ($output)
			return $output;

		return false;
	}

	public static function getApiUri()
	{
		return self::get('api_uri');
	}

	public static function getOauthUri()
	{
		return self::get('oauth_uri');
	}

	public static function getOauthUrl()
	{
		return self::get('oauth_url');
	}

	public static function getClientId()
	{
		return self::get('client_id');
	}
	
	public static function getClientSecret()
	{
		return self::get('client_secret');
	}
	
	public static function getRedirectUri()
	{
		return self::get('redirect_uri');
	}
	
	public static function getGrantType()
	{
		return self::get('grant_type');
	}

	public static function getScope()
	{
		return self::get('scope');
	}

	public static function getEndPoint()
	{
		return self::get('endpoint');
	}

	public static function getData()
	{
		return self::$__data;
	}
}