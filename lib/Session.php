<?php
	class Session{
		public static function init(){
			session_start();
		}
		public static function destroy(){
			self::init();
			session_unset();
			session_destroy();
			unset($_SESSION['userID']);
			header("Location: index.php");
		}
		public static function set($key, $value){
			$_SESSION[$key] = $value;
		}
		public static function get($key){
			if (isset($_SESSION[$key])) {
				return $_SESSION[$key];
			}else{
				return false;
			}
		}
		public function checkSession(){
			self::init();
			if (self::get("login") == false) {
				self::destroy();
				header("Location: index.php");
			}
		}
		public function checkLogin(){
			self::init();
			if (self::get("login") == true) {
				header("Location: home.php");
			}
		}
	}
?>