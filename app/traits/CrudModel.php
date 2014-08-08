<?php

trait CrudModel {

public static function get_list($filters,$order,$sort,$page) {
$per_page = Config::get('view.per_page');
$offset = ($page-1)*$per_page;
if ($sort != '') {
	$data['list'] = self::orderBy($sort,$order)->take($per_page)->offset($offset)->get()->toarray();
} else {
	$data['list'] = self::take($per_page)->offset($offset)->get()->toarray();
}
$data['total'] = self::count(); 
return $data; 
}	

}


