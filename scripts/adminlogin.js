$(document).ready(function(){

	$("input[name='btnlogin']").click(function(){
		checkLogin();
	});
});

function checkLogin(){

	$(".useridmessage").html("&nbsp;");

	if(isValidLoginForm()){
	
	  var frm=$(".frm").serialize();
	
	  $.ajax({
			url: 'modal/checkadminlogin.php',
			data: frm,
			type: 'POST',
			success: function(result){

		    	if(result.indexOf("correct")>-1){
		    		window.location.replace("adminsection.php");
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
		 $(".loginmsg").html("User ID?");
		 return false;
	 }
	 
	 if(password.length==0){
		 valid = false;
		 $(".loginmsg").html("Password?");
		 return false;
	 }
	 
	 return valid;
}