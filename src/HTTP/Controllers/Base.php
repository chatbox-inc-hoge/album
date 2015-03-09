<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2015/03/10
 * Time: 21:30
 */

namespace Chatbox\Album\HTTP\Controllers;

use Silex\ControllerProviderInterface;
use Chatbox\Input;

abstract class Base implements ControllerProviderInterface{

	/**
	 * @return Input
	 */
	public function getInput(){
		return  Input::load("json");
	}

} 