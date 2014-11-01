$(document).ready(function(){

	$("input[name='btnsubmit']").click(function(){
		checkStatus();
	});
});

function checkStatus(){

	$(".passwordmsg").html("&nbsp;");
	$(".message").html("&nbsp;");

	if(isValidForm()){
	
	  var frm = $(".frm").serialize();
	
	  $.ajax({
			url: 'checkpaymentstatus.php',
			data: frm,
			type: 'GET',
			success: function(result){
	
		    	if(result.indexOf("notlogged")>-1){
		    		window.location.replace("adminlogin.php");
		    	}
		    	else{
		    		$(".data").html(result);
		    	}
		    }		    
		});
	}
}

function isValidForm(){
	
	var valid = true;
	
	 var id = $("input[name='id']").val();

	 $(".message").html("&nbsp;");
	 
	 if(id.length==0 || isNaN(id)){
		 valid = false;
		 $("input[name='id']").parent().next().html("Id ?");
	 }
	 
	 return valid;
}