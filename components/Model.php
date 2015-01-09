<?php
	
	class Model{
		
		function __construct(){}
		
		static function findById($count){
			$obj = new static();
			$container = $obj->read($count);
			return $container->getItem(0);
		}
		
		static function findAll($range = null){
			$obj = new static();
			$container = $obj->read();
			return $container;
		}
		
		static function findAllByAttribute($state = null,$range = null){
			$obj = new static();
			$container = $obj->read($state,$range);
			return $container;
		}
		
		function set(Item $obj){
			$ref = new ReflectionClass(get_class($this));
			foreach($ref->getProperties() as $v){
				if($v->getDeclaringClass()->getName() !== get_class($this)) continue;
				$name = $v->getName();
				if(!isset($obj->$name)){
					throw new Exception("Variable is'nt exists in object");
				}
				$this->$name = $obj->$name;
			}
		}
		
		function getKeyClass(array $without_params = [],$separator = ', ',$set = false){
			$key = [];
			$ref = new ReflectionClass(get_class($this));
			foreach($ref->getProperties() as $v){
				if($v->getDeclaringClass()->getName() !== get_class($this)) continue;
				if(!in_array($v->getName(),$without_params)){
					if($set){
						$key[] = $v->getName().' = :'.$v->getName();
					}else{
						$key[] = $v->getName();
					}
				}
			}
			return implode($separator,$key);
		}
		
		function getArrayAlowProp(array $without_params = []){
			$key = [];
			$ref = new ReflectionClass(get_class($this));
			foreach($ref->getProperties() as $v){
				if($v->getDeclaringClass()->getName() !== get_class($this)) continue;
				if(!in_array($v->getName(),$without_params)){
					$prop_name = $v->getName();
					$key[$prop_name] = $this->$prop_name;
				}
			}
			return $key;
		}
		
		function keyToValue(array $arr = array(),$separator = ':'){
			$str = '';
			foreach($arr as $k=>$v){
				$str .= $k.' = '.$separator.$k;
			}
			return $str;
		}
		
		function getDBH(){
			return App::getDBHandler();
		}
	
		function save($without_prop = array()){
			try{ 
				if((!in_array('id',$without_prop))&&($this->id !== null)){
					if($STH = $this->getDBH()->prepare('SELECT COUNT(*) FROM tbl_'.strtolower(get_class($this)).' WHERE id = :id')){
						$STH->bindParam(':id',$this->id);
						$STH->execute();
						if($STH->fetchColumn() > 0){  
							$STH = $this->getDBH()->prepare("UPDATE tbl_".strtolower(get_class($this))." SET ".$this->getKeyClass($without_prop,', ',true)." WHERE id = :id");
							if($STH->execute($this->getArrayAlowProp($without_prop))){
								return $this->id;
							}else{
								return false;
							}
						}
					}
				}
			
				$STH = $this->getDBH()->prepare("INSERT INTO tbl_".strtolower(get_class($this))." (".$this->getKeyClass($without_prop).") values (:".$this->getKeyClass($without_prop,', :').")");
				if($STH->execute($this->getArrayAlowProp($without_prop))){
					$STH = $this->getDBH()->query('SELECT max(id) FROM tbl_'.strtolower(get_class($this)));
					$obj = $STH->fetch();
					return $obj[0];
				}else{
					return false;
				}
			}catch(PDOException $e){ 
				echo $e->getMessage();  
			}
		}
		
		function read($state = null,array $range = null){
			try{
				$limit = (($range!='')&&(is_array($range)))?(' LIMIT '.((int)$range[0]).((isset($range[1]))?','.((int)$range[1]):'')):'';
				if(is_array($state) && $state != array()){
					$STH = $this->getDBH()->prepare('SELECT '.$this->getKeyClass().' FROM tbl_'.strtolower(get_class($this)).' WHERE '.$this->keyToValue($state).' '.$limit);
					foreach($state as $k=>$v){
						$STH->bindParam(':'.$k,$v);
					}
				}else
				if($state == null){
					$STH = $this->getDBH()->prepare('SELECT '.$this->getKeyClass().' FROM tbl_'.strtolower(get_class($this)).' '.$limit);  
				}else{
					$STH = $this->getDBH()->prepare('SELECT '.$this->getKeyClass().' FROM tbl_'.strtolower(get_class($this)).' WHERE id = :id'); 
					$STH->bindParam(':id',$state);
				}
				$STH->execute();
				$STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, strtolower(get_class($this)));  
				
				$mw = new Container();
				while($obj = $STH->fetch()){
					$mw->addItem($obj); 
				}
				
				return $mw;
			}catch(PDOException $e){ 
				echo $e->getMessage();  
			}
		}
		
		function delete(){
			try{
				if($this->id !== null){
					if($STH = $this->getDBH()->prepare('SELECT COUNT(*) FROM tbl_'.strtolower(get_class($this)).' WHERE id = :id')){
						$STH->bindParam(':id',$this->id);
						$STH->execute();
						if($STH->fetchColumn() > 0){  
							$STH = $this->getDBH()->prepare("DELETE FROM tbl_".strtolower(get_class($this))." WHERE id = :id");
							$STH->bindParam(':id',$this->id);
							return $STH->execute();
						}
					}
				}
				return false;
			}catch(PDOException $e){ 
				echo $e->getMessage();  
			}
		}
	}