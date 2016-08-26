<?php
/*
 @nom: index 
 @auteur: piwebpool (info@infrafast.com)
 @description: main application
*/
//

    require_once('configuration.php');
    require_once('functions.php');
    include("include/TableGear1.6.1.php");
    
    $options["database"]["table"]  = "pumpSchedule";
    $options["pagination"] = array();
    $options["title"] = "Planificateur";
    $options["allowDelete"] = false;
    $options["sortable"]  = ""; 
    $options["selects"] = array(
    	"below0" => array("on" => 1, "off" => 0),
    	"0to2" => array("on" => 1, "off" => 0),
    	"2to4" => array("on" => 1, "off" => 0),
    	"4to6" => array("on" => 1, "off" => 0),
    	"6to8" => array("on" => 1, "off" => 0),
    	"8to10" => array("on" => 1, "off" => 0),
    	"10to12" => array("on" => 1, "off" => 0),
    	"12to14" => array("on" => 1, "off" => 0),
    	"14to16" => array("on" => 1, "off" => 0),
    	"16to18" => array("on" => 1, "off" => 0),
    	"18to20" => array("on" => 1, "off" => 0),
    	"20to22" => array("on" => 1, "off" => 0),
    	"22to24" => array("on" => 1, "off" => 0),
    	"24to26" => array("on" => 1, "off" => 0),
    	"26to28" => array("on" => 1, "off" => 0),
    	"above28" => array("on" => 1, "off" => 0)
    ); 
    $options["transform"]["below0"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["0to2"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["2to4"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["4to6"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["6to8"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["8to10"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["10to12"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["12to14"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["14to16"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["16to18"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["18to20"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["20to22"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["22to24"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["24to26"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["26to28"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $options["transform"]["above28"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
    $table = new TableGear($options);
    
    $optionsSet = array();
    $optionsSet["database"] = array();		    
    $optionsSet["database"]["host"]        = $options["database"]["host"];
    $optionsSet["database"]["name"]        = $options["database"]["name"];
    $optionsSet["database"]["username"]    = $options["database"]["username"];
    $optionsSet["database"]["password"]    = $options["database"]["password"] ;
    $optionsSet["database"]["table"]  = "settings";
    $optionsSet["database"]["noAutoQuery"]=true;
    $optionsSet["pagination"] = array();
    $optionsSet["title"] = "Parametres";
    $optionsSet["allowDelete"] = false;
    $optionsSet["sortable"]  = ""; 
    $optionsSet["editable"] = true;
    $optionsSet["selects"] = array(
    	"userSetting" => array("visible" => 1, "invisible" => 0)
    ); 
    $tableSettings = new TableGear($optionsSet);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Piweb</title>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/piwebscript.js"></script>
        <script type="text/javascript" src="js/TableGear1.6.1-jQuery.js"></script>
        <script type="text/javascript" src="js/weather.js"></script>
        <script type="text/javascript" src="js/loadingoverlay.js"></script>
        <script type="text/javascript" src="blockly/blockly_compressed.js"></script>
        <script type="text/javascript" src="blockly/lua_compressed.js"></script>
        <script type="text/javascript" src="blockly/blocks_compressed.js"></script>
        <script type="text/javascript" src="blockly/msg/js/fr.js"></script>
        
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/tablegear.css" />
        <link rel="stylesheet" href="css/weather-icons.css">
        <link rel="stylesheet" href="css/weather-snippet.css">
    </head>
    <body>

    <table class="materialTab">
    <tr class="header" id="sensorTable">
        <td colspan="3" class="arrondi"><b><span>-</span> Mesures</b></td>
    </tr>
    <tr>
        <th colspan="3"><div id="weather">Affichage météo?</div></th>
    </tr>
    <tr>
        <th width=33%>ph</th><th width=33%>redox</th><th width=33%>température</th>
    </tr>
    <tr>
        <td><div id="divPhMeasureID" onclick="refreshValue(this,'Ph');" class="buttonState off arrondi" ><br></div></td>
        <td><div id="divORPMeasureID" onclick="refreshValue(this,'ORP');" class="buttonState off arrondi" ><br></div></td>
        <td><div id="divTemperatureMeasureID" onclick="refreshValue(this,'Temperature');" class="buttonState off arrondi" ><br></div></td>
        
    </tr>
    <tr>
        <th colspan="3">Historique sur 
            <select  name="period"  id="periodID" onclick='updateAllGraphs();'>
                <option value="8">8 heures</option>
                <option selected="selected" value="24">dernier jour</option>
                <option value="168">dernière semaine</option>
            </select>
        </th>
    </tr>
    <tr height="180px" id="graphID">
        <td class='textType' id="graph=ph" onclick="toggleGraph(this);" ></td>
        <td class='textType' id="graph=orp" onclick="toggleGraph(this);" ></td>
        <td class='textType' id="graph=temperature" onclick="toggleGraph(this);" ></td>
    </tr>
    <tr>
        <td id="PhCalibrateID" style="background-repeat:no-repeat; background-image: url('');"><input type="button" value="Etalonner" disabled onclick="calibrateAndRefresh('Ph',document.getElementById('phCalValueID').value);"><input type="text" id="phCalValueID" name="phCalValue" value="7.00" maxlength="4" size="4"></td>
        <td id="ORPCalibrateID" style="background-repeat:no-repeat; background-image: url('');"><input type="button" value="Etalonner" disabled onclick="calibrateAndRefresh('ORP',document.getElementById('orpCalValueID').value);"><input type="text" id="orpCalValueID" name="orpCalValue" value="650" maxlength="4" size="4">mV</td>
        <td></td>
    </tr>
    </table>

    
    <table class="materialTab">
    <tr class="header" id="actionTable">
    <td colspan="2" class="arrondi"><b><span>-</span> Commandes</b></td>
    </tr>
    <tr><th>Historique</th><th>Etat actuel</th></tr>
    <?php 
    foreach($materials as $material=>$pin){ ?>
    <tr height="80px">
    	<?php echo "<td class='barType' id='graph=".$materialsColumn[$material]."' onclick='toggleGraph(this);'>"?></td>
    	<td><div id=<?php echo "'commandButtonID".$material."'";?> onclick="changeState(<?php echo "'".$material."'"; ?>,this)" class="arrondi buttonState <?php echo (getPin($pins[$materials[$material]])==1?'on':'off'); ?>"><?php echo "<br>".(getPin($pins[$materials[$material]])==1?'on':'off')."<br><br>";?></div></td>
    </tr>
    <?php } ?>
    </table>
    
    <?= $table->getTable() ?>
    <?= $table->getJavascript("jquery") ?>
    
    
    <table class="materialTab">
    <tr class="header" id="blocklyTable">
        <td colspan="1" class="arrondi"><b><span>-</span> Programmation</b></td>
    </tr>
    <tr>
        <th style="width: 100%;">
              <select  name="luascript"  id="scriptID">
                    <option value="main">defaut</option>
                    <option value="custom">perso</option>
                </select>
                <input type="button" id="saveScriptBtn" value="sauver" onclick="saveCode(document.getElementById('scriptID').value);">
                <input type="button" id="loadScriptBtn" value="charger" onclick="loadXML(document.getElementById('scriptID').value);">
                <input type="button" id="runScriptBtn" value="executer" onclick="actionCall('action=forceCron',true,'Execution démarée',false,false);">
                <input type="checkbox" id="unlock" onclick="document.getElementById('saveScriptBtn').disabled=!document.getElementById('saveScriptBtn').disabled">UnLock
        </th>
    </tr>
    <tr>
      <td><div id="blocklyDiv" style="height: 800px; width:100%"></div></td>
    <tr>
        <th>Code preview</th>
    </tr>
    <tr>
        <td width="100%"><textarea id="scriptareaID" rows="10"  style="color: grey; width: 100%;">Erreur chargement de script</textarea>
    </tr>
</table>
    
    
    
    <?= $tableSettings->fetchData("SELECT id,value,description from settings where userSetting=true;"); $tableSettings->getTable(); ?>
    <?= $tableSettings->getJavascript("jquery") ?>

    <table class="materialTab">
    <tr class="header" id="logTable">
    <td colspan="1" class="arrondi"><b><span>-</span> Log</b></td>
    </tr>
    <tr><th>Valeur</th></tr>
    <tr><td width="100%"><textarea rows="10" id="logFile" readonly style="color: grey; width: 100%;"></textarea></td></tr>
    </table>


    <xml id="fulltoolbox" style="display: none">

        <block type="controls_if"></block>
        <block type="logic_compare"></block>
        <block type="logic_operation"></block>

        <block type="dynamicData"></block>
        <block type="variables_set"><field name="VAR">info</field></block>
        <block type="variables_get"><field name="VAR">variable</field></block>
        <block type="on_off"></block>
        <block type="math_number"></block>
        <block type="math_arithmetic"></block>
        <block type="math_change"></block>
        
        <block type="weburl"></block>
        <block type="message"></block>
        <block type="register"></block>
        <block type="text"></block>
        <block type="text_join"></block>

        <block type="setcommand"></block>
        <block type="getcommand"></block>

    </xml>

    <script>

        // -----------------------------------------------------------------------
        //
        //      BLOCKLY CODE
        //
        // -----------------------------------------------------------------
        Blockly.Blocks['dynamicData'] = {
          init: function() {
            this.appendDummyInput()
                .appendField(new Blockly.FieldDropdown([["temperature", "temperature"], ["ph", "ph"], ["orp", "orp"],["periode", "period"],["heure", "hour"],["minute", "minute"],["horodateur", "timestamp"]]), "select");
            this.setOutput(true, null);
            this.setColour(330);
          }
        };
        
        Blockly.Lua['dynamicData'] = function(block) {
          var dropdown_select = block.getFieldValue('select');
          // TODO: Assemble Lua into code variable.
          var code = dropdown_select;
          // TODO: Change ORDER_NONE to the correct strength.
          return [code, Blockly.Lua.ORDER_NONE];
        };
        
        Blockly.Blocks['setcommand'] = {
          init: function() {
            this.appendValueInput("NAME")
                .setCheck("String")
                .appendField("commander")
                .appendField(new Blockly.FieldDropdown([
                    <?php foreach($materials as $material=>$pin) echo '["'.$material.'","'.$material.'"],';?>
                    ["",""]
                  ]), "command");
            this.setPreviousStatement(true, null);
            this.setNextStatement(true, null);
            this.setColour(20);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
          }
        };
        
        Blockly.Lua['setcommand'] = function(block) {
          var dropdown_command = block.getFieldValue('command');
          var value_name = Blockly.Lua.valueToCode(block, 'NAME', Blockly.Lua.ORDER_ATOMIC);
          // TODO: Assemble Lua into code variable.
          value_name = value_name.substring(1,value_name.length - 1);

          var code = 'set('+dropdown_command+','+value_name+');\n';
          return code;
        };
    
        Blockly.Blocks['getcommand'] = {
          init: function() {
            this.appendDummyInput()
                .appendField("etat")
                .appendField(new Blockly.FieldDropdown([
                    <?php foreach($materials as $material=>$pin) echo '["'.$material.'","'.$material.'"],';?>
                    ["",""]
                  ]), "command");            
                this.setColour(20);
                this.setOutput(true, "String");
          }
        };
        
        Blockly.Lua['getcommand'] = function(block) {
          var dropdown_command = block.getFieldValue('command');
          // TODO: Assemble Lua into code variable.
          var code = 'get('+dropdown_command+')';
          // TODO: Change ORDER_NONE to the correct strength.
          return [code, Blockly.Lua.ORDER_NONE];
        };
    
        Blockly.Blocks['on_off'] = {
          init: function() {
            this.appendDummyInput()
                .appendField(new Blockly.FieldDropdown([["marche", "On"], ["arret", "Off"]]), "command");
            this.setOutput(true, "String");
            this.setColour(20);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
          }
        };
    
    
        Blockly.Lua['on_off'] = function(block) {
          var dropdown_command = block.getFieldValue('command');
          // TODO: Assemble Lua into code variable.
          var code = "'"+dropdown_command+"'";
          // TODO: Change ORDER_NONE to the correct strength.
          return [code, Blockly.Lua.ORDER_NONE];
        };
    

        Blockly.Blocks['register'] = {
          init: function() {
            this.appendValueInput("url")
                .setCheck(null)
                .appendField("souscrire")
                .appendField(new Blockly.FieldDropdown([
                            <?php foreach($materials as $material=>$pin) echo '["'.$material.'","'.$material.'"],';?>
                            ["",""]
                          ]), "command")        
                .appendField(" URL");
            this.appendValueInput("onValue")
                .setCheck(null)
                .setAlign(Blockly.ALIGN_RIGHT)
                .appendField("valeur ON");
            this.appendValueInput("offValue")
                .setCheck(null)
                .setAlign(Blockly.ALIGN_RIGHT)
                .appendField("valeur OFF");
            this.setPreviousStatement(true, null);
            this.setNextStatement(true, null);
            this.setColour(65);
            this.setTooltip('%v remplacé par l'état');
          }
        };

        Blockly.Lua['register'] = function(block) {
          var dropdown_material = block.getFieldValue('material');
          var value_url = Blockly.Lua.valueToCode(block, 'url', Blockly.Lua.ORDER_ATOMIC);
          var value_onvalue = Blockly.Lua.valueToCode(block, 'onValue', Blockly.Lua.ORDER_ATOMIC);
          var value_offvalue = Blockly.Lua.valueToCode(block, 'offValue', Blockly.Lua.ORDER_ATOMIC);
          // TODO: Assemble Lua into code variable.
//          var code = "subscribe('"+dropdown_material+"','"+value_url+"','"+value_onvalue+"','"+value_offvalue+"')\n";
          return code;
        };        

    


    
        Blockly.Blocks['message'] = {
          init: function() {
            this.appendValueInput("message")
                .setCheck(["String", "Number"])
                .appendField("notifier")
                .appendField(new Blockly.FieldDropdown([["sms", "sms"], ["email", "email"], ["log", "log"]]), "command")
                .appendField("message");
            this.appendValueInput("destination")
                .setCheck(["String", "Number"])
                .appendField("destination (email,numero ou titre)");
            this.setPreviousStatement(true, null);
            this.setNextStatement(true, null);
            this.setColour(65);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
          }
        };

        Blockly.Lua['message'] = function(block) {
          var dropdown_command = block.getFieldValue('command');
          var value_message = Blockly.Lua.valueToCode(block, 'message', Blockly.Lua.ORDER_ATOMIC);
          var value_destination = Blockly.Lua.valueToCode(block, 'destination', Blockly.Lua.ORDER_ATOMIC);
          // TODO: Assemble Lua into code variable.
          var code = dropdown_command+'('+value_message+','+value_destination+');\n';
          return code;
        };


        Blockly.Lua['variables_set'] = function(block) {
          // Variable setter.
          var argument0 = Blockly.Lua.valueToCode(block, 'VALUE',
              Blockly.Lua.ORDER_NONE) || '0';
          var varName = Blockly.Lua.variableDB_.getName(
              block.getFieldValue('VAR'), Blockly.Variables.NAME_TYPE);
            // for some reason the code generatr convert some character into their HEX code, we reconvertt them back
            var cleanVarName = varName.replace("_5B", "[");
            var cleanVarName = cleanVarName.replace("_5D", "]");
            var cleanVarName = cleanVarName.replace("_22", "'");  
            var cleanVarName = cleanVarName.replace("_22", "'");  
              
          return cleanVarName + ' = ' + argument0 + ';\n';
        };
    
        Blockly.Lua['variables_get'] = function(block) {
            // Variable getter.
            var code = Blockly.Lua.variableDB_.getName(
                block.getFieldValue('VAR'),
                Blockly.Variables.NAME_TYPE
            );
            var cleanCode = code.replace("_5B", "[");
            var cleanCode = cleanCode.replace("_5D", "]"); 
            var cleanCode = cleanCode.replace("_22", "'");  
            var cleanCode = cleanCode.replace("_22", "'");             
            return [cleanCode, Blockly.Lua.ORDER_NONE];
        };
    
    
        Blockly.Lua['math_change'] = function(block) {
            // Add to a variable in place.
            var argument0 = Blockly.Lua.valueToCode(block, 'DELTA',
              Blockly.Lua.ORDER_ADDITIVE) || '0';
            var varName = Blockly.Lua.variableDB_.getName(
              block.getFieldValue('VAR'), Blockly.Variables.NAME_TYPE);
            var cleanVarName = varName.replace("_5B", "[");
            var cleanVarName = cleanVarName.replace("_5D", "]");  
            var cleanVarName = cleanVarName.replace("_22", "'");  
            var cleanVarName = cleanVarName.replace("_22", "'");
            return cleanVarName + ' = ' + cleanVarName + ' + ' + argument0 + '\n';
        };

        Blockly.Blocks['weburl'] = {
          init: function() {
            this.appendValueInput("url")
                .setCheck("String")
                .appendField("Appel URL");
            this.appendValueInput("statuskey")
                .setCheck("String")
                .appendField("reponse");
            this.setOutput(true, null); //"String"
            this.setColour(65);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
          }
        };     
        
        Blockly.Lua['weburl'] = function(block) {
          var value_url = Blockly.Lua.valueToCode(block, 'url', Blockly.Lua.ORDER_ATOMIC);
          var value_statuskey = Blockly.Lua.valueToCode(block, 'statuskey', Blockly.Lua.ORDER_ATOMIC);
          // TODO: Assemble Lua into code variable.
          var code = 'web('+value_url+','+value_statuskey+')';
          return [code, Blockly.Lua.ORDER_NONE];
        };        
        
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        //   UTILITIES FUNCTIONS
        //
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~        

        function myUpdateFunction(event) {
          var code = Blockly.Lua.workspaceToCode(workspace);
          document.getElementById('scriptareaID').value = code;
        }
        
        function loadXML(script){
            //clean the code
            Blockly.mainWorkspace.clear();
            //fetch the code from xml table
            xml_text = getScript("xml", script);
            //alert("received: "+xml_text);
            var xml = Blockly.Xml.textToDom(xml_text);
            // workspace is editable by defaut with limited blocks number
            Blockly.mainWorkspace.options.readOnly = false;
            document.getElementById('saveScriptBtn').disabled = false;  
            Blockly.mainWorkspace.options.maxBlocks = 500;
            // except for the main script
            if (script=="main" && document.getElementById('unlock').checked === false){
                // we put 1 so the blocks are greyed out
                Blockly.mainWorkspace.options.maxBlocks = 1;
                Blockly.mainWorkspace.options.disabled = true;
                Blockly.mainWorkspace.options.readOnly = true;
                document.getElementById('saveScriptBtn').disabled = true;  
            }   
            Blockly.Xml.domToWorkspace(xml, workspace);            
        }
    
        function saveCode(script){
          var xml = Blockly.Xml.workspaceToDom(workspace);
          var xml_text = Blockly.Xml.domToText(xml);
          alert("Sauvegarde: "+updateScript(xml_text,Blockly.Lua.workspaceToCode(workspace),script));
          //alert("sent: "+Blockly.Lua.workspaceToCode(workspace));
        }    

        function updateGraph(element){
            var link='graph.php?';
            element.style.backgroundSize="100% 100%";            
            var imgSrc = 'url('+link+element.id+'&period='+document.getElementById('periodID').value+'&width='+element.offsetWidth+'&height='+element.offsetHeight+'&type='+element.classList.item(0)+'&title='+element.id+')';
            element.style.backgroundImage=imgSrc;
        }
        
        function toggleGraph(element){
            var graphTypes = ["lineType", "barType", "textType"];
            var nextGraphType = "undef";
            var currentGraphType = element.classList.item(0);
            // locate the class in the list to get the next one
            var i=graphTypes.indexOf(currentGraphType);
            if (i!=-1){
                i++;
                if (i>(graphTypes.length)-1) i=0;
                nextGraphType = graphTypes[i];                
            }
            element.classList.remove(currentGraphType);
            element.classList.add(nextGraphType);
            //updateGraph(element,'images/loading.gif?');
            updateGraph(element);
        }
          
        function updateAllGraphs(){
        // this function is called when user change the combo to choose measures rendition period graph
        // it update the call to the graph function according to the selected value
            updateMeasuresGraphs();
            updateCommandsGraphs();
        }  
        
        function updateMeasuresGraphs(){
         	var cols = document.getElementById('graphID').getElementsByTagName('td'), colslen = cols.length, i = -1;
        	while(++i < colslen) updateGraph(cols[i]);
        }
        
        function updateCommandsGraphs(){    
            // refresh commands graphs
            <?php foreach($materials as $material=>$pin) echo "updateGraph(document.getElementById('graph=".$materialsColumn[$material]."')); \n"; ?>
        }
        
        function calibrateAndRefresh(id,calVal){
            var elemID = 'div'+id+'MeasureID';
            var elem = document.getElementById(elemID);
            //add loading icon
            var calibrateID=id+"CalibrateID";
            var calibrate=document.getElementById(calibrateID);
            calibrate.style.backgroundImage="url('images/loading.gif')";
            if(actionCall('action=calibrate&id='+id+'&value='+calVal,false,'Placer la sonde dans la solution '+id+' à '+calVal+'\npendant 2 minutes puis confirmez',true, true)!=false)
                elem.click();
            //remove loading icon
            calibrate.style.backgroundImage="url('')";
        }
        
        function refreshPanel(id){
            switch (id) {
                case 'sensorTable':
                    //loadWeather("45.840491, 6.085538",0);
                    loadWeather("46.203962, 6.133670",0);
                    updateMeasuresGraphs();
                    refreshValue(document.getElementById('divPhMeasureID'),'Ph');
                    refreshValue(document.getElementById('divORPMeasureID'),'ORP');
                    refreshValue(document.getElementById('divTemperatureMeasureID'),'Temperature');
                break;
                case 'logTable':
                    var logarea = document.getElementById('logFile');
                    logarea.value = actionCall('action=getLog',false,null,false,false);
                    logarea.scrollTop = logarea.scrollHeight;
                case 'actionTable':
                    updateCommandsGraphs();
                break;
                default:
            }
        }
    
        
        // -----------------------------------------------------------------------
        //
        //      RUN TIME CODE START HERE
        //
        // -----------------------------------------------------------------------
        // register function that collpase or expand titles
        $('.header').click(function(){
            $(this).LoadingOverlay("show");
        	$(this).addClass('loading');
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
            $(this).nextUntil('tr.header').fadeToggle(); 
            var id=$(this).attr('id');
            var valueToggle=($(this).find('span').text()=='-'?'0':'1');
            var urlCall="./action.php?extendedJson&action=updateSetting&id="+id+"&value="+valueToggle;
            //alert('urlCall : '+urlCall);
            $.ajax({
                type: "POST",
            	url: urlCall,
            	async:false,
                success: function(r){
                    if (valueToggle==0) refreshPanel(id);
            }});
            $(this).removeClass('loading');
            $(this).LoadingOverlay("hide", true);
        });

        // collapse all table as per settings stored in the database
        var collapsableTableList = ['actionTable','Planificateur','sensorTable','blocklyTable','logTable','Parametres'];
        for (var tableID in collapsableTableList) {
            // we collapse the section if toggleValue is 1
            if (actionCall('action=getSetting&id='+collapsableTableList[tableID],false,null,false,false)=="1") 
                document.getElementById(collapsableTableList[tableID]).click();
            else
                // otherwise we just refresh the content
                refreshPanel(collapsableTableList[tableID]);
        }

    
        var workspace = Blockly.inject('blocklyDiv',
          {
            scrollbars: true,
            comments: true,
            toolbox: document.getElementById('fulltoolbox'),
            zoom:
                 {controls: true,
                  wheel: false,
                  startScale: 1.0,
                  maxScale: 3,
                  minScale: 0.3,
                  scaleSpeed: 1.2},
             trashcan: true          
          });
        
        loadXML("main");
        // callback function to update code related xml and lua when the workspace is modified
        workspace.addChangeListener(myUpdateFunction);

        </script>
    </body>
</html>