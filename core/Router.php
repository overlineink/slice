<?php

	class Router {

		/**
		 * Route an app page
		 * @param url
		 */
		public static function route($url)
		{
			$controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
			$controller_name = $controller;
			array_shift($url);

			$action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action': 'indexAction';
			$action_name = $controller;
			array_shift($url);

			$queryParams = $url;

			$dispatch = new $controller($controller_name, $action);

			if (method_exists($controller, $action))
			{
				call_user_func_array([$dispatch, $action], $queryParams);
			} else
			{
				http_response_code(404);
			}
		}

		/**
		 * Redirects the route for an location
		 * @param location
		 */
		public static function redirect($location)
		{
			if (!headers_sent())
			{
				header('Location: '.PROOT.$location);
				exit();
			} else
			{
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.PROOT.$location.'";';
				echo '</script>';
				echo '<noscript>';
				echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
				echo '</noscript>';
				exit();
			}
		}
		
	// EOF
	}
