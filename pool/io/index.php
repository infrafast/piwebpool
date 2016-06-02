<?php 
require_once('configuration.php');
require_once('functions.php');
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>IO Driver</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

<table class="materialTab">
<tr><th>Commande</th><th>Etat</th></tr>
<?php foreach($materials as $material=>$pin){ ?>
<tr>
	<td><?php echo $material; ?></td>
	<td><div onclick="changeState(<?php echo $pin; ?>,this)" class="pinState <?php echo $pinState; ?>"></div></td></tr>
<?php } ?>
<tr>
<td colspan="3"><div onclick="demo();">Action</div></td>
</tr>
</table>

<script src="js/jquery.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>