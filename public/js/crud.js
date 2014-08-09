$( document ).ready(function() {

//--------Submit------
$(".crud_form").submit(function( event ) {
var form_id = $(this).attr('id');	
var model = form_id.split('_')[2];
var page = $('#'+form_id+' input[name=crud_page]').val();
var sort = $('#'+form_id+' input[name=crud_sort]').val();
var order = $('#'+form_id+' input[name=crud_order]').val();
var changed = $('#'+form_id+' input[name=crud_changed]').val();
if (changed == 1 ) {	
	if(confirm('You have unsaved changes on this page. Do you want to leave this page and discard your changes?')) {
		$('#'+form_id+' input[name=crud_changed]').val('');
		$('#crud_save_cancel_panel_'+model).hide();
	} else {
		return false;
	}
}
$('#crud-ajax-loader-'+model).show();
$.post( get_url("crud/getlist"),
		{page: page,sort: sort, order: order,model: model} , 
		function( data ) {
	$('#list_for_'+model).html(data);
});
event.preventDefault();
return false;
});


//-------Pagination-------------------
$('.container').on('click','.pagination a', function (event) {
    event.preventDefault();
    var pag_link = $(this).attr('href');
    var tmp = pag_link.indexOf('?page=');
    tmp = pag_link.substr(parseInt(tmp) + 6);
    tmp=tmp.split('#');
    var page = tmp[0];
    var model = tmp[1];
    $('#form_for_'+model+' input[name=crud_page]').val(page);
    $('#form_for_'+model).submit();
    return false;
});

//-----Sort--------------------------
$('.container').on('click','.crud_sort_link', function (event) {
    event.preventDefault();
    var column = $(this).data('column');
    var model = $(this).data('model');
    var sort = $('#form_for_'+model+' input[name=crud_sort]').val();
    var order = $('#form_for_'+model+' input[name=crud_order]').val();
    if(column == sort) {
    	if(order == 'desc') {
    		$('#form_for_'+model+' input[name=crud_order]').val('asc');    		
    	} else {
    		$('#form_for_'+model+' input[name=crud_order]').val('desc');    		    		
    	}
    } else {
    	$('#form_for_'+model+' input[name=crud_sort]').val(column);
    	$('#form_for_'+model+' input[name=crud_order]').val('desc');
    }
    $('#form_for_'+model).submit();
    return false;
});

//-----Make TD Editable
$('.container').on('dblclick','.scrud_editable_td', function (event) {
	var self = this;
    var column = $(self).data('column');
    var model = $(self).data('model');
    var id = $(self).data('id');
    var value = $(self).html();
    $('#form_for_'+model+' input[name=crud_changed]').val('1');
    $.post( get_url("crud/maketdeditable"),
		{column: column,model: model,id: id, data: value} , 
		function( data ) {
	    $(self).html(data);
	    $(self).children(":first").focus();
	    $('#crud_save_cancel_panel_'+model).show();
});
});


//-------Cancel Button ---------------
$('.container').on('click','.crud_cancel_btn', function (event) {
var model = $(this).data('model');
$('#crud_save_cancel_panel_'+model).hide();
$('#form_for_'+model+' input[name=crud_changed]').val('');
$('#form_for_'+model).submit();
return false;
});

//------Save Button-------------------
$('.container').on('click','.crud_save_btn', function (event) {
var model = $(this).data('model');
var form_data = $('#form_list_for_'+model).serializeArray();
form_data.push({name: "model",value: model});
$('#crud_save_cancel_panel_'+model).hide();
$('#crud-ajax-loader-'+model).show();
$('.crud_tr_'+model).removeClass('danger');
$.ajax({
type: "POST",
url: get_url("crud/savelist"),
data: form_data,
dataType: "json"
})
.done(function( data ) {
if(data.status == 'ok') {
	$('#form_for_'+model+' input[name=crud_changed]').val('');
	$('#form_for_'+model).submit();
} else {
	$('#crud_save_cancel_panel_'+model).show();
	$('#crud-ajax-loader-'+model).hide();
    $('#crud_tr_'+model+'_'+data.row_id).addClass('danger');
    alert(data.message);
}

}).fail(function() {
$('#crud_save_cancel_panel_'+model).show();
$('#crud-ajax-loader-'+model).hide();	
alert("Something Went Wrong. Please Try again Later" );
});



return false;
});



});	