<?php
    class FileHandler {
        public $source_file = null;
        public $destination_file = null;
        public function set_source($source){
            $this->source_file = $source;
        }
        public function set_destination($destination){
            $this->destination_file = $destination;
        }

        public function check_if_file_exists($file){
            $file_content = @file_get_contents($file);
            if($file_content){
                return true;
            }
            else {
                return false;
            }
        }
        public function get_file_content($file){
            try {
                $file_content = @file_get_contents($file);
                if($file_content){
                    return $file_content;
                }
                else {throw new Exception("Can't read the file. Please check if the file exists.");}
            
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }

        public function write_to_file($content, $file){
            
            try {
                $my_file = fopen($file, 'w') or die('There was an error when trying to write to: '.$file);
                fwrite($my_file, $content);
                fclose($my_file);
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }

        }

        public function append_file ($content, $file){
            
            try {
                $my_file = fopen($file, 'a') or die('There was an error when trying append: '.$file);
                fwrite($my_file, $content);
                fclose($my_file);
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }

        }

        public function delete_file($file){
            if($this->check_if_file_exists($file)){  //fails on empty files (0kb)
            $unlink = @unlink($file);
                if ($unlink){
                    echo "File ".$file." was deleted";
                }
                else
                    {echo "Error deleting file: ".$file;}
                }
            else {echo "File ".$file." does not exist - cannot delete";}
        
       
        
    }

    public function delete_file_no_checks($file){
      
        $unlink = @unlink($file);
            if ($unlink){
                echo "File ".$file." was deleted";
            }
            else
                {echo "Error deleting file: ".$file;}
           
       
    
   
    
}

    public function get_current_http_url ($folder=""){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }
    public function list_files ($folder="./uploads"){
        return array_diff(scandir($folder), array('..', '.'));
    }
    public function create_file_content_array($folder="./uploads/"){
        if (is_dir($folder)){
            
            $file_name_array= scandir($folder);
            $file_details_array=[];
            $current_index = 0;
            foreach ($file_name_array as $key => $value){
                
                if (is_file($folder.$value)){
                    $file_details_array[$current_index][0]=$value;
                    $file_details_array[$current_index][1]=filesize($folder.$value);
                    $file_details_array[$current_index][2]=filemtime($folder.$value);
                    $current_index++;
                }
            }
            return $file_details_array;

        }
        else {
            echo "Please check the folder... Seems incorrect.";
        }
    }

    public function check_if_file_in_folder ($file, $folder){
        
       
            if(is_dir($folder)){
                $folder_array=scandir($folder);
                function lowercase_name($name){
                    return strtolower($name);
                }
                $lowercase_array=array_map("lowercase_name",$folder_array);
                $file_lowercase = lowercase_name($file);
                if(in_array($file_lowercase, $lowercase_array)){
                    echo "File with same name found in the destination folder. ";
                    return true;
                    
                }
                else {
                    echo "Name valitaded OK. ";
                    return false;
                }
            }
            else {
                echo $folder." is not a valid folder. ";
                return true;
            }
   
        


    }

    public function rename_file($folder='./uploads/',$file,$new_name){
        $org_filepath = $folder.$file;
        $new_filepath = $folder.$new_name;
        rename($org_filepath, $new_filepath);

    }

    }
?>