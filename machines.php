<?php require_once('cfg/core.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?></title>
	<!-- Chart API -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" defer></script>
	<?php require_once('header-front.php'); ?>
</head>
<body>
	<?php require_once('menu.php'); ?>

	<main>
		<?php
			$pagename = explode('.', $_GET['pagename'])[0];

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("SELECT * FROM machines WHERE mac_pagename = ? LIMIT 1")){
				try{
					$stmt->bind_param('s', $pagename);
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				var_dump($row);
			}
		?>
	</main>

	<?php require_once('footer.php'); ?>
</body>
</html>