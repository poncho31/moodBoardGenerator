<?php
if (isset($_GET['section'])) {
    switch ($_GET['section']) {
        case 'home':
            include 'src/view/homepageView.php';
            break;
        default:
            include 'src/view/homepageView.php';
            break;
    }
}
else{
    include 'src/view/homepageView.php';
}