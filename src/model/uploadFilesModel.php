<?php
// header("Content-Type: application/json");
extract($_FILES['file']['name']);
$error=array();
$success = array();
$extension=array("jpeg","jpg","png","gif");
$target_dir = "../../data/images/";
if (!empty($_FILES['file']['name'])) {
    foreach($_FILES["file"]["tmp_name"] as $key=>$tmp_name)
    {
        $file_name=$_FILES["file"]["name"][$key];
        $file_tmp=$_FILES["file"]["tmp_name"][$key];
        $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        if(in_array($ext,$extension))
        {
            $file_tmp=$_FILES["file"]["tmp_name"][$key];
            $file_name = str_replace(' ', '', htmlspecialchars(iconv('ISO-8859-1','ASCII//TRANSLIT',$file_name)));
            if(!file_exists($target_dir.$file_name))
            {
                move_uploaded_file($file_tmp,$target_dir.$file_name);
            }
            else
            {
                $filename=basename($file_name,$ext);
                $newFileName=$file_name. time() .".".$ext;
                move_uploaded_file($file_tmp,$target_dir.$newFileName);
            }
            $success []= $file_name;
        }
        else
        {
            array_push($error, $file_name);
        }
    }
}
else{
    $error[] = 'error';
}
echo json_encode(['success' => $success, 'error' => $error], JSON_UNESCAPED_UNICODE);

