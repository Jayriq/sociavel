<?php  namespace Sociavel;

use Facebook\PersistentData\PersistentDataInterface;
use Facebook\Exceptions\FacebookSDKException;
use Session;

class FacebookPersistentDataHandler implements PersistentDataInterface 
{
    /**
     * @inheritdoc
     */
    public function get($key)
    {
    	return Session::get('facebook.state.' . $key);
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        return Session::set('facebook.state.' . $key, $value);
    }
}