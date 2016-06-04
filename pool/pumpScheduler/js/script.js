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

function demo(){
	$.ajax({
			type: "POST",
			 url: "./action.php?action=demo",
			success: function(r){
		 }});
}

function resetSchedule(){
	$.ajax({
			type: "POST",
			 url: "./action.php?action=resetSchedule",
			success: function(r){
		 }});
}