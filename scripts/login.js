$(document).ready(function(){

	$(".btnlogin").click(function(){
		checkLogin();
	});
});

function checkLogin(){

	$(".useridmessage").html("&nbsp;");

	if(isValidLoginForm()){
	
	  var frm=$(".frmlogin").serialize();
	
	  $.ajax({
			url: 'modal/checklogin.php',
			data: frm,
			type: 'POST',
			success: function(result){

		    	if(result.indexOf("correct")>-1){
		    		window.location.replace("usersection.php");
		    	}
		    	else if(result.indexOf("disabled")>-1){
		    		$(".loginmsg").html("Disabled...");
		    	}
		    	else if(result.indexOf("pending")>-1){
		    		$(".loginmsg").html("Not active...");
		    	}
		    	else{
		    		$(".loginmsg").html("Invalid...");
		    	}
		    }
		    
		});
	}
}

function isValidLoginForm(){
	
	var valid = true;
	
	 var userid = $("input[name='loginuserid']").val();
	 var password = $("input[name='loginpassword']").val();
	 
	 $(".message").html("&nbsp;");
	 
	 if(userid.length==0){
		 valid = false;
		 $(".loginmsg").html("userid?");
	 }
	 
	 if(password.length==0){
		 valid = false;
		 $(".loginmsg").html("Password?");
	 }
	 
	 return valid;
}