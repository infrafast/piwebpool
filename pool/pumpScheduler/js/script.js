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

function actionCall(UrlData, async=true, messageBox=null, feedback=false, confirmation=false){
    var result;
    if (messageBox!==null)
        if (confirmation!==false){
            result = confirm(messageBox);
            if (true !== result) return false;
        }else alert(messageBox);
	$.ajax({
		    type: "POST",
			url: "./action.php?"+UrlData,
			async:async,
		success: function(r){
			result = eval(r);
			if (feedback===true) alert("Resultat: "+result.answer+(result.answer=="OK"?"":" "+result.state));
	    }
	});
	return result.state;
}



function changeState(pin,elem){
	var newState = ($(elem).hasClass('on')?0:1); 
	//alert('changeState : pin'+pin+" value"+newState);
	$(elem).removeClass('off');
	$(elem).addClass('loading');
	$.ajax({
			type: "POST",
			url: "./action.php",
			data:{action:"changeState", pin:pin,state:newState},
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
    var result;
	//alert("receive before ajax: "+lua+"\n"+xml);
	$.ajax({
			type: "POST",
			url: "./action.php",
			data:{action:"updateScript",id:script,xml:xml,lua:lua},
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
		url: "./action.php",
		data:{action:"getScript",id:script,code:code},
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

function getColorVal(middleVal,compareVal){
    //return "grey";
    
    diffVal = Math.abs(compareVal - middleVal);
    var ecartVal = diffVal/middleVal;
    var colorSensor;
    if (ecartVal>0.6){ 
        colorSensor = "Tomato";
    }else if (ecartVal>0.4){ 
        colorSensor = "Orange";
    }else if (ecartVal>0.2){ 
        colorSensor = "Yellow";
    }else if (ecartVal>0.1){ 
        colorSensor = "GreenYellow";
    }else{ 
        colorSensor = "LimeGreen";
    }
    return (colorSensor);
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
                if(action=='Ph') median=7.24;
                else if (action=='ORP') median=715; 
                else median=27;
                var color=getColorVal(median,newValue);
                //alert(color);
                $(elem).attr("style", "background:"+color+";");
                newValue = "<br>"+result.state+"<br><br>";
                $(elem).html(newValue);
    		}else{
                $(elem).attr("style", "background:"+red+";");
                newValue = "<br>"+result.state+"<br><br>";
                $(elem).html(newValue);
    			
    		}
    	}
	});
}