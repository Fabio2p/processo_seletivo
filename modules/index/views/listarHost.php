<pre>
<?php //print_r($hostIdZabbix->result);?>

</pre>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<style type="text/css">

	.btn.btn-link, .btn.btn-default.btn-link {
    
    	color: ##3498db !important;

    	text-transform: unset !important;
   
	}

	.btn.btn-link:hover{
    
    	color: #000 !important;

    	text-transform: unset !important;
   
	}
</style>


<div class="container mb-5" style="background: #fff;">
	
	<table class="table">
  <thead>
    <tr>
      <th scope="col"><strong>Nome do Host</strong></th>
      <th scope="col"><strong><a href="#">Grupo de Host</a></strong></th>
      <th scope="col"><strong><a href="#">Templates</a></strong></th>
      <th scope="col"><strong><a href="#">Aplicações</a></strong></th>
      <th scope="col"><strong><a href="#">Itens</a></strong></th>
      <th scope="col"><strong><a href="#">Triggers</a></strong></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php foreach($hostIdZabbix->result as $i => $opcoesHost):?>

      	<td scope="row"><?=$opcoesHost->name; ?></td>

      	<td>
      		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#grupodehost">
  				<?= "Grupo de Host (".count($opcoesHost->groups).")"; ?>
  			</button>
		</td>
      	
      	<td>
      		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#templates">
      			<?= "Templates (".count($opcoesHost->parentTemplates) .")"; ?>
      		</button>
      	</td>
      	
      	<td>
      		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#applications">
      		<?= "Aplicações (".count($opcoesHost->applications).")"; ?></button>
      	</td>
      	
      	<td>
      		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#items">
      		<?= "Itens (".count($opcoesHost->items).")"; ?>		
      		</button>
      	</td>
      	
      	<td>
      		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#triggers">
      			<?= "Triggers (".count($opcoesHost->triggers) .")"; ?>
      		</button>
      	</td>

      <?php endforeach;?> 	
    </tr>
    
  </tbody>
</table>


<a href="<?php echo BASE_URL ?>/<?php echo $modulo ?>/monitoramento/ramificacao/<?php echo $id_empresa_edicao?>" class="btn btn-primary">Voltar</a>
</div>

<!--OPÇÕES GRUPOS DE HOSTS -->
<div class="modal fade" id="grupodehost" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OPÇÕES: GRUPOS DE HOSTS<hr></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<table class="table">
			<thead>
		    <tr>
		      
		      <th><strong>Id</strong></th>
		      
		      <th><strong>Grupo</strong></th>
		      
		      <th><strong>Ação</strong></th>

		    </tr>

		  </thead>
		  <tbody>
	  
	      	<?php foreach($opcoesHost->groups as $opcoesGruposHosts):?>

	      		<tr>
			      	<td scope="row"><?= $opcoesGruposHosts->groupid; ?></td>
			      	
			      	<td scope="row"><?= $opcoesGruposHosts->name; ?></td>

			      	<td>
			      		<a href="#" class="disabled">Ativo</a>
			      	</td>

		      </tr>

	      	<?php endforeach;?> 


		  </tbody>
		</table>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- FIM GRUPOS DE HOSTS-->

<!--OPÇÕES TEMPLATES -->
<div class="modal fade" id="templates" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OPÇÕES: TEMPLATES<hr></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<table class="table">
			<thead>
		    <tr>
		      
		      <th><strong>Id</strong></th>
		      
		      <th><strong>NOME</strong></th>
		      
		      <th><strong>Ação</strong></th> 

		    </tr>

		  </thead>
		  <tbody>
		   
	      	<?php foreach($opcoesHost->parentTemplates as $parentTemplates):?>

	      		<tr>
			      	<td scope="row"><?= $parentTemplates->templateid; ?></td>
			      	
			      	<td scope="row"><?= $parentTemplates->name; ?></td>

			      	<td>
			      		<a href="<?php echo BASE_URL?>/<?php echo $modulo?>/monitoramento/desassociamentoTemplateApiZabbix/<?php echo $id_empresa_edicao?>/<?php echo $parentTemplates->templateid; ?>/<?= $opcoesHost->hostid ?>">Desassociar</a>
			      	</td>

		      </tr>

	      	<?php endforeach;?> 

		  </tbody>
		</table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!--FIM OPÇÕES DE TEMPLATES -->


<!--OPÇÕES 	APLICAÇÕES -->
<div class="modal fade" id="applications" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OPÇÕES: APLICAÇÕES<hr></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<table class="table">
			<thead>
		    <tr>
		      
		      <th><strong>Id</strong></th>
		      
		      <!--<th><strong>TEMPLATE</strong></th> -->

		      <th><strong>NOME</strong></th>
		      
		      <th><strong>Ação</strong></th>	      

		    </tr>

		  </thead>
		  <tbody>

		     <?php foreach($opcoesHost->applications as $applications):?>

	      		<tr>
			      	<td scope="row"><?= $applications->applicationid; ?></td>

			      	<!--<td scope="row"><?php //echo $parentTemplates->name; ?></td> -->
			      	
			      	<td scope="row"><?= $applications->name; ?></td>

			      	<td>
			      		<a href="#">Ativo</a>
			      	</td>

		      </tr>

		      <?php endforeach;?> 

		  </tbody>
		</table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!--FIM OPÇÕES DE 	APLICAÇÕES -->


<!--OPÇÕES 	ITENS -->
<div class="modal fade" id="items" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OPÇÕES: ITENS<hr></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<table class="table">
			<thead>
		    <tr>
		      
		      <th><strong>Id</strong></th>
		      
		      <th><strong>NOME</strong></th>
		      
		      <th><strong>Ação</strong></th>

		    </tr>

		  </thead>
		  <tbody>

		     <?php foreach($opcoesHost->items as $items):?>

	      		<tr>
			      	<td scope="row"><?= $items->itemid; ?></td>
			      	
			      	<td scope="row"><?= $items->name; ?></td>

			      	<td>
			      		<a href="#" class="disabled">Ativo</a>
			      	</td>

		      </tr>

		     <?php endforeach;?> 

		  </tbody>
		</table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!--FIM OPÇÕES DE 	ITENS -->



<!--OPÇÕES 	TRIGGERS -->
<div class="modal fade" id="triggers" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OPÇÕES: TRIGGERS<hr></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
 
		<table class="table">
			<thead>
		    <tr>
		      
		      <th><strong>Id</strong></th>
		      
		      <th><strong>NOME</strong></th>
		      
		      <th><strong>Ação</strong></th>

		    </tr>

		  </thead>
		  <tbody>

		     <?php foreach($opcoesHost->triggers as $triggers):?>

	      		<tr>
			      	<td scope="row"><?= $triggers->triggerid; ?></td>
			      	
			      	<td scope="row"><?= $triggers->description; ?></td>

			      	<td>
			      		<a href="#" class="disabled">Ativo</a>
			      	</td>

		      </tr>

		    <?php endforeach;?> 

		  </tbody>
		</table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!--FIM OPÇÕES DE 	TRIGGERS -->