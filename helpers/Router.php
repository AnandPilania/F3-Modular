<?php

class Router
{
	public static function head($route, $call, $name = null)
	{
		static::app()->route('HEAD '.($name?'@'.$name.':':'').$route, $call);
	}

	public static function get($route, $call, $name = null)
	{
		static::app()->route('GET '.($name?'@'.$name.':':'').$route, $call);
	}

	public static function post($route, $call, $name = null)
	{
		self::app()->route('POST '.($name?'@'.$name.':':'').$route, $call);
	}

	public static function put($route, $call, $name = null)
	{
		self::app()->route('PUT '.($name?'@'.$name.':':'').$route, $call);
	}

	public static function delete($route, $call, $name = null)
	{
		self::app()->route('DELETE '.($name?'@'.$name.':':'').$route, $call);
	}

	public static function patch($route, $call, $name = null)
	{
		self::app()->route('PATCH '.($name?'@'.$name.':':'').$route, $call);
	}

	private static function app()
	{
		return Base::instance();
	}
}