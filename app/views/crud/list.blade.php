{{ Form::open(array('class'=>'crud_form_list','id' => 'form_list_for_'.$model)) }}
<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
		<tr >
@foreach($list as $l)
   @foreach($l as $k => $d)
   	  @if(array_key_exists($k,$format))
   	<th>
	   	<a href="#" class="crud_sort_link" data-column="{{$k}}" data-model="{{$model}}">{{$format[$k]['title']}}
	   		@if(($k==$sort) && ($order == 'desc'))
	   	   <span class="glyphicon glyphicon-arrow-up"></span>
	   	    @elseif(($k==$sort) && ($order=='asc'))
	   	   <span class="glyphicon glyphicon-arrow-down"></span>
	   	   @endif
	   	</a> 
   	</li>
   </ul>
   	</th>
   	 @endif
   @endforeach
   <?php break; ?>
@endforeach
</tr>
</thead>
<tbody>

@foreach($list as $l)
<tr>
   @foreach($l as $k => $d)
   	  @if(array_key_exists($k,$format))
   		<td
   		@if(isset($format[$k]['editable']))
   			class="scrud_editable_td" 
   			data-model="{{$model}}" 
   			data-id="{{$l['id']}}"
   			data-column="{{$k}}"
   		@endif
   		>
   			{{$d}}
   		</td>
   	  @endif
   @endforeach
</tr>
@endforeach
</tbody>
</table>
{{ Form::close() }}

<table>
<tr>
<td style="padding: 0px 10px; 0px 10px">
{{ $pag->fragment($model)->links() }}
</td>
<td style="padding: 0px 10px; 0px 10px">
 Page {{ $pag->getCurrentPage()}} of {{ $pag->getLastPage()}}, items {{ $pag->getFrom()}} to {{ $pag->getTo()}} of {{ $pag->getTotal()}}. 
</td>
<td id="crud-ajax-loader-{{$model}}" style="padding: 0px 10px; 0px 10px; display: none;">
 <img src="{{ URL::to('public/pic/ajax-loader.gif') }}" class="img-responsive">
</td>
<td id="crud_save_cancel_panel_{{$model}}" style="display: none;">
<button type="button" class="crud_save_btn btn btn-xs btn-primary" data-model="{{$model}}">Save</button>
<button type="button" class="crud_cancel_btn btn btn-xs btn-danger" data-model="{{$model}}">Cancel</button>
</td>
</tr>
</table>