<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form action="?module=login&option=painel-administrativo&view=email_enviado" method="post">

		<label>Para:</label>
		<input type="text" name="envia_email">

		<textarea name="envia_texto">
			
		</textarea>

		<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
		<input type="submit" name="btn_envia" value="Enviar" />

	</form>

</body>
</html>