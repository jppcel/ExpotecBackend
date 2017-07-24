<h3>{{env("APP_NAME")}} - Novo Pagamento</h3>
<p>Olá {{$person_name}}!</p>
<p>Viemos por esta apenas informar que o foi criado um pagamento para a inscrição #{{$subscription_id}}.</p>
<p>Dados do pacote selecionado:</p>
<ul>
  <li>Nome do Pacote: {{$package_name}}</li>
  <li>Preço do Pacote: {{number_format($package_price,2)}}</li>
</ul>
