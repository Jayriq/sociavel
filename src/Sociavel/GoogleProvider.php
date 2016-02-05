<?php namespace Sociavel;

use Config;
use Log;
use Auth;
use Request;
use Illuminate\Foundation\Application;

class GoogleProvider extends SociavelProvider {

    /**
     * Get the official API client instance
     *
     * @var mixed
     */
    public function getClient()
    {
    	return new GoogleClient();
    }

    /**
     * Return the current /me data
     *
     * @return array /me
     */
    public function me()
    {
    	return $this->app->session->get('google.me');
    }

    /**
     * Connect on oauth login callback
     *
     * @param  Closure   $closure
     * @return boolean
     */
    public function connect(\Closure $closure)
    {
    	$code = Request::input('code');

        if (empty($code))
        {
            return false;
        }

        if ($this->client === null)
        {
            $this->client = $this->getClient();
        }

        $access_token = null;
        try 
        {
            $access_token = $this->client->authenticate($code);
        } 
        catch(\Google_Auth_Exception $ex)
        {
            Log::error('Google_Auth_Exception caught: ' . $ex->getMessage());
        }
        
        if (empty($access_token))
        {
            Log::error('Google access token is invalid');
            return false;
        }

        $this->app->session->set('google.access_token', $access_token);

        $plus = new \Google_Service_Plus($this->client);
        $person = $plus->people->get('me');

        $account = new GooglePlusAccount($person);
        $this->app->session->put('google.me', $account->toArray());

        $closure($account);

        return true; 	
    }

    /**
     * Oauth login redirect
     *
     * @return \RedirectResponse
     */
    public function redirect()
    {
        if ($this->client === null)
        {
            $this->client = $this->getClient();
        }

        $loginUrl = $this->client->createAuthUrl();

        return redirect($loginUrl);
    }
}