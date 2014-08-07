@if($type == 'texarea')
<textarea class="form-control" rows="3" name="crud_td[{{$id}}][{{$column}}]">{{$value}}</textarea>
@elseif($type == 'input')
<input type="text" class="form-control" name="crud_td[{{$id}}][{{$column}}]" value="{{$value}}">
@elseif($type == 'select')
<select class="form-control" class="form-control" name="crud_td[{{$id}}][{{$column}}]">
	@foreach($resource as $r)
	 <option value="{{$r->id}}" 
	 	@if($r->id == $value )
	 		selected
	 	@endif
	 	
	 	>{{$r->name}}</option>
	@endforeach
</select>	
@endif