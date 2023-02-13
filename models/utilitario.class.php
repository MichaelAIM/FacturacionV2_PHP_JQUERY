<?php

class Utilitario{
	public function __construct(){}
	
	public function commerce_round($round_mode, $number) {
		$negative = $number < 0;
		$number = abs($number);
		$decimal = $number - floor($number);
		if ($decimal == 0) {
			return $negative ? -$number : $number;
		}
		switch ($round_mode) {
			case COMMERCE_ROUND_HALF_UP:
				$number = round($number);
				break;
			case COMMERCE_ROUND_HALF_DOWN:
				if($decimal <= .5) {
					$number = floor($number);
				}else{
					$number = ceil($number);
				}
				break;
			case COMMERCE_ROUND_HALF_EVEN:
				if ($decimal == .5) {
					if (floor($number) % 2 == 0) {
						$number = floor($number);
					}else{
						$number = ceil($number);
					}
				}else{
					$number = round($number);
				}
				break;
			case COMMERCE_ROUND_HALF_ODD:
				if ($decimal == .5) {
					if (floor($number) % 2 == 0) {
						$number = ceil($number);
					}else{
						$number = floor($number);
					}
				}else{
					$number = round($number);
				}
				break;
			case COMMERCE_ROUND_NONE:default:
				break;
		}
		return $negative ? -$number : $number;
	}
	
	public function JsonToArray($json) {
		return (json_decode($json,true));
	}
	
	public function invertirFecha($fecha){
		$partes_fecha = explode('-',$fecha);
		return($partes_fecha[2].'-'.$partes_fecha[1].'-'.$partes_fecha[0]);
	}
	
	public function searcharray($value, $key, $array) {
		if(!empty($array)){
			foreach ($array as $k => $val) {
				if ($val[$key] == $value) {
					return $k;
				}
			}
			return "false";
		}else{
			return "false";
		}
	}
	
	public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
	
	public function array_sort_by_twoColumn(&$arr, $colA, $colB){
		array_multisort($colA, SORT_ASC, $colB, SORT_ASC, $arr);
	}
	
	public function replace_in_array($value, $replace, $key, $array) {
		foreach ($array as $k => $val) {
			if ($val[$key] == $value) {
				$val[$key] = $replace;
				$array[$k] = $val;
			}
		}			
		return $array;
	}
	
	public function extract_array_column($input = null, $columnKey = null, $indexKey = null){
		$argc = func_num_args();
		$params = func_get_args();
		if ($argc < 2) {
			trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
			return null;
		}
		if (!is_array($params[0])) {
			trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return null;
		}
		if (!is_int($params[1]) && !is_float($params[1]) && !is_string($params[1]) && $params[1] !== null && !(is_object($params[1]) && method_exists($params[1], '__toString'))) {
			trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		if (isset($params[2]) && !is_int($params[2]) && !is_float($params[2]) && !is_string($params[2]) && !(is_object($params[2]) && method_exists($params[2], '__toString'))){
			trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		$paramsInput = $params[0];
		$paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
		$paramsIndexKey = null;
		if (isset($params[2])) {
			if(is_float($params[2]) || is_int($params[2])){
				$paramsIndexKey = (int) $params[2];
			}else{
				$paramsIndexKey = (string) $params[2];
			}
		}
		$resultArray = array();
		foreach ($paramsInput as $row) {
			$key = $value = null;
			$keySet = $valueSet = false;
			if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
				$keySet = true;
				$key = (string) $row[$paramsIndexKey];
			}
			if ($paramsColumnKey === null) {
				$valueSet = true;
				$value = $row;
			} elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
				$valueSet = true;
				$value = $row[$paramsColumnKey];
			}
			if ($valueSet) {
				if ($keySet) {
					$resultArray[$key] = $value;
				} else {
					$resultArray[] = $value;
				}
			}
		}
		return $resultArray;
	}
	
