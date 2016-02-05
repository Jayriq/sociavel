<?php namespace Sociavel;

use Config;
use Log;
use Auth;
use Request;
use Illuminate\Foundation\Application;

class Sociavel {

    /**
     * The application instance
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The social media provider instance
     *
     * @var mixed
     */
    protected $providers = [];

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

    public function with($provider)
    {
        $provider = strtolower($provider);

        if (! isset($this->providers[$provider]))
        {
            $className = 'Sociavel\\' . ucfirst($provider) . 'Provider';
            $this->providers[$provider] = new $className($this->app);
        }

        return $this->providers[$provider];
    }
}