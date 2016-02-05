<?php namespace Sociavel;

use App;
use Session;
use Config;
use Log;

class GoogleClient extends \Google_Client {

    /**
     * Class constructor
     *
     * @param \Illuminate\Session\SessionManager $session
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->setApplicationName(Config::get('services.google_oauth.app_name'));
        $this->setAccessType(Config::get('services.google_oauth.access_type'));
        $this->setClientId(Config::get('services.google_oauth.client_id'));
        $this->setClientSecret(Config::get('services.google_oauth.client_secret'));

        // http://stackoverflow.com/questions/21020898/403-error-with-messageaccess-not-configured-please-use-google-developers-conso
        // $this->setDeveloperKey(Config::get('google::api.api_key'));
        
        $this->setScopes(Config::get('services.google_oauth.scope'));

        $locale = '/' . App::getLocale();
        $url = url($locale . Config::get('services.google_oauth.redirect'));
        $this->setRedirectUri($url);

        if ($access_token = Session::get('google.access_token'))
        {
            $this->setAccessToken($access_token);
        }
    }

}