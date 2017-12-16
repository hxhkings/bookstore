<?php

	interface Lists
	{
		public function query();
		public function insert(Builder $builder): bool;
		public function delete($id): bool;
	}




?>