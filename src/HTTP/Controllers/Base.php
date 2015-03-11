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

	protected $input;
	/**
	 * @return Input
	 */
	public function getInput(){
		if(is_null($this->input)){
			$this->input = Input::load("json");
		}
		return $this->input;
	}

} 