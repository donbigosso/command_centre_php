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
    <title>Choose action</title>
</head>
<body>
    <div class="center-box">
        <div class="center-content text-light">
            <h2>
<?php
create_action_header();
?>
            </h2>
            <div class ="action-field">
            <form method="POST" action="request_handler.php">
            
         
               
            
<?php
insert_form_input();
insert_ok_cancel_buttons();
?>            
            
            </form>
            </div>
        </div>
    </div>
</body>
</html>