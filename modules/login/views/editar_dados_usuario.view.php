<!DOCTYPE html>
<html>
<head>
	<title><?= $view_title;?></title>

	<link rel="stylesheet" type="text/css" href="<?= BASE_SITE ?>/css/style.css" />
</head>
<body>
	<div class="containet">

	<form action="?module=login&option=painel-administrativo&view=salvar_dados_edita" method="post" class="cadastro-usuario">

		<h2>Editar Usuário</h2>

		<hr />
	
		<?php foreach($view_lista_objeto as  $item):?>
			<label>Id:</label>
			<input type="text" name="id" value="<?php echo $item->id; ?>" readonly="readonly" class="cadastro-input"/>

			<label>Nome:</label>
			<input type="text" name="nome" value="<?php echo $item->nome; ?>" class="cadastro-input" />

			<label>Documento:</label>
			<input type="text" name="documento" value="<?php echo $item->documento; ?>" class="cadastro-input" />

			<label>Cep:</label>
			<input type="text" name="cep" value="<?php echo $item->cep; ?>" class="cadastro-input" />
			
			<label>Endereço:</label>
			<input type="text" name="endereco" value="<?php echo $item->endereco; ?>" class="cadastro-input" />
			
			<label>Bairro:</label>
			<input type="text" name="bairro" value="<?php echo $item->bairro; ?>" />
			
			<label>Cidade:</label>
			<input type="text" name="cidade" value="<?php echo $item->cidade; ?>" class="cadastro-input" />
			
			<label>UF:</label>
			<input type="text" name="uf" value="<?php echo $item->uf; ?>" class="cadastro-input" />
			
			<label>Telefone:</label>
			<input type="text" name="telefone" value="<?php echo $item->telefone; ?>" class="cadastro-input" />
			
			<label>E-mail:</label>
			<input type="text" name="email" value="<?php echo $item->email; ?>" class="cadastro-input" />
			
			<label>Status:</label>
			<input type="text" name="ativo" value="<?php echo $item->ativo; ?>"  />
		

		<?php endforeach;?>	

		<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

		<input type="submit" name="submit" value="Editar Dados" class="cadastro-input cadastro-submit" />

	</form>
</body>
</html>