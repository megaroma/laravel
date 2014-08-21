<?php
class CrudController extends Controller {

	public function initCrud() {
		$action = Input::get('crud_action', '');

		//list--------------------
		if($action == 'getlist') {
		$page = Input::get('crud_page', 1);
		$sort = Input::get('crud_sort', '');
		$order = Input::get('crud_order', '');
		$model = Input::get('crud_model', '');
		$filters= Input::get('filter', array());
		if($model == '') return "Error";

		$per_page = Config::get('view.per_page');
		$data = array();
		

		$data['model'] = $model;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$filters = $this->check_filters($model,$filters);
		$model_run = str_replace('_', '\\', $model);
		$model_data = $model_run::get_list($filters,$order,$sort,$page); 
		$data['format'] = isset($this->format[$model]) ? $this->format[$model] : '';
		if ($data['format'] == '') return "Error"; 
		if (count($model_data['list']) < 1) return "No data"; 

		foreach ($model_data['list'] as $i => $row) {
			foreach ($row as $k => $v) {
				if(array_key_exists($k,$data['format']) ) {
					$format_value = $data['format'][$k]['value'];
					if(is_callable($format_value)) {
						$v = $format_value($row); 
					} else {
						$v=preg_replace_callback('/{([^}.\n]+)}/m',
                                        function ($pok) use ($row) {
                                        	return $row[$pok[1]];
                                        }
                                        ,
										$format_value);
					}
				}

				$data['list'][$i][$k] = $v;
			}
		}


		//$data['list'] = $model_data['list'];
		Paginator::setCurrentPage($page);
		$data['pag'] = Paginator::make($model_data['list'],$model_data['total'], $per_page); 
	
		$data['filters_status']  = Crud::get_filters_status($filters,$this->filters[$model]);

		return View::make('crud.list',$data);	
		} 

		//----Make TD Editable--------------------------------------
		elseif($action == 'maketdeditable') {
			$model = Input::get('model', '');
			$column = Input::get('column', '');
			$id = Input::get('id', '');
			$data = Input::get('data', '');	

			$format = isset($this->format[$model]) ? $this->format[$model] : '';
			if ($format == '') return $data;
			if(isset($format[$column]['editable'])) {
				$type = isset($format[$column]['editable']['type']) ? $format[$column]['editable']['type'] : 'textarea';
				$model_run = str_replace('_', '\\', $model);
				$item = $model_run::find($id);
				$input_data['value'] = $item[$column];
				$input_data['id'] = $id;
				$input_data['column'] = $column;
				$input_data['type'] = $type;
				if($type == 'select') {
					$model = $format[$column]['editable']['resource'];
					if(is_array($model)) {
						foreach($model as $d) {
							if (is_array($d) ) {
								$input_data['resource'][] = (object) array('id' => $d['id'],'name' => $d['name']);
							} else {
								$input_data['resource'][] = (object) array('id' => $d,'name' => $d);
							}
						}
					} else {
						$input_data['resource'] = $model::all();
					}
				}
				return View::make('crud.input',$input_data);
			} else {
				return $data;
			}			
		}
		//------Save List ------------------------------
		elseif($action == 'savelist') {
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
			$model_run = str_replace('_', '\\', $model);
			foreach ($data as $id => $d) {
				$item = $model_run::find($id);
				foreach ($d as $column => $value) {
					$item->$column = $value;
				}
				$item->save();
			}
			$output = array('status' => 'ok');
			return Response::json($output);
		}
		//---Add Filter---------------------------------------------
		elseif($action == 'addfilter') {
			$model = Input::get('model', '');
			$id =  Input::get('id', '');
			$i = Input::get('i', '');
			$filters = $this->get_filters_map($model);
			if (($model != '') && ($id != '') && ($i != '') && (isset($filters[$id])) && ($filters[$id]['type'] != 'static') ) {
				$data = array();
				$filter = $filters[$id];
				$data['name'] = $filter['title'];
				$data['type'] = $filter['type'];
				$data['model'] = $model;
				$data['id'] = $id;
				$data['i'] = $i;
				if(($filter['type'] == 'select') && (isset($filter['resource']))) {
					$r_model = $filter['resource'];
					$data['resource'] = $r_model::all();
				} 
				$data['selectors'] = Crud::get_selectors($filter['selectors']);
				if ($data['selectors'][0]['name'] == 'between') {
					$data['data2_style'] = "";
					$data['data_class'] = "col-sm-3";
				} else {
					$data['data_class'] = "col-sm-6";
					$data['data2_style'] = "display:none";
				}
				return View::make('crud.filter',$data);
			}			
		}
		return false;
	}


	public function get_filters_map($model) {
		return $this->filters[$model];
	}

	public function check_filters($model,$filters) {
		$filters_map = $this->get_filters_map($model);
		return Crud::check_filters($filters_map,$filters);
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}