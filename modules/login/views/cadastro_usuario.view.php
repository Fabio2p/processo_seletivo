<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form action="?module=login&option=painel-administrativo&view=salvar_dados_cadastro" method="post">
		<label>Nome:</label>
		<input type="text" name="nome" />

		<label>Documento:</label>
		<input type="text" name="documento" />

		<label>Cep:</label>
		<input type="text" name="cep" />
		
		<label>Endereço:</label>
		<input type="text" name="endereco" />
		
		<label>Bairro:</label>	
		<input type="text" name="bairro" />
		
		<label>Cidade:</label>	
		<input type="text" name="cidade" />
		
		<label>UF:</label>	
		<select name="uf">
			<option value="0">UF</option>
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
		<input type="text" name="telefone" />
		
		<label>Email:</label>	
		<input type="text" name="email" />
		
		<label>Ativo:</label>	
		<input type="text" name="ativo" />
		
		<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

		<input type="submit" name="submit" value="Salvar" />

	</form>

</body>
</html>