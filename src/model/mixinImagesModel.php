<?php
include_once '../../class/Image/ExifImageUpdate.php';
use appName\Image\IPTC;
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
$images = [];
$moodBoardImages = [];
// Modifie une image
$post = $_POST['imgValues'];
for ($i = 0; $i < count($post); $i++) {
    $image = "../../". $post[$i];
    $image2 = (count($post) > 1 && $i + 1 < count($post))? "../../". $post[$i + 1] : false;
    $size = getimagesize($image);
    $images [] = filterImage($image, false, $size, $i);
}

// Merge images
$filename=''; $path="../../data/imagesCreated/";
for ($i = 0, $j=0; $i < count($images); $i++) {
    $j = ($i < count($images) && $i > 0)? $path . $fileName: $path.$images[$i];
    $size = getimagesize($path.$images[0]);
    $image = imagecreatefromjpeg($path.$images[$i]);
    imagescale($image, $size[0], $size[1]);

    $image2 = imagecreatefromjpeg($j);
    $fileName = 'modifiedImage'.time(). microtime(true) . '.jpg';
    imagecopymerge_alpha($image, $image2, 0, 0, 0, 0, $size[0], $size[1], rand(40, 80));
    imageJPEG($image, $path . $fileName);
    imagedestroy($image);
    imagedestroy($image2);

    $objIPTC = new IPTC($path.$fileName);
    $objIPTC->setValue(IPTC_HEADLINE, "MoodeBoarded image");
    $objIPTC->setValue(IPTC_CAPTION, "Created with MoodBoard generator");
    // echo $objIPTC->getValue(IPTC_HEADLINE);
    $moodBoardImages [] = $fileName;
}
echo json_encode($moodBoardImages);



