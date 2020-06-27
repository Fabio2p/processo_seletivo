<pre>
	<?php //print_r($regras_lista_hosts->result);?>
</pre>
<!doctype html>
<html lang="pt-Br">
  <head>
<script src="https://host.local.dev-sys/assets/js/jquery.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>

  </head>
  <body>

<div class="container">   
	<form method="POST" id="regras" action="https://host.local.dev-sys/index/home/AtualizaEquipamentos" name="regras">
	<div class="row mt-5">
		<div class="col-12">
			<!-- Regras aplicada ao template -->
			<div class="form-group">
				<select class="form-control itTemplate" name="itTemplate[]" id="itTemplate"  multiple="multiple">
					

					<?php foreach($regras_lista_template->result as $h => $dadosTemplate):?>

							<?php if(@$compara_selecao[$h]):?>

								<option selected="selected" value="<?php echo $dadosTemplate->templateid; ?> ">
									<?php echo $dadosTemplate->name; ?>		
								</option>

							<?php else: ?>

								<option value="<?php echo $dadosTemplate->templateid; ?> ">
									<?php echo $dadosTemplate->name; ?>		
								</option>

							<?php endif; ?>

					<?php endforeach;?>	
				</select>
			</div>
			<!--Fim das regras aplicada -->

		</div>
		</div>
		<input type="submit" name="Enviar">
		</form>	

	<script type="text/javascript">
		$(document).ready(function() {
		    $('.itTemplate').select2({placeholder: 'Selecione um Equipamento'});
		});

	</script>	
  </body>
</html>