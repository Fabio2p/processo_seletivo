<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

       
<script>
     $('document').ready(function()
    {

        let dataTable = $('#example').DataTable({
            processing:true,
            destroy: true,
            serverSide: true,
            pageLength : 5,
            ajax: {
                url: "http://local.checkout.com.br/index/home/data",
                "type": "post",
            },
            "aoColumns": [
                { "sClass": "my_class" },
                { "sClass": "meu_nome" },
                { "sClass": "meu_sobrenome" }
            ],
            columnDefs: [
            {
                targets: 1,
                render: function(data, type, row) {
                    if (data == 'Fabio') {
                        return `<span style="color: green;">${data}</span>`
                    }
                    return data;
                }
            }
        ],
        })
       
        // var dataTable = $('#example').DataTable({
            
        //     destroy: true,
        //     retrieve: true,
        //     searching: false,
        //     pageLength: 5,
        //     processing: true,
        //     serverSide: true,
        //     deferLoading: 20,
        //     columnDefs: [
        //         {
        //             render: (data, type, row) => data,
        //             targets: 0
        //         },
        //     ],

        //     lengthMenu: [
        //         [5, 10, 20, -1],
        //         [5, 10, 20, 'Todos']
        //     ],

        //     ajax: {
        //         serverMethod: 'post',
        //         dataSrc: "",
        //         mDataProp: "",
        //         url: "http://local.checkout.com.br",
        //         type: "post",
        //         data: function(d) {
        //             d.page = dataTable.page.info().page + 1;
        //         },
                
        //     },


        //     // processing: true,

        //     // "stateSave": true,

        //     // cache: false,

        //     // "info": true,

        //     // ajax: {
        //     //     'serverMethod': 'post',
        //     //     url: "http://host.local.dev-sys/index/home/data",
                
        //     //     dataSrc: "",

        //     //     mDataProp: "",
                
        //     //     type: 'POST',
                
               
               
        //     // },

        //     // "order": [[0, 'desc']]
           
        // });
        
    
    });

</script>


    </head>
 <body>
  
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Sobrenome</th>
            </tr>
        </thead>
    </table>

 
 </body>
</html>