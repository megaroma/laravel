<?php
class Campaign extends Eloquent {
use CrudModel;

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
			'type' => 'input',
			'validate' => 'required'
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






}