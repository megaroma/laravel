<?php
class MegaController extends BaseController {

protected $layout = 'master';

public function getIndex() {
	return 'Mega Index';
}

public function getTest() {
	return "test Index";
}

public function getHome($id=66,$id2) {
	return "test $id $id2 -";
}

public function getMega() {

$validator = Validator::make(
    array(
        'name' => '',
        'page' => 'd',
        'password' => 'lamepassword',
        'email' => 'email@example.com'
    ),
    array(
        'name' => 'required',
        'fname' => 'required',
        'password' => 'required|min:8',
        'email' => 'required|email'
    )
);
if ($validator->fails())
{
	
	print_r($validator->messages());exit;
}
	return "-= test -=";
}

public function getTestdb() {
	
	
	$data['list'] = Campaign::take(4)->offset(3)->get()->toarray();
	//$campaigns = Campaign::paginate(15);

	//$data['pag'] = $campaigns;
	//$data['list'] = $campaigns;
	Paginator::setCurrentPage(2);
	$pag = Paginator::make(array('id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1), 1000, 10); 
	
	$data['pag'] = $pag;
	
	$this->layout->content = View::make('campaign',$data);
}


public function getView() {
	$data = array(
		'crud_title' => 'Testing',
		'crud_model' => 'Campaign',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => true
		);

	$this->layout->content = View::make('crud.view',$data);	
}

}
?>