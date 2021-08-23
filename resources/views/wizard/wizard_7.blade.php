@extends('layouts.wizard')
@section('styles')
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/avatar2/css/jquery.fileuploader-theme-avatar.css" media="all" rel="stylesheet">

<style>
    .location-search-block {
        position: relative;
        top: -26rem;
        z-index: 999;
    }

    #mapp {
        width: 100%;
        height: 400px;
    }

    .pac-container {
        z-index: 10000 !important;
    }

    .card .card-header {
    padding-top: 10px;
    background: #ffffff;
}

    hr {
    margin-top: 1.67rem;
    margin-bottom: 1.67rem;
    border: 0;
    border-top: 1px solid #e3e6ef;
}

.fileuploader-theme-avatar {
    position: relative;
    width: 160px;
    height: 160px;
    padding: 0;
    margin: 30px;
    background: none;
}
body {
   background: #fbfbfb;
}

.stuck {
  
  width: 100%;
  height: 400px;
 
  overflow-y: scroll;
}

.stuck p {
  margin: 10px;
}

</style>
@endsection

@section('content')

   <div class="mt-50">
   <div class="container-fluid">
      
      <div class=" checkout wizard1 wizard7 global-shadow px-sm-50 px-20 py-sm-50 py-30 mb-30 bg-white radius-xl w-100">
        
         <div class="row justify-content-center">
           
            <div class="col-xl-8">
               <div class="checkout-progress-indicator content-center">
                  <div class="checkout-progress">
                     <div class="step" id="1">
                        <span>1</span>
                        <span>Perfil</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step" id="2">
                        <span>2</span>
                        <span>Endereço</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step " id="3">
                        <span>3</span>
                        <span>Financeiro</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step " id="4">
                        <span>4</span>
                        <span>Delivery</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step" id="5">
                        <span>5</span>
                        <span>Horários</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step " id="6">
                        <span>6</span>
                        <span>Preferências</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step current" id="6">
                        <span>7</span>
                        <span>Termos de Uso</span>
                     </div>
                  </div>
               </div>
               <!-- checkout -->
               <div class="row justify-content-center">
                  <div class="col-xl-8 col-lg-9 col-sm-10">
                     <div class="card checkout-shipping-form px-30 pt-2 pb-30 border-color">
                        <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                           <h4 class="fw-500">7. Termos de Uso</h4>
                            </div>
                           
                           
                        <div class="card-body px-0 pb-0">


                          <div class="stuck">
                           <p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><strong><span style='font-size:19px;font-family:"Calibri",sans-serif;'>Termos e Condições Gerais de Contratação do COMPRA BAKANA</span></strong></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px; font-family: Calibri, sans-serif;">Por meio do presente instrumento, são estabelecidos os termos e as condições gerais para a contratação do Compra Bakana para a prestação dos Serviços (as &ldquo;<strong>Condições Gerais</strong>&rdquo;), os quais ficam incorporados, para todos os fins e efeitos, ao formulário de contratação do Compra Bakana (o &ldquo;<strong>Formulário</strong>&rdquo; e, em conjunto com a Condições Gerais, o &ldquo;<strong>Contrato</strong>&rdquo;).&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">1. Definições&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">1.1. Os termos e as expressões abaixo, quando iniciados em letra maiúscula nestes Termos e Condições ou no Contrato, no singular ou no plural, no masculino ou no feminino, terão os significados que lhes são indicados ao longo do Contrato ou abaixo:&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Estabelecimento</strong>&rdquo; significa empresa de com&eacute;rcio ou presta&ccedil;&atilde;o de servi&ccedil;os, bem como Micro Empreendedor Individual;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Grupo de Produtos e Servi&ccedil;os</strong>&rdquo; significa a relação de produtos e comercializados peldo Estabelecimento aos Clientes Finais, contendo o preço individualizado de cada um deles.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Painel Compra Bakana</strong>&rdquo; significa o software desenvolvido pelo Compra Bakana, por meio do qual os Pedidos dos Clientes Finais serão recebidos pelo Estabelecimento.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Loja Virtual</strong>&rdquo; significa o perfil do Estabelecimento na Plataforma Compra Bakana, contendo o nome, a marca, e endereço atualizado do Estabelecimento.</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Pedidos</strong>&rdquo; significa os pedidos de delivery e/ou agendamento de servi&ccedil;os do <strong>Grupo de Produtos e Servi&ccedil;os</strong>.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Plataforma Compra Bakana</strong>&rdquo; significa todos e quaisquer websites e aplicativos para celulares de titularidade do Compra Bakana, por meio dos quais, dentre outras funcionalidades, (a) o Estabelecimento, de um lado, pode ofertar os produtos do seu Cardápio aos Clientes Finais, e (b) os Clientes Finais, de outro lado, podem fazer pedidos de entrega de tais produtos aos Lojas.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Painel Compra Bakana</strong>&rdquo; significa a plataforma (web e mobile) desenvolvida pelo Compra Bakana para gestão da Loja Virtual do Estabelecimento, por meio da qual o Estabelecimento poderá divulgar e gerenciar as informações relativas ao seu Cardápio, dados cadastrais e operacionais, bem como obter relatórios de vendas e avaliações dos Clientes Finais.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&ldquo;<strong>Sinais Distintivos</strong>&rdquo; significa todas e quaisquer marcas, logotipos, fotografias e demais sinais distintivos de titularidade do Estabelecimento ou sobre as quais ele tenha autorização de uso, que venham a ser por ele disponibilizadas para a elaboração da Loja Virtual.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">2. Objeto&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">2.1. O Contrato tem por objeto (a) a promoção, pelo Compra Bakana, das atividades do Estabelecimento no território brasileiro por meio da Plataforma Compra Bakana, nos termos do art. 710 da Lei n. 10.406/2002; e (b) o licenciamento não exclusivo do uso dos Painel Compra Bakana pelo Compra Bakana &agrave; loja.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">3. Informações do Estabelecimento&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">3.1. O Estabelecimento é o único responsável por todas e quaisquer informações a respeito de suas atividades que venham a ser por ele disponibilizadas ao Compra Bakana e aos Clientes Finais (as &ldquo;<strong>Informações do Estabelecimento</strong>&rdquo;), e compromete-se a mantê-las, por meio do Painel Compra Bakana e/ou de quaisquer outros canais de comunicação disponibilizados pelo Compra Bakana, a todo tempo atualizadas e em estrita observância à legislação aplicável.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">3.2. O acesso do Estabelecimento ao Painel Compra Bakana será realizado por meio de nome de usuário e senha de uso pessoal e intransferível. O Estabelecimento reconhece que será o único responsável por todo e qualquer acesso ao Painel Compra Bakana por meio do seu nome de usuário e da sua senha.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">3.3. No prazo máximo de 30 dias contados da data de recebimento das Informações do Estabelecimento, o Compra Bakana disponibilizará a Loja Virtual na Plataforma Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">3.4. O Estabelecimento concorda que todos e quaisquer descontos e promoções oferecidas em outros canais de delivery por ele utilizados, sejam próprios ou de terceiros, deverão ser oferecidas também aos Clientes Finais.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">4. Pedidos&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.1. O Compra Bakana será exclusivamente responsável pela intermediação entre o Estabelecimento e os Clientes Finais, por meio da Plataforma Compra Bakana, e em nenhuma hipótese responderá por danos emergentes, lucros cessantes ou danos indiretos perante o Estabelecimento.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.2. O Estabelecimento será o único responsável pela execução e pela correção dos Pedidos feitos de forma inadequada ou incompleta, bem como pela completa observância de todas e quaisquer normas aplicáveis a suas atividades, incluindo, sem limitação, as normas sanitárias, e pela emissão e entrega de nota fiscal, recibo ou documento equivalente para os Clientes Finais com relação aos Pedidos.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.3. Os Pedidos serão recebidos pelo Estabelecimento por meio do Painel Compra Bakana, cabendo &agrave; loja aceitá-los, rejeitá-los ou cancelá-los também por meio do Painel Compra Bakana, sendo vedado &agrave; loja rejeitar e/ou cancelar mais do que 5% dos Pedidos por ele recebidos dentro de cada mês.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.4. Na hipótese de o Compra Bakana concordar com a integração entre o Painel Compra Bakana e os sistemas utilizados pelo Estabelecimento para que o Estabelecimento possa receber os Pedidos, referida integração deverá ser regulada por meio de instrumento específico assinado entre o Compra Bakana e os fornecedores dos sistemas utilizados pelo Estabelecimento, contendo o cronograma de homologação e implantação da integração e as responsabilidades de cada Parte.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.5. O Estabelecimento deverá atualizar o status dos Pedidos por meio do Painel Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.6. O Estabelecimento se compromete a não preparar e/ou entregar aos Clientes Finais, conforme o caso, os Pedidos que houverem sido por eles cancelados antes de sua aceita&ccedil;&atilde;o no Painel Compra Bakana, independentemente do motivo do cancelamento.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.6. Caso o Pedido contenha bebidas alcóolicas ou quaisquer outros produtos cujo consumo possua restrições, nos termos da legislação aplicável, o Estabelecimento deverá tomar as medidas necessárias para confirmar que o Cliente Final possui idade legal para o consumo de tais produtos.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">4.7. O Estabelecimento assume, em caráter irrevogável, irretratável e irreversível, a obrigação de manter o Compra Bakana a todo tempo livre e indenizado de todas e quaisquer perdas, danos e demandas que o Compra Bakana eventualmente venha a sofrer de Clientes Finais ou quaisquer outros terceiros em decorrência da execução e entrega dos Pedidos pelo Estabelecimento ou da violação pelo Estabelecimento destas Condições Gerais ou de qualquer legislação a ele aplicável.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">5. Entrega dos Pedidos&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">5.1. A (a) a entrega dos Pedidos poder&aacute; ser feita pelo próprio Estabelecimento ou (b) a entrega poderá ser feita por entregadores parceiros do Compra Bakana. Somente uma destas duas op&ccedil;&otilde;es deve ser feita pelo Estabelecimetno nas configura&ccedil;&otilde;es no Painel Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">5.2. Para a entrega feita pelo pr&oacute;prio Estabelecimento, este deverá (a) definir a área de entrega dos Pedidos por meio do Painel Compra Bakana; e (b) definir o valor da taxa de entrega a ser cobrada dos Clientes Finais.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">5.3. Para a entrega por entregadores parceiros do Compra Bakana, o valor da taxa de entrega a ser&aacute; definida pelo Compra Bakana.</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">6. Pagamento dos Pedidos&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.1. O Estabelecimento concorda que o Compra Bakana disponibilizará aos Clientes Finais um sistema de pagamento online integrado à Plataforma Compra Bakana (o &ldquo;<strong>Compra Bakana Pay</strong>&rdquo;). Dessa forma, o Estabelecimento outorga ao Compra Bakana, nos termos do art. 684 da Lei n. 10.406/2002, poderes para que o Compra Bakana possa contratar, em nome do Estabelecimento, todos e quaisquer serviços necessários ou úteis à disponibilização e manutenção do Compra Bakana Pay, incluindo, mas sem se limitar a isto, serviços de credenciamento de estabelecimentos comerciais em arranjos de pagamento, de coleta, processamento e liquidação de transações com cartões de crédito, débito e Pix, de abertura de contas de pagamento em instituições de pagamento parceiras do Compra Bakana, dentre outros.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.1.1. O Compra Bakana poderá fornecer aos Parceiros de Entrega, diretamente ou por meio de terceiros, equipamentos <em>point of sale&nbsp;</em>&ndash; POS ou outros equipamentos similares (os &ldquo;<strong>Meios de Pagamento Presenciais do Compra Bakana</strong>&rdquo;) que permitam aos Clientes Finais realizarem os pagamentos dos Pedidos diretamente a tais Parceiros de Entrega, sendo certo que os Meios de Pagamento Presenciais do Compra Bakana integrarão, para todos os fins e efeitos, o Compra Bakana Pay.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.1.2. Os Pedidos pagos por meio do Compra Bakana Pay serão repassados &agrave; loja no prazo e na forma previstos na Cláusula 8.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.1.3. Em caso de pagamento realizado por meio do Compra Bakana Pay, eventuais Chargebacks serão assumidos pelo Compra Bakana, devendo os valores dos respectivos Pedidos serem incluídos/adicionados nas mensalidades do Estabelecimento. Para os fins do Contrato, &ldquo;<strong>Chargeback</strong>&rdquo; significa um Pedido cujo pagamento tenha sido realizado por meio do Compra Bakana Pay e que tenha sido estornado com sucesso pelo titular do cartão utilizado no pagamento, incluindo em decorrência de pagamento fraudulento, resultando no cancelamento da transferência, pelos fornecedores do Compra Bakana Pay, do valor do Pedido para o Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.1.4. Fica a crit&eacute;rio do Estabelecimento &nbsp;a utiliza&ccedil;&atilde;o do Compra Bakana Pay, sendo isto configurado no Painel Compra Bakana.</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.1.5. O Estabelecimento pagará ao Compra Bakana uma comissão por Pedido pago por meio do Compra Bakana Pay, a qual será definida pelas Partes no Formulário (a &ldquo;<strong>Taxa do Compra Bakana Pay</strong>&rdquo;).&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.1.6. A <strong>Taxa do Compra Bakana Pay&nbsp;</strong>tamb&eacute;m incide sobre o valor de entrega por meios pr&oacute;prios do estabelecimento.</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.2. O Estabelecimento pode optar por disponibilizar aos Clientes Finais o pagamento de forma presencial o por outros meios pr&oacute;prios, no ato da entrega do Pedido, diretamente aos entregadores do Estabelecimento ou por retirada direta no Estabelecimento (o &ldquo;<strong>Pagamento Por Meios Pr&oacute;prios</strong>&rdquo;).&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">6.2.1. Na hipótese de o Cliente Final optar pelo <strong>Pagamento Por Meios Pr&oacute;prios</strong>, este ato n&atilde;o tem qualquer rela&ccedil;&atilde;o comercial ou financeira com o Compra Bakana, n&atilde;o sendo devida a <strong>Taxa do Compra Bakana Pay</strong>.</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">7. Remuneração&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">7.1. Pela prestação do Serviço, o Estabelecimento pagará ao Compra Bakana Remuneração composta pelos seguintes valores: (a) &ldquo;<strong>Mensalidade</strong>&rdquo;, correspondente a uma remuneração mensal fixa, como contrapartida ao licenciamento não exclusivo do uso do Painel Compra Bakana; e (b) <strong>Taxa do Compra Bakana Pay;</strong></span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">8. Forma de Pagamento e Repasse&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">8.1. Com relação aos Pedidos pagos atrav&eacute;s do <strong>Compra Bakana Pay</strong>, o valor l&iacute;quido destinado ao Estabelecimento, descontada a <strong>Taxa do Compra Bakana Pay</strong> , ser&aacute; creditada em nome do Estabelecimento em conta de pagamento em institui&ccedil;&atilde;o de pagamento definida pelo Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">8.1.1. O Estabelecimento, por meio do Painel Compra Bakana realizar&aacute; seus pedidos de saque dos valores (<strong>Repasse</strong>) que ficam dispon&iacute;veis integralmente para saque no per&iacute;odo de 30 dias ap&oacute;s o recebimento, com a possibilidade de antecipa&ccedil;&otilde;es mediante taxas vari&aacute;veis apresentadas no Painel Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">8.1.2. O Repasse &eacute; sempre transferido &agrave; conta banc&aacute;ria indicada pelo Estabelecimento nas configura&ccedil;&otilde;es do Painel Compra Bakana, , em 1 dia &uacute;til, devendo ser de titularidade do Estabelecimento e verificada pela Equipe Compra Bakana. A conta banc&aacute;ria pode se alterada a qualquer momento, mas estar&aacute; apta para receber o Repasse sem at&eacute; 5 dias &uacute;teis ap&oacute;s sua informa&ccedil;&atilde;o;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">8.2. O Estabelecimento poderá acompanhar, por meio do Painel Compra Bakana, as informações a respeito dos Repasses e dos Pedidos recebidos por meio da Plataforma Compra Bakana, os quais poderão ser questionados pelo Estabelecimento até às 10:00h do dia seguinte ao seu recebimento, desde que sejam indicados, com o maior número de detalhes possível, os motivos do seu questionamento. O não questionamento dos Pedidos no prazo previsto nesta Cláusula será considerado, para todos os fins e efeitos, como uma concordância irrevogável e irretratável do Estabelecimento quanto aos Pedidos recebidos e concluídos no dia imediatamente anterior, os quais serão integralmente considerados pelo Compra Bakana no cálculo do Repasse correspondente.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">9. Exclusividade&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">9.1. O Estabelecimento declara, por meio da assinatura no Formulário, que está ciente e concorda que o Compra Bakana poderá prestar os serviços objeto deste Contrato a quaisquer outros estabelecimentos, ainda que estes sejam direta ou indiretamente concorrentes do Estabelecimento.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">10. Avaliações&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">10.1. O Compra Bakana poderá disponibilizar na Plataforma Compra Bakana as avaliações sobre os Pedidos realizadas pelos Clientes Finais, de acordo com as estipulações dispostas na &ldquo;<strong>Política de Avaliações</strong>&rdquo; disponível no Painel Compra Bakana. O Estabelecimento reconhece e concorda que o Compra Bakana não terá qualquer responsabilidade pelas Avaliações que forem feitas pelos Clientes Finais.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">10.2. O Estabelecimento se compromete a sempre responder as Avaliações dos Clientes Finais de forma polida e prestativa, de acordo com as melhores práticas de mercado e com a utilização adequada e correta da língua portuguesa. O Estabelecimento deverá, no menor tempo possível, entrar em contato com os Clientes Finais que houverem mantido tratativas com o Compra Bakana, tomando todas e quaisquer providências necessárias para garantir a total satisfação dos Clientes Finais.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">11. Propriedade Intelectual&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">11.1. Todos e quaisquer direitos de propriedade intelectual ou industrial relativos à Plataforma Compra Bakana e/ou ao Painel Compra Bakana pertencem única e exclusivamente ao Compra Bakana. Em nenhuma hipótese, o Contrato implica transferência, no todo ou em parte, de qualquer direito de propriedade intelectual ou industrial pelo Compra Bakana para o Estabelecimento. O Estabelecimento se compromete a (a) utilizar a Plataforma Compra Bakana e o Painel Compra Bakana de acordo com as suas finalidades e exigências técnicas; (b) disponibilizar meio adequado para a implantação e a utilização do Painel Compra Bakana, conforme instruções do Compra Bakana, incluindo, sem limitação, com relação a hardware, rede, pessoas capacitadas etc.; (c) responsabilizar-se legalmente por quaisquer dados e informações que venham a ser armazenados pelo Estabelecimento no Painel Compra Bakana; (d) não fazer ou distribuir quaisquer cópias do Painel Compra Bakana; (e) não alterar, combinar, adaptar, traduzir, decodificar, fazer ou solicitar a terceiros engenharia reversa do Painel Compra Bakana; (f) não criar trabalhos deles derivados ou solicitar que terceiros o façam; e (g) não ceder, licenciar, sublicenciar ou de qualquer outra forma dispor do Painel Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">11.2. Caso o Estabelecimento deseje veicular quaisquer sinais distintivos do Compra Bakana em seus estabelecimentos, no Cardápio ou em qualquer outro material de divulgação, deverá obter a prévia autorização por escrito do Compra Bakana e somente poderá fazê-lo de acordo com a orientação do Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">11.3. O Estabelecimento outorga ao Compra Bakana, por meio da assinatura no Contrato e pelo seu prazo de vigência, licença gratuita de uso dos Sinais Distintivos, os quais serão veiculados na Plataforma Compra Bakana e em outras mídias, exclusivamente para fins de cumprimento do objeto do Contrato, responsabilizando-se o Compra Bakana pelo uso indevido que fizer de referidos Sinais Distintivos.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">11.3.1. O Estabelecimento declara ser o único e exclusivo titular ou possuir a devida autorização de uso dos titulares dos direitos da propriedade intelectual sobre os Sinais Distintivos, reconhecendo que o Compra Bakana poderá solicitar a comprovação de referida titularidade ou autorização.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">12. Inadimplemento&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">12.1. O Estabelecimento reconhece e concorda que, a inadimpl&ecirc;ncia acarretar&aacute; &nbsp;desativação da Loja Virtual a partir do dia subsequente ao vencimento</span>, sendo reabilitada em at&eacute; dois dias &uacute;teis ap&oacute;s a regulariza&ccedil;&atilde;o dos valores em aberto.</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">&nbsp;<strong>13. Alteração destas Condições Gerais&nbsp;</strong></span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">13.1. Do Estabelecimento reconhece e concorda que o Compra Bakana poderá alterar estas Condições Gerais a qualquer tempo, mediante o envio de notificação escrita &agrave; loja, por meio do Painel Compra Bakana, com antecedência mínima de 30 (trinta) dias contados da data de entrada em vigor da nova versão deste instrumento.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">13.1.1. Se a alteração destas Condições Gerais tiver um efeito adverso importante sobre do Estabelecimento e do Estabelecimento não concordar com a alteração, do Estabelecimento poderá apresentar notificação escrita ao Compra Bakana no prazo de até 30 (trinta) dias após o recebimento da notificação da mudança prevista na Cláusula 13.1. O Compra Bakana entrará em contato com do Estabelecimento para discutir os motivos pelos quais do Estabelecimento não concorda com a alteração destas Condições Gerais. Se do Estabelecimento continuar a se recusar a aceitar a mudança e o Compra Bakana recusar-se a retirar a mudança anunciada, qualquer das Partes poderá rescindir o Contrato, mediante o envio de comunicação por escrito à outra Parte.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">13.1.2. Do Estabelecimento reconhece e concorda que não terá o direito de apresentar objeção a qualquer alteração nestes Termos e Condições que o Compra Bakana venha a implantar para o cumprimento de exigências legais ou regulatórias. Para essas alterações, períodos de notificação menores podem ser aplicados pelo Compra Bakana, conforme necessário para o cumprimento dos requisitos relevantes.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">13.2. O não envio da notificação de objeção prevista na Cláusula 13.1.1 valerá como uma concordância irrevogável e irretratável do Estabelecimento quanto à alteração destas Condições Gerais pelo Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">14. Das Boas Práticas de Integridade&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">14.1. Ao cumprir as obrigações previstas no Contrato, do Estabelecimento, seus funcionários, agentes e representantes devem respeitar, plenamente, todas as leis aplicáveis sobre anticorrupção, antissuborno, antiterrorismo, antiboicote, antilavagem de dinheiro e de sanções econômicas e de defesa da concorrência, incluindo, mas não limitado à Lei n. 12.846/2013, e conduzir as suas atividades, de acordo com os mais rigorosos conceitos e princípios da ética, integridade e boa-fé, evitando por si e/ou por meio de terceiros, participação em atividades comerciais ilícitas, incluindo concorrência antiética ou desleal e demais ilícitos penais, das quais, em função da atividade exercida, do Estabelecimento delas sabe ou deveria saber.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">14.2. Do Estabelecimento se compromete a fornecer, no prazo máximo de 30 (trinta) dias, documentos no formato original e de forma organizada, bem como esclarecimentos, quando solicitado, seja para cadastro, seja para fins de auditoria. Se compromete também a, durante o prazo de vigência do Contrato e um período adicional de 5 (cinco) anos após o seu término, manter livros contábeis precisos, completos e registros apurados em conexão com os Serviços. O não fornecimento dos documentos resultará na suspensão do Repasse até o efetivo fornecimento dos documentos solicitados pelo Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">14.3. Do Estabelecimento deverá informar ativamente o Compra Bakana sobre ações ou recursos relacionados a processos com alegações de corrupção, lavagem de dinheiro ou competição limitada, assim como investigações e medidas coercitivas decorrentes de violação de lei.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">14.4. Do Estabelecimento se compromete a manter o Compra Bakana livre e indene de todo e qualquer dano e perda, incluindo multa, custo, obrigação de reparação de danos, taxas, juros, honorários advocatícios ou outras responsabilidades, incluindo as criminais, imputadas ao Compra Bakana a partir de investigação ou qualquer outro procedimento judicial ou administrativo em face do Compra Bakana, mas que tenha sido originado a partir de qualquer ação ou omissão do Estabelecimento, diretamente, ou por seus administradores, sócios, empregados, agentes, prepostos ou representantes, que configurem uma violação das leis e normas da Cláusula.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">14.5. O descumprimento desta Cláusula garante ao Compra Bakana a faculdade de rescindir o Contrato.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">15. Privacidade de Dados&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">15.1. Do Estabelecimento reconhece que poderá ter acesso a dados enviados pelo Compra Bakana que identifiquem ou permitam a identificação de indivíduos (os &ldquo;<strong>Dados Pessoais</strong>&rdquo;). As Partes concordam que a execução do presente Contrato será guiada (i) pelos princípios de <em>privacy by design</em>; e (ii) pelas leis brasileiras aplicáveis, incluindo, mas sem se limitar, o Marco Civil da Internet e o Código de Defesa do Consumidor.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">15.2. O acesso, utilização, coleta, produção, recepção, classificação, acesso, reprodução, transmissão, distribuição, processamento, arquivamento, armazenamento, eliminação, avaliação ou controle da informação, modificação, comunicação, transferência, difusão ou extração e o compartilhamento peldo Estabelecimento de Dados Pessoais que lhe forem enviados pelo Compra Bakana será autorizado e limitado ao estritamente necessário para a execução deste Contrato. Fica vedada a utilização dos Dados Pessoais para quaisquer finalidades que não tenham sido expressamente autorizadas pelos Clientes Finais e/ou pelo Compra Bakana.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">15.3. Do Estabelecimento somente poderá realizar o tratamento de Dados Pessoais recebidos por força deste Contrato durante a sua vigência e com a finalidade estrita de cumprir as obrigações do presente instrumento.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">15.4. Fica vedado ao Estabelecimento transferir, no todo ou em parte, os Dados Pessoais que lhe forem enviados pelo Compra Bakana para quaisquer terceiros não necessários ao cumprimento das obrigações por ele assumidas neste Contrato, mesmo que de forma agregada e/ou anonimizada.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">15.5. O Estabelecimento deverá promover a exclusão definitiva de quaisquer Dados Pessoais que lhe foram transmitidos por força deste Contrato por solicitação dos respectivos titulares dos Dados Pessoais ou do Compra Bakana, com exceção dos Dados Pessoais que deverão ser mantidos por conta de obrigações legais.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">15.6. O Estabelecimento deverá notificar o Compra Bakana, em até 48 (quarenta e oito) horas a partir do seu conhecimento, acerca de qualquer vazamento ou comprometimento de suas bases de dados relacionadas com o presente Contrato, bem como acerca de qualquer violação da legislação de privacidade e de proteção de dados pessoais que tiver ciência com relação aos dados em sua custódia, inclusive violação acidental ou culposa.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><strong><span style="font-family: Calibri, sans-serif;">16. Disposições Gerais&nbsp;</span></strong></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.1. A relação jurídica estabelecida entre as Partes é de prestação de serviços, de modo que o Contrato não estabelece relação de consumo, trabalho, representação comercial ou de qualquer outra natureza, sendo certo que as Partes são e permanecerão a todo tempo autônomas e independentes entre si.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.2. Do Estabelecimento reconhece e concorda que o Compra Bakana poderá ceder e transferir os seus direitos e obrigações previstos no Contrato a quaisquer terceiros.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.3. As relações jurídicas estabelecidas pelo Contrato são celebradas em caráter irrevogável e irretratável, obrigando as Partes e seus sucessores, seja qual for o título da sucessão. A eventual tolerância por qualquer das Partes quanto ao inexato ou impontual cumprimento das obrigações da outra Parte valerá tão somente de forma isolada, não constituindo renúncia ou novação.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.4. Caso qualquer disposição do Contrato se torne nula ou ineficaz, a validade ou eficácia das disposições restantes não será afetada, permanecendo em pleno vigor e efeito e, em tal caso, as Partes entrarão em negociações de boa-fé visando substituir a disposição ineficaz por outra que, tanto quanto possível e de forma razoável, atinja a finalidade e os efeitos desejados.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.5. Do Estabelecimento reconhece e concorda que o Compra Bakana, a seu exclusivo critério, poderá fornecer a terceiros interessados, a título gratuito ou oneroso, dados e informações gerais obtidos a partir do seu banco de dados, incluindo, sem limitação, informações a respeito de padrões de comportamento, hábitos de consumo e outras estatísticas. Referidos dados e informações em nenhuma hipótese indicarão o nome do Estabelecimento ou serão apresentados de modo que possam ser identificados como lhe sendo atribuídos especificamente.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.6. As disposições contidas no Contrato representam a totalidade dos entendimentos mantidos entre as Partes, superando todos e quaisquer entendimentos anteriores, verbais ou escritos, consubstanciando-se na declaração final de suas vontades.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.7. Do Estabelecimento declara que está ciente e de acordo com que o Compra Bakana preste os serviços objeto destas Condições Gerais a quaisquer outros estabelecimentos, ainda que estes sejam direta ou indiretamente concorrentes do Estabelecimento.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.8. Caso do Estabelecimento tenha assinado o Contrato por meio de qualquer ferramenta eletrônica, o Compra Bakana poderá solicitar, a qualquer momento, que do Estabelecimento assine e rubrique uma via física do Contrato e destas Condições Gerais. Caso do Estabelecimento não cumpra essa solicitação do Compra Bakana no prazo de até 5 (cinco) dias úteis contados da data de recebimento da notificação do Compra Bakana a este respeito, o Compra Bakana terá o direito de suspender, total ou parcialmente, os serviços descritos nestes Termos e Condições, até que do Estabelecimento tenha cumprido tal solicitação.&nbsp;</span></span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;"><span style="font-family: Calibri, sans-serif;">16.9.&nbsp;</span>Aplica-se ao presente contrato a legisla&ccedil;&atilde;o nacional brasileira.</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><br></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">17. As partes elegem o foro da comarca de Belo Horizonte, MG, para dirimir quest&otilde;es relativas a este contrato.</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">E por estarem assim justas e contratadas, as partes assinam digitalmente o presente.</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">Belo Horizonte, {{--  @php date_default_timezone_set('America/Sao_Paulo');
  setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
    echo Carbon\Carbon::now()->formatLocalized('%d de %B de %Y'); @endphp --}} </span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">Andr&eacute; Lu&iacute;s Parreira</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style="font-size: 14px;">Compra Bakana Ltda</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'><span style="font-size: 14px;">&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:16px;font-family:"Calibri",sans-serif;margin:0cm;'>&nbsp;</p>

                          </div>








                          
                          
                                       <div class="edit-profile__body">
                                          
                                          
                                          <form 
                                       action="{{ route('wizard.savewizard_7') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       data-parsley-validate
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                     <br><br>
                                       <div class="checkbox-theme-default custom-checkbox mt-60 mb-30 ">
                                          <input class="checkbox" type="checkbox" required 
                                          data-parsley-error-message="É necessário concordar com os Termos de Uso do Compra Bakana"
                                          id="check-un3" name="check_terms_conditions" @if($restaurant->check_terms_conditions) checked="checked" @endif>
                                          <label for="check-un3">
                                          <span class="checkbox-text">
                                          Concordo com todas as cláusulas deste Contrato e Termos de Serviço do Compra Bakana
                                          </span>
                                          </label>
                                       </div>
            
          
                                             <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                                <button type="submit" id="submit" class="btn btn-danger btn-default btn-squared mr-15">Salvar e Continuar<i class="ml-10 mr-0 las la-arrow-right"></i>
                                                </button>
                                                
                                          </div>
                                          
                                             
                                          </form>
                                       </div>
                              
                          


        



                        </div>
                     </div>
                     <!-- ends: card -->
                  </div>
                  <!-- ends: col -->
               </div>
            </div>
            <!-- ends: col -->
         </div>
      </div>
      <!-- End: .global-shadow-->
   </div>
</div>
@endsection

@section('scripts')






<script>
















$(document).ready(function () {




/* var check_terms_conditions= "<?php  echo $restaurant->check_terms_conditions; ?>";  

if (check_terms_conditions==1)  {
  
$('#submit').prop("disabled", false);
}else{
   $('#submit').prop("disabled", true);
}


$("[name='check_terms_conditions']").on("change", function () {
if ($(this).val() == 1) {
    
   $('#submit').prop("disabled", false);
}else{
   $('#submit').prop("disabled", true);
} */



});







// $('.form-control-uniform').uniform();

$('#downloadSampleRestaurantCsv').click(function (event) {
event.preventDefault();
window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
});








});



</script>
@endsection
