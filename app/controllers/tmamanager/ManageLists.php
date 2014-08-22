<?php
namespace Tmamanager;
class ManageListsController extends \CrudController {

protected $layout = 'master';

public $format = array();
public $filters = array();

public function __construct()
    {
//--------------- Tmamanager / ManageLists ---------------------------------------------  	
$this->format['Tmamanager_ManageLists'] = array (
	'id' => array(
		'title' => 'List ID',
		'value' => '{id}'
		),
	'ttl_list' => array(
		'title' => '',
		'value' => function ($row) {
				$data = array(
					'total' => $row['ttl_list'],
					'complete' => $row['ttl_complete'],
					'complete_p' => ($row['ttl_list'] > 0) ? round(($row['ttl_complete']/$row['ttl_list'])*100) : 0,
					'readytocall' => $row['ttl_readytocall'],
					'readytocall_p' =>($row['ttl_list'] > 0) ? round(($row['ttl_readytocall']/$row['ttl_list'])*100) : 0,
					'nevercalled' => $row['ttl_nevercalled'],
					'nevercalled_p' => ($row['ttl_list'] > 0) ? round(($row['ttl_nevercalled']/$row['ttl_list'])*100) : 0
					);

						return \View::make('tmamanager.summarypopover',$data);
					}
		),	
	'name' => array(
		'title' => 'Name',
		'value' => function ($row) {
				$data = array(
					'text' => $row['name'],
					'limit' => 17
					);
						return \View::make('crud.expander',$data);
			},
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
	);

$this->filters['Tmamanager_ManageLists'] = 
array(
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

);

//-----------Campaign_prospect---------------------------------------------

$this->format['Campaign_prospect'] = array (
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
		)
	);

$this->filters['Campaign_prospect'] = 
array(
		'name' => array(
			'title' => 'Name',
			'selectors' => '=,!=,>,<',
			'type' => 'text'

			)
);

}





//-----------------------
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


	$data2  = array(
		'crud_title' => 'Details',
		'crud_model' => 'Campaign_prospect',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => false,
		'crud_filter_button' => true,
		'crud_show_filters' => true,

		'section' => 'footer'
		);

	$data2['filters'] = $this->filters['Campaign_prospect'];



	$this->layout->footer = \View::make('tmamanager.managelists',$data2);

}

}