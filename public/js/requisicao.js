jQuery(function(){

	jQuery(".cadastro-submit").click(function(){

		var email = jQuery('input[name="envia_email"]').val();
		
		var nome = jQuery('input[name="nome"]').val();
		

		if(email.length == ""){

			alert('Campo "[ Para ]" Obrigatório!');


			return false;
		}

		if(nome.length == ""){

			alert('Campo "[ Nome ]" Obrigatório!');


			return false;
		}

	});

});