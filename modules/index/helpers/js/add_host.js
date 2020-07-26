jQuery(function(){

		jQuery("form#addHost").submit(function(){

			
			jQuery.ajax({

				type: 'POST',

				url	  : 'http://host.local.dev-sys/index/addHost/salvaHost',

				data: {},

				success: function(response){

					if(response == true){

						jQuery("#retorno_msg").html(response);	
					
					}else{
						jQuery("#retorno_msg").html(response);	
					}

					
				}
			});


			return false;
		});

	});