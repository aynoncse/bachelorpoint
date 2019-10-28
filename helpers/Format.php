<?php
	class Format{
		public function validate($data){
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			
			return $data;
		}
		public function textShorten($text, $limit = 500){
			$text = $text. " ";
			$text = substr($text, 0, $limit);
			$text = substr($text, 0, strrpos($text, ' '));
			$text = $text;
			return $text;
		}

		function calculateAge ($year,$month,$day){
			$currentYear = Date('Y');
			$currentMonth = Date('m'); 
			$currentDate = Date('d'); 

			if($currentDate>$day) {
				$day = $currentDate - $day;
			}else{
				$currentDate +=30;
				$day = $currentDate - $day;
				$currentMonth --;
			}

			if($currentMonth>$day) {
				$day = $currentDate - $month;
			}else{
				$currentMonth +=12;
				$month = $currentMonth - $month;
				$currentYear --;
			}

			$year = $currentYear - $year;

			if($day>=30){
				$day-=30;
				$month++;
			}
			if ($month>=12){
				$month -=12;
				$year ++; 
			}

			return $year. " Years ". $month. " Months " . $day . " Days";
		}

	}
?>