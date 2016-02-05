<?php namespace Sociavel;

use Illuminate\Support\Facades\Facade;

class SociavelFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'sv'; }

}
