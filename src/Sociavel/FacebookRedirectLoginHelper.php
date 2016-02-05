<?php namespace Sociavel;

use Request;
use Session;
use Facebook\FacebookRedirectLoginHelper as OriginalRedirectLoginHelper;

class FacebookRedirectLoginHelper extends OriginalRedirectLoginHelper {

    /**
    * Return the code.
    *
    * @return string|null
    */
    protected function getCode()
    {
        $code = Request::input('code');
        return $code ? $code : null;
    }    

    /**
    * Stores a state string in session storage for CSRF protection.
    * Developers should subclass and override this method if they want to store
    *   this state in a different location.
    *
    * @param string $state
    * @throws FacebookSDKException
    */
    protected function storeState($state)
    {
        Session::put('facebook.state', $state);
    }

    /**
    * Loads a state string from session storage for CSRF validation.  May return
    *   null if no object exists.  Developers should subclass and override this
    *   method if they want to load the state from a different location.
    *
    * @return string|null
    *
    * @throws FacebookSDKException
    */
    protected function loadState()
    {
        $state = Session::get('facebook.state');
        if ($state)
        {
            $this->state = $state;
            return $this->state;
        }

        return null;
    }


    /**
    * Check if a redirect has a valid state.
    *
    * @return bool
    */
    protected function isValidRedirect()
    {
        $savedState = $this->loadState();
        $state = Request::input('state');

        if (!$this->getCode() || !$state) 
        {
            return false;
        }

        $givenState = $state;
        $savedLen = mb_strlen($savedState);
        $givenLen = mb_strlen($givenState);

        if ($savedLen !== $givenLen) 
        {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < $savedLen; $i++) 
        {
            $result |= ord($savedState[$i]) ^ ord($givenState[$i]);
        }

        return $result === 0;
    }
}