function filterImage($img, $img2, $size, $imageIndex){
    $originalImage = imagecreatefromjpeg(($img2 != false)? $img2 : $img);
    $image = imagecreatefromjpeg($img);
    $imagex = imagesx($image);
    $imagey = imagesy($image);
    // get proeminent color of image
    $thumb=imagecreatetruecolor(1,1); imagecopyresampled($thumb,$image,0,0,0,0,1,1,imagesx($image),imagesy($image));
    $hexa= '#' . strtoupper(dechex(imagecolorat($thumb,0,0)));
    // convert hexa to rgb
    list($r, $g, $b) = sscanf($hexa, "#%02x%02x%02x");

    // USER INPUTS
    $pixeliseBool = $_POST['pixelise']['bool'];
        $pixelIncrementX = $_POST['pixelise']['incrementX'];
        $pixelIncrementY = $_POST['pixelise']['incrementY'];
        $pixelDivider = $_POST['pixelise']['divider'];
        $pixelOperator = $_POST['pixelise']['operator'];
        $pixelOrientationX = $_POST['pixelise']['orientationX'];
        $pixelOrientationY = $_POST['pixelise']['orientationY'];

    $quadrillageBool = $_POST['quadrillage']['bool'];
        $quadrillageH = $_POST['quadrillage']['H'];
        $quadrillageV = $_POST['quadrillage']['V'];
        $quadriPixelIncrementX = $_POST['quadrillage']['incrementX'];
        $quadriPixelIncrementY = $_POST['quadrillage']['incrementY'];
        $quadriThickH = $_POST['quadrillage']['thickH'];
        $quadriThickV = $_POST['quadrillage']['thickV'];
        $quadriRandomColor = $_POST['quadrillage']['colorRandom'];
            $quadriColorH = $_POST['quadrillage']['colorH'];
            $quadriColorV = $_POST['quadrillage']['colorV'];
        $quadriTypeH = $_POST['quadrillage']['typeH'];
        $quadriTypeV = $_POST['quadrillage']['typeV'];

    $autoMergeBool = $_POST['automerge']['bool'];
        $autoMergeShift = $_POST['automerge']['shift'];
    
    $ifNullThenRandom = [
        $pixeliseBool, $pixelIncrementX, $pixelIncrementY, $pixelDivider, $pixelOperator, $pixelOrientationX, $pixelOrientationY,
        $quadrillageBool, $quadrillageH, $quadrillageV, $quadriPixelIncrementX, $quadriPixelIncrementY, $quadriThickH, $quadriThickV, $quadriRandomColor, $quadriColorH, $quadriColorV, $quadriTypeH, $quadriTypeV,
        $autoMergeBool, $autoMergeShift
    ];

    foreach ($ifNullThenRandom as $value) {
        if (empty($value)) {
            $value =  rand(0, 1);
        }
    }
    $pixelNumber = $imagex * (rand(10, 80)/1000);
    $randomBool = rand(0, 1);


    $pixelate = [
                'pixelise' =>
                            [
                                'bool' => $pixeliseBool,
                                'pixelIncrementx' => $imagex * ($pixelIncrementX/500),
                                'pixelIncrementy' => $imagex * ($pixelIncrementY/500),
                                'divider' => $pixelDivider,
                                'operator' => ($pixelOperator)? '/':'*',
                                'orientationX' =>  ($pixelOrientationX !=0)? 1 +$pixelOrientationX /1000 : 1,
                                'orientationY' => ($pixelOrientationY !=0)? 1 +$pixelOrientationY /1000 : 1
                            ],
                'dimension' => 
                            [
                                'height' => $imagey,
                                'width' => $imagex
                            ],
                'quadrillage' =>
                            [
                                'bool' => $quadrillageBool,
                                'H' => $quadrillageH,
                                'V' => $quadrillageV,
                                'pixelIncrementx' => ($imagex * $quadriPixelIncrementX/1000),
                                'pixelIncrementy' => ($imagex * $quadriPixelIncrementY/1000),
                                'thickH' => $quadriThickH,
                                'thickV' => $quadriThickV,
                                'randomColor' => $quadriRandomColor,
                                'colorH' => array(
                                                'red'=>$quadriColorH[0],
                                                'green'=>$quadriColorH[1], 
                                                'blue'=>$quadriColorH[2]
                                            ),
                                'colorV' => array(
                                                'red'=>$quadriColorV[0],
                                                'green'=>$quadriColorV[1], 
                                                'blue'=>$quadriColorV[2]
                                            ),
                                'colorRH' => [
                                              'red'=>rand(0, 255),
                                              'green'=>rand(0, 255),
                                              'blue'=>rand(0, 255)
                                            ],
                                'colorRV' => [
                                              'red'=>rand(0, 255), 
                                              'green'=>rand(0, 255), 
                                              'blue'=>rand(0, 255)
                                            ],
                                'typeH'   => 
                                        [
                                            'random' => $quadriTypeH
                                        ],
                                'typeV'   => 
                                        [
                                            'random' => $quadriTypeV
                                        ]
                            ],
                'autoMerge' => 
                            [
                                'bool' => $autoMergeBool,
                                'shift' => $autoMergeShift
                            ]
                ];



    $height=$pixelate['dimension']['height'];
    $width=$pixelate['dimension']['width'];
    $divider = $pixelate['pixelise']['divider'];
    $operator = $pixelate['pixelise']['operator'];
    $axeX = $pixelate['pixelise']['orientationX'];
    $axeY = $pixelate['pixelise']['orientationY'];
    // PIXELLISATION DE L'IMAGE
    if ($pixelate['pixelise']['bool']) {
        for($y = 0;$y < $height;$y += $pixelate['pixelise']['pixelIncrementy'])
        {
            for($x = 0;$x < $width;$x += $pixelate['pixelise']['pixelIncrementx'])
            {
                $rgb = imagecolorsforindex($image, imagecolorat($image, $x, $y));
                $color = imagecolorclosest($image, $rgb['red'], $rgb['green'], $rgb['blue']);
                imagefilledrectangle($image, operator($x, $axeX, $operator), operator($y, $axeY, $operator), $x+($pixelate['pixelise']['pixelIncrementx'] / $divider), $y+($pixelate['pixelise']['pixelIncrementy']/$divider), $color);
            }
        }
    }

    
    // QUADRILLAGE DE L'IMAGE
    $pixelate_y= $pixelate['quadrillage']['pixelIncrementy'];
    $pixelate_x= $pixelate['quadrillage']['pixelIncrementx'];
    // imagefilter($image, IMG_FILTER_PIXELATE, ($imagex * $quadriPixelIncrementX/1000));

    for($y = 0;$y < $height;$y += $pixelate_y)
    {
        for($x = 0;$x < $width;$x += $pixelate_x)
        {   
            $quadri = $pixelate['quadrillage'];
            $rgb = imagecolorsforindex($image, imagecolorat($image, $x, $y));

            if($quadri['randomColor']){
                $colV = $quadri['colorRV'];
                $colH = $quadri['colorRH'];
            }
            else{
                $colV = $quadri['colorV'];
                $colH = $quadri['colorH'];
            }
            $colorV = imagecolorclosest($image, $colV['red'], $colV['green'], $colV['blue']);
            $colorH = imagecolorclosest($image, $colH['red'], $colH['green'], $colH['blue']);
            if ($quadri['bool']) {

                $Vx1 = $x; $Vy1 = $y; $Vx2 = $x; $Vy2 = $y+$pixelate_y;
                $Hx1 = $x; $Hy1 = $y; $Hx2 = $x+$pixelate_x; $Hy2 = $y;

                $randV = $quadri['typeV']['random'];
                $randH = $quadri['typeH']['random'];
                $m = $x+10;
                $m2 = $y+10;
                if ($randV) {
                    $Vx1 += rand(-rand(0, $m), $m); $Vy1 += rand(-rand(0, $m), $m); $Vx2 += rand(-rand(0, $m), $m); $Vy2 += rand(-rand(0, $m), $m);
                }
                if ($randH) {
                    $Hx1 += rand(-rand(0, $m2), $m2); $Hy1 += rand(-rand(0, $m2), $m2); $Hx2 += rand(-rand(0, $m2), $m2); $Hy2 += rand(-rand(0, $m), $m);
                }
                
                if($quadri['V'])imagelinethick($image, $Vx1, $Vy1, $Vx2, $Vy2, $colorV, $quadri['thickV']);
                if($quadri['H'])imagelinethick($image, $Hx1, $Hy1, $Hx2, $Hy2, $colorH, $quadri['thickH']);
            }
        }       
    }
    getRandomImageFilter($image, ($imagex * $quadriPixelIncrementX/1000));

    $merge = $pixelate['autoMerge'];
    if ($merge['bool']) {
        // imagecopymerge($image, $originalImage, 0, 0, 0, 0, $size[0], $size[1], $merge['shift']);
    }


    $fileName = 'modifiedImage'.time(). microtime(true) . '.jpg';
    $path = '../../data/imagesCreated/';
    imageJPEG($image, $path . $fileName);
    imagedestroy($image);
    imagedestroy($originalImage);

    $objIPTC = new IPTC($path.$fileName);
    $objIPTC->setValue(IPTC_HEADLINE, "Created Image");
    $objIPTC->setValue(IPTC_CAPTION, "Created with MoodBoard generator");
    // echo $objIPTC->getValue(IPTC_HEADLINE);
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
imagefilledpolygon($image, $points, 2, $color);
return imagepolygon($image, $points, 2, $color);
}

