<?php
    
    include "./functions/php-functions.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    
    <title>Donbigosso's World</title>
</head>
<body>
    <div class="container bg-dark text-light">
        
            <img  src="./images/maria_1_zab.jpg" class="img-fluid" alt="Responsive image"></img>    
            <div class="sticky-top bg-dark" >
                <h1>Donbigosso's Command Centre</h1>
            </div>
            <div class="main-content">
          
            
        <?php
        $gi = new GalleryInterface;
        insert_uploader();
        insert_new_file_component();
        //pic_subm_test();
        GPT_gall();
      // gall_test();
       // database_test();
       
       insert_GPT_gall();
        insert_contact_form();
        sky_scanner();
        
        ?>
        
            </div>
        
    </div>


</body>
</html>