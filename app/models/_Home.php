<?php

    class _Home extends Model
    {
        
        public function __construct() {
            # code here...
        }

        public function uploadFile()
        {
            // 1 Make directories helper
            $current_dir = getcwd(); // gets current working dir
            
            // 2 Check Resquest and Get Elements [true]
            if(isset($_FILES) && !empty($_FILES))
            {
                $e = explode('.', $_FILES['image']['name']);
                $file = array(
                    'fl_name'   =>  $_FILES['image']['name'],
                    'fl_size'   =>  $_FILES['image']['size'],
                    'fl_tmp_name'   =>  $_FILES['image']['tmp_name'],
                    'fl_extension'  =>  strtolower(end($e))
                );
            }
            
            // 3 Server helpers [remote and local path]
            $date = date("Ydm-is");
            $name = "IMG_SPL{$date}.{$file['fl_extension']}";
            $remote_destination = $current_dir . '/assets/images/upload/' . basename($file['fl_name']);
            $local_destination = $current_dir . '/assets/images/upload/' . basename($name);
            
            // 4 Handling errors
            if(!in_array($file['fl_extension'], array('jpeg', 'jpg', 'png')) || $file['fl_size'] > 2000000)
            {
                die('Couldn\'t possibly upload an image file with size greater than 2 megabytes.');
            }

            // 5 Upload file
            try {
                if(move_uploaded_file($file['fl_tmp_name'], $remote_destination))
                {
                    rename($remote_destination, $local_destination);
                    return PROOT . 'assets/images/upload/' . basename($name);
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
    