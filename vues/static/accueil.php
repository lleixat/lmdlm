<?php 
?>


<!DOCTYPE html>

<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<base href="<?php echo URL_BASE; ?>" />
		<meta name="description" content="<?php echo DESCRIPTION ?>">
		<title><?php echo TITLE ?></title>

		<link rel="stylesheet" media="screen" href="css/text.css" />
		<link rel="stylesheet" media="screen" href="css/grid.css" />

		<link href="favicon.png" rel="shortcut icon" />

		<script src="js/jquery-1.6.4.min.js"></script>


	</head>
	<body>

		<div id="conteneur">

			<?php
			require LAYOUT_HEADER;
			require LAYOUT_NAV;
			?>

			<div id="content">
				<h2 class="titre_page">Bienvenue !</h2>
				<h3>Deux-trois changements</h3>
				<h4>Ajout de la page <a href="news.html">news</a></h4>
					<p>Qui devra regrouper à terme les derniers trucs tout frais.</p>
					<p>Redirection automatique après connexion vers cette page et non plus vers la page <u>Accueil</u>.</p>
				<h4>La Roadmap</h4>	
				<p>La <a href="tdo.html">Roadmap</a> devrai faire relais de ce qui change ici... ma todo-list et pleine... et la votre ? </p>
				<h4>Le Dico</h4>
				<p>J'ai ajouté quelques mots dans le dico.</p>
				<h4>What else ?</h4>
				<p>Recrutons des joueurs !</p>
				<p class="embed_block">Deux-trois et d'autres à venir... Peut être</p>
			</div>

			<?php
			require LAYOUT_FOOTER;
			?>
		</div>
	</body>
</html>
