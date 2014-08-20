$( document ).ready(function() {

//--------Submit------
$(".crud_form").submit(function( event ) {
var form_id = $(this).attr('id');	
var model = form_id.replace('form_for_','');
var form_data = $('#'+form_id).serializeArray();
form_data.push({name: "crud_action",value: "getlist"});
//var page = $('#'+form_id+' input[name=crud_page]').val();
//var sort = $('#'+form_id+' input[name=crud_sort]').val();
//var order = $('#'+form_id+' input[name=crud_order]').val();
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
$('#crud-ajax-top-loader-'+model).show();
$.post( window.location.href,
		//{page: page,sort: sort, order: order,model: model} , 
        form_data,
		function( data ) {
	$('#list_for_'+model).html(data);
    $('#crud-ajax-top-loader-'+model).hide();   
    var filters_status = $('#crud_'+model+'_list_filters_status').val();
    if(filters_status == "") {
        $('#crud_'+model+'_filters_status').text('Not filtered');
        $('#crud_'+model+'_filters_status_info').attr('data-original-title','Not filtered');        
        $('#crud_'+model+'_filters_status_info').attr('data-content','press the plus button to add filters.');        
    } else {
        $('#crud_'+model+'_filters_status').text('Filtered');
        $('#crud_'+model+'_filters_status_info').attr('data-original-title','Filtered by:');        
        $('#crud_'+model+'_filters_status_info').attr('data-content',filters_status);        
    }
    $('#crud_'+model+'_show_filters_panel').show();
    $('#crud_'+model+'_filters_panel').hide();

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
    $.post( window.location.href,    
		{column: column,model: model,id: id, data: value,crud_action: "maketdeditable"} , 
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
form_data.push({name: "crud_action",value: "savelist"});
$('#crud_save_cancel_panel_'+model).hide();
$('#crud-ajax-loader-'+model).show();
$('#crud-ajax-top-loader-'+model).show();
$('.crud_tr_'+model).removeClass('danger');
$.ajax({
type: "POST",
url: window.location.href,
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
    $('#crud-ajax-top-loader-'+model).hide();
    $('#crud_tr_'+model+'_'+data.row_id).addClass('danger');
    alert(data.message);
}

}).fail(function() {
$('#crud_save_cancel_panel_'+model).show();
$('#crud-ajax-loader-'+model).hide();
$('#crud-ajax-top-loader-'+model).hide();	
alert("Something Went Wrong. Please Try again Later" );
});
return false;
});

//----Add filter--------------------------------------------
$('.container').on('click','.crud_add_filter', function (event) {
event.preventDefault();
var id = $(this).data('id');
var model = $(this).data('model');
var filter_count = $('#form_for_'+model+' input[name=crud_filters_count]').val();
filter_count = parseInt( filter_count ) + 1;
$.post( window.location.href,
        {id: id,model: model,i: filter_count,crud_action: "addfilter" } , 
        function( data ) {
        $('#crud_'+model+'_filters').append(data);
        $('#form_for_'+model+' input[name=crud_filters_count]').val(filter_count);
        $('.datepicker').datetimepicker({
                    pickTime: false
                });
    });


return true;
});

//---Delete filter--------------------------------------------
$('.container').on('click','.crud_del_filter_btn', function (event) {
event.preventDefault();
var i = $(this).data('i');
var model = $(this).data('model');
$('#crud_filter_'+model+'_'+i).remove();
});


//----filter-------------------------------------------------
$('.container').on('click','.crud_filter_btn', function (event) {
event.preventDefault();
var model = $(this).data('model');
$('#form_for_'+model).submit();
});


//---Show filters-------------------------------------------
$('.container').on('click','.crud_show_filters_btn', function (event) {
event.preventDefault();
var model = $(this).data('model');
$('#crud_'+model+'_show_filters_panel').hide();
$('#crud_'+model+'_filters_panel').show();

});

//---Selector--------
$('.container').on('change','.crud_filter_selector', function (event) {
    var i = $(this).data('i');
    var model = $(this).data('model');
    var selector = $(this).find(':selected').text();
    if (selector == 'between') {
        if($('#crud_filter_data_'+model+'_'+i).hasClass('col-sm-6')) {
            $('#crud_filter_data_'+model+'_'+i).removeClass('col-sm-6');
            $('#crud_filter_data_'+model+'_'+i).addClass('col-sm-3');
            $('#crud_filter_data2_'+model+'_'+i).show();
        }
    } else {
        if($('#crud_filter_data_'+model+'_'+i).hasClass('col-sm-3')) {
            $('#crud_filter_data_'+model+'_'+i).removeClass('col-sm-3');
            $('#crud_filter_data_'+model+'_'+i).addClass('col-sm-6');
            $('#crud_filter_data2_'+model+'_'+i).hide();
        }
    }
});

});	