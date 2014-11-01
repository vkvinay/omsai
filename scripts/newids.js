$(document).ready(function(){

	$("input[name='btnsubmit']").click(function(){
		checkStatus();
	});
	
	$("input[name='startdate']").simpleDatepicker();
	$("input[name='enddate']").simpleDatepicker();
});

function checkStatus(){

	$(".statusmsg").html("&nbsp;");
	$(".message").html("&nbsp;");

	if(isValidForm()){
	
	  var frm = $(".frm").serialize();
	
	  $.ajax({
			url: 'loadidsinfo.php',
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
	
	 var startdate = $("input[name='startdate']").val();
	 var enddate = $("input[name='enddate']").val();

	 $(".message").html("&nbsp;");
	 
	 if(startdate.length==0){
		 valid = false;
		 $("input[name='startdate']").parent().next().html("Start date ?");
	 }
	 
	 if(enddate.length==0){
		 valid = false;
		 $("input[name='enddate']").parent().next().html("End date ?");
	 }
	 
	 return valid;
}