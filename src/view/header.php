<?php

use appName\Html\Menu;
$menu = new Menu();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>
		<?= $config['appName']?>
	</title>
	</title>
	<link rel="stylesheet" href="src/design/css/bootstrapCSS/bootstrap.min.css">
	<link rel="stylesheet" href="src/design/js/jquery/ui/jquery-ui.min.css">
	<link rel="stylesheet" href="src/design/css/style.css">
</head>
<body>
    <header>
        <nav>
			<?= $menu->activeMenu(
						'section', 
						['home']
					);
			?>
		</nav>
		<h3 id="appTitle">
			<?= 
			$config['appName']?>
		</h3>
	</header>
	<div class="clear"></div>