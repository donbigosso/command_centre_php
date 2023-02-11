<?php
class FileManager {
    protected $parent_folder="./uploads/";
    public function  draw_bootstrap_table_header($header_array){
        echo '<table class="table text-light" >
            <thead>
            <tr>';
            foreach($header_array as $haeder){
                echo'<th scope="col">'.$haeder.'</th>';
            }
        echo '</tr>
        </thead>
        <tbody> ';
    }
    public function close_bootstrap_table(){
        echo'
        </tbody>
        </table>  
        ';
    }

    public function get_file_table($file_handler){
        $file_table = $file_handler->create_file_content_array($this->parent_folder);
        return $file_table;
    }

    public function set_file_folder($new_location){
        $this->parent_folder=$new_location;
    }

    public function draw_inner_table($file_table){
        $parent_folder = $this->parent_folder;
        foreach ($file_table as $key => $value){
            $file_index=$key+1;
            $date = date ("d/m/Y G:i",$value[2]);
            $size_kb = round($value[1]/1000);
            $display_size = $size_kb." KB";
            echo'<tr>';
            echo'<th>'.$file_index.'</th>';
            echo'<td><a href="'.$parent_folder.$value[0].'">'.$value[0].'</a></td>';
            echo'<td>'.$display_size.'</td>';
            echo'<td>'.$date.'</td>';
            echo'<td>';
            echo '<form method="POST" action="take_action.php">';
            echo '<input type="submit" value="Delete" name="submit_delete" class="btn btn-danger float-left margin-left-05em">';
            echo '<input type="hidden" value="'.$value[0].'" name="filename">';
            echo '<input type="hidden" value="'.$_SERVER["PHP_SELF"].'" name="source_page">';
            echo '<input type="hidden" value="'.$parent_folder.'" name="parent_folder">';
            echo '<input type="submit" value="Rename" name="submit_rename" class="btn btn-success float-left margin-left-05em margin-top-1em">';
            echo '</form>';
            echo'</td>';
            echo'</tr>';
        }
    }

    public function draw_full_table($file_handler){
        
        $this->draw_bootstrap_table_header(["#","Filename","Size", "Date modified","Actions"]);
        $file_table = $this->get_file_table($file_handler);
        $this-> draw_inner_table($file_table);
        $this -> close_bootstrap_table();

    }
}

?>