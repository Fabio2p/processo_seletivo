#Projeto para o consumo de api zabbx

#Passo a serem seguidos para a utilização do app:
1.* ter php instalado na máquina e as bibliotecas: curl e mysql-pdo php
2.* Configurar o apache para redirecionar para: /var/www/_seu_projeto/public
3.* importar a tabela incidetes para sua base de dados
4.* fazer a configuração do arquivo: modules/index/config.db.php e apontar para o servidor de banco
5.* Ajustar o arquivo config/config.load.php de acordo com seu domínio: define('BASE_URL',"http://host.local.dev-sys");

#OBS1: ativar o módulo htacces do apache2 para que as url escrita funcione
#OBS2: Não ativado o módulo htacces, o acesso as páginas é: ?module=index&option=home&view=index

6.* método refresh é responsáve para fazer conexão com o zabbix

