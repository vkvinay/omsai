$(document).ready(function(){

	$("input[name='btnsubmit']").click(function(){
		updateProfile();
	});
});

function updateProfile(){

	$(".passwordmsg").html("&nbsp;");
	$(".message").html("&nbsp;");

	if(isValidUpdateForm()){
	
	  var frm = $(".frm").serialize();
	
	  $.ajax({
			url: 'modal/updateadminpassword.php',
			data: frm,
			type: 'POST',
			success: function(result){
				
		    	if(result.indexOf("done")>-1){
		    		$(".passwordmsg").html("Password updated...");
		    		
		    		 $("input[name='oldpassword']").val("");
		    		 $("input[name='password']").val("");
		    		 $("input[name='cpassword']").val("");
		    	}
		    	else if(result.indexOf("invalidold")>-1){
		    		$(".passwordmsg").html("Invalid old password...");
		    	}
		    	else if(result.indexOf("error")>-1){
		    		$(".passwordmsg").html("Server error...");
		    	}
		    }		    
		});
	}
}

function isValidUpdateForm(){
	
	var valid = true;
	
	 var oldpassword = $("input[name='oldpassword']").val();
	 var password = $("input[name='password']").val();
	 var cpassword = $("input[name='cpassword']").val();

	 $(".message").html("&nbsp;");
	 
	 if(oldpassword.length==0){
		 valid = false;
		 $("input[name='oldpassword']").parent().next().html("?");
	 }
	 
	 if(password.length==0){
		 valid = false;
		 $("input[name='password']").parent().next().html("?");
	 }
	 else{
		 if(password!=cpassword){
			 valid = false;
			 $("input[name='password']").parent().next().html("Mismatch!");
		 }
	 }
	 
	 return valid;
}