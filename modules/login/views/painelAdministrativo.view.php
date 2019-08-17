<!DOCTYPE html>
<html>
    <head>
        <title><?= $view_title; ?></title>
        <meta charset="utf-8">
        
        <link rel="stylesheet" type="text/css" href="<?= BASE_SITE ?>/css/style.css" />
    </head>
    <body>
        Olá <b><?= $view_nome_do_usuario; ?></b> seja bem vindo.

        <a href="?module=login&option=pagina-de-login&view=sair-do-sistema&session=<?=base64_encode(md5(session_id()));?>">Sair</a>
    </body>
</html>