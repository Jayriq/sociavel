<?php namespace Sociavel;

use Config;
use Log;
use Auth;
use Request;
use Illuminate\Foundation\Application;

class TwitterProvider extends SociavelProvider {

    /**
     * Get the official API client instance
     *
     * @var mixed
     */
    public function getClient()
    {
    	return new TwitterClient();
    }

    /**
     * Return the current /me data
     *
     * @return array /me
     */
    public function me()
    {
    	return $this->app->session->get('twitter.me');
    }

    /**
     * Connect on oauth login callback
     *
     * @param  Closure   $closure
     * @return boolean
     */
    public function connect(\Closure $closure)
    {
    	$oauth_verifier = Request::input('oauth_verifier');

        if (empty($oauth_verifier))
        {
            return false;
        }
        
        if ($this->client === null)
        {
            $this->client = $this->getClient();
        }
        
        $access_token = $this->client->getAccessToken($oauth_verifier);

        $this->app->session->set('twitter.oauth_token', $access_token['oauth_token']);
        $this->app->session->set('twitter.oauth_token_secret', $access_token['oauth_token_secret']);

        $this->client = $this->getClient();
        $credential = $this->client->get('account/verify_credentials');

        $account = new TwitterAccount($credential);
        $this->app->session->put('twitter.me', $account->toArray());

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
        $this->app->session->forget('twitter');

        $callback_uri = url(Config::get('services.twitter_oauth.redirect'));

        if ($this->client === null)
        {
            $this->client = $this->getClient();
        }

        $request = $this->client->getRequestToken($callback_uri);

        if ($this->client->http_code != 200)
        {
            Log::error('Failed to get the Twitter request token');
            return null;
        }

        $this->app->session->put('twitter.oauth_token', $request['oauth_token']);
        $this->app->session->put('twitter.oauth_token_secret', $request['oauth_token_secret']);
        
        $loginUrl = $this->client->getAuthorizeURL($request['oauth_token']);

        return redirect($loginUrl);
    }

}