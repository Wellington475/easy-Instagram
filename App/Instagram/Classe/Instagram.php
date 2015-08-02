<?php

namespace Instagram\Classe;

use Exception;

class Instagram extends InstagramBase
{
	public static function init($config)
	{	
		self::__start($config);
	}

	public static function getAccessToken($code)
	{
		if (empty($code))
			throw new Exception( 'Invalid response code for this request.' );
		
		$response = null;
		
		$options = array(
			'post' => true,
			'url' => self::get('access_token_uri'),
			'postfields' => array(
					'client_id' => self::get('client_id'),
					'client_secret' => self::get('client_secret'),
					'grant_type' => self::get('grant_type'),
					'redirect_uri' => self::get('redirect_uri'),
					'code' => $code
				)
		);
		
		if ($response = self::curl($options)) {

			if ($responseArray = json_decode($response, true)) {
				
				if (isset($responseArray['access_token']))
					self::set('access_token', $responseArray['access_token']);
				
				self::$__data = $responseArray;
			}
			
		}

		return self::$__data;
	}

	public static function popularMedia($count = 30)
	{
		if (!self::get('access_token'))
			throw new Exception('Invalid access token.');

		$query = array(
			'access_token' => self::get('access_token'),
			'count' => (int) $count
		);

		$options = array(
			'url' => self::getEndPoint() . 'media/popular?' . http_build_query($query)
		);

		try {
			$response = self::curl($options);
			$responseArray = json_decode($response, true);
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}

		self::$__data = $responseArray;

		return self::$__data;
	}

	public static function likedMedia($count = 5)
	{
		if (!self::get('access_token'))
			throw new Exception('Invalid access token.');

		$query = array(
			'access_token' => self::get('access_token'),
			'count' => (int) $count
		);

		$options = array(
			'url' => self::getEndPoint() . 'users/self/media/liked?' . http_build_query($query)
		);

		try {
			$response = self::curl($options);
			$responseArray = json_decode($response, true);
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}

		self::$__data = $responseArray;

		return self::$__data;
	}

	public static function searchMedia($lat= '', $lng = '', $min_timestamp = '', $max_timestamp = '', $distance = '', $count = 30)
	{
		if (!$lat && !$lng)
			throw new Exception('Both lat and lng values are required to use this endpoint.');

		if (!self::get('access_token'))
			throw new Exception('Invalid access token.');

		$query = array(
			'lat' => (float) $lat,
			'lng' => (float) $lng,
			'access_token' => self::get('access_token'),
			'count' => (int) $count
		);

		if ($min_timestamp)
			$query['min_timestamp'] = (int) $min_timestamp;

		if ($distance)
			$query['distance'] = (int) $distance;

		$options = array(
			'url' => self::getEndPoint() . 'media/search?' . http_build_query($query)
		);

		try {
			$response = self::curl($options);
			$responseArray = json_decode($response, true);
		}
		catch (Exception $e) {
			echo "Ops! parece que acabou o café, nosso devenvolvedores não programam sem café!";
		}

		self::$__data = $responseArray;

		return self::$__data;
	}

	public static function recentMedia($id = 0, $count = 30)
	{
		if (!$id)
			throw new Exception('No media ID provided.');

		if (!self::get('access_token'))
			throw new Exception('Invalid access token.');

		$query = array(
			'access_token' => self::get('access_token'),
			'count' => (int) $count
		);

		$options = array(
			'url' => self::getEndPoint() . 'users/' . (int) $id . '/media/recent/?' . http_build_query($query)
		);

		try {
			$response = self::curl($options);
			$responseArray = json_decode($response, true);
		}
		catch (Exception $e) {
			echo "Ops! parece que acabou o café, nosso devenvolvedores não programam sem café!";
		}

		self::$__data = $responseArray;

		return self::$__data;
	}
}