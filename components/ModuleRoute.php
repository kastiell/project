<?php

	class ModuleRoute{
	
		public $controllerName = 'default';
		public $actionName = 'default';
		public $params = [];
	
		function __construct(){
			if(isset($_GET['r'])){
				$this->parseRoute($_GET['r']);
				unset($_GET['r']);
			}else{
				$this->parseRoute('');
			}
			$this->params = $_GET;
		}
		
		function parseRoute($route){
			try{
				$part = explode('/',$route);
				if(isset($part[0])&&$part[0]){
					$this->controllerName = $part[0];
				}else{
					$this->controllerName = App::$params['defaultController'];
				}
				if(isset($part[1])&&$part[1]){
					$this->actionName = $part[1];
				}else{
					$this->actionName = App::$params['defaultAction'];
				}
			}catch(Exception $e){
				print 'Some problems with parse route!<br>'.$e->getMessage();
			}
		}
		
		function printInf(){
			print 'ControllerName = '.$this->controllerName.'<br>'
				.'ActionName = '.$this->actionName.'<br>';
			print_r($this->params);
		}
	}