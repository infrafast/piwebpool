// Attention : il faudrait exploiter result.state et result.answer et non pas result.error

$('.header').click(function(){
    $(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
    $(this).nextUntil('tr.header').slideToggle(); 
    var id=$(this).attr('id');
    var urlCall="./action.php?action=updateSetting&id="+id+"Collapse"+"&value="+($(this).find('span').text()=='-'?'0':'1');
    //alert('urlCall : '+urlCall);
    $.ajax({
        type: "POST",
    	url: urlCall,
    	async:false,
        success: function(r){
    }});
});

function getSetting(id,elem){
    var urlCall="./action.php?action=getSetting&id="+id;
    //alert('ajaxCall : '+urlCall);
    $.ajax({
        type: "POST",
        url: urlCall,
        success: function(r){
            var result = eval(r);
            if (result.state == "1") $(elem).click();
            if (result.state == "undef") alert('Setting undefined : '+id);
    }});   
}

function changeState(pin,elem){
	var newState = ($(elem).hasClass('on')?0:1); 
	//alert('changeState : pin'+pin+" value"+newState);
	$.ajax({
			type: "POST",
			url: "./action.php?action=changeState",
			data:{pin:pin,state:newState},
			success: function(r){
				var result = eval(r);
				if(result.state == 1){          
					$(elem).removeClass('on');
					$(elem).removeClass('off');
					$(elem).addClass((newState==1?'on':'off')); 
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
	alert('Sequence demarée');
}

function forceCron(){
	$.ajax({
		    type: "POST",
			url: "./action.php?action=forceCron",
		    success: function(r){
	}});
	alert('refresh done');
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
    
function refreshPh(elem){
	$.ajax({
			type: "POST",
			url: "./action.php?action=getPh",
			success: function(r){
				var result = eval(r);
				if(result.answer == "OK"){          
				    $(elem).text(result.state);
                    //alert("refresh Ph");
				}else{
					alert('Erreur : '+result.answer);
				}
	}});
}

function refreshTemp(elem){
    alert("refresh Temp");
}

function refreshORP(elem){
    alert("refresh ORP");
}