<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{asset ('js/frontend/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
	$("input[name='check_ids']").click(function(){
	    $('input[name="item_id[]"]').not(this).prop('checked', this.checked);
	});
	$(window).on('load', function() {
		$(".background").fadeOut(1000);
	});
	//Tạm thời ẩn do ảnh hưởng ajax select2
	// $(document)
	// .ajaxStart(function () {
	// 	$(".background").fadeIn("faster");
	// })
	// .ajaxStop(function () {
	// 	$(".background").fadeOut(1000);
	// });
	// Base URL
	var base_url = "{!! url('') !!}/";
	$('.toogle-active').on('click',function(e){
	    var id = $(this).data('id');
	    var title = $(this).data('title');
	    var url = $(this).data('url');
	    swal({
	        title: "{{__('Confirmation')}}",
	        text: title,
	        buttons: {
	            cancel: "{{__('Cancel')}}",
	            yes: true,
	        },
	    })
	    .then((value) => {
	      switch (value) {
	        case "yes":
	        	$.ajax({
	        	    type: "POST",
	        	    url: url,
	        	    data: {
	        	    	id: id,
	        	    	"_token": "{{ csrf_token() }}",
	        	    },
	        	    dataType: "JSON",
	        	    success: function(result){
	        	    	if(result.success){
	        	    		swal("{{__('Success!')}}", result.message, "success");

	        	    		window.location.reload();
	        	    	}else{
	        	    		swal("{{__('Error!')}}", result.message, "error");
	        	    	}

	        	    },
	        	    error: function(jqXHR, textStatus, errorThrown){
	        	    	swal("{{__('Error!')}}", "{{__('Have error. Please try again')}}", "error");
	        	    }
	        	});
	            break;
	        default:
	            return false;
	      }
	    });
	});
	$('.delete-item').on('click',function(e){
	    var title = $(this).data('title');
	    var url = $(this).data('url');
	    var obj = $(this);
	    swal({
	        title: "{{__('Confirmation')}}",
	        text: title,
	        buttons: {
	            cancel: "{{__('Cancel')}}",
	            yes: true,
	        },
	    })
	    .then((value) => {
	      switch (value) {
	        case "yes":
	        	$.ajax({
	        	    method: "DELETE",
	        	    url: url,
	        	    data: {
	        	    	"_token": "{{ csrf_token() }}",
	        	    },
	        	    dataType: "JSON",
	        	    success: function(result){
	        	    	if(result.success){
	        	    		swal("{{__('Success!')}}", result.message, "success");
	        	    		obj.parents('.parent-item').remove();
	        	    		window.location.reload();
	        	    	}else{
	        	    		swal("{{__('Error!')}}", result.message, "error");
	        	    	}

	        	    },
	        	    error: function(jqXHR, textStatus, errorThrown){
	        	    	swal("{{__('Error!')}}", "{{__('Have error. Please try again')}}", "error");
	        	    }
	        	});
	            break;
	        default:
	            return false;
	      }
	    });
	});

	$('.delete_checked').on('click',function(e){
	    var title = $(this).data('title');
	    var url = $(this).data('url');
	    var obj = $(this);
	    var ids = [];
	    if( $('.deleteRow:checked').length > 0 ){  // at-least one checkbox checked
	        var ids = [];
	        $('.deleteRow').each(function(){
	            if($(this).is(':checked')) {
	                ids.push($(this).val());
	            }
	        });
	    } else {
	    	swal("{{__('Error!')}}", "{{__('You are not checked is checkbox')}}", "error");
	        return false;
	    }
	    swal({
	        title: "{{__('Confirmation')}}",
	        text: title,
	        buttons: {
	            cancel: "{{__('Cancel')}}",
	            yes: true,
	        },
	    })
	    .then((value) => {
	      switch (value) {
	        case "yes":
	        	$.ajax({
	        	    method: "POST",
	        	    url: url,
	        	    data: {
	        	    	ids:ids,
	        	    	"_token": "{{ csrf_token() }}",
	        	    },
	        	    dataType: "JSON",
	        	    success: function(result){
	        	    	if(result.success){
	        	    		swal("{{__('Success!')}}", result.message, "success");
	        	    		location.reload();
	        	    	}else{
	        	    		swal("{{__('Error!')}}", result.message, "error");
	        	    	}

	        	    },
	        	    error: function(jqXHR, textStatus, errorThrown){
	        	    	swal("{{__('Error!')}}", "{{__('Have error. Please try again')}}", "error");
	        	    }
	        	});
	            break;
	        default:
	            return false;
	      }
	    });
	});
</script>
