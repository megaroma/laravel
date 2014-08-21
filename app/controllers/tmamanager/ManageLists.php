<?php
namespace Tmamanager;
class ManageListsController extends \CrudController {

protected $layout = 'master';

public $format = array();

public function __construct()
    {
$this->format = ['Tmamanager_ManageLists' => array (
	'id' => array(
		'title' => 'List ID',
		'value' => '{id}'
		),
	'ttl_list' => array(
		'title' => '',
		'value' => function ($row) {
						$data = '<img src="'.\URL::to('public/pic/kpercentage.png').'" class="has_popover img-rounded"'.
						    'data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="hover"'.
						    'data-content="'.
			' Finished - '.$row['ttl_complete'].' of '.$row['ttl_list'].' <br>'
			.' Ready To Call - '.$row['ttl_readytocall'].' <br>'
			.'" >';
						return $data;
					}
		),	
	'name' => array(
		'title' => 'Name',
		'value' => '{name}',
		'editable' => array(
			'type' => 'input',
			'validate' => 'required'
			)		
		),
	'assigned_user_id' => array(
		'title' => 'Agent',
		'value' => '{agentname}',
		'editable' => array(
			'type' => 'select',
			'resource' => 'User'
			)			
		),
	'priority' => array(
		'title' => 'Priority',
		'value' => '{priority}',
		'editable' => array(
			'type' => 'select',
			'resource' => array('1','2','3','4','5','6','7','8','9','10','99')
			)			
		),
	'created_at' => array(
		'title' => 'Loaded',
		'value' => '{created_at}'
		),
	'last_disposition' => array(
		'title' => 'Last Disposition',
		'value' => '{last_disposition}'
		)




	)];
}

public $filters = array(
	'Tmamanager_ManageLists' => array(
		'c.assigned_user_id' => array(
			'title' => 'Agent',
			'selectors' => '=,!=',
			'type' => 'select',
			'resource' => 'User'

			),
			'c.customer_id' => array(
			'type' => 'static',
			'selector' => '=',
			'value' => '1'
			),
			'c.priority' => array(
			'type' => 'static',
			'selector' => '!=',
			'value' => '99'
			)

));

public function anyActive() {
	$data = array(
		'crud_title' => 'All Active Campaign Lists',
		'crud_model' => 'Tmamanager_ManageLists',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => false,
		'crud_filter_button' => true,
		'crud_show_filters' => true
		);

	$customer_id = \Auth::user()->customer_id;
	$this->filters['Tmamanager_ManageLists']['c.customer_id']['value'] = $customer_id;	

	$data['filters'] = $this->filters['Tmamanager_ManageLists'];

	if($res = $this->initCrud()) return $res;

	$this->layout->content = \View::make('crud.view',$data);	

}

}