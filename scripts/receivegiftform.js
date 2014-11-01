$(document).ready(function() {

	loadSenders();
});

function approveUser(transactionid,userid) {
	
	if(confirm("Are you sure?")){
		$.ajax({
			url : 'modal/approvepayment.php',
			data : 'transactionid=' + transactionid + '&userid=' + userid,
			type : 'GET',
			success : function(result) {
				loadSenders();
			}
		});
	}
}

function loadSenders() {

	$.ajax({
		url : 'senders.php',
		type : 'GET',
		success : function(result) {
			$(".senders").html(result);
			
			$(".approve").click(function() {
				var transactionid = $(this).attr("transactionid");
				var userid = $(this).attr("userid");
				approveUser(transactionid,userid);
			});

		}
	});
}
