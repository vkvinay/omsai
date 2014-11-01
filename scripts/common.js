function logout(){
	window.location.replace("logout.php");
}

function startLoading(){
	$(".loader").css("display","block");
}

function stopLoading(){
	$(".loader").css("display","none");
}

function disableKeyPress(obj){

	$(obj).bind('keypress', 
		function(e) {
			e.preventDefault();
		}
	);	
}


	function isURLValid(txt){
		var urlRegxp = /^(http:\/\/www.|http:\/\/|https:\/\/www.|www.){1}([\w]+)(.[\w]+){1,2}$/;

		return urlRegxp.test(txt);
	}

	function isInteger(s)
	{   
		var i;
    	for (i = 0; i < s.length; i++)
    	{   
        	// Check that current character is number.
        	var c = s.charAt(i);
        	if (((c < "0") || (c > "9"))) return false;
    	}
    	return true;
	}
	
	function isPhoneValid(phone){
		if(phone.indexOf("+")>1) 
			return false;

		return (isInteger(phone) && (phone.length >= 10 && phone.length<=13));
	}	
	
	function checkcontactnumber(contactnumber){
			if(contactnumber.length==0 || contactnumber.length>13)
				return false;
			else if(!isPhoneValid(contactnumber))
				return false;
			else
				return true;
	}
	
	function checkemail(email){

		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(email.length>0){
	
			if (!filter.test(email)) 
				return false;
			else
				return true;
		}
		else
			return false;
	}	
	

	function showInNewWindow(url){
		window.open(url,"_blank");
	}	
