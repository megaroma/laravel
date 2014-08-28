@include('crud.view')
@section('footer')


<div id="prospects_list" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="prospects" aria-hidden="true">
  <div class="modal-dialog" style="width:90%">
    <div class="modal-content">
    	<button type="button" class="close" data-dismiss="modal" style="padding:6px;"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      @yield('prospects')
    </div>
  </div>
</div>
	



<script>
$('.container').on('click','.list_id', function (event) {
    event.preventDefault();
    var id = $(this).data('list_id');
    var model = $(this).data('model');
    $('#form_for_'+model+' .crud_hidden_filter_campaign_id').val(id);
    $('#form_for_'+model+' input[name=crud_order]').val('');
    $('#form_for_'+model+' input[name=crud_sort]').val('');
    $('#form_for_'+model+' input[name=crud_page]').val('');
    $('.crud_filters_'+model).remove();
    $('#form_for_'+model).submit();
    $('#prospects_list').modal('show');
    return false;
});


</script>
@stop