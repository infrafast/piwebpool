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

function actionCall(data, messageBox=null, confirm=false){
    if (messageBox!=null){
        if (confirm!=false){
            var r = confirm(messageBox);
            if (true != r) return;
        }else  alert(messageBox);
    }
}


function calibrate(sensor){
    alert("Tremper la sonde dans une solution Ph 7 puis attendre deux minutes");
    var urlCall="./action.php";
	$.ajax({
		    type: "POST",
			url: "./action.php",
			data:{action:"calibrate",sensor:sensor},
			async:false,
		success: function(r){
			result = eval(r);
			alert("Résultat étalonnage: "+result.answer);
	    }
	}); 
}


function getSetting(id,elem){
    var urlCall="./action.php";
    //alert('ajaxCall : '+urlCall);
    $.ajax({
        type: "POST",
        url: urlCall,
        data:{action:"getSetting",id:id},
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


// the getXML has to be sync (async=flase) otehrwise we can't fetch the info frpm the database and return "undefined" variable value
function getLog(){
    var result;
	$.ajax({
		type: "POST",
		url: "./action.php",
		data:{action:"getLog"},
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

function forceCron(){
	alert("Execution des scripts en cours");
	$.ajax({
		    type: "POST",
			url: "./action.php",
			data:{action:"forceCron"},
		success: function(r){
			result = eval(r);
	    }
	});   
}

function resetSchedule(){
    var r = confirm("This will reset your schedule with defaut value");
    if (true == r) {
    	$.ajax({
    			type: "POST",
    			url: "./action.php",
    			data:{action:"resetSchedule"},
    			async:false,
    			success: function(r){
    		 }});
        location.reload(true);
    }
}


function rgbToHex(r, g, b) {
    if(r < 0 || r > 255) alert("r is out of bounds; "+r);
    if(g < 0 || g > 255) alert("g is out of bounds; "+g);
    if(b < 0 || b > 255) alert("b is out of bounds; "+b);
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1,7);
}


function getColor(median,tolerance,value){
    var diff = Math.abs(value - median);
    var ecart = diff/median;
    var prop = ecart/tolerance/100;
    
    var red = 0;
    var green = 0;
    var blue =0;
    
    if (tolerance<1){
        green = ((1-prop)*255)-(500*ecart);
        red = (prop*255)+(500*ecart);
        if (green<0) green=0; if (green>255) green=255;
        if (red<0) red=0; if (red>255) red=255;    
    }else{
// tolerance is upper 1 we are displaying a measure like temperature so we use blue color
        green = ((1-prop)*255)-(500*ecart);
        blue = (prop*255)+(500*ecart);
        if (blue<0) blue=0; if (blue>255) blue=255;
        if (green<0) green=0; if (green>255) green=255;    
    }

    return rgbToHex(red,green,blue);
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
                        tolerance=0.01;
                    }else if (action=='ORP'){
                        median=715;
                        tolerance=0.02;                        
                    }else{
                        median=25;
                        tolerance=2;                        
                    }

                    var color=getColor(median,tolerance,newValue);
                    //alert(color);
                    $(elem).attr("style", "background:"+color+";");

                    newValue = "<br>"+result.state+"<br><br>";
                    $(elem).html(newValue);
				}else{
					alert('Erreur : '+result.answer);
				}
	}});
}