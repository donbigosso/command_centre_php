<?php
    
    include "./functions/php-functions.php";
    $gi = new GalleryInterface;
    $gda = new GalleriesDatabaseAccess;
    $gda ->create_gallery_variables();
    $gda ->establish_conn();
    @$pic_get_id=intval($_GET["pic_id"]);
    @$gal_get_id=intval($_GET["gal_id"]);
    $in_gal = $gda->check_if_pic_In_gal_connected($gal_get_id, $pic_get_id);
    @$current_index= $gda->get_index_by_photo_id($gal_get_id, $pic_get_id);
    $current_page = $_SERVER['PHP_SELF'];
    @$is_last = $gda->is_last_index($gal_get_id, $pic_get_id);
    @$is_first = $gda->is_first_index($gal_get_id, $pic_get_id);
    @$previous_id = $gda->get_next_or_prev_id($gal_get_id, $pic_get_id,"prev");
    @$next_id = $gda->get_next_or_prev_id($gal_get_id, $pic_get_id,"next");
    @$source_page = $_POST["source_page"];
  //  $pic_in_gal= $gda ->check_if_pic_In_gal_connected($gal_get_id,$pic_get_id);
?>
<!DOCTYPE html>
<html>

  <head>
    <title>Responsive Picture Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body class name="body-gal-prev">
    <div class="container-gal-prev">
      <?php
      if($in_gal){
        $gi-> show_gallery_main_pic("http://donbigosso.polafri.pl/photos/",pic_filename_from_get());}
        else h2_header("Picture not found...");
      ?>
      <div class="caption-full-sc">
        <?php
       // get_pic_data();
        if($in_gal){
        echo '<b>'.$gda->get_pic_info_by_id($pic_get_id,"caption").' </b>';
        echo $gda->get_pic_info_by_id($pic_get_id,"descr");
      //  var_dump($gda->is_last_index($gal_get_id, $pic_get_id));
       
      //  echo  $previous_id;
       
       //print_r($gda->create_id_photo_table($gal_get_id));
 
       //to do - add new functions in gda class - to handle pic position in php table (results fetched from mysql)

      
        }
       
        ?>
      </div>
      <?php 
        add_gal_prev_nav();
      ?>
      <form class="pic-prev-nav-form" method="POST" action="<?php echo $current_page.'?gal_id='.$gal_get_id.'&pic_id='.$previous_id ?>">
      <input type="hidden" name="source_page" value="<?php echo $source_page; ?>" />
      <div class="prev" <?php
      if($is_first){
       echo 'style="visibility:hidden;"';}
      ?>>
      <input type="submit" value="&#10094;"/>
      </div>
      </form>
      <form class="pic-prev-nav-form" method="POST" action="<?php echo $current_page.'?gal_id='.$gal_get_id.'&pic_id='.$next_id ?>"> 
      <input type="hidden" name="source_page" value="<?php echo $source_page; ?>" />
      <div class="next"
      
      <?php
      if($is_last){
       echo 'style="visibility:hidden;"';}
      ?>>
      <input type="submit" value="&#10095;"/>  
      </div>
      </form>
      <div class="number-text">
        <?php
        if($in_gal){
          
          echo intval($current_index+1);
        echo " / ";  
        echo $gda-> count_gall_items($gal_get_id);
        }
        ?>
      </div>
      
    </div>
  </body>
</html>
