function actionCall(UrlData, async, messageBox, feedback, confirmation){
    var result;
    //$.LoadingOverlay("show");
    if (messageBox!==null)
        if (confirmation!==false){
            result = confirm(messageBox);
            if (true !== result) return false;
        }else alert(messageBox);
        // extended json is appended to the URL so the query is recognized as coming from internal application
        // which put the reply in ( )
	$.ajax({
		    type: "POST",
			url: "./action.php?extendedJson&"+UrlData,
			async:async,
		success: function(r){
			result = eval(r);
			// we should take more benefir by displaying the state and not the answer
			if (feedback===true) alert("Resultat: "+result.answer+(result.answer=="OK"?"":" "+result.state));
	    }
	});
	//$.LoadingOverlay("hide");
	return result.state;
}



function changeState(material,elem){
	var newState = ($(elem).hasClass('on')?0:1); 
	//alert('changeState : pin'+pin+" value"+newState);
	$(elem).removeClass('off');
	$(elem).addClass('loading');
	$.ajax({
			type: "POST",
			url: "./action.php?extendedJson&"+material+"="+newState,
			success: function(r){
				var result = eval(r);
				$(elem).removeClass('loading');
				$(elem).addClass('off');				
				if(result.answer == "OK"){          
					$(elem).removeClass('on');
					$(elem).removeClass('off');
					$(elem).addClass((newState==1?'on':'off')); 
					$(elem).html('<br>'+(newState==1?'on':'off')+'<br><br>');
					//$(elem).getElementById("commandButtonID").innerHTML = "<br>whatever<br>";
				}else{
					alert('Erreur : '+result.state);
				}
	}});
}

function updateScript(xml,lua,script){
    var result;
	$.ajax({
			type: "POST",
			url: "./action.php",
			data:{action:"updateScript",id:script,xml:xml,lua:lua,extendedJson:true},
			async:false,
			success: function(r){
				result = eval(r);
				if(result.answer != "OK"){          
					alert('Erreur : '+result.state);
				}
	}});
	return result.answer+" "+(result.state===true?"":result.state);
}


// the getXML has to be sync (async=flase) otehrwise we can't fetch the info frpm the database and return "undefined" variable value
function getScript(code,script){
    var result;
	$.ajax({
		type: "POST",
		url: "./action.php",
		data:{action:"getScript",id:script,code:code,extendedJson:true},
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

    
function refreshValue(elem,action,elemConsign){
	var urlCall = "./action.php?extendedJson&action=get"+action;
	$(elem).removeAttr("style");
	$(elem).removeClass('off');
	$(elem).addClass('loading');
	//alert("refresh "+urlCall);
	$.ajax({
    	type: "POST",
    	url: urlCall,
    	async:true,
    	success: function(r){
    		var result = eval(r);
            var newValue = result.state;
    		$(elem).removeClass('loading');
    		$(elem).addClass('off');
    		if(result.answer != "ERROR"){
                // retrieve the data-consign from the div.
                var median = $(elemConsign).html();
                var icon;
                // display icon into the div text
                if(action=='Ph') icon="<i class='wi wi-raindrops'></i>";
                else if (action=='ORP') icon="<i class='wi wi-earthquake'></i>";
                else icon="<i class='wi wi-thermometer'></i>";
                var color=getColorVal(median,newValue);
                //alert(color);
                $(elem).attr("style", "background:"+color+";");
                newValue = ""+result.state+"<br>"+icon;
                $(elem).html(newValue);
    		}else{
                $(elem).attr("style", "background:red;");
                $(elem).html("<br>ERROR<br><br>");
    		}
    	}
	});
}