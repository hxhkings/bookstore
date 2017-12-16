<?php

	class Sanitizer 
	{

		private $builder;

		private $patt = "/[^\w]+/";

		public function __construct(Builder $builder)
		{
			$this->builder = $builder;

			

			foreach($this->builder as $item){
				if($this->sanitize($item)){
					header('Location: /bookstore/');
					exit;
				}
			}
			return true;
		}

		private function sanitize($item)
		{
			return (preg_replace($this->patt, '', $item) === '')?true:false;
				
		}
	}

?>