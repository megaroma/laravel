<div class="form-group" id="crud_filter_{{$model}}_{{$i}}">
  @if($type == 'checkbox')
  <div class="col-sm-3">{{$name}}</div><input type="hidden" name="filter[{{$i}}][{{$id}}][selector]" value="{{$selectors[0]['id']}}" >
  @else
  <div class="col-sm-1">{{$name}}</div>
  <div class="col-sm-2">
    <select class="crud_filter_selector form-control input-sm" name="filter[{{$i}}][{{$id}}][selector]" data-i="{{$i}}" data-model="{{$model}}">
    @foreach($selectors as $option)
      <option value="{{$option['id']}}">{{$option['name']}}</option>
    @endforeach
    </select>
  </div>
  @endif  

  @if($type == 'text')
  <div class="col-sm-6">
      <input type="text" class="form-control input-sm" name="filter[{{$i}}][{{$id}}][data]">
  </div>
  @elseif($type == 'number')
  <div class="col-sm-6">  
      <input type="text" class="form-control input-sm" name="filter[{{$i}}][{{$id}}][data]">
  </div>
  @elseif($type == 'checkbox')
  <div class="col-sm-6 class="checkbox"">
    <label>
      <input type="checkbox" name="filter[{{$i}}][{{$id}}][data]" value="1" checked >
    </label>
  </div>
  @elseif($type=='select')
  <div class="col-sm-6">  
      <select  class="form-control input-sm" name="filter[{{$i}}][{{$id}}][data]">
      @foreach($resource as $r)
       <option value="{{$r['id']}}">{{$r['name']}}</option>
       @endforeach
      </select>
  </div>
  @elseif($type=='date')
  <div class="{{ $data_class }}" id="crud_filter_data_{{$model}}_{{$i}}">
               <div class='datepicker input-group date'>
                    <input type='text' class="form-control" placeholder="dd/mm/yyyy" name="filter[{{$i}}][{{$id}}][data]" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
  </div>
  <div class="col-sm-3" style="{{ $data2_style }}" id="crud_filter_data2_{{$model}}_{{$i}}">
               <div class='datepicker input-group date'>
                    <input type='text' class="form-control" placeholder="dd/mm/yyyy" name="filter[{{$i}}][{{$id}}][data2]" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
  </div>
  @endif

  
  <div class="col-sm-1">
    <button class="crud_del_filter_btn btn btn-danger btn-sm" data-i="{{$i}}" data-model="{{$model}}">
      <span class="glyphicon glyphicon-remove"></span>
    </button>
  </div>
</div>

  