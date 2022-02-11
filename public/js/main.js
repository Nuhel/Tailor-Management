$(function() {
	// For User Registration

	$("#register").click(function(){
		var name = $("#name").val();
		var username = $("#username").val();
		var email = $("#email").val();
		var password = $("#password").val();
		var dataString = 'name='+name+'&username='+username+'&email='+email+'&password='+password;
		$.ajax({
			type: "POST",
			url: "getregister.php",
			data: dataString,
			success: function(data){
				$("#state").html(data);
			}
		})
		return false;
	}) 

	// For User Login

	$("#login").click(function(){
		var email = $("#email").val();
		var password = $("#password").val();
		var dataString = 'email='+email+'&password='+password;
		$.ajax({
			type: "POST",
			url: "getlogin.php",
			data: dataString,
			success: function(data){
				if ($.trim(data) == "empty") {
					$(".empty").show();
					setTimeout(function(){
						$(".empty").fadeOut();
					}, 2000);
				}else if($.trim(data) == "disable"){
					$(".disable").show();
					setTimeout(function(){
						$(".disable").fadeOut();
					}, 2000);
				}else if($.trim(data) == "error"){
					$(".error").show();
					setTimeout(function(){
						$(".error").fadeOut();
					}, 2000);
				}else{
					window.location = "exam.php";
				}
			}
		})
		return false;
	})


	// For Employee clock in

	/*$("#employee").click(function(){
		var employId = $("#employId").val();
		var empName = $("#empName").val();
		var email = $("#email").val();
		var password = $("#password").val();
		var p_email = $("#p_email").val();
		var image = $("#image").val();
		var position_id = $("#position_id").val();
		var shift_id = $("#shift_id").val();
		var salary = $("#salary").val();
		var mobile = $("#mobile").val();
		var address = $("#address").val();
		var date = $("#date").val();

		var dataString = 'employId='+employId+'&empName='+empName+'&email='+email+'&password='+password+'&p_email='+p_email+'&image='+image+'&position_id='+position_id+'&shift_id='+shift_id+'&salary='+salary+'&mobile='+mobile+'&image='+image+'&address='+address+'&date='+date;


		$.ajax({
			type: "POST",
			url: "getemployee.php",
			data: dataString,
			success: function(data){
				$("#state").html(data);
			}
		})
		return false;
	})*/


	// Insert for testing

	$("#test").click(function(){
		var a = $("#a").val();
		var b = $("#b").val();

		var dataString = 'a='+a+'&b='+b;
		$.ajax({
			type: "POST",
			url: "gettest.php",
			data: dataString,
			success:function(data){
				$("#state").html(data);
			}
		})
		return false;
	})


	$("#clock").click(function(){
		var a = $("#a").val();
		var b = $("#b").val();
		var dataString = 'a='+a+'&b='+b;
		$.ajax({
			type: "POST",
			url: "getprofile.php",
			data: {
				a:a,
				b:b
			},
			success: function(data){
				$("#a").val("");
				$("#b").val("");
				if ($.trim(data) == "empty") {
					$(".empty").show();
					setTimeout(function(){
						$(".empty").fadeOut();
					}, 3000);
				}else if($.trim(data) == "yes"){
					$(".yes").show();
					setTimeout(function(){
						$(".yes").fadeOut();
					}, 4000);
				}else if($.trim(data) == "no"){
					$(".no").show();
					setTimeout(function(){
						$(".no").fadeOut();
					}, 4000);
				}else{
					window.location = "index.php";
				}
				

			}
		})
		return false;
	}) 

	/*$("#test").click(function(){
		var a = $("#a").val();
		var b = $("#b").val();
		var dataString = 'a='+a+'&b='+b;
		$.ajax({
			method: "POST",
			url: "gettest.php",
			data: {
				a:a,
				b:b
			},
			success: function(data){
				$("#a").val("");
				$("#b").val("");
				if ($.trim(data) == "empty") {
					$(".empty").show();
					setTimeout(function(){
						$(".empty").fadeOut();
					}, 3000);
				}else if($.trim(data) == "yes"){
					$(".yes").show();
					setTimeout(function(){
						$(".yes").fadeOut();
					}, 4000);
				}else if($.trim(data) == "no"){
					$(".no").show();
					setTimeout(function(){
						$(".no").fadeOut();
					}, 4000);
				}else{
					window.location = "index.php";
				}
				
			
			}
		})
		return false;
	}) */


	$("#test").click(function(){
		var a = $("#a").val();
		var b = $("#b").val();
		var dataString = 'a='+a+'&b='+b;
		$.ajax({
			method: "POST",
			url: "gettest.php",
			data: {
				a:a,
				b:b
			},
			success: function(data){
				$("#a").val("");
				$("#b").val("");
				$("#yes").html(data);
			}
		})
		return false;
	}) 


		// Auto div refresh 

		/*setInterval(function(){
			$("#test").load("getrefresh.php").fadeIn("slow");
		}, 1000);*/



		$("#doneBtn").click(function(){
			var datagetid = $(this).data("dataid");
			console.log(datagetid);
			$.ajax({
				method: "GET",
				url: "getTicket.php",
				data: {getid:datagetid},
				success: function(data){

					var myArray = JSON.parse(data);
					console.log(myArray.status);
					if(myArray.status == 200){
						$(".update").show();
						setTimeout(function(){
							$(".update").fadeOut();
						}, 2000);
						$("#doneb").html(myArray.message);
					//$('#doneBtn').prop('disabled', true);
					$("#doneBtn").attr("disabled", true);	
					$(".doneBy").load("getrefresh.php?getid="+datagetid);	
				}

				else if(myArray.status == 401){
					$(".deny").show();
					setTimeout(function(){
						$(".deny").fadeOut();
					}, 2000);
				}else{
					console.log(data);
					//window.location = "index.php";
				}
				
			}
		})
			return false;
		})

		/*$("#doneb").click(function(event){
			var datagetid = $(this).data("dataid");
			console.log(datagetid);
		});*/

		/*setInterval(function(){
			$(".doneBy").load("getrefresh.php?getid=<?= $datagetid ?>").fadeIn("slow");
		}, 1000);*/

	})