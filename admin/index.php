<?php  
	$bp = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR;
	include $bp.'components'.DIRECTORY_SEPARATOR.'App.php';
	App::$params['basePath'] = $bp;
	App::setComponentPath(array('main','admin'));
	
	$mr = new ModuleRoute();
	$mr->printInf();
	
	/*$menu = new Menu();
	$menu->name = 'hello';
	$menu->id_page = 3;
	//$menu->id = 114;
	$menu->save();
	*/
	
	//App::pre();
	
	/*$c = Menu::findAllByAttribute(array('id_page'=>5));
	$m = $c->getItem(0);
	//$m->id_page = 5;
	$m->delete();
*/
	/*App::pre(Menu::findAll());
	App::pre(Menu::findAllByAttribute(array('id_page'=>2)));
	*/
	
	/*if($_GET['r']=='menu'){
		function pastData(){
			include 'views/menu.php';
		}	
	}
	
	include 'views/index.php';*/