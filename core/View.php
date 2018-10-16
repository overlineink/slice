 <?php

	class View
	{

		protected $_head, $_body, $_scripts,
		$_siteTitle = SITE_TITLE, $_outputBuffer,
		$_layout = DEFAULT_LAYOUT;

		public function __construct() {
		}

		/*
		* Render the view to be displayed
		*/
		public function render($viewName)
		{
			$viewAry = explode('/', $viewName);
			$viewString = implode(DS, $viewAry);
			if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
				include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
				include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
			} else {
				http_response_code(404);
			}
		}

		/**
		 * Returns an content type value
		 * 
		 *  @param string $type
		 */
		public function content($type)
		{
			if($type == 'head') {
				return $this->_head;
			} elseif ($type == 'body') {
				return $this->_body;
			} elseif ($type == 'scripts') {
				return $this->_scripts;
			}
			return false;
		}

		/**
		 * Renders the portion of a content page that is not within a named section
		 *
		 * @return content
		 */
		public function renderBody()
		{
			return $this->content('body');
		}

		/**
		 * Start an Buffer inside view
		 * @param mixed $type
		 */
		public function start($type)
		{
			$this->_outputBuffer = $type;
			ob_start();
		}

		/**
		 * Clean Buffer
		 */
		public function end()
		{
			if($this->_outputBuffer == 'head') {
				$this->_head = ob_get_clean();
			} elseif($this->_outputBuffer == 'body') {
				$this->_body = ob_get_clean();
			} elseif($this->_outputBuffer == 'scripts') {
				$this->_scripts = ob_get_clean();
			} else {
				http_response_code(500);
			}
		}

		/**
		 * Set view title
		 * @param title
		 */
		public function setTitle($title)
		{
			$this->_siteTitle = $title;
		}

		/**
		 * Get view title
		 */
		public function getTitle()
		{
			return $this->_siteTitle;
		}

		/**
		 * Set Layout for an view
		 * @param path
		 */
		public function setLayout($path)
		{
			$this->_layout = $path;
		}

		// public function getStyles()
		// {
		// 	if(!empty($files))
		// 	{
		// 		foreach ($files as $css) {
		// 			return '<link rel="stylesheet" type="text/css" media="screen" href="' . $css['path'] . '" />';
		// 		}
		// 	}
		// }
	}

	// EOF
