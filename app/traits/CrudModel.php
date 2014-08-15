<?php

trait CrudModel {

public static function get_list($filters,$order,$sort,$page) {
$per_page = Config::get('view.per_page');
$filters_sql = Crud::get_filters_sql($filters);

$offset = ($page-1)*$per_page;
if ($sort != '') {
	$data['list'] = self::whereRaw($filters_sql)->orderBy($sort,$order)->take($per_page)->offset($offset)->get()->toarray();
} else {
	$data['list'] = self::whereRaw($filters_sql)->take($per_page)->offset($offset)->get()->toarray();
}
$data['total'] = self::whereRaw($filters_sql)->count(); 
return $data; 
}	

}


