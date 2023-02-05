<?php
    class FileUploader {
        protected $file;
        protected $uniq_ID;
        protected $file_name;
        protected $file_org_ext;
        protected $file_org_beg;
        protected $file_error;
        protected $file_tmp_name;
        protected $file_loaded;
        protected $file_size;
        protected $file_server_name;
        public $upload_success_message;
        protected $upload_failure_message;
        public function __construct(){
            
            if(isset($_FILES["file"])){
                $this->file = $_FILES['file'];    
                $this->uniq_ID= uniqid('',true);
                $this->file_name = $this->file['name'];
                $this->file_error = $this->file['error'];
                $this->file_tmp_name = $this->file['tmp_name'];
                $this->file_size = $this->file['size'];
                $file_name_arr = explode(".",$this->file_name);
                $this->file_org_ext = end($file_name_arr);
                $filename_arr_copy = $file_name_arr;
                array_pop($filename_arr_copy);
                $this->file_org_beg = implode(".",$filename_arr_copy);
                $this->file_loaded=true;
            }
            else {
              //  echo "Uploading file failed. File does not exist. ";
                $this->file_loaded=false;
            }; 
        }
       
        public function check_file() { //can be removed when not in use anymore
        
                try {
                    
                    if(isset($_FILES["file"])){
                        return true;
                    }
                    else {throw new Exception("Uploading file failed. File does not exist. ");}
                }
                catch (Exception $e) {
                    echo 'Error: ',  $e->getMessage();
                }
           
        }
       
        public function get_file_ID(){
            if ($this->file_loaded){
                return $_POST['fileID'];
            }
        }

        public function get_task(){
            if ($this->file_loaded){
                return $_POST['task'];
            }
        }

        public function get_uniq_ID(){
            return $this->uniq_ID;
        }

        public function get_file_list($file_list, $file_handler) {
            if($file_handler -> check_if_file_exists($file_list)){
                return file_get_contents($file_list);
            }
            else {echo "Error reading file list. ";}
        }

        public function check_if_ID_in_list($list){
            if(gettype($list)==="array"){
                if(in_array($this->get_file_ID(), $list)){
                    return true;
                }
                else {
                    return false;;
                }
            }
            else {
                echo "File list is not valid...";
            }

        }
        public function get_original_filename(){
            
            return $this->file_name;
        }

        public function create_uniq_filename(){
             $file_name_new = $this->file_org_beg."_".$this->uniq_ID.".".$this->file_org_ext;
            return $file_name_new;
        }

        public function conduct_checks($max_kb_size=1000, $allowed = array('jpg','jpeg','png',"gif")){
            if($max_kb_size>1){
                $type = gettype($allowed);
                $extenison = strtolower($this->file_org_ext);
                if ($type === "array"){
                    $allowed_string = implode(", ",$allowed);
                    if (in_array($extenison, $allowed)){
                        if ($this->file_size <$max_kb_size*1024){
                            return true;
                        }
                        else {
                            $actual_file_size_kb = round($this->file_size/1024,1);
                            echo "File is too big. Max size is ".$max_kb_size."kB. You are trying to upload file of ".$actual_file_size_kb."kB";
                        }
                        
                    }
                    else {
                        echo "Unsuported extension. Allowed: ".$allowed_string.". ";
                        return false;
                    }
                }
                else {
                    echo "Allowed file extensions must be provided in a form of an array. ";
                    return false;
                }
            }
            else {
                echo "Max file size must be greater than 0. Please check requirement setup. ";
                return false;
            }
        }

        public function upload_file($filename_usr="",$max_kb_size=1000, $upl_folder="./uploads/",$allowed = array('jpg','jpeg','png',"gif")){
            $file = $_FILES['file'];
            $fileName = $this->file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileExt = explode(".",$fileName);
            $file_org_beg = $fileExt[0];
            $file_org_ext = end($fileExt);
            $this->file_org_ext = strtolower($file_org_ext);
            $allowed_string = implode(", ",$allowed);
            if (in_array($this->file_org_ext, $allowed)){
                if ($fileError===0){
                    if ($fileSize<$max_kb_size*1000){
                        if ($filename_usr ===""){
                            $file_name_new = $file_org_beg."_".uniqid('',true).".".$file_org_ext; //if we want an unique id added, we can add the following to the file name: "_".uniqid('',true)
                        }
                        else {
                            $file_name_new = $filename_usr.".".$this->file_org_ext;
                        }
                        $file_destination = $upl_folder.$file_name_new;
                        move_uploaded_file($fileTmpName, $file_destination);
                        echo "File ".$fileName." successfully uploaded as ".$file_name_new.". ";
                       
                    }
                    else {
                        echo "The file is too big. Max size is: ".$max_kb_size."KB";
                    }
                }
                else {
                    echo "Error uploading file...";
                }
            }
            else {
                echo "Unsuported extension. Allowed: ".$allowed_string.". ";
            }
        }

        public function no_error_upl($upl_folder){
            $file_destination = $upl_folder.$this->file_server_name;
            move_uploaded_file($this->file_tmp_name, $file_destination);
            $this->upload_success_message = "File ".$this->file['name']." successfully uploaded as ".$this->file_server_name.". ";
        }
        

        public function upload_file_no_checks($filename_usr="", $upl_folder="./uploads/",$unique_name=false){
            if ($this->file_error===0){
                if ($filename_usr ===""){
                    if($unique_name){
                        $this->file_server_name = $this->create_uniq_filename();
                        }
                        else {
                            $this->file_server_name = $this->file_name;
                        }
                }
                else {
                    $this->file_server_name = $filename_usr.".".$this->file_org_ext;
                }
                $this->no_error_upl($upl_folder);
            } else {
                echo "Error uploading file...";
            }
        }

        public function upload_file_donbi($filename_usr="", $upl_folder="./uploads/",$unique_name=false){
            if ($this->file_error===0){
                if ($filename_usr ===""){
                    if($unique_name){
                        $this->file_server_name = $this->create_uniq_filename();
                        }
                        else {
                            $this->file_server_name = $this->file_name;
                        }
                }
                else {
                    $this->file_server_name = $filename_usr.".".$this->file_org_ext;
                }
                $this->no_error_upl($upl_folder);
                return true;
            } else {
                echo "Error uploading file...";
                return false;
            }
        }

      public function insert_uploader_bootstrap($handler="request_handler.php"){
        echo '<h2>File uploader</h2>
        <form method="POST" action="'.$handler.'" enctype="multipart/form-data">       
            <div class="row">
                <div class="col-md padding-5">
                    <input class="form-control" type="file" id="file" name="file">
                </div>
                <div class="col-md padding-5">
                   <input type="hidden" value="'.$_SERVER["PHP_SELF"].'" name="source_page">
                   <input type="submit" value="Upload" name="submit_upload" class="btn btn-primary">
                </div>
             </div>
        </form>
        ';
      }

    }

    


   
?>