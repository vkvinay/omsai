$(document).ready(function(){

	$("input[name='btnsubmit']").click(function(){
		registerUser();
	});
});

function registerUser(){

	$(".emailmessage").html("&nbsp;");

	if(isValidRegisterForm()){
	
	  var frm=$(".frm").serialize();
	
	  $.ajax({
			url: 'modal/resetpassword.php',
			data: frm,
			type: 'POST',
			success: function(result){
				
		    	if(result.indexOf("done")>-1){
		    		$(".emailmessage").html("Email sent...");
		    	}
		    	else if(result.indexOf("invalid")>-1){
		    		$(".emailmessage").html("Email does not exist...");
		    	}
		    	else if(result.indexOf("error")>-1){
		    		$(".emailmessage").html("Please try later...");
		    	}
		    }
		    
		});
	}
}

function isValidRegisterForm(){
	
	var valid = true;
	
	 var email = $("input[name='email']").val();
	 
	 $(".message").html("&nbsp;");
	 
	 if(email.length==0){
		 valid = false;
		 $("input[name='email']").parent().next().html("?");
	 }
	 else{
		 if(checkemail(email)==false){
			 valid = false;
			 $("input[name='email']").parent().next().html("Invalid!");
		 }
	 }
	 
	 return valid;
}