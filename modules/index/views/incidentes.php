<!DOCTYPE html>
<html>
<head>
<title>Detalhes de Incidentes api zabbix </title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <table class="table table-striped">
        <thead>
        <th>Id</th>
            <th>Id host</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Data de Abertura</th>
        </thead>
        <tbody>

    
            <?php foreach($dados as $list): ?>
                <?php $sstatus = $list['STATUS'] == "ABERTO" ? 'alert-danger' : 'alert-success' ?>
                <tr class=" <?=$sstatus?> ">
                    <td><?= $list['ID_INCIDENTE']; ?></td>

                    <td><?= $list['ID_HOST']; ?></td>

                    <td><?= $list['DESCRICAO']; ?></td>
                    
                    <td><?= $list['STATUS']; ?></td>

                    <td><?= $list['DATA_ABERTURA']; ?></td>

                </tr>

            <?php endforeach; ?>

    
        </tbody>

    </table>

</body>
</html>