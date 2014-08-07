@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    Basic panel example
  </div>
</div>

<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
		<tr >
@foreach($list as $l)
   @foreach($l as $k => $d)
   	<th>
	   	<a>{{$k}}<span class="glyphicon glyphicon-arrow-down"></span></a> 
   	</li>
   </ul>
   	</th>
   @endforeach
   <?php break; ?>
@endforeach
</tr>
</thead>
<tbody>

@foreach($list as $l)
<tr>
   @foreach($l as $k => $d)
   	<td> {{$d}} </td>
   @endforeach
</tr>
@endforeach


</tbody>

</table>

{{ $pag->links() }}
<br>
Page {{ $pag->getCurrentPage()}} of {{ $pag->getLastPage()}}, items {{ $pag->getFrom()}} to {{ $pag->getTo()}} of {{ $pag->getTotal()}}. 


@stop