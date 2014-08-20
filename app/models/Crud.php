<?php
class Crud {
	public static $selectors = array(
		'=' => array('name' => '=', 'code' => '{field} = {data}' ),
		'!=' => array('name' => '!=', 'code' => '{field} <> {data}' ),
		'<' => array('name' => '<', 'code' => '{field} < {data}' ),
		'>' => array('name' => '>', 'code' => '{field} > {data}' ),
		'btw' => array('name' => 'between', 'code' => '{field} between {data} and {data2}' ),		
		'dt_btw' => array('name'=> 'between', 'code' => "DATE({field}) between STR_TO_DATE({data},'%m/%d/%Y') and STR_TO_DATE({data2},'%m/%d/%Y') "),		
		'dt_equal' => array('name'=> '=', 'code' => "DATE({field}) = STR_TO_DATE({data},'%m/%d/%Y') ")		

		);

	public static function get_selectors($selectors) {
		$s_arr = explode(",", $selectors);
		$data = array();
		foreach($s_arr as $sel) {
			$data[] = array(
					'id' => $sel,
					'name' => self::$selectors[$sel]['name']
				);
		}
		return $data;
	}

	public static function get_selector_code($field,$selector,$data,$data2 = '') {
		$code = self::$selectors[$selector]['code'];
		$code = str_replace("{field}", $field, $code);
		$code = str_replace("{data}", DB::connection()->getPdo()->quote($data), $code);
		$code = str_replace("{data2}", DB::connection()->getPdo()->quote($data2), $code);
		return $code;
	}	

	public static function get_filters_sql($filters) {
		$sql_arr = array();
		foreach($filters as $filter) {
			$field = key($filter);
			$selector = $filter[$field]['selector'];
			//$data = $filter[$field]['data'];
			$data = array_get($filter,$field.'.data', '');
			$data2 = array_get($filter,$field.'.data2', '');
			if($data != '') {
				$sql_arr[] = self::get_selector_code($field,$selector,$data,$data2);
				//$sql_arr[] = $field.' '.self::$selectors[$selector]['code'].' '.DB::connection()->getPdo()->quote($data);  
			}
		}
		if(count($sql_arr) > 0) {
			return implode (' and ',$sql_arr);
		} else {
			return '1';
		}
	}

	public static function get_filters_status($filters,$filters_map) {
		$status = "";
		foreach($filters as $filter) {
			$field = key($filter);
			if(isset($filters_map[$field]) && ($filters_map[$field]['type'] != 'static') 
				&& isset($filter[$field]['data']) && ($filter[$field]['data'] != '') ) {
				if ($filters_map[$field]['type'] == 'select') {
					$res_mod = $filters_map[$field]['resource'];
					$item = $res_mod::find($filter[$field]['data']);
					$status .= $filters_map[$field]['title'].self::$selectors[$filter[$field]['selector']]['name']."'".$item['name']."' <br>";
				} elseif ($filters_map[$field]['type'] == 'checkbox') {
					$status .= $filters_map[$field]['title'].'<br>';
				} else {
					if(self::$selectors[$filter[$field]['selector']]['name'] == 'between') {
						$status .= $filters_map[$field]['title'].' '.self::$selectors[$filter[$field]['selector']]['name']." '".$filter[$field]['data']."' and '".$filter[$field]['data2']."' <br>";
					} else {
						$status .= $filters_map[$field]['title'].self::$selectors[$filter[$field]['selector']]['name']."'".$filter[$field]['data']."' <br>";
					}					
				}
			}
		}
		return $status;
	}


	public static function check_filters($filters_map,$filters) {
		$data = array();
		foreach ($filters as $i => $filter) {
			$field = key($filter);
			if(isset($filters_map[$field]) && ($filters_map[$field]['type'] != 'static') ) {
				$data[] = $filter;
			}
		}
		foreach ($filters_map as $field => $map) {
			if($map['type'] == 'static') {
				$data[][$field] = array(
						'selector' => $map['selector'],
						'data' => $map['value']
					); 
			}
		}
		return $data;
	}

}