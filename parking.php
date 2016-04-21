<?php
$MIN_HEIGHT = 400;


/*
 * | denotes special line formatting when followed by one of these chars:
 * 
 * ~ .... font size 60 (instead of 45) - used for authorized vehicles
*/



$height = 0;
$data = explode('`',$_GET["data"]);

for($x=0;$x<count($data);$x++){
  if($data[$x] == "") $height += 35;
  else {
    if($data[$x][0] == '|' && $data[$x][1] == '~') $height += 85;
    else $height += 70;
  }   
}

$offsetY = 0;
if($_GET["type"] == 2){ // Meter
  $offsetY = 110;
  $height += 35;
} else if($_GET["type"] == 3){ // Commercial
  $offsetY = 400;
  $height += 35;
} else if($_GET["type"] == 4){ // Authorized
  $offsetY += 110;
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
else if($type == 3){ // COMMERCIAL VEHICLES ONLY METERED PARKING
  imagefilledrectangle($im, 10, 10, 590, $height+250, $red);
  imagefilledrectangle($im, 20, 20, 580, $height+240, $white);

  imagettftext($im, 40, 0, 230, 65, $red, $font, "hour");
  imagettftext($im, 40, 0, 230, 125, $red, $font, "metered");
  imagettftext($im, 40, 0, 230, 185, $red, $font, "parking");

  imagettftext($im, 60, 0, 35, 300, $red, $font, "COMMERCIAL");
  imagettftext($im, 60, 0, 35, 380, $red, $font, "VEHICLES ONLY");
  imagettftext($im, 42, 0, 35, 480, $red, $font, "OTHERS NO STANDING");


  $x = 60;
  if(strlen($hours) == 2) $x -= 40;

  // hour designation
  imagefilledrectangle($im, 20, 20, 200, 190, $red);
  imagettftext($im, 140, 0, $x, 170, $white, $font, $hours);
  

  
  $textcolor = $red;
}
else if($type == 4){ // AUTHORIZED VEHICLES ONLY
  imagefilledrectangle($im, 10, 10, 590, $height+250, $red);
  imagefilledrectangle($im, 20, 20, 580, $height+240, $white);

  imagettftext($im, 40, 0, 230, 65, $red, $font, "Authorized");
  imagettftext($im, 40, 0, 230, 125, $red, $font, "Vehicles");
  imagettftext($im, 40, 0, 230, 185, $red, $font, "Only");

  imagefilledrectangle($im, 20, 20, 200, 190, $red);
  drawfilledstar($im, 110, 110, 80, $white);
//  imagefilledpolygon($im, $star, sizeof($star)/2, $white);

  $textcolor = $red;

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
  
    $font_size = 45;
    if($data[$x][0] == '|' && $data[$x][1] == '~'){
      $font_size = 60;
      $data[$x] = substr($data[$x], 2);
    }     

    imagettftext($im, $font_size, 0, 35, $y, $textcolor, $font, $data[$x]);
    $y += 35+$font_size;
  }
}


// arrow
$hh = $height+190;
imagefilledrectangle($im, 50, $hh-10, 400, $hh+10, $textcolor);
if($arrow != 2) imagefilledpolygon($im, array(35,$hh, 80,$hh+30, 80,$hh-30), 3, $textcolor); // arrow left
if($arrow != 1) imagefilledpolygon($im, array(420,$hh, 375,$hh+30, 375,$hh-30), 3, $textcolor); // arrow right






imagepng($im);
imagedestroy($im);




function drawfilledstar($im, $x, $y, $rad, $color){
  $c1 = .309016994; //*$rad;
  $c2 = .809016994; //*$rad;
  $s1 = .951056516; //*$rad;
  $s2 = .587785252; //*$rad;

  $p = array();
  

  $p[0] = $x; $p[1] = -$rad+$y;
  $p[2] = -$s2*$rad+$x; $p[3] = $c2*$rad+$y;
  $p[4] = $s1*$rad+$x; $p[5] = -$c1*$rad+$y;
  $p[6] = -$s1*$rad+$x; $p[7] = -$c1*$rad+$y;
  $p[8] = $s2*$rad+$x; $p[9] = $c2*$rad+$y;

  $points = array($x, $y, $p[0], $p[1], $p[2], $p[3], $p[4], $p[5]);
  imagefilledpolygon($im, $points, sizeof($points)/2, $color);	

  $points = array($x, $y, $p[4], $p[5], $p[6], $p[7], $p[8], $p[9]);
  imagefilledpolygon($im, $points, sizeof($points)/2, $color);	

  $points = array($x, $y, $p[8], $p[9], $p[0], $p[1]);
  imagefilledpolygon($im, $points, sizeof($points)/2, $color);	


}



?>