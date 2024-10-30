<?php	
	//A
	$a = $_POST["destinatario"];
	$f=2;
	//Oggetto
	$oggetto = $_POST["oggetto"];
	//Messaggio
	$messaggio = html_entity_decode($_POST["messaggio"]);
	$messaggio .= '<br />';
	$messaggio .= '<br />';
	$messaggio .= '<div><img src="';
	$messaggio .= $_POST["siteurl"]."/wp-content".$_POST['img'];
	$messaggio .= '"/></div>';
	$messaggio .= '<br />';

	//Da
	$header = "From: ".$_POST["mittente"]."\r\n";
	$header.= "MIME-Version: 1.0\n";
	$header.= "Content-type: text/html; charset=\"iso-8859-1\"\n";
	$header.="Content-Transfer-Encoding: 7bit\n";

	
	if ( mail($a,$oggetto,$messaggio,$header) ) {
		@header("location: vis_ext.php?msg=ok&ABSPATH=".$_POST["ABSPATH"]."&up=".$_POST["up"]."&np=".$_POST["np"]."&ext=".$_POST["ext"]."&siteurl=".$_POST["siteurl"]."&comment_registration=".$_POST["comment_registration"]."&user_ID=".$_POST["user_ID"]."&col_dim_vista=".$_POST["col_dim_vista"]."&user_identity=".$_POST["user_identity"]."&blogname=".$_POST["blogname"]);
	} else {
		@header("location: vis_ext.php?msg=Cartolina non Inviata! :\'(&ABSPATH=".$_POST["ABSPATH"]."&up=".$_POST["up"]."&np=".$_POST["np"]."&ext=".$_POST["ext"]."&siteurl=".$_POST["siteurl"]."&comment_registration=".$_POST["comment_registration"]."&user_ID=".$_POST["user_ID"]."&col_dim_vista=".$_POST["col_dim_vista"]."&user_identity=".$_POST["user_identity"]."&blogname=".$_POST["blogname"]);
	}
?>
