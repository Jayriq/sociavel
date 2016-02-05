<?php namespace Sociavel;

use Sociavel\Contracts\SocialMediaAccount;

class FacebookAccount implements SocialMediaAccount {
    /**
     * All of the account's attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new generic account object.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the Facebook account unique id
     *
     * @return int
     */
    public function getId()
    {
        return $this->attributes['id'];    
    }

    /**
     * Get the Facebook account nickname
     *
     * @return string
     */    
    public function getNickname()
    {
        return $this->getName();
    }

    /**
     * Get the Facebook account full name
     *
     * @return string
     */    
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * Get the Facebook account registered email
     *
     * @return string
     */    
    public function getEmail()
    {
        return isset($this->attributes['email']) ? $this->attributes['email'] : null;    
    }

    /**
     * Get the Facebook account avatar
     *
     * @return string url
     */     
    public function getAvatar()
    {
        return 'https://graph.facebook.com/' . $this->getId() . '/picture?width=300&height=300';
    }

    /**
     * Get the Facebook account first name
     *
     * @return string
     */    
    public function getFirstname()
    {
        return $this->attributes['first_name'];    
    }

    /**
     * Get the Facebook account lastname
     *
     * @return string
     */     
    public function getLastname()
    {
        return $this->attributes['last_name'];    
    }

    /**
     * Get the Facebook account birthday
     *
     * @return string
     */     
    public function getBirthday()
    {
        return $this->attributes['birthday'];    
    }

    /**
     * Get the Facebook account gender
     *
     * @return string
     */   
    public function getGender()
    {
        return $this->attributes['gender'];    
    }

    /**
     * Get the Facebook account image or photo
     *
     * @return string url
     */     
    public function getPhoto()
    {
        return 'https://graph.facebook.com/' . $this->getId() . '/picture?width=300&height=300';
    }

    /**
     * Get the Facebook account profile link
     *
     * @return string url
     */     
    public function getProfileUrl()
    {
        return $this->attributes['link'];
    }

    /**
     * Get the Facebook account verified status
     *
     * @return int
     */     
    public function getVerified()
    {
        return $this->attributes['verified'];
    }

    /**
     * Get the name of this provider
     *
     * @var string
     */
    public function getProviderName()
    {
        return 'facebook';
    }

    /**
     * Get the all attributes as an array
     *
     * @return array
     */     
    public function toArray()
    {
        return array_merge($this->attributes, array('photo' => $this->getPhoto()));
    }    

}