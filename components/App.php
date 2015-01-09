<?php

	class App{
		
		static public $params = array(
		
			'basePath' => "/",
			'app_name' => 'Engine',
			'componentPath' => array(
				'main' => array('components'),
				'admin' => array('admin.models','admin.controllers')
			),
			'defaultAction' => 'index',
			'defaultController' => 'index',
			'pathInitDB' => 'sqlite:db/mdb.db',
		
		);
		
		static $currentComponentPath = [];
	
		static function setComponentPath(array $cur = array('main')){
			App::$currentComponentPath = $cur;
			spl_autoload_register(array('App','autoload_callback'));
		}
		
		static public function getDBHandler(){
			try{
				if(preg_match('/sqlite:/i',App::$params['pathInitDB'])){
					$new_path = preg_replace('/sqlite:/i',App::$params['basePath'],App::$params['pathInitDB']);
					$DBH = new PDO('sqlite:'.$new_path);
				}else{
					$DBH = new PDO(App::$params['pathInitDB']);
				}
				$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				return $DBH;
			}catch(PDOException $e){ 
				echo $e->getMessage();  
			}
		}
		
		//Точечная нотация ('components.Model')
		static public function import($path_to_class){
			try{
				$path = preg_replace('/\./',DIRECTORY_SEPARATOR,$path_to_class);
				$pathToClass = App::$params['basePath'].$path.'.php';
				if(file_exists($pathToClass)){
					include_once $pathToClass;
					return true;
				}
				return false;
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		static public function autoload_callback($class_name){
			foreach(App::$currentComponentPath as $v1){
				foreach(App::$params['componentPath'][$v1] as $v2){
					$v2 = preg_replace('/\./',DIRECTORY_SEPARATOR,$v2);
					$pathToClass = App::$params['basePath'].$v2.DIRECTORY_SEPARATOR.$class_name.'.php';
					if(file_exists($pathToClass)){
						include $pathToClass;
					}
				}
			}
		}
		
		static function pre($o){
			print('<pre>');
			print_r($o);
			print('</pre>');
		}
	}