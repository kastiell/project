<?php

	class Container{
		
		private $items = [];
		
		function addItem(Model $item){
			$this->items[] = $item;
		}
		
		function getItem($count = null){
			try{
				if($count === null){
					return $this->items;
				}else{
					if(!isset($this->items[$count])){
						return null;
					}
					return $this->items[$count];
				}
			}catch(Exception $e){ 
				echo $e->getMessage();  
			}
		}
	}