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
	'list_id' => array(
		'title' => 'List ID',
		'value' => '<a href="http://beltone.impactservices.biz/show_direct_mail_piece/get_file.php?id={list_id}" >{list_id}</a>'
		),
	'info' => array(
		'title' => '',
		'value' => '<a href="#" class="list_id" data-model="Campaign_prospect" data-list_id="{list_id}" ><img title="Show Details - {name}" src="'.\URL::to('public/pic/help-icon.png').'"></a>'
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
		),
	'delete_campaign' => array(
		'title' => '',
		'value' => '<button type="button" class="delete_c btn btn-danger btn-xs" data-id="{list_id}"><span class="glyphicon glyphicon-remove"></span> Delete</button>')
	);

$this->filters['Tmamanager_ManageLists'] = 
array(
		'c.assigned_user_id' => array(
			'title' => 'Agent',
			'selectors' => '=,!=',
			'type' => 'select',
			'resource' => 'User'

			),
		'c.name' => array(
			'title' => 'Name',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

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
			),
		'assigned_user_id' => array(
			'type' => 'static',
			'selector' => '=',
			'value' => ''
			)

);

//-----------Campaign_prospect---------------------------------------------

$this->format['Campaign_prospect'] = array (
	'name' => array(
		'title' => 'Name',
		'value' => '{name}',
		),
	'address1' => array(
		'title' => 'Address 1',
		'value' => '{address1}',
		),	
	'address2' => array(
		'title' => 'Addr 2',
		'value' => '{address2}',
		),	
	'city' => array(
		'title' => 'City',
		'value' => '{city}',
		),	
	'state' => array(
		'title' => 'State',
		'value' => '{state}',
		),
	'zip' => array(
		'title' => 'Zip',
		'value' => '{zip}',
		),
	'telephone' => array(
		'title' => 'Telephone',
		'value' => '{telephone}',
		),
	'next_call_scheduled' => array(
		'title' => 'Next Call',
		'value' => '{next_call_scheduled}',
		),
	'timestamp' => array(
		'title' => 'Appt Dt',
		'value' => '{timestamp}',
		),
	'finished' => array(
		'title' => 'Finished',
		'value' => function ($row) {
					return ($row['finished'] == '1') ? 'yes' : 'no';
			       },
		)

	);

$this->filters['Campaign_prospect'] = 
array(
		'name' => array(
			'title' => 'Name',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

			),
		'address1' => array(
			'title' => 'Address1',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

			),	
		'address2' => array(
			'title' => 'Address2',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

			),	
		'city' => array(
			'title' => 'City',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

			),	
		'state' => array(
			'title' => 'State',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

			),	
		'zip' => array(
			'title' => 'Zip',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

			),	
		'telephone' => array(
			'title' => 'Telephone',
			'selectors' => '=,!=,like,not_like,start_like,end_like',
			'type' => 'text'

			),	
		'next_call_scheduled' => array(
			'title' => 'Next Call',
			'selectors' => 'dt_equal,dt_btw',
			'type' => 'date'

			),																		
		'campaign_id' => array(
			'selector' => '=',
			'type' => 'hidden',
			'value' => '16')

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

		'crud_auto_filter' => true,
		'crud_filter_button' => true,
		'crud_show_filters' => true
		);
	if(\Input::get('confirm_delete', false)) return $this->confirm_delete(\Input::get('id', ''));
	if(\Input::get('delete_campaign', false)) return $this->delete_campaign(\Input::get('id', ''));

	if(\Input::get('TMA', false)) {
		$user_id = \Auth::user()->id;
		$this->filters['Tmamanager_ManageLists']['assigned_user_id']['value'] = $user_id;
		$this->filters['Tmamanager_ManageLists']['c.assigned_user_id']['resource'] = 'User|id='.$user_id;
	}

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

		'section' => 'prospects'
		);

	$data2['filters'] = $this->filters['Campaign_prospect'];



	$this->layout->footer = \View::make('tmamanager.managelists',$data2);

}

//-----------------------
public function anyArchive() {
	$data = array(
		'crud_title' => 'All Inactive Campaign Lists',
		'crud_model' => 'Tmamanager_ManageLists',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => true,
		'crud_filter_button' => true,
		'crud_show_filters' => true
		);

	if(\Input::get('confirm_delete', false)) return $this->confirm_delete(\Input::get('id', ''));
	if(\Input::get('delete_campaign', false)) return $this->delete_campaign(\Input::get('id', ''));

	if(\Input::get('TMA', false)) {
		$user_id = \Auth::user()->id;
		$this->filters['Tmamanager_ManageLists']['assigned_user_id']['value'] = $user_id;
		$this->filters['Tmamanager_ManageLists']['c.assigned_user_id']['resource'] = 'User|id='.$user_id;
	}
	$customer_id = \Auth::user()->customer_id;
	$this->filters['Tmamanager_ManageLists']['c.customer_id']['value'] = $customer_id;	
	$this->filters['Tmamanager_ManageLists']['c.priority']['selector'] = '=';

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

		'section' => 'prospects'
		);

	$data2['filters'] = $this->filters['Campaign_prospect'];



	$this->layout->footer = \View::make('tmamanager.managelists',$data2);

}

//------------------------------------
public function confirm_delete($id) {
	if($id == '') return 'Error';
	$data = array();
	$campaign = \Campaign::find($id);
	$user = \User::find($campaign->assigned_user_id);
	$data['name'] = $campaign->name;
	$data['comment'] = $campaign->comment;
	$data['agent'] = isset($user->name)?$user->name : '';


	$data['priority'] = $campaign->priority;
	$data['created'] = $campaign->created_at;
	$user = \User::find($campaign->loaded_by_user_id);
	$data['loaded'] = isset($user->name)?$user->name : '';
	$data['orig'] = $campaign->uploaded_filename;

	return \View::make('tmamanager.confirmdelete',$data);
}

public function delete_campaign($id) {
	$customer_id = \Auth::user()->customer_id;
	\DB::statement('call deletecampaign(' . \DB::raw($customer_id) . ',' . \DB::raw($id) . ')');	
	return 'ok';
}

}