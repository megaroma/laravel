<?php
class CrudController extends Controller {

	public function postGetlist() {
		$page = Input::get('page', 1);
		$sort = Input::get('sort', '');
		$order = Input::get('order', '');
		$model = Input::get('model', '');
		$filters= Input::get('filters', array());
		if($model == '') return "Error";

		$per_page = Config::get('view.per_page');
		$data = array();
		

		$data['model'] = $model;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$model_data = $model::get_list($filters,$order,$sort,$page); 
		$data['format'] = isset($this->format[$model]) ? $this->format[$model] : '';
		if ($data['format'] == '') return "Error"; 

		foreach ($model_data['list'] as $i => $row) {
			foreach ($row as $k => $v) {
				if(!array_key_exists($k,$data['format']) ) continue;
				$v=preg_replace_callback('/{([^}.\n]+)}/m',
                                        function ($pok) use ($row) {
                                        	return $row[$pok[1]];
                                        }
                                        ,
										$data['format'][$k]['value']);

				$data['list'][$i][$k] = $v;
			}
		}

		//$data['list'] = $model_data['list'];
		Paginator::setCurrentPage($page);
		$data['pag'] = Paginator::make($model_data['list'],$model_data['total'], $per_page); 
	
		return View::make('crud.list',$data);	
	}

	public function postMaketdeditable() {
		$model = Input::get('model', '');
		$column = Input::get('column', '');
		$id = Input::get('id', '');
		$data = Input::get('data', '');	

		$format = isset($this->format[$model]) ? $this->format[$model] : '';
		if ($format == '') return $data;
		if(isset($format[$column]['editable'])) {
			$type = isset($format[$column]['editable']['type']) ? $format[$column]['editable']['type'] : 'textarea';
			$item = $model::find($id);
			$input_data['value'] = $item[$column];
			$input_data['id'] = $id;
			$input_data['column'] = $column;
			$input_data['type'] = $type;
			if($type == 'select') {
				$model = $format[$column]['editable']['resource'];
				$input_data['resource'] = $model::all();
			}
			return View::make('crud.input',$input_data);
		} else {
			return $data;
		}

	}

	public function postSavelist() {
		$data = Input::get('crud_td', ''); 
		$model = Input::get('model', '');
		$format = isset($this->format[$model]) ? $this->format[$model] : '';
		if ($format == '') return Response::json(array('status' => 'ok'));
		//validate
		foreach ($data as $id => $d) {
			$val_data = array();
			foreach ($d as $column => $value) {
				if(isset($format[$column]['editable']['validate'])) {
					$val_data[0][$column] = $value;
					$val_data[1][$column] = $format[$column]['editable']['validate'];					
				}
			}
			if (count($val_data) > 0 ) {

				$validator = Validator::make($val_data[0],$val_data[1]);
				if ($validator->fails()) {
					$messages = $validator->messages();
					$mess = '';
					foreach ($messages->all() as $message) {
   				 		$mess .=  $message.' ';
					}
					$output = array('status' => 'error','row_id' => $id,'message' => $mess);
					return Response::json($output);
				}
			}
		}

		//save
		foreach ($data as $id => $d) {
			$item = $model::find($id);
			foreach ($d as $column => $value) {
				$item->$column = $value;
			}
			$item->save();
		}
		$output = array('status' => 'ok');
		return Response::json($output);
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}