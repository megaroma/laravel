<?php
class Campaign extends Eloquent {
protected $table = 'campaigns';

public static $format = array (

	'id' => array(
		'title' => 'ID',
		'value' => '{id}'
		),
	'name' => array(
		'title' => 'Name',
		'value' => '{name}',
		'editable' => array(
			'type' => 'input'
			)
		),
	'priority' => array(
		'title' => 'Priority',
		'value' => '{priority}',
		'editable' => array(
			'type' => 'input'
			)		
		),
	'assigned_user_id' => array(
		'title' => 'User',
		'value' => '{assigned_user_id}',
		'editable' => array(
			'type' => 'select',
			'resource' => 'User'
			)	

		)


	);



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