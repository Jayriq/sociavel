<?php namespace Sociavel;

use Facebook\GraphNodes\GraphUser;
use Sociavel\Contracts\SocialMediaAccount;

class FacebookAccount implements SocialMediaAccount {

    /**
     * All of the account's attributes.
     *
     * @var \Facebook\GraphNodes\GraphUser
     */
    protected $graphuser;

    /**
     * Create a new generic account object.
     *
     * @param  \Facebook\GraphNodes\GraphUser  $user
     * @return void
     */
    public function __construct(GraphUser $user)
    {
        $this->graphuser = $user;
    }

    /**
     * Get the Facebook account unique id
     *
     * @return int
     */
    public function getId()
    {
        return $this->graphuser->getId();
    }

    /**
     * Get the Facebook account nickname
     *
     * @return string
     */    
    public function getNickname()
    {
        return $this->graphuser->getName();
    }

    /**
     * Get the Facebook account full name
     *
     * @return string
     */    
    public function getName()
    {
        $fullname = $this->getFirstName();

        if ($name = $this->getMiddleName())
        {
            $fullname .= " $name";
        }

        if ($name = $this->getLastName())
        {
            $fullname .= " $name";
        }

        return $fullname;

    }

    /**
     * Get the Facebook account registered email
     *
     * @return string
     */    
    public function getEmail()
    {
        return $this->graphuser->getEmail();
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
        return $this->graphuser->getFirstName();
    }

    /**
     * Get the Facebook account middle name
     *
     * @return string
     */     
    public function getMiddleName()
    {
        return $this->graphuser->getMiddleName();
    }

    /**
     * Get the Facebook account lastname
     *
     * @return string
     */     
    public function getLastname()
    {
        return $this->graphuser->getLastName();
    }

    /**
     * Get the Facebook account birthday
     *
     * @return string
     */     
    public function getBirthday()
    {
        return $this->graphuser->getBirthday()->format('Y-m-d');
    }

    /**
     * Get the Facebook account gender
     *
     * @return string
     */   
    public function getGender()
    {
        return $this->graphuser->getGender();
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
        return $this->graphuser->getLink();
    }

    /**
     * Get the Facebook account verified status
     *
     * @return mixed
     */     
    public function getVerified()
    {
        return null;
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
        return array(
            'id' => $this->getId(),
            'nickname' => $this->getNickname(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'first_name' => $this->getFirstname(),
            'middle_name' => $this->getMiddleName(),
            'last_name' => $this->getLastName(),
            'birthday' => $this->getBirthday(),
            'gender' => $this->getGender(),
            'photo' => $this->getPhoto(),
            'profile_url' => $this->getProfileUrl(),
            'verified' => $this->getVerified()
        );
    }    

}