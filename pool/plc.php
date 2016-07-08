    <?php
    // Pautex JF ‘setdata.php' 06-2016
    // place avec PLCLink data 1 ou 0 dans un fichier text
    // (autre data possible mais pas avec un switch)

    $mode = $_GET["mode"];			// le mode demande direct,json,xml
    $data = $_GET["data"];			// data envoyée par PLCLink (switch)

    if(isset($data)) {				// data est envoyé par switch
    	$f = fopen("data.txt","w");	// data mise en fichier
    	fwrite($f,$data);
    	fclose($f);
    } else {						// fata relue du fichier text local  'data.txt'
    	$data =  file_get_contents("data.txt",$data);
    }
    // impose une valeur à la variable la premiere fois - pas de fichier par exemple
    if( ! $data) $data = 0;

    // ------------------------------
    // sortie finale defaut = direct
    // ------------------------------

    if(isset($mode)) {					// sortie JSON ou XML
    	if( $mode == "json") {			// sortie json
    		// simule exactement reponse de type : {"state":"0","answer":"OK"}  
    		header('Content-Type: application/json’);		// pas forcement utile
    		// echo '{"state":"' . $data . '","answer":"OK"} '; 	// ca marche pas ?!
    		$json = array('state'=>$data, 'answer'=>'OK');	// ca marche !
    		echo json_encode( $json );
    	} 
    	else if($mode == "xml") {		// sortie xml  a faire
    		echo $data;
    	}
    }
    else {
    	echo $data;						// sortie direct 1 ou 0
    }
    ?>