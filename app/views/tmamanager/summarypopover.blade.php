<img 	src="{{URL::to('public/pic/kpercentage.png')}}" 
     	class="has_popover img-rounded"
		data-container="body" 
		data-toggle="popover" 
		data-placement="bottom" 
		data-trigger="hover"
		data-content="Finished - {{$complete}} of {{$total}} ({{$complete_p}}%) <br>Ready To Call - {{$readytocall}} ({{$readytocall_p}}%)<br>Never Called - {{$nevercalled}} ({{$nevercalled_p}}%)">