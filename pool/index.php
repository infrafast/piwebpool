<?php

require_once('configuration.php');
require_once('functions.php');
include("include/TableGear1.6.1.php");

$options["database"]["table"]  = "pumpSchedule";
$options["pagination"] = array();
$options["title"] = "Planificateur";
$options["allowDelete"] = false;
$options["sortable"]  = ""; //array("<FIELD1>", "<FIELD2", "ETC...");

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
$optionsSet["pagination"] = array();
$optionsSet["title"] = "Parametres";
$optionsSet["allowDelete"] = false;
$optionsSet["sortable"]  = ""; 

$optionsSet["selects"] = array(
	"actionTable" => array("invisible" => 1, "visible" => 0),
	"blocklyTable" => array("invisible" => 1, "visible" => 0),
	"scheduler" => array("activé" => 1, "désactivé" => 0)
); 
$optionsSet["transform"]["below0"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$optionsSet["transform"]["0to2"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$tableSettings = new TableGear($optionsSet);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestion piscine</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/TableGear1.6.1-jQuery.js"></script>
        <script src="blockly/blockly_compressed.js"></script>
        <script src="blockly/lua_compressed.js"></script>
        <script src="blockly/blocks_compressed.js"></script>
        <script src="blockly/msg/js/fr.js"></script>
        <link type="text/css" rel="stylesheet" href="css/tablegear.css" />
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

    <table class="materialTab">
    <tr class="header" id="sensorTable">
    <td colspan="3"><b><span>-</span> Mesures</b></td>
    </tr>
    
    <tr><th width=33%>Ph</th><th width=33%>Redox</th><th width=33%>Temperature</th></tr>
    <tr>
        <td><div id="divPhMeasureID" onclick="refreshValue(this,'Ph');" class="buttonState off"><br></div></td>
        <td><div id="divORPMeasureID" onclick="refreshValue(this,'ORP');" class="buttonState off"><br></div></td>
        <td><div id="divTemperatureMeasureID" onclick="refreshValue(this,'Temperature');" class="buttonState off"><br></div></td>
    </tr>
    <tr>
        <th></th>
        <th>Historique sur <select  name="period"  id="periodID" onclick='updateGraphs();'>
                <option value="8">8 heures</option>
                <option selected="selected" value="24">dernier jour</option>
                <option value="168">dernière semaine</option>
        </select></th>
        <th></th>
    </tr>
    <tr height="180px" id="graphID">
        <td class='textType' id="graph=ph" onclick="toggleGraph(this);" style="background-image: url('images/loading.gif'); background-repeat:no-repeat; "></td>
        <td class='textType' id="graph=orp" onclick="toggleGraph(this);" style="background-image: url('images/loading.gif'); background-repeat:no-repeat; "></td>
        <td class='textType' id="graph=temperature" onclick="toggleGraph(this);" style="background-image: url('images/loading.gif'); background-repeat:no-repeat; "></td>
    </tr>
    <tr>
        <td id="PhCalibrateID" style="background-repeat:no-repeat; background-image: url('');"><input type="button" value="Etalonner (ph7)" onclick="calibrateAndRefresh('Ph');"></td>
        <td id="ORPCalibrateID" style="background-repeat:no-repeat; background-image: url('');"><input type="button" value="Etalonner (650mv)" onclick="calibrateAndRefresh('ORP');"></td>
        <td></td>
    </tr>
    </table>

    
    <table class="materialTab">
    <tr class="header" id="actionTable">
    <td colspan="2"><b><span>-</span> Commandes</b></td>
    </tr>
    <tr><th>Historique</th><th>Etat actuel</th></tr>
    <?php 
    foreach($materials as $material=>$pin){ ?>
<tr "height=80px">
    	<?php echo "<td class='barType' id='graph=".$materialsColumn[$material]."' onclick='toggleGraph(this);' style=\"background-image:url(images/loading.gif); background-repeat:no-repeat;\">"?></td>
    	<td><div id="commandButtonID" onclick="changeState(<?php echo $pin; ?>,this)" class="buttonState <?php echo (getPinState($pin,$pins)==1?'on':'off'); ?>"><?php echo "<br>".(getPinState($pin,$pins)==1?'on':'off')."<br><br>";?></div></td>
    </tr>
    <?php } ?>
    </table>
    
    <table class="materialTab">
        <tr class="header" id="blocklyTable">
            <td colspan="1"><b><span>-</span> Programmation</b></td>
        </tr>
        <tr>
            <th style="width: 100%;">
                  <select  name="luascript"  id="scriptID">
                        <option value="main">defaut</option>
                        <option value="custom">perso</option>
                    </select>
                    <input type="button" value="sauver" onclick="saveCode(document.getElementById('scriptID').value);">
                    <input type="button" value="charger" onclick="loadXML(document.getElementById('scriptID').value);">
                    <input type="button" value="executer" onclick="actionCall('action=forceCron',true,'Execution démarée');">
            </th>
        </tr>
        <tr>
          <td><div id="blocklyDiv" style="height: 500px; width:100%"></div></td>
            <xml id="toolbox" style="display: none">
    
                <block type="controls_if"></block>
                <block type="logic_compare"></block>
                <block type="logic_operation"></block>
    
                <block type="sensors"></block>
                <block type="variables_set"><field name="VAR">info</field></block>
                <block type="variables_get"><field name="VAR">variable</field></block>
                <block type="on_off"></block>
                <block type="math_number"></block>
    
                <block type="message"></block>
                <block type="text"></block>
                <block type="text_join"></block>
    
                <block type="setcommand"></block>
                <block type="getcommand"></block>
    
            </xml>
        <tr>
            <th>Code preview</th>
        </tr>
        <tr>
            <td width="100%"><textarea id="scriptareaID" rows="10" readonly style="color: grey; width: 100%;">Erreur chargement de script</textarea>
        </tr>
    </table>
    
    
    <table class="materialTab">
    <tr class="header" id="logTable">
    <td colspan="1"><b><span>-</span> Log</b></td>
    </tr>
    <tr><th>Valeur</th></tr>
    <tr><td width="100%"><textarea rows="5" id="logFile" readonly style="color: grey; width: 100%;"></textarea></td></tr>
    </table>
    
    <div><?= $table->getTable() ?></div>
    <?= $table->getJavascript("jquery") ?>
    <div><?= $tableSettings->getTable() ?></div>
    <?= $tableSettings->getJavascript("jquery") ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    
    <script>
        var graphTypes = ["lineType", "barType", "textType"]; 
        
        // collapse all table as per settings stored in the database
        var collapsableTableList = ['actionTable','Planificateur','sensorTable','blocklyTable','logTable','Parametres'];
        
        for (var tableID in collapsableTableList) {
          if (actionCall('action=getSetting&id='+collapsableTableList[tableID],false)=="1") document.getElementById(collapsableTableList[tableID]).click();
        }
    
        // refresh measures indicators
        refreshValue(document.getElementById('divPhMeasureID'),'Ph');
        refreshValue(document.getElementById('divORPMeasureID'),'ORP');
        refreshValue(document.getElementById('divTemperatureMeasureID'),'Temperature');
    
    
            // retrieve logfile
        document.getElementById('logFile').value = actionCall('action=getLog',false);
        
        
        // draw measures graph
        updateGraphs();
        
        //setup Blockly for LUA variable
        Blockly.Blocks['sensors'] = {
          init: function() {
            this.appendDummyInput()
                .appendField(new Blockly.FieldDropdown([["temperature", "temperature"], ["ph", "ph"], ["orp", "orp"],["periode", "period"],["heure", "hour"]]), "select");
            this.setOutput(true, null);
            this.setColour(330);
          }
        };
        
        Blockly.Lua['sensors'] = function(block) {
          var dropdown_select = block.getFieldValue('select');
          // TODO: Assemble Lua into code variable.
          var code = dropdown_select;
          // TODO: Change ORDER_NONE to the correct strength.
          return [code, Blockly.Lua.ORDER_NONE];
        };
        
        Blockly.Blocks['setcommand'] = {
          init: function() {
            this.appendValueInput("NAME")
                .setCheck("Number")
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
                this.setOutput(true, "Boolean");
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
                .appendField(new Blockly.FieldDropdown([["marche", "1"], ["arret", "0"]]), "command");
            this.setOutput(true, "Number");
            this.setColour(20);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
          }
        };
    
    
        Blockly.Lua['on_off'] = function(block) {
          var dropdown_command = block.getFieldValue('command');
          // TODO: Assemble Lua into code variable.
          var code = dropdown_command;
          // TODO: Change ORDER_NONE to the correct strength.
          return [code, Blockly.Lua.ORDER_NONE];
        };
    
        Blockly.Blocks['message'] = {
          init: function() {
            this.appendValueInput("NAME")
                .setCheck(["String", "Number"])
                .appendField("notifier")
                .appendField(new Blockly.FieldDropdown([["sms", "sms"], ["email", "email"], ["log", "log"]]), "command");
            this.setPreviousStatement(true, null);
            this.setNextStatement(true, null);
            this.setColour(65);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
          }
        };
    
        Blockly.Lua['message'] = function(block) {
          var dropdown_command = block.getFieldValue('command');
          var value_name = Blockly.Lua.valueToCode(block, 'NAME', Blockly.Lua.ORDER_ATOMIC);
          // TODO: Assemble Lua into code variable.
          var code = dropdown_command+'('+value_name+');\n';
          return code;
        };
    
        Blockly.Lua['variables_set'] = function(block) {
          // Variable setter.
          var argument0 = Blockly.Lua.valueToCode(block, 'VALUE',
              Blockly.Lua.ORDER_NONE) || '0';
          var varName = Blockly.Lua.variableDB_.getName(
              block.getFieldValue('VAR'), Blockly.Variables.NAME_TYPE);
          return varName + ' = ' + argument0 + ';\n';
        };
    
    
      var workspace = Blockly.inject('blocklyDiv',
          {toolbox: document.getElementById('toolbox'),
            zoom:
                 {controls: true,
                  wheel: true,
                  startScale: 1.0,
                  maxScale: 3,
                  minScale: 0.3,
                  scaleSpeed: 1.2},
             trashcan: true          
          });
        
        loadXML("main");
    
        // callback function to update code related xml and lua when the workspace is modified
        workspace.addChangeListener(myUpdateFunction);
    
    
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
            Blockly.Xml.domToWorkspace(xml, workspace);
        }
    
        function saveCode(script){
          var xml = Blockly.Xml.workspaceToDom(workspace);
          var xml_text = Blockly.Xml.domToText(xml);
          alert("Sauvegarde: "+updateScript(xml_text,Blockly.Lua.workspaceToCode(workspace),script));
          //alert("sent: "+Blockly.Lua.workspaceToCode(workspace));
        }    
        
        function updateGraph(element){
            var imgSrc = 'url(graph.php?'+element.id+'&period='+document.getElementById('periodID').value+'&width='+element.offsetWidth+'&height='+element.offsetHeight+'&type='+element.classList.item(0)+')';
            //alert("imgSrc="+imgSrc);
            element.style.backgroundSize="100% 100%";
            element.style.backgroundImage=imgSrc; 	     
        }
        
        
        function toggleGraph(element){
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
            updateGraph(element);
        }
          
        function updateGraphs(){
        // this function is called when user change the combo to choose measures rendition period graph
        // it update the call to the graph function according to the selected value
         	var cols = document.getElementById('graphID').getElementsByTagName('td'), colslen = cols.length, i = -1;
        	while(++i < colslen) updateGraph(cols[i]);
            updateCommandsGraphs();
        }  
        
        function updateCommandsGraphs(){    
            // refresh commands graphs
            <?php foreach($materials as $material=>$pin) echo "updateGraph(document.getElementById('graph=".$materialsColumn[$material]."')); \n"; ?>
        }
        
        
        function calibrateAndRefresh(id){
            var elemID = 'div'+id+'MeasureID';
            var elem = document.getElementById(elemID);
            //add loading icon
            var calibrateID=id+"CalibrateID";
            var calibrate=document.getElementById(calibrateID);
            calibrate.style.backgroundImage="url('images/loading.gif')";
            if(actionCall('action=calibrate&id='+id,false,'Placer la sonde dans la solution\npendant 2 minutes puis confirmez',false, true)!=false)
                elem.click();
            //remove loading icon
            calibrate.style.backgroundImage="url('')";
        }

    </script>
    </body>
</html>