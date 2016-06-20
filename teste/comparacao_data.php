<?php
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
ini_set('max_execution_time', 300);

			$data1 = strtotime(date('Y-m-d H:i:s'));
			$data2 = strtotime('2016-06-01 00:00:00');
			if($data1 > $data2){
				echo $data1." é maior que ".$data2."<br />";	
			}else{
				echo $data1." é menor que ".$data2."<br />";	
			}
			
	?>