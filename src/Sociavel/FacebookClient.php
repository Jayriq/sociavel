<?php namespace Sociavel;

use App;
use Session;
use Config;
use Log;
use Facebook\Facebook;

class FacebookClient extends Facebook
{    
    function __construct()
    {
        parent::__construct([
            'app_id' => Config::get('services.facebook_oauth.app_id'),
            'app_secret' => Config::get('services.facebook_oauth.app_secret'),
            'default_graph_version' => 'v2.5',
            'persistent_data_handler' => new FacebookPersistentDataHandler()
        ]);
    }
}

