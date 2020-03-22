 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 <table class="table table-hover" id="idGrupoHost">
            <thead>
                <th class="text-center"><strong>Grupo do Host</strong></th>
                <th class="text-center"><strong>Hosts Associado</strong></th>
                <th class="text-center"><strong>Templates Associado</strong></th>
                <th class="text-center"><strong>Editar</strong></th>
                <th class="text-center"><strong>Ativar/Desativar</strong></th>
            </thead>
            <tbody>
            <?php foreach($GruposHosts->result as $i => $listaGrupos):?>
                <tr> 
                    <td class="text-center">
                        <?php echo $listaGrupos->name; ?>
                    </td>
                    <td class="text-center"><?php echo count($listaGrupos->hosts); ?></td>
                    <td class="text-center"><?php echo count($listaGrupos->templates); ?></td>
                    <td class="text-center"><a href="#" class="teste" data-id="edita-<?= $listaGrupos->groupid;?>"> editar</a></td>
                    <td class="text-center">Ativo</td>
                </tr>
            <?php endforeach; ?>
                   
</tbody>
</table>

<script type="text/javascript">
    
   jQuery(function(){

       


        jQuery(".teste").click(function(){

            var edicao = jQuery(this).data('id');

            swal({

                "title": "Edição: Grupo de Host",
                
                "content": "input",

                "input":"text",
                
                "icon": "warning",

                "buttons":{

                    "cancel": "Cancelar",

                    "confirm": "Editar",
                },


            }).then((confirm) => {

                if (confirm) {
                    
                     swal("Alteração cancelada!", confirm);
                     
                } else {
                    
                    swal("Alteração cancelada!");
                }
              
            }); // Fim do then

        }); //Fim do swall

   });

</script>