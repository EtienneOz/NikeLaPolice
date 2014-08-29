NikeLaPolice
============

Destroy fonts and make ttf.<br/>
Un projet de Lucas Lejeune & Étienne Ozeray.<br/>
Voir les specimens des fontes générées : [http://etienneozeray.fr/svg2ttf/specimens](http://etienneozeray.fr/svg2ttf/specimens)

1 --> PureData permet de déformer la fonte (ici Terminus) à partir d'un flux vidéo.<br/>
Voir les commentaires dans le fichier patch1.pd<br/>
Lancer ensuite l'exportation de chaque lettre en format tiff<br/><br/>

2 --> Préparation des fichier pour les convertir en ttf<br/>
Utilisation du php pour créer un fichier svg font contenant chaque caractère qui est ensuite converti en ttf via l'api de <a href="http://onlinefontconverter.com/" target="_blank">Online Font Converter</a>.<br/>
Le dossier de svg doit comporter, dans l'ordre, les lettres suivantes :<br/>
	Capitales --> 'A', 'À', 'Æ', 'B', 'C', 'D', 'E', 'É', 'È', 'Ê', 'Ë', 
	'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'Ô', 
	'Ö', 'Œ', 'P', 'Q', 'R', 'S', 'T', 'U', 'Ù', 'Û', 'Ü', 
	'V', 'W', 'X', 'Y', 'Z' <br/>
	 Bas-de-casse --> 'a', 'à', 'æ', 'b', 'c', 'ç', 'd', 'e', 'é', 'è', 'ê', 
	'ë', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 
	'ô', 'ö', 'œ', 'p', 'q', 'r', 's', 't', 'u', 'ù', 'û', 
	'ü', 'v', 'w', 'x', 'y', 'z' <br/>
	 Chiffres --> '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' <br/>
	 Ponctuation --> '-', ',', ';', '!', '?', '\'', '«', '»', '(', ')', '[', 
	']', '{', '}', '@', '\*', '&amp;', '#', '%', '+', '±', '=', 
	'$', ':', '.', '/' <br/>
Si une lettre est manquante, la remplacer par un svg dont l'attribut 'd' de la balise &lt;path&gt; est vide.
Chaque svg ne doit comporter qu'une balise  &lt;path&gt; comprenant un attribut 'd' contenant l'ensemble des points. Ils doivent aussi être inversés verticalement et renommés de 1.svg à 26.svg. Enfin, compresser dans un .zip l'ensemble des svg (pas le dossier).
À partir de fichiers tiff, il est possible d'automatiser le processus via le terminal (sous macOS ou Linux) :<br/>
Installer <a href="http://imagemagick.org/" target="_blank">ImageMagick</a> et <a href="http://autotrace.sourceforge.net/">Autotrace</a> puis dans le terminal, taper :<br/>
	<pre>
	# 1 -> aller dans le dossier 		
	  cd chemin/vers/le/dossier
	# 2 -> flip les images
	  mogrify -flip  *.tif
	# 3 -> Vectoriser le dossier entier
	# 3.a -> Pour des images comprenant des courbes :
	  for i in *.tif ; do 
	    autotrace \
	  	  -background-color=FFFFFF \
	  	  -color-count 2 \
	  	  "$i" -output-file="${i%.*}.svg" ; 
	  done
	# 3.b -> Pour des images sans courbes :
	  for i in *.tif ; do 
	  	autotrace \
	  	  -background-color=FFFFFF \
	  	  -corner-threshold 360 \
	  	  -color-count 2 \
	  	  "$i" -output-file="${i%.*}.svg" ; 
	  done
	# 4 -> Renommer le dossier entier de 1.svg à 26.svg
	  a=1 
	  for i in *.svg; do
	    new=$(printf "%2d.svg" ${a})
	    mv ${i} ${new}
	    let a=a+1
	   done
	# 5 -> Créer un zip : 
	  zip svg.zip *.svg 
 	</pre><br/><br/>


3 --> Utiliser ensuite le formulaire de index.php<br/>
Une version en ligne est disponible à l'adresse <a href="http://etienneozeray.fr/svg2ttf" target="_blank">http://etienneozeray.fr/svg2ttf</a><br/><br/>

4 --> (optionnel) Les fichiers ttf pouvant peser très lourds, utiliser le script python Simplify de FontForge pour supprimer les points vectoriels en trop.


To do :
=======
• Inverser et centrer les glyphes, voir screenshot 3. (une solution temporaire est utilisée en inversant les svg en amont) ;<br/>
• Empecher de nommer la fonte avec un nom existant (pour l'archivage) ;<br/>
• Se passer de l'API parfois defectueuse en utilisant les scripts python de FontForge ;<br/>
• Prendre en charge les autres formats de compression ;<br/>
• Prendre en charge les alphabets incomplets ;<br/>
• Prendre en charge les fontes à chasse variable ;<br/>

## Specimen

![specimen](https://github.com/EtienneOz/NikeLaPolice/blob/master/Specimens/specimen.jpg)


## License

NikeLaPolice is under [The Artistic License 2.0](https://github.com/EtienneOz/NikeLaPolice/blob/master/LICENSE) for the whole project.
The tool SVG2TTF is under [GNU GPL V3 License](https://github.com/EtienneOz/SvgToTtf/blob/master/LICENSE). [Here](https://github.com/EtienneOz/SvgToTtf/tree/master) is his own Git.
