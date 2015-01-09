<?php  
	$bp = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR;
	include $bp.'components'.DIRECTORY_SEPARATOR.'App.php';
	App::$params['basePath'] = $bp;
	App::setComponentPath(array('main'));
	
	
	class Menu extends Model1{
		public $name;
		public $id_page;
		public $id = null;
	}	
	
	class Test extends Model{
		public $test;
		public $id = null;
	}
	
	$menu = new Menu();
	$test = new Test();
	
	$menu->hello();
	
	/*for($i = 1; $i<=16;$i++){
		Test::findById($i)->delete();
	}*/
	/*//$new_menu = Menu::findById(94);
	$new_menu = $menu;
	if($new_menu != null){
		$new_menu->name = 'Second';
		$new_menu->id_page = 22;
		print_r($new_menu->save());
	}*/
	
//	print_r($new_menu->delete());
	
	//$menu->id = 97;
	
	//$menu->save();
	//$menu->delete();
	//$test->save();
	/*$mw = $menu->read();
	$tw = $test->read();
	
	print '<pre>';
	print_r($mw->getItem());
	print '/<pre>';
	
	print '<pre>';
	print_r($tw->getItem());
	print '/<pre>';*/
	
	
	
	
	
	
	
	