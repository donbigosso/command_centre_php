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

    public function draw_form_filelds_bootstrap(){
        $f_fields = $this-> form_fields;
        foreach($f_fields as $value){
            if ($value[1]==="text"){
                $label=$value[0];
                if ($value[0]==="name"){
                    $label = "Your name";
                }
              // echo '<input type="text" name="'.$value[0].'" placeholder="'.$value[0].'">';
                echo '
                <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">'.$label.'</span>
                <input type="text" name="'.$value[0].'" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                </div>
                ';
            }
            else if ($value[1]==="email"){
                $label=$value[0];
                if ($value[0]==="email"){
                    $label = "Your email";
                } 
               // echo '<input type="email" name="'.$value[0].'" placeholder="'.$value[0].'">';
               echo '
               <div class="input-group input-group-sm mb-3">
               <span class="input-group-text" id="inputGroup-sizing-sm">'.$label.'</span>
               <input type="email" name="'.$value[0].'" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
               </div>
               ';
            }
            else if ($value[1]==="textarea"){
                $label=$value[0];
                if ($value[0]==="message"){
                    $label = "Your message";
                }
               // echo '<input type="textarea" name="'.$value[0].'" placeholder="'.$value[0].'">';
               echo '
               <div class="input-group input-group-sm mb-3">
               <span class="input-group-text" id="inputGroup-sizing-sm">'.$label.'</span>
               <input type="textarea" name="'.$value[0].'" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
               </div>
               ';
            }

        }
    }

    public function create_form_layout_web3form(){
        echo '<form action="https://api.web3forms.com/submit" method="POST">';
        echo '<input type="hidden" name="access_key" value="'.$this->web3forms_key.'">';
        $this->draw_form_filelds_bootstrap();
        echo '<input type="hidden" name="redirect" value="https://web3forms.com/success">';
        echo '<button type="submit">Submit Form</button>';

    }

    public function create_web3form_bootstrap(){
        echo '<div class="mb-3">';
        echo '<form action="https://api.web3forms.com/submit" method="POST">';
        echo '<input type="hidden" name="access_key" value="'.$this->web3forms_key.'">';
        $this->draw_form_filelds_bootstrap();
        echo '<input type="hidden" name="redirect" value="https://web3forms.com/success">';
        echo '<button type="submit" class="btn btn-primary m-3 p-3">Submit Form</button>';
        echo '</form>';
        echo '</div>';
    }
}


?>