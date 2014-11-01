$(document).ready(function() {
	$("input[name='btnlogs']").click(getPreviousTransactions);
	$("input[name='btntransfer']").click(transferAmount);
});

function getPreviousTransactions() {

	var userid = $("input[name='userid']").val();
	
	$(".msguserid").html("&nbsp;");
	$(".msgupdate").html("&nbsp;");
	
	if(userid.length==0 || isNaN(userid)){
		$(".msguserid").html("Invalid!");
		return;
	}
	
	$.ajax({
		url : 'ewalletlogs.php',
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

function transferAmount() {

	var userid = $("input[name='userid']").val();
	var amount = $("input[name='amount']").val();
	
	$(".msguserid").html("&nbsp;");
	$(".msgupdate").html("&nbsp;");
	
	if(userid.length==0 || isNaN(userid)){
		$(".msguserid").html("Invalid!");
		return;
	}

	if(amount.length==0 || isNaN(amount) || parseInt(amount)<500){
		$(".msgamount").html("Invalid!");
		return;
	}
	
	var frm = $(".frm").serialize();
	
	$.ajax({
		url : 'modal/addtoewallet.php',
		data : frm,
		type : 'GET',
		success : function(result) {

			if(result.indexOf("notlogged")>-1)
				window.location.replace("adminlogin.php");
			else if(result.indexOf("done")>-1){
				$(".msgupdate").html("Amount transferred...");
				$("input[name='userid']").val("");
				$("input[name='amount']").val("");
			}
			else if(result.indexOf("error")>-1)
				$(".msgupdate").html("Server error...");
		}
	});
}
