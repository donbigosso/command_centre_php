<?php
   
    class GalleriesDatabaseAccess {
        protected $servername;
        protected $username;
        protected $password;
        protected $dbname;
        protected $conn;
        protected $gallery_name= "Galeria Marysi";
        
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
                echo "Connection to Donbigosso's database established";
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
                photos.descr
                FROM picture_in_gallery
                INNER JOIN photos
                ON picture_in_gallery.picture_id=photos.id
                INNER JOIN galleries
                ON picture_in_gallery.gallery_id=galleries.id
                WHERE galleries.name = "'.$gallery_name.'";'
            );
        }
        public function create_gallery_search_query_bkp($gallery_name){
            return ('
                SELECT
                picture_in_gallery.id,
                photos.caption,
                picture_in_gallery.date_added
                FROM picture_in_gallery
                INNER JOIN photos
                ON picture_in_gallery.picture_id=photos.id
                INNER JOIN galleries
                ON picture_in_gallery.gallery_id=galleries.id
                WHERE galleries.name = "'.$gallery_name.'";'
            );
        }
        
        
        public function create_gallery_table($gallery_name="Galeria Marysi"){
            $this->execute_mysql_query($this->create_gallery_search_query($gallery_name));
        }

    }
?>