<?php namespace Sociavel;

use Config;
use Log;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class FacebookProvider extends SociavelProvider {

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
        $helper = $this->client->getRedirectLoginHelper();

        try 
        {
            $access_token = $helper->getAccessToken();
        }
        catch(FacebookResponseException $ex)
        {
            Log::error('FacebookResponseException caught: ' . $ex->getMessage());   
        }
        catch (FacebookSDKException $ex)
        {
            Log::error('FacebookSDKException caught: ' . $ex->getMessage());
        }

        if (empty($access_token))
        {
            Log::error('Facebook access token is invalid');
            return false;
        }

        $this->app->session->set('facebook.oauth_access_token', $access_token->getValue());

        $response = null;
        try
        {
            $response = $this->client->get('/me?fields=id,name,first_name,middle_name,last_name,email,birthday,gender,link', $access_token->getValue());
        }
        catch(FacebookResponseException $ex)
        {
            Log::error('FacebookResponseException caught: ' . $ex->getMessage());   
        }
        catch (FacebookSDKException $ex)
        {
            Log::error('FacebookSDKException caught: ' . $ex->getMessage());
        }

        if (empty($response))
        {
            Log::error('Facebook return an invalid response');
            return false;
        }

        $graphUser = $response->getGraphUser();

        $account = new FacebookAccount($graphUser);

        $this->app->session->put('facebook.me', $graphUser);

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

        $loginUrl = $this->client->getRedirectLoginHelper()->getLoginUrl(
            url(Config::get('services.facebook_oauth.redirect')),
            Config::get('services.facebook_oauth.scope')
        );

        return redirect($loginUrl);
    }

}