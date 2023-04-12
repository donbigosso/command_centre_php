<?php
include "./classes/FileUploader.php";
include "./classes/FileHandler.php";
include "./classes/ContactForm.php";
include "./classes/DataHandler.php";
include "./classes/FlightSearch.php";
include "./classes/FileManager.php";
include "./classes/GalleriesDatabaseAccess.php";
include "./classes/GalleryInterface.php";

function draw_file_list($parent_folder){
    $file_array = array_diff(scandir($parent_folder), array('..', '.'));
    
    foreach ($file_array as $key => $value){
        $real_key=$key-1;
        echo '
        <tr><th scope="row">'.$real_key.'</th><td><a href="'.$parent_folder.$value.'">'.$value.'</a></td>
        
        <td>
        <form method="POST" action="request_handler.php">
        <input type="hidden" value="'.$value.'" name="delete">
        <input type="hidden" value="'.$_SERVER["PHP_SELF"].'" name="source_page">
        <input type="submit" value="Delete" name="submit_delete" class="btn btn-danger">
        </form>
        </td></tr>';
    }

}

function insert_file_component($file_list_function, $parent_folder="./uploads/"){
    
    echo '
    <h2>Files</h2>';
    draw_bootstrap_table_header(["#","Filename","Action"]);
    
    $file_list_function($parent_folder);
    echo'
    </tbody>
    </table>  
    ';
}





function insert_new_file_component(){
    h2_header("File list");
    $fm = new FileManager;
    $fh = new FileHandler;
    $fm->draw_full_table($fh);
    

};

function delete_file($folder="./uploads/"){
    if(isset($_POST['submit_delete'])){
        $file_name=$_POST['delete'];
        $file_path=$folder.$file_name;
        @unlink($file_path);
        go_back_with_GET();
    
        
    }
    
}

function create_action_header(){
    if(isset($_POST['submit_delete'])){
        echo 'Do you really want to delete '.$_POST['filename'].'?';
    }
    else if (isset($_POST['submit_rename'])){
        echo 'Type new name for '.$_POST['filename'].'.';
    }
    else if (isset($_GET['error'])){
       
        if ($_GET['error']==="name_used"){
            echo 'File with same name already present in the folder!';
        }
        else if ($_GET['error']==="name_empty"){
            echo 'Filename cannot be empty!';
        }
        else if ($_GET['error']==="no_upl_sel"){
            echo 'No file selected!';
        }
    }
    else if (isset($_GET['success'])){
        if ($_GET['success']==="file_renamed"){
            echo 'File successfully renamed!';
        }
        else if ($_GET['success']==="file_deletd"){
            echo 'File successfully deleted!';
        }
        else if ($_GET['success']==="file_uploaded"){
            echo 'File successfully uploaded!';
        }

    }

}



