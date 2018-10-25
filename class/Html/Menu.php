<?php
namespace appName\Html;

class Menu {
	function activeMenu($controller, $tabs){
		$activePage = basename(isset($_GET[$controller])? $_GET[$controller]: '', ".php");
        $menu = "<ul>";
		foreach ($tabs as $tabName) {
			$active = ($activePage == $tabName) ? 'active':'';
			$menu .= "<li class='". $active ."'>";
			$menu .= "<a  href='?".$controller."=".$tabName."'>".UcFirst($tabName)."</a>";
			$menu .= "</li>";
        }
        $menu .= "</ul>";
		return $menu;
	}
}