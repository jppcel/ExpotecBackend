<h3>{{env("APP_NAME")}} - Novo Pedido</h3>
<p>Olá {{$person_name}}!</p>
<p>Viemos por esta apenas informar que foi criado um pedido para a inscrição #{{$subscription_id}}.</p>
<p>Dados do pacote selecionado:</p>
<ul>
  <li>Nome do Pacote: {{$package_name}}</li>
  <li>Preço do Pacote: {{number_format($package_price,2)}}</li>
</ul>
<p>Obs: Os dados aqui enviados são para informar a criação do pedido. Caso o procedimento de pagamento não foi concluído durante o processo de inscrição, a inscrição deverá ser re-efetuada, acessando <a href="{{env("APP_URL_FRONT")}}/login">o login do sistema</a> e selecionando novamente o pacote de inscrição e iniciando novamente o processo de pagamento.</p>