// header("Content-Type: image/JPEG");
// imageJPEG($image, 'img');
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
    // creating a cut resource 
    $cut = imagecreatetruecolor($src_w, $src_h); 
    // copying relevant section from background to the cut resource 
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
    
    // copying relevant section from watermark to the cut resource 
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 
    
    // insert cut resource to destination image 
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 
function blur($gdImageResource, $blurFactor = 3)
{
  // blurFactor has to be an integer
  $blurFactor = round($blurFactor);
  
  $originalWidth = imagesx($gdImageResource);
  $originalHeight = imagesy($gdImageResource);

  $smallestWidth = ceil($originalWidth * pow(0.5, $blurFactor));
  $smallestHeight = ceil($originalHeight * pow(0.5, $blurFactor));

  // for the first run, the previous image is the original input
  $prevImage = $gdImageResource;
  $prevWidth = $originalWidth;
  $prevHeight = $originalHeight;

  // scale way down and gradually scale back up, blurring all the way
  for($i = 0; $i < $blurFactor; $i += 1)
  {    
    // determine dimensions of next image
    $nextWidth = $smallestWidth * pow(2, $i);
    $nextHeight = $smallestHeight * pow(2, $i);

    // resize previous image to next size
    $nextImage = imagecreatetruecolor($nextWidth, $nextHeight);
    imagecopyresized($nextImage, $prevImage, 0, 0, 0, 0, 
      $nextWidth, $nextHeight, $prevWidth, $prevHeight);

    // apply blur filter
    imagefilter($nextImage, IMG_FILTER_GAUSSIAN_BLUR);

    // now the new image becomes the previous image for the next step
    $prevImage = $nextImage;
    $prevWidth = $nextWidth;
      $prevHeight = $nextHeight;
  }

  // scale back to original size and blur one more time
  imagecopyresized($gdImageResource, $nextImage, 
    0, 0, 0, 0, $originalWidth, $originalHeight, $nextWidth, $nextHeight);
  imagefilter($gdImageResource, IMG_FILTER_GAUSSIAN_BLUR);

  // clean up
  imagedestroy($prevImage);

  // return result
  return $gdImageResource;
}


