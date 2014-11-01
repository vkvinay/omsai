$(document).ready(function(){

	$("input[name='btnsubmit']").click(function(){
		updateProfile();
	});
});

function updateProfile(){

	$(".emailmessage").html("&nbsp;");

	if(isValidUpdateForm()){
	
	  var frm = $(".frm").serialize();
	
	  $.ajax({
			url: 'modal/updateprofile.php',
			data: frm,
			type: 'POST',
			success: function(result){
				
		    	if(result.indexOf("done")>-1){
		    		window.location.replace("profileupdated.php");
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

function isValidUpdateForm(){
	
	var valid = true;
	
	 var name = $("input[name='name']").val();
	 var contact_number = $("input[name='contact_number']").val();
	 var city = $("input[name='city']").val();
	 var address = $("textarea[name='address']").val();

	 var accountholdername = $("input[name='accountholdername']").val();
	 var bank = $("input[name='bank']").val();
	 var branch = $("input[name='branch']").val();
	 var accountnumber = $("input[name='accountnumber']").val();
	 var ifsccode = $("input[name='ifsccode']").val();
	 
	 $(".message").html("&nbsp;");
	 
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