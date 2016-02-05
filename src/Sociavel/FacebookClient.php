<?php namespace Sociavel;

use App;
use Session;
use Config;
use Log;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;

class FacebookClient {

    /**
     * The Facebook redirect login helper object
     *
     * @var \App\Lib\SocialMedia\FacebookRedirectLoginHelper
     */
    protected $redirectHelper;

    /**
     * The Facebook session object
     *
     * @var \Facebook\FacebookSession
     */
    protected $session;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct() 
    {
        FacebookSession::setDefaultApplication(
            Config::get('services.facebook_oauth.app_id'), 
            Config::get('services.facebook_oauth.app_secret')
        );
    }

    /**
     * Get the Facebook redirect login helper object
     *
     * @return \App\Lib\SocialMedia\FacebookRedirectLoginHelper
     */
    public function getRedirectHelper()
    {
        if( $this->redirectHelper === null)
        {
            $locale = '/' . App::getLocale();
            $url = url($locale . Config::get('services.facebook_oauth.redirect'));
            $this->redirectHelper = new FacebookRedirectLoginHelper($url);
        }

        return $this->redirectHelper;
    }

    /**
     * Get the Facebook session object
     *
     * @return \Facebook\FacebookSession
     */
    public function getSession()
    {
        if ($this->session)
        {
            return $this->session;
        }

        $access_token = Session::get('facebook.oauth_access_token');

        if ($access_token)
        {
            $this->session = new FacebookSession($access_token);
        }
        else
        {
            $this->session = $this->getRedirectHelper()->getSessionFromRedirect();
        }

        return $this->session;
    }

    /**
     * Get the Facebook oauth redirect url
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->getRedirectHelper()
                        ->getLoginUrl(Config::get('services.facebook_oauth.scope'));
    }

    /**
     * Call the Facebook GET api
     *
     * @return \Facebook\FacebookResponse
     */
    public function get($graphUrl)
    {
        return (new FacebookRequest($this->getSession(), 'GET', $graphUrl))->execute();
    }

}