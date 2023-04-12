<?php
   
    class GalleriesDatabaseAccess {
        protected $servername;
        protected $username;
        protected $password;
        protected $dbname;
        protected $conn;
        protected $gallery_name= "Galeria Marysi";
        protected $gallery_table;
        
        public function create_gallery_variables(){
            $this->servername="localhost:3306";
            $this->username="webdev";
            $this->password="kaszanka";
            $this->dbname = "bgs_galeries";
        }
        
        public function test_db(){
            echo $this-> servername;
        }
        public function establish_conn(){
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error){
                die ("Failed to connect to Donbigosso's database");
                
            }
            else {
               
                return true;
            }
        }



        public function close_conn(){
            $this->conn->close;
            echo "Connection to Donbigosso's database closed.";
            
                
                
        }


        public function execute_mysql_query($query){
            if($this->establish_conn()){
                $result = $this->conn->query($query);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                          print_r($row);
                          echo "<br>";
                      }
                }
            }
            else {echo "Cannot complete the query...";}
        }

        public function create_gallery_search_query($gallery_name){
            return ('
                SELECT
                photos.file_name,
                photos.photo_miniature,
                photos.caption,
                photos.descr,
                picture_id,
                gallery_id
                FROM picture_in_gallery
                INNER JOIN photos
                ON picture_in_gallery.picture_id=photos.id
                INNER JOIN galleries
                ON picture_in_gallery.gallery_id=galleries.id
                WHERE galleries.name = "'.$gallery_name.'";'
            );
        }

        public function photo_id_query ($gallery_id){
            return ('
                SELECT
                picture_id
                FROM picture_in_gallery
                WHERE gallery_id = "'.$gallery_id.'";'
            );
        }

        public function create_id_photo_table($gallery_id){
            $query=$this->photo_id_query($gallery_id);
            $result = $this->conn->query($query); 
            if ($result->num_rows > 0) {
                $pic_id_table=[];
                $i=0;
                while($row = $result->fetch_assoc()) {
                    array_push($pic_id_table,$row["picture_id"]);
                 
                    $i++;
                  }
                
                  return $pic_id_table;
            } 
            else {return false;}    
        }

        public function count_gall_items($gallery_id){
            return count($this->create_id_photo_table($gallery_id));
        }

        public function get_index_by_photo_id($gallery_id,$current_id){
            $photo_id_table= $this->create_id_photo_table($gallery_id);
            $index=null;
            foreach($photo_id_table as $key=>$value){
                //$index = $key;
               if ($current_id==$value) {
                $index = $key;
               }
            }
            return $index;
        }

        public function get_next_or_prev_index($gallery_id,$current_id,$next_or_prev){
            $prev_index=null;
            $next_index=null;
            $current_index=$this->get_index_by_photo_id($gallery_id,$current_id);
            $last_index= $this->count_gall_items($gallery_id)-1;
           if ($current_index < $last_index){
           
            if ($current_index>0){
                $prev_index =$current_index-1;
            }
            $next_index=$current_index+1;
           }
           else if ($current_index == $last_index){
            $prev_index =$current_index-1;
           }
          
           
           if ($next_or_prev=="next"){
            return $next_index;
           }
           else if ($next_or_prev=="prev"){
            return $prev_index;
           }
           else {
            return false;
           }
                
        }

        public function print_next_prev($gallery_id,$current_id){
            $previous = $this->get_next_or_prev_index($gallery_id,$current_id,"prev");
            $next = $this->get_next_or_prev_index($gallery_id,$current_id,"next");
            if ($previous!==null){
            echo "Previous index: ". $previous;}
            if ($next){
            echo " Next index: ".$next;}

        }

        public function is_last_index ($gallery_id,$current_id){
            $previous = $this->get_next_or_prev_index($gallery_id,$current_id,"prev");
            $next = $this->get_next_or_prev_index($gallery_id,$current_id,"next");
            if ($next){
                return false;
            }
            else return true;
        }

        public function is_first_index ($gallery_id,$current_id){
            $previous = $this->get_next_or_prev_index($gallery_id,$current_id,"prev");
           
            if  ($previous!==null){
                return false;
            }
            else return true;
        }

        
     
        public function get_next_or_prev_id($gallery_id,$current_id,$next_or_prev){
            $gall_Table= $this->create_id_photo_table($gallery_id);
            $previous_index = $this->get_next_or_prev_index($gallery_id,$current_id,"prev");
            $next_index = $this->get_next_or_prev_index($gallery_id,$current_id,"next");
            $previous_id=null;
            $next_id = null;
            if ($previous_index!==null){
                $previous_id = $gall_Table[$previous_index];
            }
            if ($next_index){
                $next_id=$gall_Table[$next_index];
            }
            if ($next_or_prev=="next"){
                return  $next_id;
               }
               else if ($next_or_prev=="prev"){
                return $previous_id;
               }
               else {
                return null;
               }


        }

        public function check_if_pic_In_gal($gallery_id, $pic_id){
            $query='SELECT * FROM bgs_galeries.picture_in_gallery
            WHERE picture_id='.$pic_id.' AND gallery_id='.$gallery_id.';';
             if($this->establish_conn()){
                $result = $this->conn->query($query); 
                if ($result->num_rows > 0) {
                    return true;
                } 
                else {return false;} 
             }
        }

        public function check_if_pic_In_gal_connected($gallery_id, $pic_id){
            $query='SELECT * FROM bgs_galeries.picture_in_gallery
            WHERE picture_id='.$pic_id.' AND gallery_id='.$gallery_id.';';
           
                $result = $this->conn->query($query); 
                if ($result->num_rows > 0) {
                    return true;
                } 
                
        }

        public function get_pic_filename_by_id($pic_id){
            $query='SELECT file_name FROM bgs_galeries.photos where id='.$pic_id.';';
            if($this->establish_conn()){
                $result = $this->conn->query($query); 
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        return $row['file_name'];
                    } 
                    else {return false;} 
            }
        }

        public function get_pic_info_by_id($pic_id,$column){
            $query='SELECT '.$column.' FROM bgs_galeries.photos where id='.$pic_id.';';
            if($this->establish_conn()){
                $result = $this->conn->query($query); 
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        return $row[$column];
                    } 
                    else {return false;} 
            }
        }

        public function get_gal_info_by_id($gal_id,$column){
            $query='SELECT '.$column.' FROM bgs_galeries.galleries where id='.$gal_id.';';
            if($this->establish_conn()){
                $result = $this->conn->query($query); 
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        return $row[$column];
                    } 
                    else {return false;} 
            }
        }

  
        
        public function create_gallery_table($gallery_name="Galeria Marysi"){
            if($this->establish_conn()){
                $result = $this->conn->query($this->create_gallery_search_query($gallery_name));
                
                if ($result->num_rows > 0) {
                    $gallery_table=[[],[],[],[],[],[]];
                    $i=0;
                    while($row = $result->fetch_assoc()) {
                        array_push($gallery_table[0],$row["file_name"]);
                        array_push($gallery_table[1],$row["photo_miniature"]);
                        array_push($gallery_table[2],$row["caption"]);
                        array_push($gallery_table[3],$row["descr"]);
                        array_push($gallery_table[4],$row["picture_id"]);
                        array_push($gallery_table[5],$row["gallery_id"]);
                        $i++;
                      }
                      $this->gallery_table = $gallery_table; 
                      return $gallery_table;
                }
            }
            else {return false;}
        }




        public function return_gall_table(){
            return $this->gallery_table;
        }
        
        public function create_gallery_table_bkp($gallery_name="Galeria Marysi"){
            $this->execute_mysql_query($this->create_gallery_search_query($gallery_name));
        }

    }
?>