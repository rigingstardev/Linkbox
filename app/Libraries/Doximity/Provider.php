<?php

namespace App\Libraries\Doximity;

use GuzzleHttp\Client;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;
use GuzzleHttp\ClientInterface;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * Base url to doximity oAuth 2.0
     *
     * @var string
     */
    protected $doximity_url = 'https://auth.doximity.com/';

    /**
     * Base url to doximity api
     *
     * @var string
     */
    protected $doximity_api = 'https://www.doximity.com/api/v1/';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['basic', 'email'];

    /**
     * The separating character for the requested scopes.
     *
     * @var string
     */
    protected $scopeSeparator = ' ';

    /**
     * Get the authentication URL for the provider.
     *
     * @param  string  $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            $this->doximity_url . 'oauth/authorize',
            $state
        );

    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return $this->doximity_url . 'oauth/token';
    }
    /**
     * Get the access token response for the given code.
     *
     * @param  string  $code
     * @return array
     */
    public function getAccessTokenResponse($code)
    {
        $postKey = (version_compare(ClientInterface::VERSION, '6') === 1) ? 'form_params' : 'body';

        $response = $this->getHttpClient()->post($this->getTokenUrl(), [           
            $postKey => $this->getTokenFields($code),
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get the raw user for the given access token.
     *
     * @param  string  $token
     * @return array
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            $this->doximity_api . 'users/current', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }  
    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param  array  $user
     * @return \Laravel\Socialite\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'                    => $user['id'],
            'nickname'              => $user['first_name'],
            'name'                  => $user['full_name'],           
            'email'                 => $user['email'],                    
            'contact_number'        =>  $user['phone'],
            'profile_description'   =>  $user['description'],
            'gender'                =>  $user['gender'],
            'npi_number'            =>  $user['npi'],
            //'dob'                   =>  $user['birthday'],
            'city'                  =>  $user['city'],  
            'has_uploaded_profile_photo' => $user['has_uploaded_profile_photo'],
            'profile_image'              => $user['profile_photo'],   
            'speciality'                  => $user['specialty']          
        ]);
    }
    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     * @return array
     */
    protected function getTokenFields($code)
    {
        return [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => $this->redirectUrl,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];
    }
    /**
     * Get a instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client(['verify' => false]);
        }

        return $this->httpClient;
    }
}