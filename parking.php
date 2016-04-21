<?php
$MIN_HEIGHT = 400;


$height = 0;
$data = explode('`',$_GET["data"]);

for($x=0;$x<count($data);$x++){
  if($data[$x] == "") $height += 35;
  else $height += 70;
}

$offsetY = 0;
if($_GET["type"] == 2){
  $offsetY = 110;
  $height += 35;
}


if($height+260 < $MIN_HEIGHT) $height = $MIN_HEIGHT-260;
$height += $offsetY;


$font = "./arialnb.ttf";

header("Content-type: image/png");
$im = imagecreatetruecolor(600, $height+260);


// COLORS
$white = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 148, 39, 45);
$green = imagecolorallocate($im, 0, 130, 74);

$type = $_GET["type"];
$arrow = $_GET["arrow"];
$hours = $_GET["hours"];

// No parking sign
imagefilledrectangle($im, 0, 0, 600, $height+260, $white);


if($type == 1){ // NO STANDING
  imagefilledrectangle($im, 10, 10, 590, $height+250, $red);
  imagettftext($im, 55, 0, 35, 90, $white, $font, "NO STANDING");
  $textcolor = $white;
} 
else if($type == 2){ // METERED PARKING
  imagefilledrectangle($im, 10, 10, 590, $height+250, $green);
  imagefilledrectangle($im, 20, 20, 580, $height+240, $white);

  imagettftext($im, 40, 0, 230, 65, $green, $font, "hour");
  imagettftext($im, 40, 0, 230, 125, $green, $font, "metered");
  imagettftext($im, 40, 0, 230, 185, $green, $font, "parking");

  $x = 60;
  if(strlen($hours) == 2) $x -= 40;

  // hour designation
  imagefilledrectangle($im, 20, 20, 200, 190, $green);
  imagettftext($im, 140, 0, $x, 170, $white, $font, $hours);
  $textcolor = $green;
}
else { // NO PARKING (default)
  imagefilledrectangle($im, 10, 10, 590, $height+250, $red);
  imagefilledrectangle($im, 20, 20, 580, $height+240, $white);
  imagettftext($im, 55, 0, 35, 90, $red, $font, "NO PARKING");
  $textcolor = $red;
}


$y = 180+$offsetY;
for($x=0;$x<count($data);$x++){
  if($data[$x] == ""){
    $y += 35;
  } else {
    imagettftext($im, 45, 0, 35, $y, $textcolor, $font, $data[$x]);
    $y += 70;
  }
}


// arrow
$hh = $height+190;
imagefilledrectangle($im, 50, $hh-10, 400, $hh+10, $textcolor);
if($arrow != 2) imagefilledpolygon($im, array(35,$hh, 80,$hh+30, 80,$hh-30), 3, $textcolor); // arrow left
if($arrow != 1) imagefilledpolygon($im, array(420,$hh, 375,$hh+30, 375,$hh-30), 3, $textcolor); // arrow right






imagepng($im);
imagedestroy($im);
?>