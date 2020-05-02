<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/css/style.css" />
</head>
<body>
	
	<div class="container">
	
	<div class="container_form">

		<form method="post">
			 
			<div class="input">
				
				<label>Login</label>
				
				<input type="text" name="email">

				<label>Senha</label>
				
				<input type="password" name="password">
                <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
				<input type="hidden" name="ipExterno" value="<?= $ipExterno; ?>">		
				<input type="submit" value="Acessar" class="btn-submit" />
				
				<?php if(isset($error)):?>

					<?php echo $error; ?>

				<?php endif;?>	
			</div>
		</form>

	</div>
	
</body>
</html>