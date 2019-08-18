<!DOCTYPE html>
<html>
<head>
	<title><?= $view_title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?= BASE_SITE ?>/css/style.css" />
</head>
<body>


	<div class="containet">
		<form action="?module=login&option=painel-administrativo&view=email_enviado" method="post" class="cadastro-usuario">

			<h2>Enviar E-mail</h2>

		<hr />

			<label>Para:</label>
			<input type="text" name="envia_email" class="cadastro-input">

			<textarea name="envia_texto" class="email-textarea">
				
			</textarea>

			<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
			<input type="submit" name="btn_envia" value="Enviar" class="cadastro-input cadastro-submit" />

		</form>

	</div>	

	<script src="<?= BASE_SITE?>/js/jquery.js"></script>
	
	<script type="text/javascript">
		jQuery(function(){

			jQuery(".cadastro-submit").click(function(){

				var email = jQuery('input[name="envia_email"]').val();
				
				var nome = jQuery('input[name="nome"]').val();
				

				if(email.length == ""){

					alert('Campo "[ Para ]" Obrigatório!');


					return false;
				}

				if(nome.length == ""){

					alert('Campo "[ Nome ]" Obrigatório!');


					return false;
				}

			});

		});
	</script>

</body>
</html>