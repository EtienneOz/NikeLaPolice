<!--

###########################################################################
###########################################################################
###                                                                     ### 
###   S V G  TO  T T F                                                  ### 
###   ================                                                  ### 
###   Transformer une suite de SVG en SVG font puis en TTF.             ###
###   Licence GNU/GPL V.3 (https://www.gnu.org/copyleft/gpl.html).      ###
###   Copyleft Étienne Ozeray et Lucas Lejeune.                         ###
###   Merci à Alexis Pétard pour son coup de main (http://elaxis.fr/).  ###
###                                                                     ###  
###########################################################################
###########################################################################

-->


<!doctype html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <title>SVG</title>
	    <style>
	        body 	   { font-family: 'luxi'; margin: 15px; font-size:80%; }
	    	@font-face { font-family:'luxi'; src: url(fontface/LuxiMono.ttf);  }
    		@font-face { font-family: 'luxiItalic'; src: url(fontface/LuxiMono-Oblique.ttf); }
        	a 		   { text-decoration:none; padding-bottom: 2px; border-bottom: 1px solid black; color:black; font-family:'luxiItalic'; }
        	#retour	   { position:fixed; left:15px; bottom:15px; }
	    </style>
	</head>
	<body>		
	    <?php      
		
			// Debug
			ini_set('display_startup_errors', '1');
			ini_set('display_errors','1');
			ini_set('max_execution_time', 10000);
			
			// Débrider la limite de mémoire
			ini_set('memory_limit', '-1');			

	        $titre   = htmlspecialchars($_POST['nom']); 			// ## Titre de la fonte
	        $crenage = htmlspecialchars($_POST['crenage']);       	// ## Définir le crénage
	        $hauteur = htmlspecialchars($_POST['hauteur']);       	// ## Définir la hauteur     

			// Vérifier les fichiers envoyés
			$valid_formats = array("zip");
			$file_format = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
			$max_file_size = 1000000 ; //100 kb
			$path = "uploads/"; // Upload directory
			$count = 0;
			$nom = 'cool';
			
			if ($_FILES['file']['error'] > 0) $erreur = "Erreur lors du transfert";
			if ($_FILES['file']['size'] > $max_file_size) $erreur = "Le fichier est trop gros";
			if ( in_array($file_format,$valid_formats) ) {
			$resultat = move_uploaded_file($_FILES['file']['tmp_name'], $path.$titre.'.zip');
			if ($resultat) echo "--> Transfert réussi<br/>";
			} else{
				echo 'Ce fichier n\'est pas un fichier .zip.';
			}
			 
			// Extraire le zip
			exec('unzip uploads/'.$titre.'.zip -d uploads/unzip/');
			echo '--> Le fichier est décompressé<br/>';

	
	        // Construction du Svg Font
	        $lettres = array(1 => 
	        	// Capitales 
	        	'A', 'À', 'Æ', 'B', 'C', 'D', 'E', 'É', 'È', 'Ê', 'Ë', 
	        	'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'Ô', 
	        	'Ö', 'Œ', 'P', 'Q', 'R', 'S', 'T', 'U', 'Ù', 'Û', 'Ü', 
	        	'V', 'W', 'X', 'Y', 'Z',
	        	// Bas-de-casse 
	        	'a', 'à', 'æ', 'b', 'c', 'ç', 'd', 'e', 'é', 'è', 'ê', 
	        	'ë', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 
	        	'ô', 'ö', 'œ', 'p', 'q', 'r', 's', 't', 'u', 'ù', 'û', 
	        	'ü', 'v', 'w', 'x', 'y', 'z',
	        	// Chiffres 
	        	'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
	        	// Ponctuation 
	        	'-', ',', ';', '!', '?', '\'', '«', '»', '(', ')', '[', 
	        	']', '{', '}', '@', '*', '&amp;', '#', '%', '+', '±', '=', 
	        	'$', ':', '.', '/' );

