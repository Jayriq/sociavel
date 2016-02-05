<?php namespace Sociavel;

use Config;
use Log;
use Auth;
use Request;
use Illuminate\Foundation\Application;

abstract class SocialMediaProvider {

    /**
     * The application instance
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The official API client instance
     *
     * @var mixed
     */
    protected $client = null;

    /**
     * Class constructor
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the official API client instance
     *
     * @var mixed
     */
    public abstract function getClient();

    /**
     * Return the current /me data
     *
     * @return array /me
     */
    public abstract function me();

    /**
     * Connect on oauth login callback
     *
     * @param  Closure   $closure
     * @return boolean
     */
    public abstract function connect(\Closure $closure);

    /**
     * Oauth login redirect
     *
     * @return \RedirectResponse
     */
    public abstract function redirect();

    /**
     * Dynamically handle calls to the api client instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if ($this->client === null)
        {
            $this->client = $this->getClient();
        }

        if (!method_exists($this->client, $method))
        {
            throw new \BadMethodCallException("Cannot call method '$method' to api instance.");    
        }

        return call_user_func_array([$this->client, $method], $parameters);
    }    
}


