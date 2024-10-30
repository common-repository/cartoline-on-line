<?php
	//Dichiarazione variabili
	$tipi_img_supp=array("jpg","jpeg","gif","png","bmp");
	require_once('../lettore_file.php');
	//Trasforma le path windows per l'upload
	function col_fix_win_path($path){
		$path = str_replace("\\","/",$path);
		$path = str_replace("//","/",$path);
		$path = str_replace("//","/",$path);
		$path = str_replace("//","/",$path);
		if(substr($path, -1)=='/'){
			$path = substr($path,0,strlen($path)-1);
		}
		return $path;
	}
	//Formattazione Data all'Italiana
	function col_format_data($data){
		$comodo=split(" ",$data);
		foreach($comodo as $val){
			$val=str_replace(","," ",$val);
		};
		switch(strtolower($comodo[0])){
			case 'january':$comodo[0]='Gennaio';break;
			case 'february':$comodo[0]='Febbraio';break;
			case 'march':$comodo[0]='Marzo';break;
			case 'april':$comodo[0]='Aprile';break;
			case 'may':$comodo[0]='Maggio';break;
			case 'june':$comodo[0]='Giugno';break;
			case 'july':$comodo[0]='Luglio';break;
			case 'august':$comodo[0]='Agosto';break;
			case 'september':$comodo[0]='Settembre';break;
			case 'october':$comodo[0]='Ottobre';break;
			case 'november':$comodo[0]='Novembre';break;
			case 'december':$comodo[0]='Dicembre';break;
		};
		if($comodo[4]=='pm'){
			$comodo_=split(":",$comodo[3]);
			$comodo_[0]=$comodo_[0]+12;
			$comodo[3]=$comodo_[0].':'.$comodo_[1];
		}
		$data=$comodo[1].$comodo[0]." ".$comodo[2]." alle ".$comodo[3];
		return $data;
	}
	function col_get_tipo_img($nome_file){
		$file_info=pathinfo($nome_file);
		return strtolower($file_info['extension']);
	}
	//Controllo sul file per capire se è immagine
	function col_is_file_img($nome_file){
		global $tipi_img_supp;
		if (in_array(col_get_tipo_img($nome_file), $tipi_img_supp)) { 
			return true;
		}else{
			return false;
		}
	}
	//Controllo sul file per capire se è immagine
	function rreset_var_get(){
		print '<input type="hidden" name="ABSPATH" value="'.$_GET['ABSPATH'].'"/>';
		print '<input type="hidden" name="up" value="'.$_GET['up'].'"/>';
		print '<input type="hidden" name="np" value="'.$_GET['np'].'"/>';
		print '<input type="hidden" name="ext" value="'.$_GET['ext'].'"/>';
		print '<input type="hidden" name="siteurl" value="'.$_GET['siteurl'].'"/>';
		print '<input type="hidden" name="col_dim_vista" value="'.$_GET['col_dim_vista'].'"/>';
		print '<input type="hidden" name="php_gd" value="'.$_GET['php_gd'].'"/>';
		print '<input type="hidden" name="user_identity" value="'.$_GET['user_identity'].'"/>';
		print '<input type="hidden" name="blogname" value="'.$_GET['blogname'].'"/>';
	}

	$col_path = 'wp-content/plugins/CartolineOL';
	$directory = (isset($_GET['directory']))?$_GET['directory']:$_GET['ABSPATH'].$_GET['up'].'/cartoline/';
	$thumb_dir = $_GET['up'].'/cartoline/';

	//percorso immagine

	include "../../../plugins/CartolineOL/pag/setting.php";
	function set_head(){
/*		print "<link rel=\"stylesheet\" href=\"".$_GET['siteurl']."/wp-content/plugins/CartolineOL/css/lightbox.css\" type=\"text/css\" media=\"screen\" />\n";
		print "<script src=\"".$_GET['siteurl'].$col_path."/wp-content/plugins/CartolineOL/js/prototype.js\" type=\"text/javascript\"></script>\n";
		print "<script src=\"".$_GET['siteurl'].$col_path."/wp-content/plugins/CartolineOL/js/scriptaculous.js?load=effects\" type=\"text/javascript\"></script>\n";
		print "<script src=\"".$_GET['siteurl'].$col_path."/wp-content/plugins/CartolineOL/js/lightbox.js\" type=\"text/javascript\"></script>\n";*/
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="generator" content="ARKSOFT snc" /> <!-- leave this for stats -->
		<link rel="stylesheet" href="../css/stile.css" type="text/css" media="screen" />
		<?php
			set_head();
		?>
					<script language="javascript">
							var check=false;
							function colcontrollo(){
									//alert(document.cartolina.img[0].length);
									/*for (i=0;i<document.cartolina.img.length;i++){
										if (document.cartolina.img[i].checked==true){										
											check=true;
										}	
									}*/
									if(check == false){
										alert('Attenzione devi selezionare una Cartolina da inviare');
										document.cartolina.img.focus();
										return false;
									}
									if(document.cartolina.mittente.value == ''){
										alert('Attenzione il mittente risulta vuoto');
										document.cartolina.mittente.focus();
										return false;
									}
									if(document.cartolina.mittente.value.indexOf ('@',0)  == -1) { 
										alert('Attenzione l\'email del mittente non è valida');
										document.cartolina.mittente.focus();
										return false;
									}
									if(document.cartolina.destinatario.value == ''){
										alert('Attenzione il destinatario risulta vuoto');
										document.cartolina.destinatario.focus();
										return false;
									}
									if(document.cartolina.destinatario.value.indexOf ('@',0)  == -1) { 
										alert('Attenzione l\'email del destinatario non è valida');
										document.cartolina.destinatario.focus();
										return false;
									}
									if(document.cartolina.oggetto.value == ''){
										alert('Attenzione l\'oggetto risulta vuoto');
										document.cartolina.oggetto.focus();
										return false;
									}
									if(document.cartolina.messaggio.value== ''){
										alert('Attenzione il messaggio risulta vuoto');
										document.cartolina.messaggio.focus();
										return false;
									}
									return true;
							}

					</script>
	</head>
	<body>
<?php
	
	//Lista immagini da directory
	
		$page=isset($_GET['pagina'])?$_GET['pagina']:1;
	
		
		$dir = "../../../uploads/cartoline/";
		$tpages=0;
		if (is_dir($dir)){
			//apro la cartella
			if ($dh = opendir($dir)) {
				//vedo il contenuto della cartella
				while (($file = readdir($dh)) !== false) {
					//creo l'array dei file
					if(strlen($file)>2){
						$lista=$lista.$file.",";
						$tfile=$tfile+1;
					}
				}
				closedir($dh);
			}
		}
		//totale pagine
		$tpages=ceil($tfile/$num);
		
		$view_page_url = $_SERVER['REQUEST_URI'];
		$this_page_url = $view_page_url;

		print "
		<center>
			<div id=\"visione_\">
		";

		if($tpages>1){
			print "	<div id=\"floor_\">\n
					<div class=\"floor\">\n
			";
			if ($page-1 > 0){
				print '
				<form method="get" action="">
				';
				rreset_var_get();
				print '
					<input type="hidden" name="pagina" value="'.($page-1).'"/>
					<input type="submit" class="button_" value="Precedente"/>
				</form>
				';
			}else{
				print '&nbsp;';
			}
			print "
					</div>
					<div class=\"floor\">
						Pagina ".$page." di ".$tpages."
					</div>
					<div class=\"floor\">
			";
			if ($page+1 <= $pages){
				print '
				<form method="get" action="">
				';
				rreset_var_get();
				print '
					<input type="hidden" name="pagina" value="'.($page+1).'"/>
					<input type="submit" class="button_" value="Prossima"/>
				</form>
				';
			}else{
				print '&nbsp;';
			}
			print "
					</div>
				</div>
			";
		}

		print "
			<form action=\"".$_GET['siteurl']."/wp-content/plugins/CartolineOL/funct/invio_op.php\" name=\"cartolina\" method=\"post\" onsubmit=\"return colcontrollo();\">
		";
		if($tpages>0){
			rreset_var_get();
			$bg_alternato="class=\"alternate\"";
			$i=0;
			$listaesplodi=explode(",",$lista);
			if(strlen($_GET['pagina'])>0){$b=($_GET['pagina']-1)*$num; $fine=$b+$num;}else{$b=0; $fine=$num;}
			for($a=$b; $a<$fine; $a++){
?>			<script language="javascript">
				/*function colattivaradio<? print $a; ?>(){
					check=true;
					document.cartolina.img<? print $a; ?>.checked=true;	
				}*/
			</script>	
<?				if(strlen($listaesplodi[$a])>0){
				print "<div $bg_alternato>";
					$thumb_url = $dir.$listaesplodi[$a];
					print "<div class=\"img_cartolina_\"><img src=\"$thumb_url\" width=\"150\" height=\"150\" alt=\"Anteprima\" target=\"top\" rel=\"lightbox[cartoline]\" ></div>";
				$nomefile=substr($listaesplodi[$a],0,strpos($listaesplodi[$a],"."));
				$peso=filesize($thumb_url);
				$peso=round($peso/1024);
				//$nomefile=(strlen($nomefile)>19)?substr($nomefile,0,15).'...':$nomefile;
				
				//percorso immagine
				$scomponi=explode("/",$_SERVER['REDIRECT_SCRIPT_URI']);
				$ultimo=array_pop($scomponi);
				$ultimo1=array_pop($scomponi);
				$ultimo2=array_pop($scomponi);
				$ultimo3=array_pop($scomponi);
				$ricomponi=implode("/",$scomponi);
				$percorsoassoluto=$ricomponi."/uploads/cartoline/";
				//fine percorso
				
				$immagineinvio=$percorsoassoluto.$listaesplodi[$a];

				print "
					<div class=\"info_cartolina_\">
						<div class=\"info\">
							<h2><span class=\"evi\">".$nomefile."</span></h2><br />
							<strong>Dimensione File</strong>:<br />
							".$peso." Kb<br /><br />
							<div class=\"select_\">
								<div class=\"sel_0\">
									<strong>Seleziona</strong><br />
								</div>
								<div class=\"sel_1\">
									<input type='radio' id=\"img\" name=\"img\" onclick=\"javascript: check=true;\" value='".$immagineinvio."'>
								</div>
							</div>
							<div class=\"sel_2\">
								<a href=\"#invio_mail\" id='".$a."' name='".$a."' onclick=\"javascript:  document.cartolina.img[".$a."].checked=true; check=true;\">Inviala Subito</a>
							</div>
						</div>
					</div>
				";
				if ($bg_alternato=="class=\"alternate\""){
					$bg_alternato="class=\"alternate_\"";
				}else{
					$bg_alternato="class=\"alternate\"";
				}
				print "</div>\n\n";
			}
			}
		}else{
				rreset_var_get();
			print '<div>Ancora non ci sono cartoline caricate</div>';
		}
		print "
					</div>
				</div>
				<!-- Form di invio E-Mail -->
				<div id=\"invio_mail\">
					<h2>Invia la Cartolina Selezionata</h2>
					<input type=\"hidden\" name=\"blog_\" id=\"blog_\" value=\"Invio Cartolina Offerto da ".$_GET['blogname']."\"/>
					<input type=\"hidden\" name=\"ABSPATH\" value=\"".$_GET['ABSPATH']."\"/>
					<input type=\"hidden\" name=\"up\" value=\"".$_GET['up']."\"/>
					<input type=\"hidden\" name=\"np\" value=\"".$_GET['np']."\"/>
					<input type=\"hidden\" name=\"ext\" value=\"".$_GET['ext']."\"/>
					<input type=\"hidden\" name=\"siteurl\" value=\"".$_GET['siteurl']."\"/>
					<input type=\"hidden\" name=\"col_dim_vista\" value=\"".$_GET['col_dim_vista']."\"/>
					<input type=\"hidden\" name=\"php_gd\" value=\"".$_GET['php_gd']."\"/>
					<input type=\"hidden\" name=\"user_identity\" value=\"".$_GET['user_identity']."\"/>
					<input type=\"hidden\" name=\"blogname\" value=\"".$_GET['blogname']."\"/>
					<p>
						<label for=\"mittente\">* E-Mail Mittente (non sar&agrave; memorizzato)</label>
						<input type=\"text\" name=\"mittente\" value=\"\"/>
					</p>
					<p>
						<label for=\"destinatario\">* E-Mail Destinatario (non sar&agrave; memorizzato)</label>
						<input type=\"text\" name=\"destinatario\" value=\"\"/>
					</p>
					<p>
						<label for=\"oggetto\">Oggetto</label>
						<input type=\"text\" name=\"oggetto\" value=\"\"/>
					</p>
					<p>
						<label for=\"messaggio\">Messaggio</label>
						<textarea name=\"messaggio\"></textarea>
					</p>
					
					<input type=\"submit\" class=\"button_\" value=\"Invia\"/>
				</div>
			</form>
		";
		//Messaggio di avvenuto invio email
		if(isset($_GET['msg'])){
			if($_GET['msg']=='ok'){
				print "
				<center>
					<div id=\"visione_\" style=\"background-color: #AAFFAA;\">
						<h2>Posta inoltrata con successo</h2>
					</div>
				</center>
				";
			}else{
				print "
				<center>
					<div id=\"visione_\">
						<h2>".$_GET['msg']."</h2>
					</div>
				</center>
				";
			}
		}
		//fine invio
		if($tpages>1){
			print "	<div id=\"floor_\">\n
					<div class=\"floor\">\n
			";
			if ($page-1 > 0){
				print '
				<form method="get" action="">
				';
				rreset_var_get();
				print '
					<input type="hidden" name="pagina" value="'.($page-1).'"/>
					<input type="submit" class="button_" value="Precedente"/>
				</form>
				';
			}else{
				print '&nbsp;';
			}
			print "
					</div>
					<div class=\"floor\">
						Pagina ".$page." di ".$tpages."
					</div>
					<div class=\"floor\">
			";
			if ($page+1 <= $tpages){
				print '
				<form method="get" action="">
				';
				rreset_var_get();
				print '
					<input type="hidden" name="pagina" value="'.($page+1).'"/>
					<input type="submit" class="button_" value="Prossima"/>
				</form>
				';
			}else{
				print '&nbsp;';
			}
			print "
					</div>
				</div>
			";
		}
		print "
			</center>
		";
?>
	</body>
</html>