//	        $lettres = array(1 => 
//	        	'a', 'à', 'æ', 'b', 'c', 'ç', 'd', 'e',
//	        	'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 
//	        	'', 'œ', 'p', 'q', 'r', 's', 't', 'u',
//	        	'v', 'w', 'x', 'y', 'z');
	                                 
	                              
	        $xml = '<?xml version="1.0" standalone="no"?>
	            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd" >
	            <svg xmlns="http://www.w3.org/2000/svg">
	            <metadata>
	                Copyright : Etienne Ozeray et Lucas Lejeune, Brussels 2014
	                </metadata>
	            <defs>';
	        $xml .='<font id="' . $titre . '" horiz-adv-x="' . $crenage . '" >';
	        $xml .='<font-face font-family="' . $titre . '" font-weight="regular" units-per-em="' . $hauteur . '"  />';
	        $xml .='<missing-glyph horiz-adv-x="' . $crenage . '" s="" />';
	        $xml .='<glyph unicode="SPACE" horiz-adv-x="' . $crenage . '" d="" />';
	        $xml .='<glyph unicode="&#x09;" horiz-adv-x="' . $crenage . '"  d="" />';
	        $xml .='<glyph unicode="&#xa0;" horiz-adv-x="' . $crenage . '"  d="" />';
	        
	        // Parsing du svg
	        for ($i = 1; $i <= 113; $i++) {
          		$lettre = file_get_contents('uploads/unzip/' . $i . '.svg');
	            $debut = strrpos($lettre,'d=');
	            if ($debut == FALSE){
		            $xml .='<glyph unicode="' . $lettres[$i] . '" horiz-adv-x="'.$crenage. '"  d="" />';
	            } else {
		            $attrD = substr($lettre, $debut);
		            $coordonees = str_replace("</svg>","",$attrD);
		            $xml .='<glyph unicode="' . $lettres[$i] . '" horiz-adv-x="'.$crenage.'" '.$coordonees;
	            }
	        }
	        $xml .='</font></defs></svg>';
	        
	        $file = $titre.'.svg';
	        file_put_contents('svgFontes/'.$file, $xml);
	        echo '--> ' . $titre . '.svg créé <br/>';
	
			// Conversion du svg font en ttf,
			// Online font converter API (http://onlinefontconverter.com/)
	        require_once 'unirest-php-master/lib/Unirest.php';
	        $src = 'svgFontes/' .$titre.'.svg';
	        $des = 'ttf/'.$titre.'.tar.gz' ;
	        
	        $response = Unirest::post(
	          "https://ofc.p.mashape.com/directConvert/",
	          array(
	            "X-Mashape-Authorization" => "UyZ767DPfreAqKEH1xUbCBkM5uIxlmjN"
	          ),
	          array(
	            "file" => "@".$src,
	            "format" => "ttf"
	          )
	        );
	        
			$res = $response -> __get( 'body' ) ;
			if( isset($res) ) {
				file_put_contents( $des, $res )    ;
				echo '--> ' .$titre. '.tar.gz  créé <br />'     ;
			}

			//extraire le .tar.gz et le déplacer dans le dossier de stockage
			$p = new PharData('ttf/'.$titre.'.tar.gz');
			$p->decompress(); 
			$phar = new PharData('ttf/'.$titre.'.tar');
			$phar->extractTo('ttf/');
			echo '--> ' .$titre.'.tar.gz décompressé, la fonte est prête !';
			copy('./ttf/onlinefontconverter.com/converted-files/' .$titre. '.ttf', './ttf/stock/' .$titre. '.ttf');
			
			//supprimer les fichiers créés sauf le ttf
			for ($j = 1 ; $j <= 113 ; $j++) {
				unlink('uploads/unzip/'.$j.'.svg');
			}
			
			unlink('uploads/'.$titre.'.zip');
			unlink('svgFontes/'.$titre.'.svg');
			unlink('ttf/'.$titre.'.tar.gz');
			unlink('ttf/'.$titre.'.tar');
			unlink('ttf/onlinefontconverter.com/converted-files/'.$titre.'.ttf');
			unlink('ttf/onlinefontconverter.com/README.txt');
			rmdir('ttf/onlinefontconverter.com/converted-files');
			rmdir('ttf/onlinefontconverter.com');
			
		?>
		<br/>
		<br/>
		<!-- Télécharger le fichier -->
		<a href="<?php echo 'ttf/stock/' .$titre. '.ttf' ?>">Télécharger <?php echo $titre. '.ttf'?> !</a>
		<a href="index.php" id="retour"> &lt;-- Retourner au formulaire </a>
	</body>
</html>