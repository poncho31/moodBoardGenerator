<?php
// header('Content-Type: image/png');

// $dest2 = imagecreatefromjpeg('../../data/images/small.jpg1540387037.jpg');
// $src = imagecreatefromjpeg('../../data/images/beautiful_scenic_01_hd_picture_166320.jpg1540334918.jpg');
// $src2 = imagecreatefromjpeg('../../data/images/images.jpg1540334640.jpg');






// imagealphablending($dest, true);
// imagesavealpha($dest, true);

// imagecopymerge($dest, $src, 0, 0, 50, 302, 600, 600, 30); //have to play with these numbers for it to work for you, etc.

// imagealphablending($dest2, false);
// imagesavealpha($dest, false);
// imagecopymerge($dest, $src, 0, 0, 50, 0, 600, 600, 20); //have to play with these numbers for it to work for you, etc.



// imagepng($dest);

// imagedestroy($dest);
// imagedestroy($src);

// function pixelate($image, $output, $pixelate_x = 5, $pixelate_y = 5)
// {
//     // check if the input file exists
//     if(!file_exists($image))
//         echo 'File "'. $image .'" not found';

//     // get the input file extension and create a GD resource from it
//     $ext = pathinfo($image, PATHINFO_EXTENSION);
//     if($ext == "jpg" || $ext == "jpeg")
//         $img = imagecreatefromjpeg($image);
//     elseif($ext == "png")
//         $img = imagecreatefrompng($image);
//     elseif($ext == "gif")
//         $img = imagecreatefromgif($image);
//     else
//         echo 'Unsupported file extension';

//     // now we have the image loaded up and ready for the effect to be applied
//     // get the image size
//     $size = getimagesize($image);
//     $height = $size[1];
//     $width = $size[0];

//     // start from the top-left pixel and keep looping until we have the desired effect
//     for($y = 0;$y < $height;$y += $pixelate_y+1)
//     {

//         for($x = 0;$x < $width;$x += $pixelate_x+1)
//         {
//             // get the color for current pixel
//             $rgb = imagecolorsforindex($img, imagecolorat($img, $x, $y));

//             // get the closest color from palette
//             $color = imagecolorclosest($img, $rgb['red'], $rgb['green'], $rgb['blue']);
//             imagefilledrectangle($img, $x, $y, $x+$pixelate_x, $y+$pixelate_y, $color);

//         }       
//     }

//     // save the image
//     $output_name = $output .'_'. time() .'.jpg';

//     imagejpeg($img, $output_name);
//     // imagejpeg($img);
//     imagedestroy($img); 
// }
// header("Content-Type: image/JPEG");
// pixelate('beautiful-anture-desktop-background-wallpaper.jpg1540386974.jpg', "testing");







header('Content-Type: application/json');
$temp = [];
foreach ($_POST['val'] as $key) {
    $path = "../../". $key;
    $temp [] = pixelateImage($path);
}
echo json_encode($temp);



function pixelateImage($path){
    $dest = imagecreatefromjpeg($path);
    $image = imagecreatefromjpeg($path);
    $imagex = imagesx($image);
    $imagey = imagesy($image);

    $pixelate_y=10;
    $pixelate_x=10;
    $height=$imagey;
    $width=$imagex;
    for($y = 0;$y < $height;$y += $pixelate_y+1)
    {
        for($x = 0;$x < $width;$x += $pixelate_x+1)
        {
        // get the color for current pixel
        $rgb = imagecolorsforindex($image, imagecolorat($image, $x, $y));

        // get the closest color from palette
        $color = imagecolorclosest($image, $rgb['red'], $rgb['green'], $rgb['blue']);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        // imagecopymerge($image, $dest, 0, 0, 50, 0, 50, 200, 1); //have to play with these numbers for it to work for you, etc.
        // imagecopymerge($image, $dest, 0, 100, 100, 50, 200, 200, 1); //have to play with these numbers for it to work for you, etc.
        // imagecopymerge($image, $dest, 250, 0, 100, 50, 200, 200, 1); //have to play with these numbers for it to work for you, etc.

        imagefilledrectangle($image, $x, $y, $x+$pixelate_x, $y+$pixelate_y, $color);   
        }
    }


    for($y = 0;$y < $height;$y += $pixelate_y+1000)
    {
        for($x = 0;$x < $width;$x += $pixelate_x+1000)
        {
            //make a border line for each square
            $rgb = imagecolorsforindex($image, imagecolorat($image, $x, $y));
            $color = imagecolorclosest($image, 123, 123, 123);
            imagelinethick($image, $x, $y, $x, $y+$pixelate_y, $color, 1);
            imagelinethick($image, $x, $y, $x+$pixelate_x, $y, $color, 2);
        }       
    }
    $fileName = 'createdImage'.time(). microtime(true) . '.jpg';
    $path = '../../data/imagesCreated/';
    imageJPEG($image, $path . $fileName);
    return $fileName;
}

function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1)
{
    /* this way it works well only for orthogonal lines
    imagesetthickness($image, $thick);
    return imageline($image, $x1, $y1, $x2, $y2, $color);
    */
    if ($thick == 1) {
        return imageline($image, $x1, $y1, $x2, $y2, $color);
    }
$t = $thick / 2 - 0.5;
if ($x1 == $x2 || $y1 == $y2) {
    return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
}
$k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
$a = $t / sqrt(1 + pow($k, 2));
$points = array(
    round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
    round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
    round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
    round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
);
imagefilledpolygon($image, $points, 4, $color);
return imagepolygon($image, $points, 4, $color);
}

// header("Content-Type: image/JPEG");
// imageJPEG($image, 'img');
