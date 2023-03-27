<?php
    
    include "./functions/php-functions.php";
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
      <img
        src="http://donbigosso.polafri.pl/photos/Ewa_birthday_05_min.jpg"
        alt="Picture 1"
      />
      <div class="caption-full-sc">
        <?php
        get_pic_data();
        
        ?>
      </div>
      <div class="prev">&#10094;</div>
      <div class="next">&#10095;</div>
      <div class="number-text">1 / 3</div>
    </div>
  </body>
</html>
