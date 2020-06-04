<pre>
	<?php //print_r($regras_lista_hosts->result);?>
</pre>
<!doctype html>
<html lang="pt-Br">
  <head>
<script src="http://host.local.dev-sys/assets/js/jquery.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  </head>
  <body>

<div class="container">   
	<form method="POST" id="regras" action="http://host.local.dev-sys/index/home/interacao" name="regras">
	<div class="row mt-5">
		<div class="col-12">
			<!-- Regras aplicada ao template -->
			<div class="form-group">
				<select class="form-control" name="itTemplate[]" id="itTemplate" multiple="true">
					<option value="0">Selecione um Equipamento</option>
					<?php foreach($regras_lista_template->result as $h => $dadosTemplate):?>

						<option value="<?php echo $dadosTemplate->templateid; ?>"><?php echo $dadosTemplate->name; ?></option>

					<?php endforeach;?>	
				</select>
			</div>
			<!--Fim das regras aplicada -->

			<div class="form-group">
				<select class="form-control" name="GruposHost[]" id="GruposHost" multiple="true">
					<option value="0">Selecione um Grupo</option>
					<?php foreach($regras_lista_hosts->result as $h => $host):?>

						<option value="<?php echo $host->groupid; ?>"><?php echo $host->name; ?></option>

					<?php endforeach;?>	
				</select>
			</div>

		</div>
		</div>
		<input type="submit" name="Enviar">
		</form>	
  </body>
</html>