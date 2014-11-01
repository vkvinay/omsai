$(document).ready(function(){

	$("input[name='btnsubmit']").click(function(){
		registerUser();
	});
});

function registerUser(){

	$(".emailmessage").html("&nbsp;");
	$(".idmessage").html("&nbsp;");
	$(".sidemessage").html("&nbsp;");
	
	if(isValidRegisterForm()){
	
	  var frm=$(".frm").serialize();
	
	  $.ajax({
			url: 'modal/registerusernow.php',
			data: frm,
			type: 'POST',
			success: function(result){

		    	if(result.indexOf("done")>-1){
		    		window.location.replace("registered.php");
		    	}
		    	else if(result.indexOf("notfound")>-1){
		    		$(".idmessage").html("Id not found...");
		    	}
		    	else if(result.indexOf("invalidid")>-1){
		    		$(".idmessage").html("Invalid id...");
		    	}
		    	else if(result.indexOf("pending")>-1){
		    		$(".idmessage").html("Id not activated...");
		    	}
		    	else if(result.indexOf("duplicateemail")>-1){
		    		$(".emailmessage").html("Already taken...");
		    	}
		    	else if(result.indexOf("duplicateside")>-1){
		    		$(".sidemessage").html("Side already filled...");
		    	}
		    }		    
		});
	}
}

function isValidRegisterForm(){
	
	var valid = true;
	
	 var email = $("input[name='email']").val();
	 var name = $("input[name='name']").val();
	 var contact_number = $("input[name='contact_number']").val();
	 var city = $("input[name='city']").val();
	 var address = $("textarea[name='address']").val();
	 var cpassword = $("input[name='cpassword']").val();
	 
	 var accountholdername = $("input[name='accountholdername']").val();
	 var bank = $("input[name='bank']").val();
	 var branch = $("input[name='branch']").val();
	 var accountnumber = $("input[name='accountnumber']").val();
	 var ifsccode = $("input[name='ifsccode']").val();
	 
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
	 
	 if(name.length==0){
		 valid = false;
		 $("input[name='name']").parent().next().html("?");
	 }
	 
	 if(contact_number.length==0){
		 valid = false;
		 $("input[name='contact_number']").parent().next().html("?");
	 }
	 else{
		 if(checkcontactnumber(contact_number)==false){
			 valid = false;
			 $("input[name='contact_number']").parent().next().html("Invalid");
		 }
	 }
	 
	 if(city.length==0){
		 valid = false;
		 $("input[name='city']").parent().next().html("?");
	 }
	 
	 if(address.length==0){
		 valid = false;
		 $("textarea[name='address']").parent().next().html("?");
	 }
	 
	 if(accountholdername.length==0){
		 valid = false;
		 $("input[name='accountholdername']").parent().next().html("?");
	 }
	 
	 if(bank.length==0){
		 valid = false;
		 $("input[name='bank']").parent().next().html("?");
	 }
	 
	 if(branch.length==0){
		 valid = false;
		 $("input[name='branch']").parent().next().html("?");
	 }
	 
	 if(accountnumber.length==0){
		 valid = false;
		 $("input[name='accountnumber']").parent().next().html("?");
	 }
	 
	 if(ifsccode.length==0){
		 valid = false;
		 $("input[name='ifsccode']").parent().next().html("?");
	 }
	 
	 return valid;
}