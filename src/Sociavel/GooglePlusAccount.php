<?php namespace Sociavel;

use Sociavel\Contracts\SocialMediaAccount;

class GooglePlusAccount implements SocialMediaAccount {

    /**
     * The person object
     *
     * @var \Google_Service_Plus_Person
     */
    protected $person;

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
    public function __construct(\Google_Service_Plus_Person $person, $access_token = null)
    {
        $this->person = $person;
        $this->access_token = $access_token;
    }

    /**
     * Get the Google account unique id
     *
     * @return int
     */
    public function getId()
    {
        return $this->person->getId();
    }

    /**
     * Get the Google account nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->person->getNickname();
    }

    /**
     * Get the Google account fullname
     *
     * @return string
     */
    public function getName()
    {
        $fullname = $this->getGivenName();

        if ($name = $this->getMiddleName())
        {
            $fullname .= " $name";
        }

        if ($name = $this->getFamilyName())
        {
            $fullname .= " $name";
        }

        return $fullname;
    }

    /**
     * Get the Google account registered email
     *
     * @return string
     */    
    public function getEmail()
    {
        $emails = $this->person->getEmails();
        
        if(isset($emails[0]) && is_object($emails[0]))
        {
            /** \Google_Service_Plus_PersonEmails */
            return $emails[0]->getValue();            
        }

        return null;
    }

    /**
     * Get the avatar / image URL for the user.
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->person->getImage()->getUrl();
    }

    /**
     * Get the Google account family name
     *
     * @return string
     */    
    public function getFamilyName()
    {
        /** \Google_Service_Plus_PersonName */
        return $this->person->getName()->getFamilyName();
    }

    /**
     * Get the Google account given name
     *
     * @return string
     */     
    public function getGivenName()
    {
        /** \Google_Service_Plus_PersonName */
        return $this->person->getName()->getGivenName();   
    }

    /**
     * Get the Google account middle name
     *
     * @return string
     */     
    public function getMiddleName()
    {
        /** \Google_Service_Plus_PersonName */
        return $this->person->getName()->getMiddleName();
    }

    /**
     * Get the Google account birthday
     *
     * @return string
     */     
    public function getBirthday()
    {
        return $this->person->getBirthday();
    }

    /**
     * Get the Google account gender
     *
     * @return string
     */     
    public function getGender()
    {
        return $this->person->getGender();
    }

    /**
     * Get the Google account image or photo
     *
     * @return string url
     */     
    public function getPhoto()
    {
        /** \Google_Service_Plus_PersonImage */
        return $this->person->getImage()->getUrl();
    }

    /**
     * Get the Google account profile link
     *
     * @return string url
     */     
    public function getProfileUrl()
    {
        return $this->person->getUrl();
    }

    /**
     * Get the Google account verified status
     *
     * @return mixed
     */     
    public function getVerified()
    {
        return $this->person->getVerified();
    }

    /**
     * Get the Google account last access token
     *
     * @return string
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
        return 'google';
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
            'email' => $this->getEmail(),
            'family_name' => $this->getFamilyName(),
            'given_name' => $this->getGivenName(),
            'middle_name' => $this->getMiddleName(),
            'birthday' => $this->getBirthday(),
            'gender' => $this->getGender(),
            'photo' => $this->getPhoto(),
            'profile_url' => $this->getProfileUrl(),
            'verified' => $this->getVerified()
        );
    }

}