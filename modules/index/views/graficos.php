<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          
        var v_link      = 20;
        
        var v_firewall  = 30;
        
        var v_servidor  = 10;
        
        var v_switch    = 50;
        
        var v_outros    = 60;

        //Condiçoes de verificação para o mapeamentos dos equipamentos Links
        if(v_link == 0 && v_link <= 10){

            links = 'green';
        
        }
        else if(v_link > 11 && v_link <= 15){
            
            links = 'blue';

        }
        else if(v_link > 16 && v_link <= 18){

            links = 'yellow';
        }
        else{

            links = 'red';
        }

        //Condiçoes de verificação para o mapeamentos dos equipamentos Firewalls
        if(v_firewall == 0 && v_firewall <= 10){

            firewall = 'green';

        }
        else if(v_firewall > 11 && v_firewall <= 30){

            firewall = 'blue';

        }
        else if(v_firewall > 16 && v_firewall > 40){

            firewall = 'yellow';

        }
        else{

            firewall = 'red';
        }

        //Servidor
        if(v_servidor == 0 || v_servidor <= 10){

            servidor = 'green';

        }
        
        else if(v_servidor > 11 && v_servidor <= 18){

            servidor = 'blue';
        }

        else if(v_servidor > 19 && v_servidor <= 40){

            servidor = 'yellow';

        }

        else{

            servidor = 'red';
        }

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Noc'],
          ['Links',     30],
          ['Firewalls',      20],
          ['Servidores',  30],
          ['Switch', 12],
          ['Outros',    17]
        ]);

        var options = {
          title: 'Noc - Relatórios',

            colors: [links,firewall,servidor],
     
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="float:right; width: 500px; height: 500px;"></div>
  </body>
</html>
