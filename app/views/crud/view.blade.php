@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    {{ $crud_title }}

    {{ Form::open(array('class'=>'crud_form','id' => 'form_for_'.$crud_model)) }}
    	{{ Form::hidden('crud_model', $crud_model ) }}
    	{{ Form::hidden('crud_sort', $crud_sort ) }}
    	{{ Form::hidden('crud_order', $crud_order ) }}
    	{{ Form::hidden('crud_page', $crud_page ) }}
    	{{ Form::hidden('crud_changed', "" ) }}

    {{ Form::close() }}
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