	<!-- Add user -->
	$(document).on('click','#btn-add',function(e) {
		var data = $("#user_form").serialize();
		$.ajax({
			data: data,
			type: "post",
			url: "backend/save.php",
			success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						$('#addModal').modal('hide');
						alert('เพิ่มข้อมูลเรียบร้อย !'); 
                        location.reload();						
					}
					else if(dataResult.statusCode==201){
					   alert(dataResult);
					}
			}
		});
	});

	$(document).on('click','.update',function(e) {
		var id_u=$(this).attr("data-id");
		var vname_u=$(this).attr("data-name");
		var lastname_u=$(this).attr("data-last");
		var email=$(this).attr("data-email");
		var hospcode=$(this).attr("data-hospcode");
		var tcode=$(this).attr("data-tcode");
		$('#id_u').val(id_u);
		$('#vname_u').val(vname_u);
		$('#lastname_u').val(lastname_u);
		$('#hname_u').val(hname);
		$('#amper_u').val(amper);
		$('#tcode_u').val(tcode);
	});

	<!-- Update -->
	$(document).on('click','#update',function(e) {
		var data = $("#update_form").serialize();
		$.ajax({
			data: data,
			type: "post",
			url: "backend/save.php",
			success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						$('#editModal').modal('hide');
						alert('ปรับปรุงข้อมูลเรียบร้อย !'); 
                        location.reload();						
					}
					else if(dataResult.statusCode==201){
					   alert(dataResult);
					}
			}
		});
	});
	$(document).on("click", ".delete", function() { 
		var id_u=$(this).attr("data-id");
		$('#id_u').val(id_u);
		
	});
	$(document).on("click", "#delete", function() { 
		$.ajax({
			url: "backend/save.php",
			type: "POST",
			cache: false,
			data:{
				type:3,
				id: $("#id_u").val()
			},
			success: function(dataResult){
					$('#deleteModal').modal('hide');
					$("#"+dataResult).remove();
			
			}
		});
	});
	$(document).on("click", "#delete_multiple", function() {
		var user = [];
		$(".user_checkbox:checked").each(function() {
			user.push($(this).data('user-id'));
		});
		if(user.length <=0) {
			alert("Please select records."); 
		} 
		else { 
			WRN_PROFILE_DELETE = "ต้องการลบข้อมูล "+(user.length>1?"รายการ":"เหล่านี้")+" ?";
			var checked = confirm(WRN_PROFILE_DELETE);
			if(checked == true) {
				var selected_values = user.join(",");
				console.log(selected_values);
				$.ajax({
					type: "POST",
					url: "backend/save.php",
					cache:false,
					data:{
						type: 4,						
						id : selected_values
					},
					success: function(response) {
						var ids = response.split(",");
						for (var i=0; i < ids.length; i++ ) {	
							$("#"+ids[i]).remove(); 
						}	
					} 
				}); 
			}  
		} 
	});
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		var checkbox = $('table tbody input[type="checkbox"]');
		$("#selectAll").click(function(){
			if(this.checked){
				checkbox.each(function(){
					this.checked = true;                        
				});
			} else{
				checkbox.each(function(){
					this.checked = false;                        
				});
			} 
		});
		checkbox.click(function(){
			if(!this.checked){
				$("#selectAll").prop("checked", false);
			}
		});
	});
