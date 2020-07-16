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

  </head>
  <body>

<div class="container">   
	<form method="POST" id="regras" name="regras">
	<div class="row mt-5">
		<div class="col-sm-3">
			<!-- Regras aplicada ao template -->
			<div class="form-group">
				<select class="form-control" name="rnTemplate" id="rnTemplate">
					<option value="0">Selecione um Equipamento</option>
					<?php foreach($regras_lista_template->result as $h => $dadosTemplate):?>

						<option value="<?php echo $dadosTemplate->templateid; ?>"><?php echo $dadosTemplate->host; ?></option>

					<?php endforeach;?>	
				</select>
			</div>
			<!--Fim das regras aplicada -->

			<div class="form-group">
				<select class="form-control" name="equipamento" id="equipamento">
					<option value="0">Selecione um Equipamento</option>
					<?php foreach($regras_lista_hosts->result as $h => $host):?>

						<option value="<?php echo $host->hostid; ?>"><?php echo $host->host; ?></option>

					<?php endforeach;?>	
				</select>
			</div>

			<select name="severidade" id="severidade" class="form-control mb-4">
				<option value="0">Nenhuma</option>
				<option value="2">Informação</option>
				<option value="3">Alerta</option>
				<option value="5">Desastre</option>
			</select>

			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="rnCliente" name="rnCliente">Cliente
			</div>	

			<div class="form-check mb-4">
				<input type="checkbox" class="form-check-input" id="rnEmpresa" name="rnEmpresa">Empresa
			</div>	

			<div class="form-group">
				<label>Notificar Cliente:</label>
				<input class="form-control" type="text" id="tempoNotificaCliente" name="tempoNotificaCliente">
			</div>

			<div class="form-group">
				<label>Notificar Empresa:</label>
				<input class="form-control" type="text" id="tempoNotificaEmpresa" name="tempoNotificaEmpresa">
			</div>

			<div class="form-group">
				<label>Renotificação</label>
				<input class="form-control" type="text" id="renotificacao" name="renotificacao">
			</div>

			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Adicionar Regra">
			</div>
		</div>

		<div class="col-md-4">
			
			<table class="table table-hover">
				<thead>
					<th><input type="checkbox" name="todos" id="todos"></th>
					<th>Id</th>
					<th>Nome</th>
				</thead>

				<tbody id="teste">
				</tbody>
			</table>

			<div id="exibe"></div>
		</div>
	</div>

</form>
</div>



<script type="text/javascript">
	
	jQuery(function(){

		jQuery("#equipamento").change(function(){

			//let id = 1;

			let idHost = jQuery(this).val();

			jQuery.get("https://host.local.dev-sys/index/home/getRegrasTriggers/"+idHost, function(h){

			var objHost = jQuery.parseJSON(h);
                
                jQuery("#teste").empty();      	 
                       
                jQuery.each(objHost, function(i, listItem){

                 jQuery("#teste").prepend('<tr><td><input type="checkbox" name="cbs[]" value="'+listItem.triggerid+'" class="selecionado"></td>'+'<td>'+listItem.triggerid+'</td><td class="descricao">'+listItem.description+'</td></tr>');

                 //console.log(listItem.description);

                });


			});

		}); // fim do changes

		//@Regras aplicada ao template
		jQuery("#rnTemplate").change(function(){

			//let id = 1;

			let idHost = jQuery(this).val();

			jQuery.get("https://host.local.dev-sys/index/home/getRegrasTriggers/"+idHost, function(h){

			var objHost = jQuery.parseJSON(h);
                
                jQuery("#teste").empty();      	 
                       
                jQuery.each(objHost, function(i, listItem){

                 jQuery("#teste").prepend('<tr><td><input type="checkbox" name="cbs[]" value="'+listItem.triggerid+'" class="selecionado"></td>'+'<td>'+listItem.triggerid+'</td><td class="descricao">'+listItem.description+'</td></tr>');

                 //console.log(listItem.description);

                });


			});

		}); // fim do changes

		//@Fim das regras aplicada ao template

		jQuery("form[name='regras']").submit(function(){

			var checkeds 			 	= new Array();

			let equipamento 		 	= jQuery("#equipamento").val();

			//@paga o id do templare
			let rnTemplate 				= jQuery("#rnTemplate").val();

			let severidade  		 	= jQuery("#severidade").val();

			let tempoNotificaCliente   	= jQuery("#tempoNotificaCliente").val();

			let tempoNotificaEmpresa   	= jQuery("#tempoNotificaEmpresa").val();

			let renotificacao   	 	= jQuery("#renotificacao").val();

			//Verifica se a opção notifica cliente está selecionado
			if(jQuery("#rnCliente").is(":checked")){


				var rnCliente = 1;

			}else{

				var rnCliente = 0;
			}

			//Verifica se a opção notifica Empresa está selecionado
			if(jQuery("#rnEmpresa").is(":checked")){


				var rnEmpresa = 1;

			}else{

				var rnEmpresa = 0;
			}

			jQuery("input[name='cbs[]']:checked").each(function (){
			   
			   checkeds.push( jQuery(this).val());
			});
			 
			jQuery.ajax({
			  
			  type: "POST",
			  
			  url: "https://host.local.dev-sys/index/home/salvar",

			  data: {rnTemplate:rnTemplate,equipamento:equipamento,severidade:severidade,rnCliente:rnCliente,rnEmpresa:rnEmpresa,tempoNotificaCliente:tempoNotificaCliente,tempoNotificaEmpresa:tempoNotificaEmpresa,renotificacao:renotificacao, 'checkeds':checkeds},
			  
			  success: function(data){

			    //console.log(data);

			    jQuery("#regras").html(data);
			  }

			}); //Fim ajax

			return false;
		}); // fim submit
		
		//@Marca e desmarca
		jQuery("#todos").on('click',function(){

			jQuery(".selecionado").each(function(){

				if(jQuery(this).prop("checked")){

					 jQuery(this).prop("checked", false);
			     
				}else{

					jQuery(this).prop("checked", true);
				}
			});	

		});
		// fim da funcionalidade

	});
</script>
  </body>
</html>