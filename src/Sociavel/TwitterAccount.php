<?php namespace Sociavel;

use Sociavel\Contracts\SocialMediaAccount;

class TwitterAccount implements SocialMediaAccount {

    /**
     * The Twitter stdClass credential
     *
     * @var \stdClass
     */
    protected $credential;

    /**
     * The access token
     *
     * @var string
     */
    protected $access_token;

    /**
     * Create a new generic account object.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(\stdClass $credential, $access_token = null)
    {
        $this->credential = $credential;
        $this->access_token = $access_token;
    }

    /**
     * Get the Twitter account unique id
     *
     * @return int
     */
    public function getId()
    {
        return $this->credential->id;
    }

    /**
     * Get the nickname / username for the user.
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->credential->screen_name;
    }    

    /**
     * Get the Twitter account full name
     *
     * @return string
     */    
    public function getName()
    {
        return $this->credential->name;
    }

    /**
     * Get the Twitter account email
     *
     * @return string
     */    
    public function getEmail()
    {
        return null;
    }

    /**
     * Get the avatar / image URL for the user.
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->credential->profile_image_url;
    }

    /**
     * Get the Twitter account screen name
     *
     * @return string
     */
    public function getScreenName()
    {
        return $this->credential->screen_name;
    }

    /**
     * Get the Twitter account location
     *
     * @return string
     */    
    public function getLocation()
    {
        return $this->credential->location;
    }

    /**
     * Get the Twitter account image or photo
     *
     * @return string url
     */     
    public function getPhoto()
    {
        // profile_image_url_https or profile_image_url
        return $this->credential->profile_image_url;
    }

    /**
     * Get the Twitter account profile link
     *
     * @return string url
     */     
    public function getProfileUrl()
    {
        return 'https://twitter.com/' . $this->getScreenName();
    }

    /**
     * Get the Twitter account verified status
     *
     * @return mixed
     */     
    public function getVerified()
    {
        return $this->credential->verified;
    }

    /**
     * Get the Twitter account last access token
     *
     * @return array|null
     */     
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Get the name of this provider
     *
     * @var string
     */
    public function getProviderName()
    {
        return 'twitter';
    }

    /**
     * Get the all attributes as an array
     *
     * @return array
     */     
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'screen_name' => $this->getScreenName(),
            'name' => $this->getName(),
            'location' => $this->getLocation(),
            'photo' => $this->getPhoto(),
            'profile_url' => $this->getProfileUrl(),
            'verified' => $this->getVerified()
        );
    }

}