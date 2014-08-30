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


<div class="modal fade" id="confDelete" tabindex="-1" role="dialog" aria-labelledby="confDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="confDeleteLabel">Delete Canpaign List</h4>
      </div>
      <div class="modal-body">
        <h5 class="text-center text-primary">Delete Campaign List </h5>
        <h4 class="text-center text-danger">** CAUTION **</h4>
        <p class="text-left">You are about to delete records from the database. You will be deleting: </p>
        <p class="text-left">
            <span class="text-danger">*</span> The Campaign List <br>
            <span class="text-danger">*</span> All prospects/users who were on that list <br>
            <span class="text-danger">*</span> All campaign call records generated from the Campaign List <br>
        </p>
        <ul class="list-group">
            <li class="list-group-item active text-center">Once these records are deleted, they cannot be retrieved.</li>
        </ul>

        <p class="text-left">The Campaign List about to be Deleted is: </p>
        <div id="campaign_info"></div>

      </div>
      <div class="modal-footer">
        {{ Form::hidden('campaign_id', '', array('id' => 'campaign_id')) }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel Delete</button>
        <button type="button" class="btn btn-primary" id="confirm_delete_btn">Confirm Delete</button>
      </div>
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

$('.container').on('click','.delete_c', function (event) {
    event.preventDefault();
    var id = $(this).data('id');
    $('#campaign_id').val(id);
    $('#campaign_info').html('<img src="{{ URL::to('public/pic/ajax-loader.gif') }}" class="img-responsive">');
    $('#confDelete').modal('show');
    $.post( window.location.href,
        {id: id,confirm_delete: true } , 
        function( data ) {
        $('#campaign_info').html(data);
    });

    return false;
});

$('#confirm_delete_btn').click(function(){
    var id = $('#campaign_id').val();
    $.post( window.location.href,
        {id: id,delete_campaign: true } , 
        function( data ) {
        $('#confDelete').modal('hide');
        $('#form_for_Tmamanager_ManageLists').submit();
    });

});

</script>
@stop