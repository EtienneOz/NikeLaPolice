<!--

###########################################################################
###########################################################################
###                                                                     ### 
###   S V G  TO  T T F                                                  ### 
###   ================                                                  ### 
###   Transformer une suite de SVG en SVG font puis en TTF.             ###
###   Licence GNU/GPL V.3 (https://www.gnu.org/copyleft/gpl.html).      ###
###   Un projet de Étienne Ozeray et Lucas Lejeune.                     ###
###   Merci à Alexis Pétard pour son coup de main (http://elaxis.fr/).  ###
###                                                                     ###  
###########################################################################
###########################################################################

-->


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>svg2ttf</title>
    <style>
    	@font-face { font-family: 'luxi'; 	   src: url(fontface/LuxiMono.ttf); }
    	@font-face { font-family: 'luxiBold';   src: url(fontface/LuxiMono-Bold.ttf); }
    	@font-face { font-family: 'luxiItalic'; src: url(fontface/LuxiMono-Oblique.ttf); }
        body 	   { font-family: 'luxi'; margin: 15px; font-size:80%; }
        h1 		   { font-size:100%; font-family: 'luxiBold';}
        pre 	   { margin-left:15px; font-size: 90%; font-family: 'luxi'; width: 600px; }
        a 		   { text-decoration:none; padding-bottom: 2px; border-bottom: 1px solid black; color:black; font-family:'luxiItalic'; }
        bold 	   { font-family:'luxiBold'; }
        input 	   { font-family: 'luxi'; ]
    </style>
</head>
	<body>
		<h1>
		 S V G --> T T F
		</h1>
		<p style="width:600px;">
			Générer 1 .ttf à partir de 112 .svg .<br/><br/>

			Utilisation du php pour créer un fichier svg font contenant chaque caractère qui est ensuite converti en ttf via l'api de <a href="http://onlinefontconverter.com/" target="_blank">Online Font Converter</a>.<br/>
			Le dossier de svg doit comporter, dans l'ordre, les lettres suivantes :
Capitales :<br/>
'A', 'À', 'Æ', 'B', 'C', 'D', 'E', 'É', 'È', 'Ê', 'Ë', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'Ô', 'Ö', 'Œ', 'P', 'Q', 'R', 'S', 'T', 'U', 'Ù', 'Û', 'Ü', 'V', 'W', 'X', 'Y', 'Z' <br/>
Bas-de-casse :<br/>
'a', 'à', 'æ', 'b', 'c', 'ç', 'd', 'e', 'é', 'è', 'ê', 'ë', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'ô', 'ö', 'œ', 'p', 'q', 'r', 's', 't', 'u', 'ù', 'û', 'ü', 'v', 'w', 'x', 'y', 'z' <br/>
Chiffres :<br/>
'0', '1', '2', '3', '4', '5', '6', '7', '8', '9' <br/>
Ponctuation : <br/>
'-', ',', ';', '!', '?', '\'', '«', '»', '(', ')', '[', ']', '{', '}', '@', '*', '&', '#', '%', '+', '±', '=', '$', ':', '.', '/' <br/>
Si une lettre est manquante, la remplacer par un svg dont l'attribut 'd' de la balise <path> est vide.<br/>
			Les svg ne doivent comporter qu'une balise <bold>&lt;path&gt;</bold> comprenant un attribut <bold>'d'</bold> contenant l'ensemble des points. Ils doivent aussi être <bold>inversés verticalement</bold> et renommés <bold>de 1.svg à 113.svg</bold>. Enfin, les fichiers (pas le dossier) doivent être compressés dans un <bold>.zip</bold> .
			À partir de fichiers images (ici tiff), il est possible d'automatiser le processus via le terminal (sous macOS ou Linux) :<br/>
			Installer <a href="http://imagemagick.org/" target="_blank">ImageMagick</a> et <a href="http://autotrace.sourceforge.net/">Autotrace</a> puis dans le terminal, taper :<br/>
			<pre>
# 1 -> aller dans le dossier 		
  cd chemin/vers/le/dossier
# 2 -> flip les images
  mogrify -flip  *.tif
# 3 -> Vectoriser le dossier entier
# 3.a -> Pour des images comprenant des courbes :
  for i in *.tif ; do autotrace -background-color=FFFFFF -color-count 2 "$i" -output-file="${i%.*}.svg" ; done
# 3.b -> Pour des images sans courbes :
  for i in *.tif ; do autotrace -background-color=FFFFFF -corner-threshold 360 -color-count 2 "$i" -output-file="${i%.*}.svg" ; done
# 4 -> Renommer le dossier entier de 1.svg à 26.svg
  a=1 
  for i in *.svg; do
    new=$(printf "%2d.svg" ${a}) 
    mv ${i} ${new}
    let a=a+1
  done
# 5 -> Créer un zip : 
  zip svg.zip *.svg 
 			</pre>
 			Toutes les fontes générées sont disponibles à l'adresse <a href="ttf/stock/">http://etienneozeray.fr/ttf/stock/</a>.
		</p>
		<h1>
			 Envoyer le fichier
		</h1>
		<form action="resultat.php" method="post" enctype="multipart/form-data">
			<p>
			    1 --> Le nom de la fonte :
				<input type="text" name="nom" value="SansTitre" required />
			</p>
			<p>
				2 --> Définir le crénage :
				<input type="text" name="crenage" value="510" required />
			</p>
			<p>
				3 --> Définir la hauteur :
				<input type="text" name="hauteur" value="400" required />
			</p>
			<p>
            	4 --> Upload du fichier ZIP :
   				<input type="file" id="file" name="file" multiple="multiple" />
   				<br/><br/>
            	5 --> <input type="submit" value="Clique !" />
            </p>
		</form>
	
	</body>
</html>