<!DOCTYPE html>
<html>
    <head>

        <title><?= $view_title; ?></title>

        <meta charset="utf-8">
        
        <link rel="stylesheet" type="text/css" href="<?= BASE_SITE ?>/css/style.css" />

    </head>

    <body>
    	<div class="container">
    		
    		<div class="form-header">

    			<div class="container-welcome">
    					
    				Olá <b><?= $view_nome_do_usuario; ?></b> seja bem vindo

    			</div>

    			<div class="container-cadastro">

    				<a href="?module=login&option=painel-administrativo&view=cadastra_usuario">
    					Cadastrar usuário
    				</a>
    				
    			</div>

    			<div class="container-logout">
		       		 
		       		 <a href="?module=login&option=pagina-de-login&view=sair-do-sistema&session=<?=base64_encode(md5(session_id()));?>">Sair</a>

		       	</div>

    			<div class="containe-form-body">

			        <form class="xml-importa"  enctype="multipart/form-data" action="?module=login&option=painel-administrativo&view=importacao-xml" method="post" name="importar_xml">
			        	
			        	<input type="file" name="importar_xml" />

			        	<input type="hidden" name="token" class="input-file" value="<?$_SESSION['token']?>" />

			        	<input type="submit" class="input-submt" name="submit" value="importar Xml">

			        </form>

			    </div>    

		    </div> 

		    <div class="form-edicao">
		    	

		    	<div class="emvia-email-usuario">
		    		<a href="?module=login&option=painel-administrativo&view=enviar_email">Enviar E-mail</a>
		    	</div>
		    </div>   

		    <div class="container-data">
		    	
		    	<table class="table">

		    		<thead class="border-bottom">
		    		
		    			<th>Id</th>
		    			
		    			<th>Nome</th>
		    			
		    			<th>Nº Documento</th>
		    			
		    			<th>Cep</th>
		    			
		    			<th>Endereço</th>
		    			
		    			<th>Bairro</th>
		    			
		    			<th>Cidade</th>
		    			
		    			<th>UF</th>
		    			
		    			<th>Telefone</th>
		    			
		    			<th>E-mail</th>
		    			
		    			<th>Ativo</th>

		    			<th>Editar usuário</th>
		    			
		    		</thead>

		    		<tbody>
		    			
		    		
		    			<?php if($view_exibe_registros): ?>

		    						
			    			<?php foreach($view_exibe_registros as $i=> $item):?>

			    				<?php if($i % 2 == 0): 

			    					$hover = "hover";

			    				else:

			    					$hover = "no-hover";

			    				endif;?>
			    						
			    				<tr class="<?= $hover; ?>">	

			    					<td width="3%" id="<?= $item->id; ?>"><?= $item->id; ?></td>

			    					<td width="15%"><?= $item->nome; ?></td>

			    					<td width="10%"><?= $item->documento; ?></td>

			    					<td width="10%"><?= $item->cep; ?></td>

			    					<td width="10%"><?= $item->endereco; ?></td>

			    					<td width="10%"><?= $item->bairro; ?></td>

			    					<td width="10%"><?= $item->cidade; ?></td>

			    					<td width="2%"><?= $item->uf; ?></td>

			    					<td width="7%"><?= $item->telefone; ?></td>

			    					<td width="10%"><?= $item->email; ?></td>

			    					<td width="1%"><?= $item->ativo; ?></td>

			    					<td>
			    						<a href="?module=login&option=painel-administrativo&view=editar&id=<?= $item->id; ?>"">Editar</a>
			    					</td>
			    				</tr>

			    			<?php endforeach;?>		

			    	<?php endif; ?>		
		    		
		    		</tbody>

		    	</table>

		    </div>

     </div>   

	<script src="<?= BASE_SITE?>/js/jquery.js"></script>
	
	<script src="<?= BASE_SITE?>/js/requisicao.js"></script>

	</script>


    </body>

</html>