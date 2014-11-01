var main_user;

$(document).ready(function(){
	var userid = $("input[name='userid']").val();
	main_user = userid;
	showTree(userid);
});

function showTree(userid){
	$.ajax({
		url: 'getdowntree.php',
		data: 'userid=' + userid,
		type: 'GET',
		success: function(result){
			
			if(result.indexOf("notlogged")>-1)
				window.location.replace("index.php");
			else{
				$('.downtree').html(result);
			
				setPopups();
			}
		}
	});
}

function setPendingActivation(id){
	
	if(confirm("Want to activate this account?")){
		
		$.ajax({
			url: 'modal/activateaccount.php',
			type: 'GET',
			data: 'userid=' + id,
			success: function(result){
				
				showTree(main_user);
			}
		});
	}
}

function setPopups(){
	var moveLeft = 50;
	var moveDown = 30;
	  
	$('.popper').hover(function(e) {
		
		var id = $(this).attr("data-popbox");
		
		var parentOffset = $(this).parent().offset(); 
		
	    $("#" + id).show()
	      .css('top', e.pageY + moveDown)
	      .css('left', e.pageX - parentOffset.left + moveLeft);
	  }, function() {
		  $(".popbox").hide();
	  });
	
	$('.active').click(function(e) {
		var id = $(this).attr("rel");
		
		showTree(id);
	});
/*	
    $(".pending").click(function(){
    	var id = $(this).attr("rel");
        setPendingActivation(id);
    });
*/	
	$('.parent').click(function(e) {
		var id = $(this).attr("rel");
		
		showTree(id);
	});	
}