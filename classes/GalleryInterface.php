<?php
class GalleryInterface {
    protected $gallery_path;
    protected $gallery_interface_path;
    protected $frame_padding_px =5;
    protected $frame_max_width_px=300;
    protected $picture_inn_background="#19334d";
    protected $caption_desc_frame_color="#b2cce6";
    
    public function set_gallery_path($gp){
        $this->gallery_path = $gp;
    }

    public function set_gallery_interface_path($gip){
        $this->gallery_interface_path = $gip; }

    public function create_html_inner_pic($picture_name, $caption=""){
        $picture_path=$this->gallery_path.$picture_name;
        echo '<img src="'.$picture_path.'" alt="'.$caption.'" class="inner_miniature_pic" style="max-height: '.$this->frame_max_width_px.'px"/>';
    }

    public function insert_gallery_inn_frame($picture_name, $caption){
        $frame_max_width=$this->frame_max_width_px."px";
        echo '<div class="inn_pic_frame" style="max-width: '.$frame_max_width.'" >';
        $this->create_html_inner_pic($picture_name, $caption);
        echo'</div>';
    }

    public function insert_gallery_out_frame($picture_name, $caption, $description=""){
        $out_frame_max_width=$this->frame_padding_px*2+$this->frame_max_width_px;
      
        $frame_style='"padding: '.$this->frame_padding_px.'px; max-width: '.$out_frame_max_width.'px; background-color:'.$this->picture_inn_background.'; border-color: '.$this->caption_desc_frame_color.'; color:'.$this->caption_desc_frame_color.' "';
        echo '<div class="out_pic_frame" style='.$frame_style.' >';
        $this->insert_gallery_inn_frame($picture_name, $caption);
        echo '<b>'.$caption.'</b><br> '.$description;
        echo'</div>';
    }

    public function insert_items($filename_arr, $miniature_arr="", $caption_arr, $desc_arr){
        $gall_size= count($filename_arr);
        for ($i=0; $i<$gall_size; $i++){
            if (@$miniature_arr[$i]){
                $this->insert_gallery_out_frame($miniature_arr[$i],$caption_arr[$i],$desc_arr[$i]);    
            }
            else {
                $this->insert_gallery_out_frame($filename_arr[$i],$caption_arr[$i],$desc_arr[$i]);
            }
        }
    }

   

    public function GPT_gallery(){
        $gp= $this->gallery_path;
        echo '
            <div class="gallery">
            <div class="gallery-item">
                <img src="'.$gp.'g_bissau_05_min.jpg" alt="Image 1">
                <div class="caption">
                <h3>Image 1 Caption</h3>
                </div>
            </div>
            <div class="gallery-item">
                <img src="'.$gp.'g_bissau_06_min.jpg" alt="Image 2">
                <div class="caption">
                <h3>Image 2 Caption</h3>
                </div>
            </div>
            <div class="gallery-item">
                <img src="'.$gp.'g_bissau_01_min.jpg" alt="Image 3">
                <div class="caption">
                <h3>Image 3 Caption</h3>
                </div>
            </div>
            </div>
        ';
    }

    public function content_test(){
        echo'<h3>Content test</h3>';
    }

    public function GPT_gall_container($picture_name, $caption, $description){
        echo '<div class="gallery">';
        $this->GPT_gall_item($picture_name, $caption, $description);
        echo '</div>';
    }

    public function insert_GPT_items ($picture_arr, $miniature_arr, $caption_arr, $pic_id_arr=null, $gal_id_arr=null){
        $gall_size= count($picture_arr);
        
        for ($i=0; $i<$gall_size; $i++){
            if (@$miniature_arr[$i]){
                
                $this->GPT_gall_item($miniature_arr[$i], $caption_arr[$i], $pic_id_arr[$i], $gal_id_arr[$i]);
            }
            else {
                $this->GPT_gall_item($picture_arr[$i], $caption_arr[$i], $pic_id_arr[$i], $gal_id_arr[$i]);
            }
        }
    }
    public function GPT_gall_container_new($picture_arr=null, $miniature_arr=null, $caption_arr=null, $pic_id_arr=null, $gal_id_arr=null){
        echo '<a name="gallery"></a>';
        echo '<div class="gallery">';
       
     //  $this->GPT_gall_item($picture_arr[1]);
        $this->insert_GPT_items ($picture_arr, $miniature_arr, $caption_arr, $pic_id_arr, $gal_id_arr);
        echo '</div>';
    }

    public function GPT_gall_item($picture_name, $caption=null, $pic_id=null, $gal_id=null){
        $picture_path=$this->gallery_path.$picture_name;
        
        echo'<form method="POST" action="'.$this->gallery_interface_path.'?pic_id='.$pic_id.'&gal_id='.$gal_id.'">';
       echo '<input type="hidden" name="source_page" value="'.$_SERVER["PHP_SELF"].'">';
       echo '<input type="hidden" name="pic_id" value="'.$pic_id.'">';
       echo '<input type="hidden" name="gal_id" value="'.$gal_id.'">';
        echo '<div class="gallery-item">';
       echo '<input type="image" name="btn_opentextbox" src="'.$picture_path.'" value="Submit" alt="'.$caption.'" />';
     //   echo '<img src="'.$picture_path.'" alt="Image 3">';
       //echo 'Form';
       // echo $picture_path;
        echo'</form>';
        echo'<div class="caption">
        <h3>'.$caption.'</h3>
        </div>';
        echo '</div>';
    }

    public function insert_closing_button(){
        if (isset($_POST['source_page'])){
            $source_page=$_POST['source_page'];
            echo '
                <div class="close-window"><a href="'.$source_page.'#gallery">&#x2573;</a></div>
            ';
        }
    }
    
    public function show_gallery_main_pic($path="http://donbigosso.polafri.pl/photos/",$filename){
        $full_path=$path.$filename;
        echo '
        <img
        src="'.$full_path.'"
        alt="'.$filename.'"
        />
        ';
     }
    
}




//todo
//frame colors as class varialbles, minature handling

?>