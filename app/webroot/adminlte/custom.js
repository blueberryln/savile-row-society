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

// change the status of outfit comments
$(document).on('click','.comment_status',function(){
	var id = $(this).attr('rel');
	var model = 'OutfitComment';
	var status ='';
	$(this).attr('disabled',true);
	$(this).text('Loading...');
	if($(this).hasClass('label-success')){
		var status = '0';
	}
	else if($(this).hasClass('label-warning')){
		var status = '1';
	}
	if(id){
		$.ajax({
			url : '/admins/status/'+model+'/'+id+'/'+status,
			success : function(response){
				if(response == '0'){
					var new_status = '<button title="Click to Disable" rel ="'+id+'" class="label label-success comment_status">Enabled</button>';
				}
				else if(response == '1'){
					var new_status = '<button title="Click to Enable" rel ="'+id+'" class="label label-warning comment_status">Disabled</button>';
				}
				$('.os'+id).html(new_status);
			}
		});
	}
});


// change the status of blog posts
$(document).on('click','.blog_status',function(){
	var id = $(this).attr('rel');
	var model = 'Blog';
	var status ='';
	$(this).attr('disabled',true);
	$(this).text('Loading...');
	if($(this).hasClass('label-success')){
		var status = '0';
	}
	else if($(this).hasClass('label-warning')){
		var status = '1';
	}
	if(id){
		$.ajax({
			url : '/admins/status/'+model+'/'+id+'/'+status,
			success : function(response){
				if(response == '0'){
					var new_status = '<button title="Click to Disable" rel ="'+id+'" class="label label-success blog_status">Enabled</button>';
				}
				else if(response == '1'){
					var new_status = '<button title="Click to Enable" rel ="'+id+'" class="label label-warning blog_status">Disabled</button>';
				}
				$('.bs'+id).html(new_status);
			}
		});
	}
});

/* generic function for changing status */
$(document).on('click','.change_status',function(){
	var model = $(this).attr('getModel');
	var id = $(this).attr('rel');
	var status ='';
	$(this).attr('disabled',true);
	$(this).text('Loading...');
	if($(this).hasClass('label-success')){
		var status = '0';
	}
	else if($(this).hasClass('label-warning')){
		var status = '1';
	}
	if(id){
		$.ajax({
			url : '/admins/status/'+model+'/'+id+'/'+status,
			success : function(response){
				if(response == '0'){
					var new_status = '<button title="Click to Disable" getModel="'+model+'" rel ="'+id+'" class="label label-success change_status">Enabled</button>';
				}
				else if(response == '1'){
					var new_status = '<button title="Click to Enable" getModel="'+model+'" rel ="'+id+'" class="label label-warning change_status">Disabled</button>';
				}
				$('.status'+id).html(new_status);
			}
		});
	}
});

/* generic function for deleting a record  */
$(document).on('click','.delete_record',function(){
	if(confirm('Do you really want to delete this record.'))
	{
		var model = $(this).attr('getModel');
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