<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="http://host.local.dev-sys/assets/js/jquery.js"></script>
	<script src="http://host.local.dev-sys/assets/js/sweetalert.min.js"></script>
</head>
<body>

	<script type="text/javascript">
		
	swal({
	    title: "Are you sure?",
	    text: "Once deleted, you will not be able to recover this record!",
	    type: 'input',
	   
	   	icon: "warning",

	    buttons: true,
	  
	    content: {
		    element: "input",
		    attributes: {
		      placeholder: "Type your password",
		      type: "text",
		      name: 'teste'
		    },
	  }

	}).then((willSalve) => {

	    
	    if (sendData) {

            provedor          = jQuery('input[name="provedor"]').val();

            tipo              = jQuery('input[name="tipo"]').val();

            host              = jQuery('input[name="host"]').val();

            desc              = jQuery('input[name="desc"]').val();

            velocidade        = jQuery('input[name="velocidade"]').val();

            comunicacao       = jQuery('input[name="comunicacao"]').val();

            ddns              = jQuery('input[name="ddns"]').val();

            ip                = jQuery('input[name="ip"]').val();

            sistema           = jQuery('input[name="sistema"]').val();

            marca             = jQuery('input[name="marca"]').val();

            modelo             = jQuery('input[name="modelo"]').val();

            circuito          = jQuery('input[name="circuito"]').val();

            mascara           = jQuery('select[name="mascara"]').val();

            equipObs          = jQuery('input[name="equipObs"]').val();

            nomeVisivelhost   = jQuery('input[name="nomeVisivelhost"]').val();

            dnsHost           = jQuery('input[name="dnsHost"]').val();

            portaHost         = jQuery('input[name="portaHost"]').val();

            interface_default = jQuery('input[name="interface_default"]').val();

            interface_agent   = jQuery('input[name="interface_agent"]').val();

            macro             = jQuery('input[name="macro"]').val();

            valorMacro        = jQuery('input[name="valorMacro"]').val();

            GruposHost        = jQuery('select[name="GruposHost[]"]').val();

            itTemplate        = jQuery('select[name="itTemplate[]"]').val();



           

            $.ajax({
                
                url: "<?php echo BASE_URL;?>/<?php echo $modulo; ?>/monitoramento/addEquipamento/<?php echo $id_empresa_edicao;?>/"+ valor,

                data: {provedor:provedor,tipo:tipo,host:host,desc:desc,velocidade:velocidade,comunicacao:comunicacao,ddns:ddns,ip:ip,sistema:sistema,marca:marca,modelo:modelo,circuito:circuito,mascara:mascara,equipObs:equipObs,nomeVisivelhost:nomeVisivelhost,dnsHost:dnsHost,portaHost:portaHost,interface_default:interface_default,interface_agent:interface_agent,macro:macro,valorMacro:valorMacro,GruposHost:GruposHost,itTemplate:itTemplate},

                type:'POST',

                 success:function(data){

                  if(data == true){

                     swal({title: data});

                     
                  
                  }else{

                     swal({title: data});

                     return false;
                  }  
                  

                 }


             });

        } //fim ajax

	});
			  

	</script>

</body>
</html>