// Attention : il faudrait exploiter result.state et result.answer et non pas result.error

$('.header').click(function(){
	$(this).addClass('loading');
    $(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
    $(this).nextUntil('tr.header').slideToggle(); 
    var id=$(this).attr('id');
    var urlCall="./action.php?action=updateSetting&id="+id+"&value="+($(this).find('span').text()=='-'?'0':'1');
    //alert('urlCall : '+urlCall);
    $.ajax({
        type: "POST",
    	url: urlCall,
    	async:false,
        success: function(r){
    }});
    $(this).removeClass('loading');
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
	$(elem).removeClass('off');
	$(elem).addClass('loading');
	$.ajax({
			type: "POST",
			url: "./action.php?action=changeState",
			data:{pin:pin,state:newState},
			success: function(r){
				var result = eval(r);
				$(elem).removeClass('loading');
				$(elem).addClass('off');				
				if(result.state == 1){          
					$(elem).removeClass('on');
					$(elem).removeClass('off');
					$(elem).addClass((newState==1?'on':'off')); 
					$(elem).html('<br>'+(newState==1?'on':'off')+'<br><br>');
					//$(elem).getElementById("commandButtonID").innerHTML = "<br>whatever<br>";
				}else{
					alert('Erreur : '+result.answer);
				}
	}});
}

function updateScript(xml,lua,script){
	//alert(xml+" "+lua);
	var result;
	$.ajax({
			type: "POST",
			url: "./action.php?action=updateScript",
			data:{id:script,xml:xml,lua:lua},
			async:false,
			success: function(r){
				result = eval(r);
				if(result.answer != "OK"){          
					alert('Erreur : '+result.state);
				}
	}});
	return result.answer+" "+(result.state==true?"":result.state);
}


// the getXML has to be sync (async=flase) otehrwise we can't fetch the info frpm the database and return "undefined" variable value
function getScript(code,script){
    var result;
	$.ajax({
		type: "POST",
		url: "./action.php?action=getScript",
		data:{id:script,code:code},
		async:false,
		success: function(r){
			result = eval(r);
			if(result.answer != "OK"){          
				alert('Erreur : '+result.state);
			}
	    }
	});    
	return result.state;
}


// the getXML has to be sync (async=flase) otehrwise we can't fetch the info frpm the database and return "undefined" variable value
function getLog(){
    var result;
	$.ajax({
		type: "POST",
		url: "./action.php?action=getLog",
		async:false,
		success: function(r){
			result = eval(r);
			if(result.answer != "OK"){          
				alert('Erreur : '+result.state);
			}
	    }
	});   
	//alert('calledGetLog');
	return result.state;
}

function scenario(){
	$.ajax({
		    type: "POST",
			url: "./action.php?action=scenario",
		    success: function(r){}
	});
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

function rgbToHex(r, g, b) {
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}

function getColor(median,tolerance,value){
    var diff = Math.abs(value - median);
    var ecart = diff/median;
    var prop = ecart/tolerance;
    var green = ((1-prop)*255);
    var red = (prop*255);
    return rgbToHex(green,red,0);
}

    
function refreshValue(elem,action){
	var urlCall = "./action.php?action=get"+action;
	$(elem).removeAttr("style");
	$(elem).removeClass('off');
	$(elem).addClass('loading');
	//alert("refresh "+urlCall);
	$.ajax({
			type: "POST",
			url: urlCall,
			async:false,
			success: function(r){
				var result = eval(r);
                var newValue = result.state;
				
				$(elem).removeClass('loading');
				$(elem).addClass('off');
				if(result.answer == "OK"){
                    var median;
                    var tolerance;
                    if(action=='Ph'){
                        median=7.24;
                        tolerance=0.04;
                    }else if (action=='ORP'){
                        median=715;
                        tolerance=0.1;                        
                    }else{
                        median=15;
                        tolerance=0.1;                        
                    }
                    alert(getColor(median,tolerance,newValue));
                    
                    newValue = "<br>"+result.state+"<br><br>";
                    $(elem).html(newValue);    
                    $(elem).attr("style", "background:#FF69B4;");

                    
				}else{
					alert('Erreur : '+result.answer);
				}
	}});
}