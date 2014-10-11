<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Collection usefull methods
 *
 * @package    Eiva/Coffee
 * @category   Base
 * @author     Thernytskyi A., Kostylev A.
 * @copyright  (c) 2014
 * @license    https://github.com/mendor1990/coffee
 */
class Kohana_Coffee {


	// Coffee instances
	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Coffee
	 */
	public static function instance()
	{
		if ( ! isset(Coffee::$_instance))
		{
			$class = 'Coffee';
			Coffee::$_instance = new $class();
		}

		return Coffee::$_instance;
	}
	
	/**
	 * get all the controllers and the actions that can be used
	 * @return array
	 */
	public static function list_controllers()
	{
		$list_controllers = array();
	
		$controllers = Kohana::list_files('classes/controller');
	
		foreach ($controllers as $controller)
		{
			$controller = basename($controller,'.php');
			$list_controllers[] = $controller;
		}
	
		return $list_controllers;
	}
	
	/**
	 * get all the actions that can be used
	 * @param string $controller
	 * @return array
	 */
	public static function list_action($controller = '')
	{
		$list_action = array();
		$class = new ReflectionClass('Controller_'.$controller);
		$methods = $class->getMethods();
		foreach ($methods as $obj => $val)
		{
			if (strpos( $val->name , 'action_') !== FALSE )
			{
				$list_action[] = str_replace('action_', '', $val->name);
			}
		}
		return $list_action;
	}
	
	/**
	 * Check enabled module by name
	 * @param string $name
	 * @return boolean
	 */
	public function is_module($name = ''){
		if (array_key_exists($name, Kohana::modules()))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * @param string $value
	 * @param string $length
	 *
	 * Принимает в качестве параметра текст и его длинну. Доходит до заданного символа,
	 * заканчивает слово и если текст был обрезан, то добавляет три точки
	 */
	public function cut_text($value, $length){
		$text = implode(array_slice(explode('<br>',wordwrap($value,$length,'<br>',false)),0,1));
		if($text!=$value)$text=$text.'...';
		return $text;
	}
	
	/**
	 *
	 * @param int $number - количество элементов
	 * @param array $endingArray - массив возможных вариантов слова
	 * @return string
	 *
	 * Метод сколняет существительные
	 */
	public function getNumEnding($number, $endingArray)
	{
		$number = $number % 100;
		if ($number>=11 && $number<=19) {
			$ending=$endingArray[2];
		}
		else {
			$i = $number % 10;
			switch ($i)
			{
				case (1): $ending = $endingArray[0]; break;
				case (2):
				case (3):
				case (4): $ending = $endingArray[1]; break;
				default: $ending=$endingArray[2];
			}
		}
		return $ending;
	}

}
