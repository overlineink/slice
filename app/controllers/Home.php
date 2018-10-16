<?php

    class Home extends Controller
    {
        public function __construct($controller, $action) {
            parent::__construct($controller, $action);
            $this->setModel('_Home');
        }
        
        public function indexAction()
        {
            $GLOBALS['render'] = '';
            if(isset($_FILES) && !empty($_FILES))
            { 
                $GLOBALS['render'] = $this->_HomeModel->uploadFile();
                $GLOBALS['message'] = 'Image Uploaded. Path: ' . $GLOBALS['render'];
            }
            $this->view->render('home/index');
        }
    }
    