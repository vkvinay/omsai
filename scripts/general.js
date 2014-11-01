function checkall(objForm){
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++) {
		if (objForm.elements[i].type=='checkbox') {
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}

function confirm_submit(objForm) {
	return true;
}
function validcheck(name){
var chObj = document.getElementsByName(name);
var result	=	false;
for(var i=0;i<chObj.length;i++){

	if(chObj[i].checked){
	  result=true;
	  break;
	}
}
  if(!result){
    return false;
  }else{
	 return true;
  }
}

function paidConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to paid the users?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function printConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to print the record?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function updateConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to update the record?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}
function deleteConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to delete the record?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function activateConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to activate the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}

function deactivateConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to deactivate the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}
function featuredConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to Featured the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}
function UnfeaturedConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to Unfeatured the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}
function bannedConfirmFromUser(name)
{		
	
	
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to banned the user?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}

function acceptConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to accept the friendship?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}


function alocateConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to alocate these code to this user ?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function sendsmsConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to send sms to these users ?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}
 