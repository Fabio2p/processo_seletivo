<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

       
<script>
     $('document').ready(function()
    {
       
        $('#example').DataTable({

            processing: true,

            "stateSave": true,

            cache: false,

            "info": true,

            ajax: {
 
                url: "http://host.local.dev-sys/index/datatable/dataTableJson",
                
                dataSrc: "",

                mDataProp: "",
                
                type: 'POST',
                
               
               
            },

            "columns": [
              
                { "data": "NOME" },
                { "data": "DESCRICAO" }
            ],
            
            "order": [[0, 'desc']]
           
        });
        
       
        

        $("#selecione").change(function(){

           var t = $(this).val();

      
            $('#example').DataTable({

                processing: true,
                
                "stateSave": true,

                destroy: true,

                cache: false,

                "info": true,

                ajax: {
    
                    url: "http://host.local.dev-sys/index/datatable/dataTableJsons",
                    
                    dataSrc: "",

                    mDataProp: "",
                    
                    type: 'POST',

                    data:{t:t}
                
                },

                "columns": [
                
                    { "data": "NOME" },
                    { "data": "DESCRICAO" }
                ],
                
                "order": [[0, 'desc']]
            
            });
        

        });

    });

</script>


    </head>
 <body>
    <form>
        <select name="" id="selecione">
            <option value="1">Equipamento</option>
             <option value="2">Equipamento</option>
              <option value="3">Equipamento</option>
               <option value="4">Equipamento</option>
        </select>
    </form>

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                
                <th>Nome</th>
                <th>descricao</th>
               
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
             
                <th>Nome</th>
                 <th>descricao</th>
              
            </tr>
        </tfoot>
    </table>

 
 </body>
</html>