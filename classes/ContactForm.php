<?php
class ContactForm {
    protected $web3forms_key = "4bd68651-0747-4481-bb2a-7004ad773b54";
    protected $form_fields = [["name","text"],["email","email"],["message","textarea"]];
    
    public function f_set_form_fields($input){
        $this->form_fields = $input;
    }

    public function f_no_of_fields(){
        return count($this->form_fields);
    }

    public function draw_form_filelds_html(){
        $f_fields = $this-> form_fields;
        foreach($f_fields as $value){
            if ($value[1]==="text"){
                echo '<input type="text" name="'.$value[0].'" value="'.$value[0].'">';
            }
            else if ($value[1]==="email"){
                echo '<input type="email" name="'.$value[0].'" value="'.$value[0].'">';
            }
            else if ($value[1]==="textarea"){
                echo '<input type="textarea" name="'.$value[0].'" value="'.$value[0].'">';
            }

        }
    }

    public function create_form_layout_web3form(){
        echo '<form action="https://api.web3forms.com/submit" method="POST">';
        echo '<input type="hidden" name="access_key" value="'.$this->web3forms_key.'">';
        $this->draw_form_filelds_html();
        echo '<input type="hidden" name="redirect" value="https://web3forms.com/success">';
        echo '<button type="submit">Submit Form</button>';

    }
}


?>