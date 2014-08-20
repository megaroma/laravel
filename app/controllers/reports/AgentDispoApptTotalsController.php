<?php
namespace Reports;
class AgentDispoApptTotalsController extends \CrudController {

	protected $layout = 'master';

public $format = ['Reports_AgentDispoApptTotals' => array (
	'id' => array(
		'title' => 'Id',
		'value' => '{id}'
		),
	'AgentName' => array(
		'title' => 'Agent Name',
		'value' => '{AgentName}'
		),
	'call_perod' => array(
		'title' => 'Calling Period',
		'value' => '{call_perod}'
		),
	'total_dispositions' => array(
		'title' => 'Dispositions',
		'value' => '{total_dispositions}'
		),
	'appt_set' => array(
		'title' => 'Appointments',
		'value' => '{appt_set}'
		)





	)];

public $filters = array(
	'Reports_AgentDispoApptTotals' => array(
		'user_id' => array(
			'title' => 'Agent',
			'selectors' => '=,!=',
			'type' => 'select',
			'resource' => 'User'
			),
		'timestamp' => array(
			'title' => 'Date',
			'selectors' => 'dt_btw',
			'type' => 'date'

			),
		'UsersWithPhone' => array(
			'title' => 'Users With Phone',
			'selectors' => '=',
			'type' => 'checkbox'

			),
		'customer_id' => array(
			'type' => 'static',
			'selector' => '=',
			'value' => '1'
			)

		));

	public function anyIndex() {

	$data = array(
		'crud_title' => 'TMA Campaign Disposition and Appointment Totals',
		'crud_model' => 'Reports_AgentDispoApptTotals',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => false,
		'crud_filter_button' => true,
		'crud_show_filters' => true
		);

	$customer_id = \Auth::user()->customer_id;
	$this->filters['Reports_AgentDispoApptTotals']['customer_id']['value'] = $customer_id;	

	$data['filters'] = $this->filters['Reports_AgentDispoApptTotals'];

	if($res = $this->initCrud()) return $res;

	$this->layout->content = \View::make('crud.view',$data);	

	}
}