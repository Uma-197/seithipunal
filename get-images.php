<?php
$directory = "postimages/";
$images = glob($directory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

foreach ($images as $image) {
   $imageName = basename($image);
   echo '<div class="col-md-3">';
   echo '<img src="' . $directory . $imageName . '" class="img-thumbnail" onclick="selectImage(\'' . $imageName . '\')" style="cursor:pointer;">';
   echo '</div>';
}
?>
