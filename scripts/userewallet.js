$(function() {
	getPreviousTransactions();
	getPairIncomeLogs();
	
	$("input[name='btntransfer']").click(transferAmount);
	
	$("input[name='btnwithdrawl']").click(withdrawlRequest);
	
	$("input[name='btnaddtoewallet']").click(transferToEWallet);
});

function getPreviousTransactions() {

	var userid = $("input[name='hidden_userid']").val();
	
	$(".msguserid").html("&nbsp;");
	
	if(userid.length==0 || isNaN(userid)){
		$(".msguserid").html("Invalid!");
		return;
	}
	
	$.ajax({
		url : 'userewalletlogs.php',
		type : 'GET',
		data: 'userid=' + userid,
		success : function(result) {

			if(result.indexOf("notlogged")>-1)
				window.location.replace("adminlogin.php");
			else
				$(".logs").html(result);
		}
	});
	
}

function getPairIncomeLogs() {

	var userid = $("input[name='hidden_userid']").val();
	
	$(".msguserid").html("&nbsp;");
	
	if(userid.length==0 || isNaN(userid)){
		$(".msguserid").html("Invalid!");
		return;
	}
	
	$.ajax({
		url : 'userpairincomelogs.php',
		type : 'GET',
		data: 'userid=' + userid,
		success : function(result) {

			if(result.indexOf("notlogged")>-1)
				window.location.replace("adminlogin.php");
			else
				$(".pairlogs").html(result);
		}
	});
	
}

function transferAmount() {

	var userid = $("input[name='userid']").val();
	var amount = $("input[name='amount']").val();
	
	var valid = true;
	
	$(".msguserid").html("&nbsp;");
	$(".msgamount").html("&nbsp;");
	
	if(userid.length==0 || isNaN(userid)){
		$(".msguserid").html("Invalid!");
		valid = false;
	}

	if(amount.length==0 || isNaN(amount) || parseInt(amount)<500){
		$(".msgamount").html("Atleast 500 can be transferred!");
		valid = false;
	}
	
	if(valid){
		var frm = $(".frm").serialize();
		
		$.ajax({
			url : 'modal/addtouserewallet.php',
			data : frm,
			type : 'GET',
			success : function(result) {
	
				if(result.indexOf("notlogged")>-1)
					window.location.replace("index.php");
				else if(result.indexOf("done")>-1){
					$(".msgupdate").html("Amount transferred...");
					$("input[name='userid']").val("");
					$("input[name='amount']").val("");
					
					getPreviousTransactions();
				}
				else if(result.indexOf("invalid")>-1)
					$(".msgupdate").html("Id does not exist...");
				else if(result.indexOf("pending")>-1)
					$(".msgupdate").html("Id is not activated...");
				else if(result.indexOf("insufficient")>-1)
					$(".msgupdate").html("Insufficient balance...");
				else if(result.indexOf("error")>-1)
					$(".msgupdate").html("Server error...");
			}
		});
	}
}

function withdrawlRequest() {

	var amount = $("input[name='withdrawlamount']").val();
	
	var valid = true;
	
	$(".msgwithdrawlamount").html("&nbsp;");

	if(amount.length==0 || isNaN(amount) || parseInt(amount)<500){
		$(".msgwithdrawlamount").html("Minimun 500...");
		valid = false;
	}
	
	if(valid){
		
		$.ajax({
			url : 'modal/addwithdrawlrequest.php',
			data : 'amount=' + amount,
			type : 'GET',
			success : function(result) {
	
				if(result.indexOf("notlogged")>-1)
					window.location.replace("index.php");
				else if(result.indexOf("done")>-1){
					$(".msgwithdrawlamount").html("Request submitted...");
					$("input[name='withdrawlamount']").val("");
					
					getPreviousTransactions();
				}
				else if(result.indexOf("invalid")>-1){
					$(".msgwithdrawlamount").html("Balance insufficient...");
				}
				else if(result.indexOf("error")>-1)
					$(".msgwithdrawlamount").html("Server error...");
			}
		});
	}
}

function transferToEWallet() {

	var amount = $("input[name='withdrawlamount']").val();
	
	var valid = true;
	
	$(".msgwithdrawlamount").html("&nbsp;");

	if(amount.length==0 || isNaN(amount) || parseInt(amount)<500){
		$(".msgwithdrawlamount").html("Minimun 500...");
		valid = false;
	}
	
	if(valid){
		
		$.ajax({
			url : 'modal/transfertoewallet.php',
			data : 'amount=' + amount,
			type : 'GET',
			success : function(result) {
	
				if(result.indexOf("notlogged")>-1)
					window.location.replace("index.php");
				else if(result.indexOf("done")>-1){
//					$(".msgwithdrawlamount").html("Amount transferred...");
//					$("input[name='withdrawlamount']").val("");
//					
//					getPreviousTransactions();
					window.location.replace("userewallet.php");
				}
				else if(result.indexOf("invalid")>-1){
					$(".msgwithdrawlamount").html("Balance insufficient...");
				}
				else if(result.indexOf("error")>-1)
					$(".msgwithdrawlamount").html("Server error...");
			}
		});
	}
}
