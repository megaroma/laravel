<?php
namespace Admin;
class AdminController extends \CrudController {


protected $layout = 'master';

//-----view for Campaign-------------------
public $format = ['Campaign' => array (

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
		),
	'created_at' => array(
		'title' => 'Created',
		'value' => '{created_at}'

		)


	)];

public $filters = array(
	'Campaign' => array(
		'assigned_user_id' => array(
			'title' => 'User',
			'selectors' => '=,!=',
			'type' => 'select',
			'resource' => 'User'

			),
		'priority' => array(
			'title' => 'Priority',
			'selectors' => '=,!=,>,<',
			'type' => 'number'

			),
		'created_at' => array(
			'title' => 'Created',
			'selectors' => 'dt_equal',
			'type' => 'date'

			),
		'customer_id' => array(
			'type' => 'static',
			'selector' => '=',
			'value' => '3'
			)




		)

	);


public function getIndex() {
	$data = array(
		'crud_title' => 'Testing',
		'crud_model' => 'Campaign',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => true,
		'crud_filter_button' => true
		);

	$data['filters'] = $this->filters['Campaign'];

	$this->layout->content = \View::make('crud.view',$data);	
}


}
