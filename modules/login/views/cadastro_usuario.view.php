<!DOCTYPE html>
<html>
<head>
	<title><?= $view_title;?></title>

	 <link rel="stylesheet" type="text/css" href="<?= BASE_SITE ?>/css/style.css" />
</head>
<body>

	<div class="containet">

	<form action="?module=login&option=painel-administrativo&view=salvar_dados_cadastro" method="post" class="cadastro-usuario">

		<h2>Formulário de Cadastro</h2>

		<hr />

		<label>Nome:</label>
		<input type="text" name="nome" class="cadastro-input" />

		<label>Documento:</label>
		<input type="text" name="documento" class="cadastro-input" />

		<label>Cep:</label>
		<input type="text" name="cep" class="cadastro-input" />
		
		<label>Endereço:</label>
		<input type="text" name="endereco" class="cadastro-input" />
		
		<label>Bairro:</label>	
		<input type="text" name="bairro" class="cadastro-input" />
		
		<label>Cidade:</label>	
		<input type="text" name="cidade" class="cadastro-input" />
		
		<label>UF:</label>	
		<select name="uf" class="cadastro-input">

			<option value="">UF</option>

			<option value="DF">DF</option>
			
			<option value="AC">AC</option>
			
			<option value="AL">AL</option>
			
			<option value="AM">AM</option>
			
			<option value="AP">AP</option>
			
			<option value="BA">BA</option>
			
			<option value="CE">CE</option>
			
			<option value="ES">ES</option>
			
			<option value="GO">GO</option>
			
			<option value="MA">MA</option>
			
			<option value="MT">MT</option>
			
			<option value="MS">MS</option>
			
			<option value="MG">MG</option>
			
			<option value="PA">PA</option>
			
			<option value="PB">PB</option>
			
			<option value="PR">PR</option>
			
			<option value="PE">PE</option>
			
			<option value="PI">PI</option>
			
			<option value="RJ">RJ</option>
			
			<option value="RN">RN</option>
			
			<option value="RS">RS</option>
			
			<option value="RO">RO</option>
			
			<option value="RR">RR</option>
			
			<option value="SC">SC</option>
			
			<option value="SP">SP</option>
			
			<option value="SE">SE</option>
			
			<option value="TO">TO</option>

		</select>
		
		<label>Telefone:</label>	
		<input type="text" name="telefone" class="cadastro-input" />
		
		<label>Email:</label>	
		<input type="text" name="email" class="cadastro-input" />
		
		<label>Ativo:</label>	
		<input type="text" name="ativo" />
		
		<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

		<input type="submit" name="submit" value="Salvar" class="cadastro-input cadastro-submit" />

	</form>

</div>

<script src="<?= BASE_SITE?>/js/jquery.js"></script>
	
<script type="text/javascript">
	jQuery(function(){

	jQuery(".cadastro-submit").click(function(){
		
		var nome = jQuery('input[name="nome"]').val();
		
		var documento = jQuery('input[name="documento"]').val();
		
		var cep = jQuery('input[name="cep"]').val();
		
		var endereco = jQuery('input[name="endereco"]').val();
		
		var bairro = jQuery('input[name="bairro"]').val();
		
		var cidade = jQuery('input[name="cidade"]').val();
		
		var uf = jQuery('input[name="uf"]').val();
		
		var telefone = jQuery('input[name="telefone"]').val();
		
		var email = jQuery('input[name="email"]').val();
		
		var ativo = jQuery('input[name="ativo"]').val();
		
		if(nome.length == ""){

			alert('Campo "[ Nome ]" Obrigatório!');


			return false;
		}

		if(documento.length == ""){

			alert('Campo "[ Documento ]" Obrigatório!');


			return false;
		}

		if(cep.length == ""){

			alert('Campo "[ Cep ]" Obrigatório!');


			return false;
		}

		if(endereco.length == ""){

			alert('Campo "[ Endereço ]" Obrigatório!');


			return false;
		}

		if(bairro.length == ""){

			alert('Campo "[ Bairro ]" Obrigatório!');


			return false;
		}

		if(cidade.length == ""){

			alert('Campo "[ Cidade ]" Obrigatório!');


			return false;
		}

		if(uf.length == ""){

			alert('Campo "[ UF ]" Obrigatório!');


			return false;
		}

		if(telefone.length == ""){

			alert('Campo "[ telefone ]" Obrigatório!');


			return false;
		}

		if(email.length == ""){

			alert('Campo "[ Email ]" Obrigatório!');


			return false;
		}

		if(ativo.length == 0){

			alert('Campo "[ Ativo ]" Obrigatório!');


			return false;
		}

	});

});
</script>


</body>
</html>