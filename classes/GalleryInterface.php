<?php
class GalleryInterface {
    protected $gallery_path;
    protected $frame_padding_px =5;
    protected $frame_max_width_px=300;
    protected $picture_inn_background="#19334d";
    protected $caption_desc_frame_color="#b2cce6";
    public function set_gallery_path($gp){
        $this->gallery_path = $gp;
    }
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

    public function GPT_gallery_item($picture_name, $caption, $description="", $picture_id, $gallery_id){
        $picture_path=$this->gallery_path.$picture_name;
        echo '
            <div class="gallery-item">
                <img src="'.$picture_path.'g_bissau_05_min.jpg" alt="Image 1">
                <div class="caption">
                <h3>Image 1 Caption</h3>
                </div>
            </div>
        ';
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

}



//todo
//frame colors as class varialbles, minature handling

?>