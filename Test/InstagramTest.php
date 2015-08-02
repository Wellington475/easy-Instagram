<?php

namespace Instagram\Tests;

use PHPUnit_Framework_TestCase;
use Instagram\Classe\Instagram as Instagram;


require('vendor/autoload.php');

class InstagramTest extends PHPUnit_Framework_TestCase {
	
	public $config;

	public function assertPreConditions()
	{
		$this->assertTrue(
			class_exists($class = 'Instagram\Classe\Instagram'),
			'Class not found: '.$class
		);
	}

	/**
	 * Setup / Constructor
	 */
	public function setUp()
	{
		$this->config = array();
	}

	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function testInvalidArgumentException()
	{
		Instagram::init();
	}

	/**
	 * @expectedException Exception
	 */
	public function testEmptyArgumentException()
	{
		Instagram::init($this->config);
	}

	/**
	 * @expectedException Exception
	 */
	public function testAnyInvalidArgumentException()
	{
		$this->config = array(
			'client_id' => 'CLIENT_ID',
			'client_secret' => 'CLIENT_SECRET',
		);
		
		Instagram::init($this->config);
	}

	public function testDefaultScope()
	{
		$this->config = array(
			'client_id' => 'MyClientId',
			'client_secret' => 'MyClientSecret',
			'redirect_uri' => 'MyRedirectURL'
		);
		
		Instagram::init($this->config);
		
		$this->assertEquals(Instagram::getScope(), 'likes');
	}

	public function testConfigArgument()
	{
		$this->config = array(
			'client_id' => 'MyClientId',
			'client_secret' => 'MyClientSecret',
			'redirect_uri' => 'MyRedirectURL'
		);
		
		Instagram::init($this->config);
		
		$this->assertEquals(Instagram::getClientId(), 'MyClientId');
		$this->assertEquals(Instagram::getClientSecret(), 'MyClientSecret');
		$this->assertEquals(Instagram::getRedirectUri(), 'MyRedirectURL');
	}

	public function testDefaultApiUri()
	{
		$this->config = array(
			'client_id' => 'MyClientId',
			'client_secret' => 'MyClientSecret',
			'redirect_uri' => 'MyRedirectURL'
		);
		
		Instagram::init($this->config);
		
		$this->assertEquals(Instagram::getApiUri(), 'https://api.instagram.com/');
	}


	/**
	 * @depends testDefaultApiUri
	 */
	public function testDefaultOauthUrl()
	{
		$this->config = array(
			'client_id' => 'MyClientId',
			'client_secret' => 'MyClientSecret',
			'redirect_uri' => 'MyRedirectURL'
		);

		Instagram::init($this->config);

		$this->assertEquals(Instagram::getOauthUrl(), Instagram::getApiUri() . 'oauth/authorize/');
	}

	public function testDefaultGrantType()
	{
		$this->config = array(
			'client_id' => 'MyClientId',
			'client_secret' => 'MyClientSecret',
			'redirect_uri' => 'MyRedirectURL'
		);

		Instagram::init($this->config);

		$this->assertEquals(Instagram::getGrantType(), 'authorization_code');
	}

	public function testDefaultEndpoint()
	{
		$this->config = array(
			'client_id' => 'MyClientId',
			'client_secret' => 'MyClientSecret',
			'redirect_uri' => 'MyRedirectURL'
		);

		Instagram::init($this->config);

		$this->assertEquals(Instagram::getEndPoint(), Instagram::getApiUri() . 'v1/');
	}

	public function testDefaultData() 
	{
		$this->config = array(
			'client_id' => 'MyClientId',
			'client_secret' => 'MyClientSecret',
			'redirect_uri' => 'MyRedirectURL'
		);

		Instagram::init($this->config);

		$this->assertEmpty(Instagram::getData());
	}

}