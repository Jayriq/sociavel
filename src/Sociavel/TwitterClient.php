<?php namespace Sociavel;

use Session;
use Config;
use Log;

class TwitterClient extends \TwitterOAuth\Api {

    /**
     * The twitter api url
     *
     * @var string
     */
    public $host = "https://api.twitter.com/1.1/";

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct() 
    {
        $consumer_key = Config::get('services.twitter_oauth.consumer_key');
        $consumer_secret = Config::get('services.twitter_oauth.consumer_secret');
        $oauth_token = Session::get('twitter.oauth_token');
        $oauth_token_secret = Session::get('twitter.oauth_token_secret');

        return parent::__construct($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
    }

}