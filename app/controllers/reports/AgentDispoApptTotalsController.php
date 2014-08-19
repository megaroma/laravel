<?php
namespace Reports;
class AgentDispoApptTotalsController extends \CrudController {

	protected $layout = 'master';

public $format = ['Reports_AgentDispoApptTotals' => array (

	'name' => array(
		'title' => 'Name',
		'value' => '{id}'
		),
	'AgentName' => array(
		'title' => 'AgentName',
		'value' => '{name}'
		))];

public $filters = array(
	'Reports_AgentDispoApptTotals' => array(
		'u.id' => array(
			'title' => 'User',
			'selectors' => '=,!=',
			'type' => 'select',
			'resource' => 'User'

			)

		));

	public function anyIndex() {

	$data = array(
		'crud_title' => 'Testing',
		'crud_model' => 'Reports_AgentDispoApptTotals',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => true,
		'crud_filter_button' => true
		);

	$data['filters'] = $this->filters['Reports_AgentDispoApptTotals'];

	if($res = $this->initCrud()) return $res;

	$this->layout->content = \View::make('crud.view',$data);	

	}
}