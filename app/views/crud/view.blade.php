@section('content')
<div class="panel panel-default">
<div class="panel-heading">
    <div class="row">
        <div class="col-sm-4">{{ $crud_title }}</div>
        <div class="col-sm-4 col-sm-offset-4" id="crud_{{$crud_model}}_show_filters_panel">
            <button type="button" class="crud_show_filters_btn btn btn-success btn-xs" data-model="{{$crud_model}}">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
            <span id="crud_{{$crud_model}}_filters_status">Not filtered</span>
            <span id="crud_{{$crud_model}}_filters_status_info" class="label label-info" data-container="body" data-toggle="popover" data-placement="bottom" data-content="
press the plus button to add filters." data-trigger="hover" title="Not filtered" >i</span>
        </div>
    </div>    
</div>
  <!--<div class="panel-body">-->
    <table class="table" id="crud_{{$crud_model}}_filters_panel" style="display:none;">
        <tr>
    <td>{{-- $crud_title --}}</td>
    <td>
    {{ Form::open(array('class'=>'crud_form form-horizontal','id' => 'form_for_'.$crud_model , 'role' => 'form' )) }}
    	{{ Form::hidden('crud_model', $crud_model ) }}
    	{{ Form::hidden('crud_sort', $crud_sort ) }}
    	{{ Form::hidden('crud_order', $crud_order ) }}
    	{{ Form::hidden('crud_page', $crud_page ) }}
    	{{ Form::hidden('crud_changed', "" ) }}
        {{ Form::hidden('crud_filters_count', count($filters) ) }}

<div id="crud_{{$crud_model}}_filters" ></div>


@if((isset($filters))&&(count($filters)>0))
    <div class="dropdown">
        <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownmenu" data-toggle="dropdown">
            Add filter
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownmenu">
            @foreach($filters as $id => $filter)
            @if($filter['type'] != 'static')
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="#" class="crud_add_filter" data-id="{{$id}}" data-model="{{$crud_model}}">
                    {{$filter['title']}}
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
    {{ Form::close() }}
    </td>
    <td> 
        @if((isset($crud_filter_button)) && $crud_filter_button)
        <button class="crud_filter_btn btn btn-primary" data-model="{{$crud_model}}">Filter</button>
        @endif
    </td>
</tr>
</table>
  <!--</div>-->
</div>
@endif
<div id="list_for_{{$crud_model}}">
</div>

<script>
$( document ).ready(function() {
@if(isset($crud_auto_filter) && $crud_auto_filter)
$('#form_for_{{$crud_model}}').submit();
@endif
$('.label').popover({html: true});
});


</script>
@stop