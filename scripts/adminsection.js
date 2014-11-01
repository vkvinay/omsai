$(document).ready(function() {
	getNewRequests();
	getNewWithdrawlRequests();
	
	$("input[name='btnupdate']").click(updateStatus);
});

function getNewRequests() {

	$.ajax({
		url : 'newrequests.php',
		type : 'GET',
		success : function(result) {

			$(".accountdetails").html(result);

			$(".activate").click(function() {
				var userid = $(this).attr("rel");

				activateAccount(userid);
			});
		}
	});
}

function getNewWithdrawlRequests() {

	$.ajax({
		url : 'newwithdrawlrequests.php',
		type : 'GET',
		success : function(result) {

			$(".withdrawlrequests").html(result);

			$(".approve").click(function() {
				var request_id = $(this).attr("rel");

				updateWithdrawlRequest(request_id, 'approved');
			});

			$(".deny").click(function() {
				var request_id = $(this).attr("rel");

				updateWithdrawlRequest(request_id, 'deny');
			});
		}
	});
}

function activateAccount(userid) {

	if (confirm("Sure to activate this account?")) {
		$.ajax({
			url : 'modal/activateaccount.php',
			data : 'userid=' + userid,
			type : 'GET',
			success : function(result) {
				getNewRequests();
			}
		});
	}
}

function updateWithdrawlRequest(request_id, status) {

	if (confirm("Sure to " + status + " this request?")) {
		$.ajax({
			url : 'modal/updatewithdrawlrequest.php',
			data : 'request_id=' + request_id + '&status=' + status,
			type : 'GET',
			success : function(result) {
				getNewWithdrawlRequests();
			}
		});
	}
}

function updateStatus() {

	var userid = $("input[name='userid']").val();
	var action = $("input[name='action']:checked").val();
	
	$(".msguserid").html("&nbsp;");
	
	if(userid.length==0 || isNaN(userid)){
		$(".msguserid").html("Invalid!");
		return;
	}
	
	var msg = "";
	var actiontype = "";
	if(action=="active"){
		msg = "Sure to activate this account?";
		actiontype = "activated";
	}
	else{
		msg = "Sure to de-activate this account?";
		actiontype = "deactivated";
	}
	
	if (confirm(msg)) {
		
		var frm = $(".frm").serialize();
		
		$.ajax({
			url : 'modal/activatedeactivateaccount.php',
			data : frm,
			type : 'GET',
			success : function(result) {
				alert(result);

				if(result.indexOf("done")>-1)
					$(".msgupdate").html("Account " + actiontype);
				else if(result.indexOf("already")>-1)
					$(".msgupdate").html("Account already " + actiontype);
				else if(result.indexOf("error")>-1)
					$(".msgupdate").html("Server error...");
				
				getNewRequests();
			}
		});
	}
}
