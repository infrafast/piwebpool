function changeState(pin,elem){
	var newState = ($(elem).hasClass('on')?1:0); 
	$.ajax({
			type: "POST",
			url: "./action.php?action=changeState",
			data:{pin:pin,state:newState},
			success: function(r){
				var result = eval(r);
				if(result.state == 1){          
					$(elem).removeClass('on');
					$(elem).removeClass('off');
					$(elem).addClass((newState==1?'off':'on')); 
				}else{
					alert('Erreur : '+result.error);
				}
	}});
}

function scenario(){
	$.ajax({
		    type: "POST",
			url: "./action.php?action=scenario",
		    success: function(r){
	}});
}

function resetSchedule(){
    var r = confirm("Are you sure to reset your schedule with defaut value?");
    if (true == r) {
    	$.ajax({
    			type: "POST",
    			url: "./action.php?action=resetSchedule",
    			success: function(r){
        }});
    
    }
}