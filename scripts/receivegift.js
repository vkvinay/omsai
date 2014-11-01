$(document).ready(function(){

	$("input[name='btnsubmit']").click(function(){
		checkPassword();
	});
});

function checkPassword(){

	$(".passwordmsg").html("&nbsp;");
	$(".message").html("&nbsp;");

	if(isValidForm()){
	
	  var password = $("input[name='password']").val();
	
	  $.ajax({
			url: 'modal/checktransactionpassword.php',
			data: 'password=' + password,
			type: 'POST',
			success: function(result){
	
		    	if(result.indexOf("valid")>-1){
		    		window.location.replace("receivegiftform.php");
		    	}
		    	else if(result.indexOf("wrong")>-1){
		    		$(".passwordmsg").html("Invalid password...");
		    	}
		    	else if(result.indexOf("error")>-1){
		    		$(".passwordmsg").html("Server error...");
		    	}
		    }		    
		});
	}
}

function isValidForm(){
	
	var valid = true;
	
	 var password = $("input[name='password']").val();

	 $(".message").html("&nbsp;");
	 
	 if(password.length==0){
		 valid = false;
		 $("input[name='password']").parent().next().html("?");
	 }
	 
	 return valid;
}