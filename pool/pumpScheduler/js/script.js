$('.header').click(function(){
   $(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
    $(this).nextUntil('tr.header').slideToggle(); 
    $.ajax({
	    type: "POST",
		url: "./action.php?action=updateSetting&id=actionTableCollapse&value"+value=='-'?'0':'1',
	    success: function(r){
    }});
});


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
    var r = confirm("This will reset your schedule with defaut value");
    if (true == r) {
    	$.ajax({
    			type: "POST",
    			url: "./action.php?action=resetSchedule",
    			async:false,
    			success: function(r){
    		 }});
        location.reload(true);
    }
}