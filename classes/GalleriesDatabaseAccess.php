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
                }
            }
            else {echo "Cannot complete the query...";}
        }




        public function return_gall_table(){
            return $this->gallery_table;
        }
        
        public function create_gallery_table_bkp($gallery_name="Galeria Marysi"){
            $this->execute_mysql_query($this->create_gallery_search_query($gallery_name));
        }

    }
?>