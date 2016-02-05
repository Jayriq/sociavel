<?php

return [

	/*
	 * Social Media Configuration
	 */

	'twitter_oauth' => [ // https://apps.twitter.com
		'consumer_key'		=> env('TWITTER_CONSUMER_KEY', 'hAxosrlkXCJnbXyzzGUeTw'), // Consumer Key (API Key)
		'consumer_secret'	=> env('TWITTER_CONSUMER_SECRET', 'CHPWfowGH4mB3b1oifTmCdGXrRbXk16iVDNw43Qo'), // Consumer Secret (API Secret)
		'redirect' 			=> '/login/twitter',
	],

	'facebook_oauth' => [ // https://developers.facebook.com
		'app_id'			=> env('FACEBOOK_APP_ID', '123456789012345'), // APP ID
		'app_secret'		=> env('FACEBOOK_APP_SECRET', 'ab1172hb2a5rf945ee0d5bb87c579edg'), // APP Secret
		'scope'				=> [ 'public_profile', 'email', 'user_location', 'user_birthday', 'user_likes' ],
		'redirect' 			=> '/login/facebook',
	],	

	'google_oauth' => [ // https://cloud.google.com/console
		'app_name'		=> 'Laravel 5',
		'client_id' 	=> env('GOOGLE_CLIENT_ID', '995781515634-el75e8u4v4pjkdv5v8qxxjd4h8uvrh8t.apps.googleusercontent.com'),
		'client_secret' => env('GOOGLE_CLIENT_SECRET', '1H_CjOxOsJ8Ab6iEJ12gRWxb'),
		'api_key' 		=> env('GOOGLE_API_KEY', 'CIzaSyARuYz5IMDE-cxNtm1UiFFHjYJ8LoG7jfY'),
		'access_type' 	=>  'online',
		'scope' 		=> [ 'https://www.googleapis.com/auth/plus.login',
					 		 'https://www.googleapis.com/auth/userinfo.email',
					 		 'https://www.googleapis.com/auth/userinfo.profile' ],
		'redirect' 		=> '/login/google',
	]

];