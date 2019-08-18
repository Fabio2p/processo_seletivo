<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="?module=login&option=painel-administrativo&view=salvar_dados_edita" method="post">
	
		<?php foreach($view_lista_objeto as  $item):?>

			<input type="text" name="id" value="<?php echo $item->id; ?>" readonly="readonly"/>

			<input type="text" name="nome" value="<?php echo $item->nome; ?>" />

			<input type="text" name="documento" value="<?php echo $item->documento; ?>" />

			<input type="text" name="cep" value="<?php echo $item->cep; ?>" />
			
			<input type="text" name="endereco" value="<?php echo $item->endereco; ?>" />
			
			<input type="text" name="bairro" value="<?php echo $item->bairro; ?>" />
			
			<input type="text" name="cidade" value="<?php echo $item->cidade; ?>" />
			
			<input type="text" name="uf" value="<?php echo $item->uf; ?>" />
			
			<input type="text" name="telefone" value="<?php echo $item->telefone; ?>" />
			
			<input type="text" name="email" value="<?php echo $item->email; ?>" />
			
			<input type="text" name="ativo" value="<?php echo $item->ativo; ?>" />
		

		<?php endforeach;?>	

		<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

		<input type="submit" name="submit" value="Editar Dados" />

	</form>
</body>
</html>