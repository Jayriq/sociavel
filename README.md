# Sociavel

This is social media integration package/wrapper for Laravel. 
Using various 3rd party SDK created by best people available on earth, such:

* Facebook's official SDK, [facebook/facebook-php-sdk-v4](https://github.com/facebook/facebook-php-sdk-v4)
* Google's API SDK, [google/google-api-php-client](https://github.com/google/google-api-php-client)
* Great Twitter oauth library from Ruud Kamphuis [ruudk/twitter-oauth](https://packagist.org/packages/ruudk/twitter-oauth)

## Getting started

To get started, add to your `composer.json` as a dependency
```
$ composer require frengky/sociavel
```

Configure your Laravel installation to use included Service Provider and Facade:
```php
// File: config/app.php

'providers' => [
    // ...
	'Sociavel\Providers\SociavelServiceProvider'
];

'aliases' => [
    // ...
    'Sociavel' => 'Sociavel\SociavelFacade'
];
```

Add your social media API Key to `config/services.php`
```php
// File: config/services.php
    /*
	 * Social Media Configuration
	 */
	'twitter_oauth' => [ // https://apps.twitter.com
		'consumer_key'		=> 'secret-goes-here',
		'consumer_secret'	=> 'secret-goes-here',
		'redirect' 			=> '/login/twitter'
	],

	'facebook_oauth' => [ // https://developers.facebook.com
		'app_id'			=> 'secret-goes-here',
		'app_secret'		=> 'secret-goes-here',
		'scope'				=> [ 'public_profile', 'email', 'user_location', 'user_birthday', 'user_likes' ],
		'redirect' 			=> '/login/facebook'
	],	

	'google_oauth' => [ // https://cloud.google.com/console
		'app_name'		=> 'Laravel 5',
		'client_id' 	=> 'secret-goes-here',
		'client_secret' => 'secret-goes-here',
		'access_type' 	=>  'online',
		'scope' 		=> [ 'https://www.googleapis.com/auth/plus.login',
					 		 'https://www.googleapis.com/auth/userinfo.email',
					 		 'https://www.googleapis.com/auth/userinfo.profile' ],
		'redirect' 		=> '/login/google'
	]

```

Finally, an easy code you can implement into your Laravel controller:

```php
// You can specify: facebook, twitter, or google.
Sociavel::with('facebook')->connect(function($account) {
	
    // Save the retrieved social media data into the database as a user.
    // For complete fields, see 'Sociavel\Contracts\SocialMediaAccount'
    $user = new User;
    $user->social_id = $account->getId();
    $user->name = $account->getName();
    $user->save();
    
    // Authenticating as Laravel user session!
    Auth::login($user);
});
```

Feel in doubt? you can call the original SDK object directly from the facade!
```php
// Familiar with this Facebook's SDK v5 code?
$fb = new Facebook\Facebook([/* . . . */]);
$helper = $fb->getCanvasHelper();

// The exact same way, but from Sociavel facade!
Sociavel::with('facebook')->getCanvasHelper();
```

## Conclusion

This code may contains some bugs, and i will get it improved by time to time when i get some free coffee time.