function rgba_colorize($img, $color) 
{ 
    imagesavealpha($img, true); 
    imagealphablending($img, true); 

    $img_x = imagesx($img); 
    $img_y = imagesy($img); 
    for ($x = 0; $x < $img_x; ++$x) 
    { 
        for ($y = 0; $y < $img_y; ++$y) 
        { 
            $rgba = imagecolorsforindex($img, imagecolorat($img, $x, $y)); 
            $color_alpha = imagecolorallocatealpha($img, $color[0], $color[1], $color[2], $rgba['alpha']); 
            imagesetpixel($img, $x, $y, $color_alpha); 
            imagecolordeallocate($img, $color_alpha); 
        } 
    } 
} 

function operator($val1, $val2, $operator){
    switch($operator){
        case '*':
            $response = $val1 * $val2;
            break;
        case '/':
            $response = $val1 / $val2;
            break;
        case '+':
            $response = $val1 + $val2;
            break;
        case '*':
            $response = $val1 - $val2;
            break;
        case '%':
            $response = $val1 % $val2;
            break;
        default:
            $response = 'Error';
    }
    return $response;
}

function getRandomImageFilter($image, $pixel){
    $name = [
            // With arguments
            IMG_FILTER_CONTRAST, IMG_FILTER_PIXELATE, IMG_FILTER_COLORIZE, IMG_FILTER_SMOOTH,
            // Without arguments
            IMG_FILTER_EMBOSS, IMG_FILTER_EDGEDETECT, IMG_FILTER_GRAYSCALE,
            IMG_FILTER_GAUSSIAN_BLUR, IMG_FILTER_SELECTIVE_BLUR, IMG_FILTER_MEAN_REMOVAL,
            IMG_FILTER_NEGATE,
            // Others
            'blur'
            ];
    $random = rand(0, count($name)-1);

    if($random <= count($name)-2){
        if ($random == 0) {
            imagefilter($image, $name[$random], rand(-rand(0, 150), 150));
        }
        elseif ($random == 1) {
            imagefilter($image, $name[$random], $pixel, true);
        }
        elseif ($random == 2) {
            imagefilter($image, $name[$random], rand(0, 255), rand(0, 255), rand(0, 255));
        }
        elseif ($random == 3) {
            imagefilter($image, $name[$random], rand(0, 20));
        }
        else{
            imageFilter($image, $name[$random]);
        }
    }
    else{
        blur($image, rand(1, 5));
    }
}