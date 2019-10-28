<?php
	class DB
	{
		public $host = DB_HOST;
		public $user = DB_USER;
		public $pass = DB_PASS;
		public $dbname = DB_NAME;

		public $link;
		public $error;

		public function __construct(){
			$this->connectDB();
		}
		private function connectDB() {
			$this->link =	new mysqli($this->host, $this->user, $this->pass, $this->dbname);
			if (!$this->link){
				$this->error = "Connection Failed ".$this->link->connect_error;
				return false;
			}
		}

		//READ or SELECT Data
		public function selectData($query){
			$result = $this->link->query($query) or die ($this->link->error.__LINE__);
			if ($result->num_rows > 0) {
				return $result;
			}else{
				return false;
			}
		}

		//CREATE or INSERT Data
		public function createData($query){
			$insert = $this->link->query($query) or die ($this->link->error.__LINE__);
			if ($insert) {
				return $insert;
			}else{
				return false;
			}
		}

		//Update Data
		public function updateData($query){
			$update = $this->link->query($query) or die ($this->link->error.__LINE__);
			if ($update) {
				return $update;
			}else{
				return false;
			}
		}
		public function deleteData($query){
			$delete = $this->link->query($query) or die ($this->link->error.__LINE__);
			if ($delete) {
				return $delete;
			}else{
				return false;
			}
		}
	}
?>