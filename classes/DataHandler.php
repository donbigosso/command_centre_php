<?php
    class DataHandler {
        

        public function decode_data($data){
            if($data) {
                try {
                    
                    $json_content  = json_decode($data, TRUE);
                    if($json_content){
                        return $json_content;
                    }
                    else {throw new Exception("Data is not a valid json. Can't decode. Please check it. ");}
                }
                catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }

        public function encode_data($data){
            try {
                $encoded_data = json_encode($data, JSON_UNESCAPED_UNICODE);
                return $encoded_data;
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }
        public function check_if_object($data){
           $type = gettype($data);
           if ($type === "array"){
            return true;
           }
           else {return false;
            }
        }
        public function get_keys($data){
            try {
                if ($this->check_if_object($data)){
                    $keys = array_keys($data);
                    return $keys;  
                }
                else {
                    throw new Exception("Data is not a valid array/object. Can't get keys. ");
                }
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }

        }

        public function check_key_consistency($object1,$object2){
            try {
                if ($this->check_if_object($object1)&&$this->check_if_object($object2)){
                    if($this->get_keys($object1)===$this->get_keys($object2)){
                        return true;
                    }
                    else {
                        return false;
                    }  
                }
                else {
                    throw new Exception("One or both objects are not valid. Can't compare keys.");
                }
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }

        public function add_key_value_pair ($array, $key, $value){
            try {
                if ($this->check_if_object($array)&&!$this->check_if_object($key)){
                    $array[$key] = $value;
                    return $array;  
                }
                else {
                    throw new Exception("Array is invalid or key is an object. Can't append.");
                }
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }

        public function check_array_key_integrity($array, $key_array){
            try{
                $array_length =count($array);

                for ($i=0;$i<$array_length;$i++){
                    $array_keys = $this->get_keys($array[$i]);
                    
                    if (!$this->check_key_consistency($array_keys, $key_array)){
                        $check_value=false;
                        throw new Exception("Key inconsistency at index: ".$i);
                    }
                    else {$check_value=true;}               
                   
                }
                return $check_value;
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }

        public function add_key_value_pairs_to_whole_array($array,$key,$value){
            try{
                if ($this->check_if_object($array)){
                    $length = count($array);
                    for ($i=0;$i<$length;$i++){
                        $array[$i]=$this->add_key_value_pair($array[$i],$key,$value);
                    };
                    return $array;
                }
                else {
                    throw new Exception("Array provided is not a valid array/object.");
                }
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }

        public function remove_key_value_pair($array,$key){
            try {
                if ($this->check_if_object($array)&&!$this->check_if_object($key)){
                    $keys = $this->get_keys($array);
                    if(in_array($key, $keys)){
                        unset($array[$key]);
                        return $array;
                    }
                    else {
                        throw new Exception("The key '$key' is not present in the array. Cannot delete something that does not exist!");
                    };
                    
                }
                else {
                    throw new Exception("Array provided is not a valid array/object or key is incorrect.");
                }
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }

        public function change_value_at_key($array,$key,$new_value){
            try {
                if ($this->check_if_object($array)&&!$this->check_if_object($key)){
                    $keys = $this->get_keys($array);
                    if(in_array($key, $keys)){
                       $array[$key]=$new_value;
                        return $array;
                    }
                    else {
                        throw new Exception("The key '$key' is not present in the array. Cannot change something that does not exist!");
                    };
                    
                }
                else {
                    throw new Exception("Array provided is not a valid array/object or key is incorrect.");
                }
            }
            catch (Exception $e) {
                echo 'Error: ',  $e->getMessage();
            }
        }

        
    }


?>