<?php

	class Cookie
	{
		/**
		 * Set a Cookie
		 *
		 * @param string $name
		 * @param int $value
		 * @param mixed $expiry
		 * @return Boolean
		 */
		public static function set($name, $value, $expiry)
		{
			if (setCookie($name, $value, $time()+$expiry, '/'))
			{
				return true;
			}
			return false;
		}

		/**
		 * Returns a cookie with given name
		 *
		 * @param mixed $name
		 * @return Cookie
		 */
		public static function get($name)
		{
			return $_COOKIE[$name];
		}
		
		/**
		 * Delete the target Cookie
		 * @param mixed $name
		 */
		public static function delete($name)
		{
			return self::set($name, '', time()-1);
		}

		
		/**
		 * Check if the target Cookie exists
		 * @param mixed $name
		 */
		public static function exists($name)
		{
			return isset($_COOKIE[$name]);
		}

	// EOF
	}