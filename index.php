<?php 
// Autoload
require_once __DIR__ . '/vendor/autoload.php';
// echo $_GET['url'];
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($actual_link == 'http://localhost/projects/moodBoardGenerator/') {
//    header('Location: http://localhost/projects/moodBoardGenerator/?section=home');
}
// $router = new appName\Routing\Router($_REQUEST);
// var_dump($router);
// $router->get('/', function(){ header('Location: /?section=home');});
// $router->get('/posts', function(){echo 'Tous les articles';});
// $router->get('/posts/:slug-:id', function($slug, $id) use ($router){
//     echo $router->url('Posts#show', ['id'=> 1, 'slug' => 'salut-les-gens']);
// }, 'posts.show')->with('id', '[0-9]+')->with('slug', '([a-z\-0-9]+)');

// $router->get('/posts/:id', "Posts#show");
// // die($_GET['url']);
// //Configuration
// $router->post('/posts/:id', function($id){echo 'Encoder l\'article'. $id . '<pre>'. print_r($_POST, true).'</pre>';});
// $router->run();
include_once 'config/config.php';

//VIEW
include 'src/view/header.php';
include 'src/controller/sectionController.php';
include 'src/view/footer.php';
?>