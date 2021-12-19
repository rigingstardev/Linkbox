<?php

namespace App\Libraries;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
/**
 * Class Doximity
 * 
 */
class Doximity
{
    // @var string The Stripe API key to be used for requests.
    public static $apiKey;

    // @var string The base URL for the Doximity API.
    public static $apiBase = 'https://auth.doximity.com';   

    // @var string|null The version of the Stripe API to use for requests.
    public static $apiVersion = null;

    // @var string|null The account ID for connected accounts requests.
    public static $accountId = null;

    // @var boolean Defaults to true.
    //public static $verifySslCerts = true;

    // @var array The application's information (name, version, URL)
    public static $appInfo = null;  

    public static $client =  null; 

 	public function __constructor(){

 		$this->client = new Client();
 	}
    /**
     * @return string The API key used for requests.
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }      

    /**
     * @return string | null The Stripe account ID for connected account
     *   requests.
     */
    public static function getAccountId()
    {
        return self::$accountId;
    }

    /**
     * @param string $accountId The Stripe account ID to set for connected
     *   account requests.
     */
    public static function setAccountId($accountId)
    {
        self::$accountId = $accountId;
    }   
    /**
     * @param string $appName The application's name
     * @param string $appVersion The application's version
     * @param string $appUrl The application's URL
     */
    public static function setAppInfo($appName, $appVersion = null, $appUrl = null)
    {
        if (self::$appInfo === null) {
            self::$appInfo = array();
        }
        self::$appInfo['name'] = $appName;
        self::$appInfo['version'] = $appVersion;
        self::$appInfo['url'] = $appUrl;
    }
    /**
     * @param string $appName The application's name
     * @param string $appVersion The application's version
     * @param string $appUrl The application's URL
     */
   /* public static function Client()
    {
        $this->client = new \GuzzleHttp\Client();

    }*/
    /**
     * @param string $appName The application's name
     * @param string $appVersion The application's version
     * @param string $appUrl The application's URL
     */
    public static function getClientResponse($method,$requestType,$options)
    {
        //return $res = self::client->request($method,self::$apiBase."/$requestType",$options);
    	$client = new Client();
    	//$client->setDefaultOption('verify', false);
    	//return true;
    	$res =  $client->request($method, self::$apiBase."/$requestType", ['verify' => false,'query'=>$options]);

    	print_r($res);
    	exit;
        //return $client->get(self::$apiBase."/$requestType", $options);
    }
    /**
     * @param string $appName The application's name
     * @param string $appVersion The application's version
     * @param string $appUrl The application's URL
     */
    public static function authorize()
    {

    	$requestType = 'oauth/authorize';
    	

    	$options = [


    				'client_id'=>config('services.doximity.client_id'),
    				'response_type'=>'code',
    				'redirect_uri'=>config('services.doximity.redirect'),
    				'scope'=>'basic%20colleagues',
    				'type'=>'verify'
 					];

        self::getClientResponse('GET',$requestType,$options);
    }
    /**
     * @param string $appName The application's name
     * @param string $appVersion The application's version
     * @param string $appUrl The application's URL
     */
    public static function user()
    {
        
    }
}