<?php namespace Sociavel\Contracts;

interface SocialMediaAccount {
    
    /**
     * Get the name of this provider
     *
     * @var string
     */
    public function getProviderName();

    /**
     * Get the unique identifier for the user.
     *
     * @return string
     */
    public function getId();

    /**
     * Get the nickname / username for the user.
     *
     * @return string
     */
    public function getNickname();

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the e-mail address of the user.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get the avatar / image URL for the user.
     *
     * @return string
     */
    public function getAvatar();

    /**
     * Get the all attributes as an array
     *
     * @return array
     */     
    public function toArray();    
}