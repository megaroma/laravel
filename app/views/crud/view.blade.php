@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    <table class="table">
        <tr>
    <td>{{ $crud_title }}</td>
    <td>
    {{ Form::open(array('class'=>'crud_form form-horizontal','id' => 'form_for_'.$crud_model , 'role' => 'form' )) }}
    	{{ Form::hidden('crud_model', $crud_model ) }}
    	{{ Form::hidden('crud_sort', $crud_sort ) }}
    	{{ Form::hidden('crud_order', $crud_order ) }}
    	{{ Form::hidden('crud_page', $crud_page ) }}
    	{{ Form::hidden('crud_changed', "" ) }}

    <div class="form-group">
        <label class ="col-sm-2 control-label">
            <select class="form-control input-xs">
                <option>
        </label>
        <div class = "col-sm-10">
            <button type="submit" class="btn btn-default btn-xs">Add filter</button>
        </div>
    </div>

    {{ Form::close() }}
    </td>
    <td>Button</td>
</tr>
</table>
  </div>
</div>

<div id="list_for_{{$crud_model}}">
</div>

<script>
$( document ).ready(function() {
@if(isset($crud_auto_filter) && $crud_auto_filter)
$('#form_for_{{$crud_model}}').submit();
@endif
});


</script>
@stop