<?php namespace Sociavel;

use Config;
use Log;
use Auth;
use Request;
use Illuminate\Foundation\Application;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphUser;

class FacebookProvider extends SocialMediaProvider {

    /**
     * Get the official API client instance
     *
     * @var mixed
     */
    public function getClient()
    {
        return new FacebookClient();
    }

    /**
     * Return the current /me data
     *
     * @return array /me
     */
    public function me()
    {
        return $this->app->session->get('facebook.me');
    }

    /**
     * Connect on oauth login callback
     *
     * @param  Closure   $closure
     * @return boolean
     */
    public function connect(\Closure $closure)
    {
        if ($this->client === null)
        {
            $this->client = $this->getClient();
        }

        $access_token = null;
        $session = null;

        try 
        {
            $session = $this->client->getRedirectHelper()->getSessionFromRedirect();
            $access_token = $session->getToken();
        }
        catch (\Exception $ex)
        {
            Log::error('Facebook_Auth_Exception caught: ' . $ex->getMessage());
        }

        if (empty($access_token))
        {
            Log::error('Facebook access token is invalid');
            return false;
        }

        $this->app->session->set('facebook.oauth_access_token', $session->getToken());

        $graphObject = $this->client->get('/me')->getGraphObject();
        
        $account = new FacebookAccount($graphObject->asArray());

        $this->app->session->put('facebook.me', $graphObject->asArray());

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
        
        return redirect($this->client->getLoginUrl());
    }

}