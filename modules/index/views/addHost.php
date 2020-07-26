
<!doctype html>
<html lang="pt-Br">
  <head>
<script src="https://host.local.dev-sys/assets/js/jquery.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  </head>
  <body>

<div class="container">   

	<div id="retorno_msg"></div>

	<form method="POST" id="addHost" name="regras">
	<div class="row mt-5">

		<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Adicionar Regra">
			</div>

		<div class="col-sm-3">
			<div class="form-group">
				<label>Host</label>
				<input class="form-control" type="text" id="equipamento" name="equipamento">
			</div>

			<div class="form-group">
				<label>Nome Visível</label>
				<input class="form-control" type="text" id="nome" name="nome">
			</div>

			<div class="form-check">
				<input type="radio" class="form-check-input" id="interface" value="1" name="interface">Ip
			</div>	

			<div class="form-check mb-4">
				<input type="radio" class="form-check-input" id="interface" value="0" name="interface">Dns
			</div>	

			<div class="form-group">
				<label>dns</label>
				<input class="form-control" type="text" id="dns" name="dns">
			</div>

			<div class="form-group">
				<label>ip</label>
				<input class="form-control" type="text" id="ip" name="ip">
			</div>

			
			<!-- Regras aplicada ao template -->
			<div class="form-group">
					<label>Template:</label><br>
					<?php foreach($regras_lista_template->result as $h => $dadosTemplate):?>

						<input type="checkbox" name="template" id="template" value="<?=$dadosTemplate->templateid;?>"><?=$dadosTemplate->name; ?><br><br>

					<?php endforeach;?>	
				
			</div><br>
			<!--Fim das regras aplicada -->

			<div class="form-group">
					<label>Grupos</label><br>
					<?php foreach($grupos->result as $h => $host):?>

						<input type="checkbox" name="grupos" id="grupos" value="<?=$host->groupid;?>"><?=$host->name?><br><br>

					<?php endforeach;?>	
				
			</div>

		</div>

		
	</div>

</form>
</div>


<script type="text/javascript">
	jQuery(function(){

		jQuery("form#addHost").submit(function(){

			let template 		= jQuery("#template").val();

			let grupos 			= jQuery("#grupos").val();

			let equipamento     = jQuery("#equipamento").val();

			let nome    		= jQuery("#nome").val();

			let dns     		= jQuery("#dns").val();
			
			let ip     			= jQuery("#ip").val();

			let interface     			= jQuery("#interface").val();
			
			jQuery.ajax({

				type: 'POST',

				url	  : 'http://host.local.dev-sys/index/addHost/salvaHost',

				data: {equipamento:equipamento, nome:nome, template:template, grupos:grupos,dns:dns, ip:ip,interface:interface},

				success: function(response){

					if(response.error == false){

						location.reload();

						limpaFromulario();
						
						console.log(response.mensagem);

						jQuery("#retorno_msg").html(response.mensagem);

					}else{
						
						console.log(response.mensagem);

						jQuery("#retorno_msg").html(response.mensagem);
					}		
				
				},

				error: function (xhr, ajaxOptions, thrownError) {

					jQuery("#retorno_msg").html("Falha ao conectar com o Appliance!");

			    }


			});


			return false;
		});

		

		function limpaFromulario(){
   		 	
   		 	$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    		
    		$(':checkbox, :radio').prop('checked', false);
		}

	});
</script>