function insert_uploader_old(){
    echo '<h2>File uploader</h2>
    <form method="POST" action="request_handler.php" enctype="multipart/form-data">       
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

function insert_uploader(){
    $fu = new FileUploader;
    $fu-> insert_uploader_bootstrap();
}

function insert_form_input(){
    if (isset($_POST['submit_rename'])){
        echo ' <div class="form-group row">'; 
        echo '<input type="text" class="form-control" name="user_filename" id="input" value="'.$_POST['filename'].'">';
        echo '<input type="hidden" value="'.$_SERVER["PHP_SELF"].'" name="source_page">';
        echo '<input type="hidden" value="'.$_POST["filename"].'" name="original_filename">';
        echo '<input type="hidden" value="'.$_POST["parent_folder"].'" name="parent_folder">';
        echo '<input type="hidden" value="submit_rename" name="original_request">';
        echo '</div>';
    }
    else if (isset($_POST['submit_delete'])){
        echo '<input type="hidden" value="submit_delete" name="original_request">';
        echo '<input type="hidden" value="'.$_POST["filename"].'" name="original_filename">';
        echo '<input type="hidden" value="'.$_POST["parent_folder"].'" name="parent_folder">';
        echo '<input type="hidden" value="'.$_SERVER["PHP_SELF"].'" name="source_page">';   
    }
    
}

function insert_ok_cancel_buttons(){
    if (!empty($_POST)){
        echo '<div class="form-group row padding-5">';
        echo '<div class="col-6">';
        echo '<input type="submit" value="OK" name="submit_ok" class="btn btn-success  center-margin">';
        echo '</div>';
        echo '<div class="col-6" >';
        echo '<input type="submit" value="Cancel" name="submit_cancel" class="btn btn-danger    center-margin">';
        echo '</div>';
        echo '</div>';
        
    }
    else if (isset($_GET['error']) || isset($_GET['success'])){
        insert_ok_go_back_btn();
    }
}

function insert_ok_go_back_btn(){
    echo '<div class="form-group row padding-5">';
    echo '<div class="col">';
    echo '<input type="submit" value="OK" name="error_ok" class="btn btn-success  center-margin">';
    echo '</div>';
    echo '</div>';
}

function test(){
   echo "<h1>This is a test function</h1>"; 
   echo '<h1 id="test_h1">Nothing</h1>';
   echo'<div id="test_2">AAAA</div>';
   echo "<script>test();
   test2();
   </script>";
  
  
}

function display_file_detail_array(){
    echo "<h1>File array</h1>";
    $fh = new FileHandler;
    print_r($fh->create_file_content_array());
}

function insert_contact_form(){
    h2_header("Send me a message");
    $cf = new ContactForm;
   
    $cf->create_web3form_bootstrap(get_setting_value("web3forms_key"));

}


function file_uploader_2(){
    ini_set('upload_max_filesize', '30M');
    if(isset($_POST['submit_upload'])){
        $fu = new FileUploader;
        if($fu -> upload_file_donbi()){
            header('Location: take_action.php?success=file_uploaded');
        }
        else {
            echo "No file selected. ";
            header('Location: take_action.php?error=no_upl_sel');
            
        }

       
        
        
        
    };
}





function go_back_with_GET ($get_query="",$get_value=""){
    
    if(isset($_POST['source_page'])){
        $source_page = $_POST['source_page'];
       if ($get_query ===""){
            header('Location: '.$source_page); 
       }
       else {header('Location: '.$source_page."?".$get_query."=".$get_value);}
    }
    else {
        if ($get_query ===""){
         header('Location: index.php'); 
        }
        else {header('Location: index.php?'.$get_query.'='.$get_value);}
    }
}

function display_message($message,$color="green"){
    echo '
    <span style="color:'.$color.'">'.$message.'</span>
    ';
}





function send_curl_post_data($url = 'http://localhost/my/donbigosso/curl_test.php', $data = "name=jane&age=23"){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($curl);
    curl_close($curl);
    return ($result);

   
}

function curl_test(){
    echo "<h2>This is a curl test function</h2>"; 
      print_r(send_curl_post_data());
 }



 function request_validate_action(){
    if (isset ($_POST["submit_ok"])){
        print_r($_POST);
        //for file rename 
       
        if($_POST['original_request']==='submit_rename'){ 
            if($_POST["user_filename"]===""){
                go_back_with_GET("error","name_empty");
            }
            else {
                $fh = new FileHandler;
                $new_file_name= $_POST["user_filename"];
                $folder = $_POST["parent_folder"];
                if (!$fh -> check_if_file_in_folder($new_file_name,$folder)){
                    //proceed with rename and go back
                    $org_filename = $_POST["original_filename"];
                    $fh->rename_file($folder, $org_filename, $new_file_name);
                    go_back_with_GET("success","file_renamed");
                }
                else {
                    go_back_with_GET("error","name_used");
                }
            }

        }
        else if ($_POST['original_request']==='submit_delete'){
            //actions for seleting file
            echo "Will delete file";
            $folder = $_POST["parent_folder"];
            $fh = new FileHandler;
            $file_path = $_POST["parent_folder"].$_POST["original_filename"];
            $fh->delete_file_no_checks($file_path);
            go_back_with_GET("success","file_deletd");
        }

        

    }
    else if(isset($_POST["submit_cancel"])){
        header('Location: index.php');
    }

    else if (isset($_POST["error_ok"])){
        header('Location: index.php');
}

 }

 function h2_header($text){
    echo "<h2>";
    echo $text;
    echo "</h2>";
 }

 function get_setting_value($set_name){
    $fh = new FileHandler;
    $dh = new DataHandler;
    $set_fil_cont = $fh-> get_file_content("./data/settings.json");
    $set_fil_data = $dh->decode_data($set_fil_cont);
    $setting_value = $set_fil_data[$set_name];
    return $setting_value;
 }

 function set_test(){
    h2_header("Settings test");
    echo get_setting_value("web3forms_key");

 }

 function sky_scanner(){
    $fs = new FlightSearch;
    h2_header("Flights to Gambia");
    $fs -> sky_scaner_widget();
 }




 function gall_test(){
    h2_header("Gallery testing");
    $gda = new GalleriesDatabaseAccess;
    $gda ->create_gallery_variables();
    $gda->create_gallery_table();
    $gal_tab=$gda->return_gall_table();
    $gi = new GalleryInterface;
    $gi->set_gallery_path("http://donbigosso.polafri.pl/photos/");
    $gi->insert_items($gal_tab[0],$gal_tab[1],$gal_tab[2],$gal_tab[3]);
   
   // $gi->insert_gallery_out_frame("Ewa_birthday_07.jpg","Dzieci siedzą w kole...","Marysia ubiera uprząż.");
   // $gi->insert_gallery_out_frame("Ewa_birthday_13.jpg","Mapa skarbów","Ciekawe gdzie jest skarb?");
   // $gi->insert_items(["g_bissau_02.jpg","g_bissau_08.jpg","g_bissau_07.jpg"],["g_bissau_02_min.jpg",null,"g_bissau_07_min.jpg"],["Photo 1","Photo 2","Photo 3"],["Description of the first picture", "Description of the second picture","Description of the third picture"]);
 
 
   
 }

 function GPT_gall(){
    h2_header("GPT Gallery testing");
    $gi = new GalleryInterface;
    $gi->set_gallery_path("http://donbigosso.polafri.pl/photos/");
    $gi->GPT_gallery();
 }


 function get_pic_data(){
    $gda = new GalleriesDatabaseAccess;
    @$get_pic_id=intval($_GET["pic_id"]);
    @$get_gal_id=intval($_GET["gal_id"]);
    $gda ->create_gallery_variables();
    echo 'Pic id: '.$get_pic_id.' gal ID: '.$get_gal_id;
    var_dump($gda ->check_if_pic_In_gal($get_gal_id,$get_pic_id));
    var_dump ($gda->get_pic_filename_by_id(12));
 }

 function pic_filename_from_get(){
    @$get_pic_id=intval($_GET["pic_id"]);
    $gda = new GalleriesDatabaseAccess;
    $gda ->create_gallery_variables();
    return $gda->get_pic_filename_by_id($get_pic_id);

 }

 function pic_subm_test(){
    $api_beg="api_donbigosso.php";
    $get_vals="?test=answer";
    $img="http://donbigosso.polafri.pl/photos/Ewa_birthday_12_min.jpg";
    $api=$api_beg.$get_vals;
    echo'
    <form action="'.$api.'" method="POST">
    <input type="image" name="btn_opentextbox" src="'.$img.'" value="Submit" />
    </form>
 
    ';

 }

 function show_gallery_main_pic($path="http://donbigosso.polafri.pl/photos/",$filename){
    $full_path=$path.$filename;
    echo '
    <img
    src="'.$full_path.'"
    alt="'.$filename.'"
    />
    ';
 }

 function add_gal_prev_nav(){
    $gi = new GalleryInterface;
    $gi-> insert_closing_button();
 }

 function insert_GPT_gall(){
    $gda = new GalleriesDatabaseAccess;
    $gda ->create_gallery_variables();
    $gda->create_gallery_table();
    $gal_tab=$gda->return_gall_table();
    $gi = new GalleryInterface;
    $gi -> set_gallery_path("http://donbigosso.polafri.pl/photos/");
    $gi -> set_gallery_interface_path("http://localhost/my/donbigosso/gallery_preview.php");
    $gi->GPT_gall_container_new($gal_tab[0],$gal_tab[1],$gal_tab[2],$gal_tab[4],$gal_tab[5]);
 }
?>

