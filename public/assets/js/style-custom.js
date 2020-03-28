jQuery(function(){

  var host = "http://"+location.hostname;
      
  // Requisicao  assincrono para cadastro de hosts
  jQuery("form[name='cadastro_grupo_host']").submit(function() {
      
      var gHost = jQuery("input[name='gHost']").val();

      var idEmpresa = jQuery("input[name='idEmpresa']").val();

      jQuery.ajax({
          
        url: host+"/sdredes/monitoramento/salvarGrupoHost",
          
        type: 'post',

        data: {gHost:gHost, idEmpresa:idEmpresa},

        success: function(response) {

          jQuery('#cadastro_grupo').empty().html(response);
          
        }

      });

        return false;

      }); // fim de cadastro de Host

   
    // Requisicao  assincrono para cadastro de templates
    jQuery("form[name='cadastro_template']").submit(function() {

      var template = jQuery("input[name='template']").val();

      var nomeVisivel = jQuery("input[name='nomeVisivel']").val();

      var template_GruposHosts = jQuery("select[name='template_GruposHosts[]']").val();

      var descricao = jQuery("#descricao").val();

      var idEmpresa = jQuery("input[name='idEmpresa']").val();

      jQuery.ajax({
        
        url: host+'/sdredes/monitoramento/salvarTemplate',
        
        type: 'post',

        data: {template:template, nomeVisivel:nomeVisivel, template_GruposHosts:template_GruposHosts, descricao:descricao, idEmpresa:idEmpresa},

         success: function(response) {

          jQuery('#retorno_msg_template').empty().html(response);

        }

      });


      return false;

    }); // fim de cadastro de Templates


      /*====================================================================*/
      // Requisicao  assincrono para cadastro de Hosts
    //   jQuery("form[name='cadastro_host']").submit(function() {

    //     var nomeHost = jQuery("input[name='nomeHost']").val();

    //     var nomeVisivelHost = jQuery("input[name='nomeVisivelHost']").val();

    //     var GruposHost = jQuery("select[name='GruposHost[]']").val();

    //     var agent = jQuery("input[name='agent']").val();
        
    //     var portaHost = jQuery("input[name='portaHost']").val();
        
    //     var IpHost = jQuery("input[name='IpHost']").val();

    //     var dnsHost = jQuery("input[name='dnsHost']").val();

    //     var idTemplate = jQuery("select[name='idTemplate[]']").val();
       
    //     var descricaoHost = jQuery("#descricaoHost").val();

    //     jQuery.ajax({
          
    //       url: '/equipamentos/salvarHost',
          
    //       type: 'post',

    //       data: {nomeHost:nomeHost, nomeVisivelHost:nomeVisivelHost, GruposHost:GruposHost, agent:agent, portaHost:portaHost, IpHost:IpHost, dnsHost:dnsHost, idTemplate:idTemplate, descricaoHost:descricaoHost},

    //        success: function(response) {

    //         jQuery('#retorno_msg_host').empty().html(response);

    //       }

    //     });


    //     return false;

    //  }); // fim de cadastro de Templates
      
    

  // Requisicao  assincrono para cadastro de Aplicações
  jQuery("form[name='cadastro_aplicacoes']").submit(function() {

      var zAplicacao = jQuery("input[name='zAplicacao']").val();
      
      var listHosts =  jQuery("select[name='listaHosts[]']").val();

      var idEmpresa = jQuery("input[name='idEmpresa']").val();

      jQuery.ajax({
      
      url: host+'/sdredes/monitoramento/salvarApplicationApiZabbix',
      
      type: 'post',

      data: {zAplicacao:zAplicacao,listHosts:listHosts,idEmpresa:idEmpresa},

      success: function(response) {

          jQuery('#cadastro_aplicacao').empty().html(response);

      }

      });

      return false;

  }); // fim de cadastro de Aplicações


  // Requisicao  assincrono para cadastro de itens
  jQuery("form[name='cadastro_items']").submit(function() {

      var zitems = jQuery("input[name='zitems']").val();

      //var lista_de_chaves = jQuery("select[name='lista_de_chaves']").val();

      var delay = jQuery("input[name='delay']").val();

      var lista_Hosts_itens = jQuery("select[name='lista_Hosts_itens[]']").val();

      var lista_aplicacoes_itens = jQuery("select[name='lista_aplicacoes_itens[]']").val();

      var idEmpresa = jQuery("input[name='idEmpresa']").val();

      var item_Expressoes = jQuery("#item_Expressoes").val();
      

      jQuery.ajax({
      
        url: host+'/sdredes/monitoramento/salvaItens',
        
        type: 'post',

        data: {zitems:zitems,item_Expressoes:item_Expressoes,delay:delay,lista_Hosts_itens:lista_Hosts_itens,lista_aplicacoes_itens:lista_aplicacoes_itens, idEmpresa:idEmpresa},

        success: function(response) {

            jQuery('#retorno_msg_items').empty().html(response);

        }

      });

      return false;

  }); // fim de cadastro de Itens

  // Requisicao  assincrono para cadastro de Triggers
  jQuery("form[name='cadastro_triggers']").submit(function() {

      var ztriggers = jQuery("input[name='ztriggers']").val();

      var zSeveridade = $("input[name='priority']:checked").val();

      var tg_Expressoes = jQuery("#tg_Expressoes").val();

      var tg_descricao = jQuery("#tg_descricao").val();

      var idEmpresa = jQuery("input[name='idEmpresa']").val();
      
    
      jQuery.ajax({
      
        url: host+'/sdredes/monitoramento/salvaTriggers',
        
        type: 'post',


        data: {ztriggers:ztriggers, zSeveridade:zSeveridade, tg_Expressoes:tg_Expressoes, tg_descricao:tg_descricao, idEmpresa:idEmpresa},
        
        success: function(response) {

            jQuery('#retorno_msg_triggers').empty().html(response);

        }

      });

      return false;

  }); // fim de cadastro de Triggers

  /*
  *FUNCIONALIDADE VALORES DE EXPRESSÕES DE ITENS
  */
  // jQuery("#lista_de_chaves").change(function(){

  //     jQuery("#tg_valores_expressoes").html(jQuery(this).val());

  // }); //

   /*
  *FUNCIONALIDADE EXPRESSÕES DE TRIGGERS
  */
  jQuery("#lista_triggers_hosts").change(function(){

      jQuery("#tg_Expressoes").append("{"+jQuery(this).val()+":Aqui fica o valor da expressao}=0");

  }); //


  /*
  *FUNCIONALIDADE VALORES DE EXPRESSÕES DE ITENS
  */
  jQuery("#tipoAgents").change(function(){

      // Captura o valor da opção
      var id = jQuery(this).val();

      //Agente Zabbix
      if(id == 0){

        jQuery("#expressoes").html('<option selected disabled><strong>Adicionar uma Chave</strong></option><option value="agent.hostname"><strong>Nome do host do agente</strong></option><option value="agent.ping">Verificação de disponibilidade do agente.</option><option value="agent.version">Versão do agente Zabbix.</option><option value="kernel.maxfiles">Número máximo de arquivos abertos suportado pelo S.O.</option><option value="kernel.maxproc"> Quantidade máxima de processos suportada pelo S.O.</option><option value="net.dns[<ip>,name,<type>,<timeout>,<count>,<protocol>]">Verifica se o serviço do DNS está em execução.</option><option value="net.dns.record[<ip>,name,<type>,<timeout>,<count>,<protocol>]">Executa uma consulta DNS.</option><option value="net.if.collisions[if]">Número de colisões fora da janela.</option><option value="net.if.in[if,<mode>]">   Retorna estatísticas de tráfego de uma interface.</option><option value="net.if.list">Lista das interfaces de rede (incluindo o tipo da interface, status, endereço IPv4 e descrição).</option><option value="net.if.out[if,<mode>]">Estatísticas de saída de tráfego na interface de rede.</option><option value="net.if.total[if,<mode>]">Sumarização das estatísticas de entrada e saída da interface de rede.</option><option value="net.tcp.listen[port]">Verifica se determinada porta TCP está em modo de ESCUTA.</option><option value="net.tcp.port[<ip>,port]">    Verifica se é possível estabelecer uma conexão TCP com a porta especificada.</option><option value="net.tcp.service[service,<ip>,<port>]">Verifica se o serviço está em execução e aceitando conexões TCP.</option><option value="net.tcp.service.perf[service,<ip>,<port>]">Verifica a performance de um serviço TCP.</option><option value="net.udp.listen[port]">Verifica se determinada porta UDP está em modo de ESCUTA.</option><option value="net.udp.service[service,<ip>,<port>]">Verifica se o serviço está em execução e respondendo a requisições UDP.</option><option value="net.udp.service.perf[service,<ip>,<port>]">Verifica a performance de um serviço UDP.<segundos> - tempo utilizado, em segundos, para se conectar ao serviço</option><option value="perf_counter[counter,<interval>]">Valor de um contador de performance do Windows.</option><option value="proc.cpu.util[<name>,<user>,<type>,<cmdline>,<mode>,<zone>]">Utilização percentual, pelo processo, de CPU.</option><option value="proc.mem[<name>,<user>,<mode>,<cmdline>,<memtype>]">Memória utilizada pelo processo em bytes.</option><option value="proc.num[<name>,<user>,<state>,<cmdline>]">Número de processos.</option><option value="proc_info[process,<attribute>,<type>]">Várias informações sobre processo(s) específico(s).</option><option value="sensor[device,sensor,<mode>]">Sensor de leitura de hardware.</option><option value="service.info[service,<param>]">Informação sobre um serviço.</option><option value="services[<type>,<state>,<exclude>]">Lista de serviços.</option><option value="system.boottime">Tempo desde a carga do sistema.</option><option value="system.cpu.intr">Interrupções do dispositivo.</option><option value="system.cpu.load[<cpu>,<mode>]">Carga da CPU.</option><option value="system.cpu.num[<type>]">Número de CPUs.</option>option value="system.cpu.switches">Número de trocas de contexto.</option><option value="system.cpu.util[<cpu>,<type>,<mode>]">Uso percentual de CPU.</option><option value="system.hostname[<type>]">Nome do host.</option><option value="system.hw.chassis[<info>]">  Informação do chassi.</option><option value="system.hw.cpu[<cpu>,<info>]">Informação da CPU.</option><option value="system.hw.devices[<type>]">Lista de dispositivos USB ou PCI.</option><option value="system.hw.macaddr[<interface>,<format>]">Lista dos endereços MAC.</option><option value="system.localtime[<type>]">   Horário do sistema.</option><option value="system.run[command,<mode>]">Executa o comando em no host.</option><option value="system.stat[resource,<type>]">   Estatísticas do sistema.</option><option value="system.sw.arch"> Informação sobre a arquitetura de software.</option><option value="system.sw.os[<info>]">   Informação sobre o sistema operacional.</option><option value="system.sw.packages[<package>,<manager>,<format>]">Lista de pacotes instalados.</option><option value="system.swap.in[<device>,<type>]">Estatísticas de envio de dados do swap para a memória.</option><option value="system.swap.out[<device>,<type>]">Estatísticas de envio de dados da memória para o swap.</option><option value="system.swap.size[<device>,<type>]">Tamanho do espaço do swap em bytes ou percentual relativo ao total.</option><option value="system.uname">Identificação do sistema.</option><option value="system.uptime">Tempo desde a carga do sistema.</option><option value="system.users.num">Número de usuários conectados.</option><option value="vfs.dev.read[<device>,<type>,<mode>]">Estatísticas de leitura de disco.</option>option value="vfs.dev.write[<device>,<type>,<mode>]">Estatísticas de gravação de disco.</option><option value="vfs.dir.count[dir,<regex_incl>,<regex_excl>,<types_incl>,<types_excl>,<max_depth>,<min_size>,<max_size>,<min_age>,<max_age>,<regex_excl_dir>]"></option><option value="">Contagem recursiva de entradas de diretório.</option><option value="vfs.dir.size[dir,<regex_incl>,<regex_excl>,<mode>,<max_depth>,<regex_excl_dir>]">Tamanho do diretório (em bytes).</option><option value="vfs.file.cksum[file]">   Verificação "checksum", calculada pelo algoritmo UNIX cksum.</option><option value="vfs.file.contents[file,<encoding>]">Recupera o conteúdo de um arquivo.</option><option value="vfs.file.exists[file]">Verifica se o arquivo existe.</option><option value="vfs.file.md5sum[file]">Verificação checksum MD5.</option><option value="vfs.file.regexp[file,regexp,<encoding>,<start line>,<end line>,<output>]">Busca um texto em um arquivo.<output></option><option value="vfs.file.regmatch[file,regexp,<encoding>,<start line>,<end line>]">Busca um texto em um arquivo.</option><option value="vfs.file.size[file]">Tamanho do arquivo (em bytes).</option><option value="vfs.file.time[file,<mode>]">Horário do arquivo. Retorna: timestamp UNIX</option><option value="vfs.fs.inode[fs,<mode>]">    Quantidade ou percentual de inodes. Retorna: inteiro para quantidade; número fracionário para percentual</option><option value="vfs.fs.size[fs,<mode>]">Espaço em disco em bytes ou em percentual do total</option><option value="vm.memory.size[<mode>]">Tamanho da memória em bytes ou em percentual relativo ao total.</option><option value="vm.vmemory.size[<type>]">Espaço virtual em bytes ou percentual do total.</option><option value="web.page.get[host,<path>,<port>]">Recupera o conteúdo de uma página web.</option><option value="web.page.perf[host,<path>,<port>]">Tempo para carga completa de uma página web (em segundos).</option><option value="web.page.regexp[host,<path>,<port>,regexp,<length>,<output>]">Busca um texto em uma página web. Retorna a linha que contêm o texto pesquisado, ou como for especificado no parâmetro opcional <output></option><option value="wmi.get[<namespace>,<query>]">Executa requisição WMI retornando o primeiro objeto selecionado.</option><option value="zabbix.stats[<ip>,<port>]">Retorna um objeto JSON contendo métricas internas do servidor ou proxy do Zabbix.</option><option value="zabbix.stats[<ip>,<port>,queue,<from>,<to>]">Número de itens na fila que estão atrasados ​​no servidor ou proxy do Zabbix por "de" até "a" segundos, inclusive.</option>');

      }

      //Agente Zabbix (Ativo)
      if(id == 2){

        jQuery("#expressoes").html('<option selected disabled><strong>Adicionar uma Chave</strong></option><option value="agent.hostname"><strong>Nome do host do agente</strong></option><option value="agent.ping">Verificação de disponibilidade do agente.</option><option value="agent.version">Versão do agente Zabbix.</option><option value="kernel.maxfiles">Número máximo de arquivos abertos suportado pelo S.O.</option><option value="kernel.maxproc"> Quantidade máxima de processos suportada pelo S.O.</option><option value="net.dns[<ip>,name,<type>,<timeout>,<count>,<protocol>]">Verifica se o serviço do DNS está em execução.</option><option value="net.dns.record[<ip>,name,<type>,<timeout>,<count>,<protocol>]">Executa uma consulta DNS.</option><option value="net.if.collisions[if]">Número de colisões fora da janela.</option><option value="net.if.in[if,<mode>]">   Retorna estatísticas de tráfego de uma interface.</option><option value="net.if.list">Lista das interfaces de rede (incluindo o tipo da interface, status, endereço IPv4 e descrição).</option><option value="net.if.out[if,<mode>]">Estatísticas de saída de tráfego na interface de rede.</option><option value="net.if.total[if,<mode>]">Sumarização das estatísticas de entrada e saída da interface de rede.</option><option value="net.tcp.listen[port]">Verifica se determinada porta TCP está em modo de ESCUTA.</option><option value="net.tcp.port[<ip>,port]">    Verifica se é possível estabelecer uma conexão TCP com a porta especificada.</option><option value="net.tcp.service[service,<ip>,<port>]">Verifica se o serviço está em execução e aceitando conexões TCP.</option><option value="net.tcp.service.perf[service,<ip>,<port>]">Verifica a performance de um serviço TCP.</option><option value="net.udp.listen[port]">Verifica se determinada porta UDP está em modo de ESCUTA.</option><option value="net.udp.service[service,<ip>,<port>]">Verifica se o serviço está em execução e respondendo a requisições UDP.</option><option value="net.udp.service.perf[service,<ip>,<port>]">Verifica a performance de um serviço UDP.<segundos> - tempo utilizado, em segundos, para se conectar ao serviço</option><option value="perf_counter[counter,<interval>]">Valor de um contador de performance do Windows.</option><option value="proc.cpu.util[<name>,<user>,<type>,<cmdline>,<mode>,<zone>]">Utilização percentual, pelo processo, de CPU.</option><option value="proc.mem[<name>,<user>,<mode>,<cmdline>,<memtype>]">Memória utilizada pelo processo em bytes.</option><option value="proc.num[<name>,<user>,<state>,<cmdline>]">Número de processos.</option><option value="proc_info[process,<attribute>,<type>]">Várias informações sobre processo(s) específico(s).</option><option value="sensor[device,sensor,<mode>]">Sensor de leitura de hardware.</option><option value="service.info[service,<param>]">Informação sobre um serviço.</option><option value="services[<type>,<state>,<exclude>]">Lista de serviços.</option><option value="system.boottime">Tempo desde a carga do sistema.</option><option value="system.cpu.intr">Interrupções do dispositivo.</option><option value="system.cpu.load[<cpu>,<mode>]">Carga da CPU.</option><option value="system.cpu.num[<type>]">Número de CPUs.</option>option value="system.cpu.switches">Número de trocas de contexto.</option><option value="system.cpu.util[<cpu>,<type>,<mode>]">Uso percentual de CPU.</option><option value="system.hostname[<type>]">Nome do host.</option><option value="system.hw.chassis[<info>]">  Informação do chassi.</option><option value="system.hw.cpu[<cpu>,<info>]">Informação da CPU.</option><option value="system.hw.devices[<type>]">Lista de dispositivos USB ou PCI.</option><option value="system.hw.macaddr[<interface>,<format>]">Lista dos endereços MAC.</option><option value="system.localtime[<type>]">   Horário do sistema.</option><option value="system.run[command,<mode>]">Executa o comando em no host.</option><option value="system.stat[resource,<type>]">   Estatísticas do sistema.</option><option value="system.sw.arch"> Informação sobre a arquitetura de software.</option><option value="system.sw.os[<info>]">   Informação sobre o sistema operacional.</option><option value="system.sw.packages[<package>,<manager>,<format>]">Lista de pacotes instalados.</option><option value="system.swap.in[<device>,<type>]">Estatísticas de envio de dados do swap para a memória.</option><option value="system.swap.out[<device>,<type>]">Estatísticas de envio de dados da memória para o swap.</option><option value="system.swap.size[<device>,<type>]">Tamanho do espaço do swap em bytes ou percentual relativo ao total.</option><option value="system.uname">Identificação do sistema.</option><option value="system.uptime">Tempo desde a carga do sistema.</option><option value="system.users.num">Número de usuários conectados.</option><option value="vfs.dev.read[<device>,<type>,<mode>]">Estatísticas de leitura de disco.</option>option value="vfs.dev.write[<device>,<type>,<mode>]">Estatísticas de gravação de disco.</option><option value="vfs.dir.count[dir,<regex_incl>,<regex_excl>,<types_incl>,<types_excl>,<max_depth>,<min_size>,<max_size>,<min_age>,<max_age>,<regex_excl_dir>]"></option><option value="">Contagem recursiva de entradas de diretório.</option><option value="vfs.dir.size[dir,<regex_incl>,<regex_excl>,<mode>,<max_depth>,<regex_excl_dir>]">Tamanho do diretório (em bytes).</option><option value="vfs.file.cksum[file]">   Verificação "checksum", calculada pelo algoritmo UNIX cksum.</option><option value="vfs.file.contents[file,<encoding>]">Recupera o conteúdo de um arquivo.</option><option value="vfs.file.exists[file]">Verifica se o arquivo existe.</option><option value="vfs.file.md5sum[file]">Verificação checksum MD5.</option><option value="vfs.file.regexp[file,regexp,<encoding>,<start line>,<end line>,<output>]">Busca um texto em um arquivo.<output></option><option value="vfs.file.regmatch[file,regexp,<encoding>,<start line>,<end line>]">Busca um texto em um arquivo.</option><option value="vfs.file.size[file]">Tamanho do arquivo (em bytes).</option><option value="vfs.file.time[file,<mode>]">Horário do arquivo. Retorna: timestamp UNIX</option><option value="vfs.fs.inode[fs,<mode>]">    Quantidade ou percentual de inodes. Retorna: inteiro para quantidade; número fracionário para percentual</option><option value="vfs.fs.size[fs,<mode>]">Espaço em disco em bytes ou em percentual do total</option><option value="vm.memory.size[<mode>]">Tamanho da memória em bytes ou em percentual relativo ao total.</option><option value="vm.vmemory.size[<type>]">Espaço virtual em bytes ou percentual do total.</option><option value="web.page.get[host,<path>,<port>]">Recupera o conteúdo de uma página web.</option><option value="web.page.perf[host,<path>,<port>]">Tempo para carga completa de uma página web (em segundos).</option><option value="web.page.regexp[host,<path>,<port>,regexp,<length>,<output>]">Busca um texto em uma página web. Retorna a linha que contêm o texto pesquisado, ou como for especificado no parâmetro opcional <output></option><option value="wmi.get[<namespace>,<query>]">Executa requisição WMI retornando o primeiro objeto selecionado.</option><option value="zabbix.stats[<ip>,<port>]">Retorna um objeto JSON contendo métricas internas do servidor ou proxy do Zabbix.</option><option value="zabbix.stats[<ip>,<port>,queue,<from>,<to>]">Número de itens na fila que estão atrasados ​​no servidor ou proxy do Zabbix por "de" até "a" segundos, inclusive.</option>');
      }

      //Monitoração simples
      if(id == 3){

         jQuery("#expressoes").html('<option selected disabled><strong>Adicionar uma Chave</strong></option><option value="icmpping[<target>,<packets>,<interval>,<size>,<timeout>]">Verifica se o servidor está acessível através de ICMP ping.</option>><option value="icmppingloss[<target>,<packets>,<interval>,<size>,<timeout>]">Retorna o percentual de perda de pacotes ICMP.</option><option value="icmppingsec[<target>,<packets>,<interval>,<size>,<timeout>,<mode>]">Tempo de resposta do ICMP ping.</option><option value="net.tcp.service[service,<ip>,<port>]">Verifica se o serviço está em execução e aceitando conexões TCP.</option><option value="net.tcp.service.perf[service,<ip>,<port>]">Verifica a performance de um serviço TCP.</option><option value="net.udp.service[service,<ip>,<port>]">Verifica se o serviço está em execução e respondendo a requisições UDP.</option><option value="net.udp.service.perf[service,<ip>,<port>]">Verifica a performance de um serviço UDP.</option><option value="vmware.cluster.status[<url>,<name>]">Status do cluster VMware.</option><option value="vmware.eventlog[<url>,<mode>]">VMware event log, <url> - VMware service URL.</option><option value="vmware.fullname[<url>]">Nome completo do serviço do hypervisor VMware.</option><option value="vmware.datastore.read[<url>,<datastore>,<mode>]">VMware datastore read statistics.</option><option value="vmware.datastore.size[<url>,<datastore>,<mode>]">Estatísticas de capacidade do datastore em bytes ou em percentual do total.</option><option value="vmware.datastore.write[<url>,<datastore>,<mode>]">VMware datastore write statistics.</option><option value="vmware.datastore.hv.list[<url>,<datastore>]">VMware datastore hypervisors list.</option><option value="vmware.hv.cluster.name[<url>,<uuid>]">Nome do cluster do hypervisor VMware.</option><option value="vmware.hv.cpu.usage[<url>,<uuid>]">Utilização do processador do hypervisor VMware em Hz.</option><option value="vmware.hv.datastore.read[<url>,<uuid>,<datastore>,<mode>]">Estatísticas de leitura do datastore do hypervisor VMware.</option><option value="vmware.hv.datastore.size[<url>,<uuid>,<datastore>,<mode>]">Estatísticas de capacidade do datastore em bytes ou em percentual do total.</option><option value="vmware.hv.datastore.write[<url>,<uuid>,<datastore>,<mode>]">Estatísticas de gravação do armazenamento de dados do hypervisor VMware.</option><option value="vmware.hv.datastore.list[<url>,<uuid>]">VMware hypervisor datastores list.</option><option value="vmware.hv.full.name[<url>,<uuid>]">Nome do hypervisor VMware.</option><option value="vmware.hv.hw.cpu.freq[<url>,<uuid>]">Frequência do processador do hypervisor VMware.</option><option value="vmware.hv.hw.cpu.model[<url>,<uuid>]">Modelo do processador do hypervisor VMware.</option><option value="vmware.hv.hw.cpu.num[<url>,<uuid>]">Número de cores de processamento em um hypervisor VMware.</option><option value="vmware.hv.hw.cpu.threads[<url>,<uuid>]">Número de threads do processador hypervisor VMware.</option><option value="vmware.hv.hw.memory[<url>,<uuid>]">Total de memória do hypervisor VMware.</option><option value="vmware.hv.hw.model[<url>,<uuid>]">Modelo do hypervisor VMware.</option><option value="vmware.hv.hw.uuid[<url>,<uuid>]">UUID da BIOS do hypervisor VMware.</option><option value="vmware.hv.hw.vendor[<url>,<uuid>]">Fornecedor do hypervisor VMware.</option><option value="vmware.hv.memory.size.ballooned[<url>,<uuid>]">Hypervisor VMware que aumentou o uso de memória.</option><option value="vmware.hv.memory.used[<url>,<uuid>]">Total de memória utilizada no hypervisor VMware.</option><option value="vmware.hv.network.in[<url>,<uuid>,<mode>]">Estatísticas de entrada de rede do hypervisor VMware.</option><option value="vmware.hv.network.out[<url>,<uuid>,<mode>]">Estatísticas de saída de rede do hypervisor VMware.</option><option value="vmware.hv.perfcounter[<url>,<uuid>,<path>,<instance>]">Contador de desempenho do hypervisor VMWare.</option><option value="vmware.hv.uptime[<url>,<uuid>]">Tempo desde o ultimo boot do hypervisor VMware.</option><option value="vmware.hv.version[<url>,<uuid>]">Versão do hypervisor VMware.</option><option value="vmware.hv.vm.num[<url>,<uuid>]">Número de máquinas virtuais no hypervisor VMware.</option><option value="vmware.version[<url>]">Versão do serviço do VMware.</option><option value="vmware.vm.cluster.name[<url>,<uuid>]">Nome da máquina virtual VMware.</option><option value="vmware.vm.cpu.num[<url>,<uuid>]">Número de processadores na máquina virtual VMware.</option><option value="vmware.vm.cpu.ready[<url>,<uuid>]">Tempo em prontidão do processador da máquina virtual em milisegundos.</option><option value="vmware.vm.cpu.usage[<url>,<uuid>]">Utilização de processador pela máquina virtual VMware em Hz.</option><option value="vmware.vm.hv.name[<url>,<uuid>]">Nome do hypervisor da máquina virtual VMware.</option><option value="vmware.vm.memory.size.ballooned[<url>,<uuid>]">Máquina virtual VMware que aumentou o uso de memória.</option><option value="vmware.vm.memory.size.compressed[<url>,<uuid>]">Tamanho comprimido da memória comprometida com a máquina virtual VMware.</option><option value="vmware.vm.memory.size.private[<url>,<uuid>]">Tamanho da memória privada da máquina virtual VMware.</option><option value="vmware.vm.memory.size.shared[<url>,<uuid>]">Tamanho da memória compartilhada da máquina virtual VMware.</option><option value="vmware.vm.memory.size.swapped[<url>,<uuid>]">Tamanho da memória da máquina virtual VMware que está em swap.</option><option value="vmware.vm.memory.size.usage.guest[<url>,<uuid>]">Memória utilizada pelo agente de monitoração VMware na máquina virtual.</option><option value="vmware.vm.memory.size.usage.host[<url>,<uuid>]">Utilização de memória pela máquina virtual VMware.</option><option value="vmware.vm.memory.size[<url>,<uuid>]">Tamanho total da memória da máquina virtual VMware.</option><option value="vmware.vm.net.if.in[<url>,<uuid>,<instance>,<mode>]">Estatísticas de entrada de rede da interface na máquina virtual VMware.</option><option value="vmware.vm.net.if.out[<url>,<uuid>,<instance>,<mode>]">Estatísticas de saída de rede da interface na máquina virtual VMware.</option><option value="vmware.vm.perfcounter[<url>,<uuid>,<path>,<instance>]">Contador de desempenho de máquina virtual VMWare.</option><option value="vmware.vm.powerstate[<url>,<uuid>]">Estado de carga da máquina virtual VMware.</option><option value="vmware.vm.storage.committed[<url>,<uuid>]">Espaço de armazenamento comprometido com a máquina virtual VMware.</option><option value="vmware.vm.storage.uncommitted[<url>,<uuid>]">Espaço de armazenamento alocado mas não utilizado pela máquina virtual VMware.</option><option value="vmware.vm.storage.unshared[<url>,<uuid>]">Espaço de armazenamento não compartilhado pela máquina virtual VMware.</option><option value="vmware.vm.uptime[<url>,<uuid>]">Tempo de carga da máquina virtual VMware.</option><option value="vmware.vm.vfs.dev.read[<url>,<uuid>,<instance>,<mode>]">Estatísticas de leitura de disco da máquina virtual VMware.</option><option value="vmware.vm.vfs.dev.write[<url>,<uuid>,<instance>,<mode>]">Estatísticas de gravação de disco da máquina virtual VMware.</option><option value="vmware.vm.vfs.fs.size[<url>,<uuid>,<fsname>,<mode>]">Estatísticas do sistema de arquivos da máquina virtual VMware.</option>');  
      }

  }); //


  /*
  *FUNCIONALIDADE DO ITEM: CAPTURA O VALOR DO AGENTE
  */
  jQuery("#expressoes").change(function(){

      jQuery("#item_Expressoes").html(jQuery(this).val());

  }); //



});
