// Delete comment call
$(document).on('click','.delete_comment',function(){
	if(confirm('Do you really want to delete this comment.'))
	{
		var model = "OutfitComment";
		var id = $(this).attr('rel');
		$.ajax({
			url: '/admins/delete/'+model+'/'+id,
			success: function(res){
				if(res!='fail')
				{
					$('.tr'+res).remove();
				}
			}
		});
	}

});

//Delete blog post call
$(document).on('click','.delete_blogpost',function(){
	if(confirm('Do you really want to delete this blogpost.'))
	{
		var model = 'Blog';
		var id = $(this).attr('rel');
		var datastring = 'model:'+model+', id:'+id;
		$.ajax({
			url: '/admins/delete/'+model+'/'+id,
			success: function(res){
				if(res!='fail')
				{
					$('.tr'+res).remove();
				}
			}
		});
	}

});
//selecct outfit 
$(document).on('change','.select_stylist',function(){
	var stylist_id = $(this).val();
	if(stylist_id!=''){
		$.ajax({
			url : '/admins/select_outfit/'+stylist_id,
			success : function(response){
				$('.select_outfit_div').fadeIn();
				$('.select_outfit').html(response);
			}
		});
	}

});