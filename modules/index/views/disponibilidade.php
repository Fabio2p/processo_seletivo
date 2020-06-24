<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
</head>
<body>

<div class="refresh">
<?php 

 
 $hosts = array('host' => 
                              array(
                                    "NOMEPOINT01" => "Zabbix Central",
                                    
                                    "ENDPOINT01" => "172.17.0.3",

                                    "NOMEPOINT02" => "Servidor Web",
                                    
                                    "ENDPOINT02" => "172.17.0.2",));

        foreach( $hosts as $host):

              $url = $host['ENDPOINT01'];

              $url02 = $host['ENDPOINT02'];

              if(isset($url)):

                  $ttl = 128;
                  
                  $timeout = 5;
                  
                  $ping = new Ping($url, $ttl, $timeout);

                  $latency = $ping->ping();
                  
                  if($latency > '0.0.1'):

                     echo "Nome de Appliance 01 : ". $host['NOMEPOINT01'] .'<br>';

                     echo "Conexao sem Interferencia: ". $latency;

                    else:

                      echo "Nome de Appliance 01: ". $host['NOMEPOINT01'] .'<br>';

                      echo "A latencia esta alta: ". $latency;

                  endif;

        
               endif;      

        endforeach;  
?>        

</div>


</body>
</html>

<script>
	
	jQuery(function(){

	
	});

</script>


