@if(strlen($text) > $limit)
<span title="{{$text}}">
	{{substr($text,0,$limit)}}
	<a href="#" class="crud_show_more"> ...</a>
	<span style="display:none;">
		{{substr($text,$limit)}}
		<a href="#" class="crud_show_less"><span class="glyphicon glyphicon-chevron-up"></span></a>
	</span>
</span>
@else
{{$text}}
@endif