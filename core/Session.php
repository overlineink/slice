<?php

	class Session
	{
		/**
		 * Check Session
		 * @param name
		 */
		public static function exists($name)
		{
			return (isset($_SESSION[$name])) ? true : false;
		}

		/**
		 * Returns the target Session
		 * @param name
		 */
		public static function get($name)
		{
			return $_SESSION[$name];
		}

		/**
		 * Set Session's value
		 * @param name
		 * @param value
		 */
		public static function set($name, $value)
		{
			return $_SESSION[$name] = $value;
		} 

		/**
		 * Destroys a Session
		 * @param name
		 */
		public static function delete($name)
		{
			if (self::exists($name))
			{
				unset($_SESSION[$name]);
			}
		}

		/**
		 * Return's User-Agent version
		 */
		public static function uagent_no_version()
		{
			$uagent = $_SERVER['HTTP_USER_AGENT'];
			$regx = '/\/[a-zA-Z0-9.]+/';
			$newString = preg_replace($regx, '', $uagent);
			return $newString;
		}

	// EOF
	}