	public function extract_array_row($input = null, $columnKey = null, $valueKey = null, $indexKey = null){
		$argc = func_num_args();
		$params = func_get_args();
		if ($argc < 2) {
			trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
			return null;
		}
		if (!is_array($params[0])) {
			trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return null;
		}
		if (!is_int($params[1]) && !is_float($params[1]) && !is_string($params[1]) && $params[1] !== null && !(is_object($params[1]) && method_exists($params[1], '__toString'))) {
			trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		if (isset($params[3]) && !is_int($params[3]) && !is_float($params[3]) && !is_string($params[3]) && !(is_object($params[3]) && method_exists($params[3], '__toString'))){
			trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		$paramsInput = $params[0];
		$paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
		$paramsIndexKey = null;
		if (isset($params[2])) {
			if(is_float($params[2]) || is_int($params[2])){
				$paramsIndexKey = (int) $params[2];
			}else{
				$paramsIndexKey = (string) $params[2];
			}
		}
		$resultArray = array();
		foreach ($paramsInput as $row) {
			$key = $value = null;
			$keySet = $valueSet = false;
			if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
				$keySet = true;
				$key = (string) $row[$paramsIndexKey];
			}
			if ($paramsColumnKey === null) {
				$valueSet = true;
				$value = $row;
			} elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
				$valueSet = true;
				if($valueKey == $row[$paramsColumnKey]){
					$value = $row;
				}
			}
			if ($valueSet) {
				if ($keySet) {
					$resultArray[$key] = $value;
				} else {
					if($value !== NULL){
						$resultArray[] = $value;
					}
				}
			}
		}
		return $resultArray;
	}
	
	public function array_remove_values($array,$value){
		foreach (array_keys($array, $value, true) as $key) {
			unset($array[$key]);
		}
		return $array;
	}

	public function array_assoc_remove_values($array,$value){
		$return = array(); 
		foreach($array as $k => $v) {
			if(is_array($v)) {
				$return[$k] = $this->array_assoc_remove_values($v, $value); //recursion
				continue;
			}else if($v == $value){
				unset($array);
				continue;
			}
			$return[$k] = $v;
		}
		return array_filter($return);
	}
	
	public function multiarray_unique($array){
		$unique = array_values(array_map('unserialize', array_unique(array_map('serialize', $array))));
		return($unique);
	}
	
	public function days_diff($date1, $date2){
		$current = $date1;
		$datetime2 = date_create($date2);
		$count = 0;
		while(date_create($current) < $datetime2){
			$current = gmdate("Y-m-d", strtotime("+1 day", strtotime($current)));
			$count++;
		}
		return $count;
	}
	
	public function hours_diff($datefrom, $dateto){
		$difference = abs(strtotime($datefrom) - strtotime($dateto));
		$datediff = date("H:i", mktime(0,0,$difference));
		return $datediff;
	}
	function isRut($value){
		if($value == ""){
			return false;
		}
		$RegExp='/^([0-9]){7,8}$/';

		if(preg_match($RegExp,$value) === 0){
			return false;
		}else{
			var_dump($value);
		}
		$RUT=explode("-",$value);
		$elRut=$RUT[0];
		$factor=2;
		$suma=0;
		for($i=strlen($elRut)-1;$i>=0;$i--){
			$factor=($factor>7) ? 2:$factor;
			$suma+=((int)$elRut{$i})*((int)$factor++);
		}
		$ret=true;
		$dv=11-($suma%11);
		if($dv == 11){
			$dv=0;
		}elseif($dv == 10){
			$dv="k";
		}
		if($dv!=strtolower($RUT[1])){
			$ret=false;
		}
		return $ret;
	}
	public function objectToArray($obj) {
		if(is_object($obj)) $obj = (array) $obj;
		if(is_array($obj)) {
			$new = array();
			foreach($obj as $key => $val) {
				$new[$key] = $this->objectToArray($val);
			}
		}else{
			$new = $obj;
		}
		return $new;
	}
	public function formatNum($num){
		$newNUM = number_format($num,0,',','.');
		return $newNUM;
	}
	public function debugARRAY($array){
		highlight_string(print_r($array,true));
	}
	public function keyPOSITION($key,$array){
		return array_search($key,array_keys($array));
	}
}
?>