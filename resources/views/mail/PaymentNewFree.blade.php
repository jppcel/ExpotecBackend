<h3>{{env("APP_NAME")}} - Inscrição Confirmada</h3>
<p>Olá {{$person_name}}!</p>
<p>Viemos por esta apenas informar que foi confirmada a inscrição #{{$subscription_id}}.</p>
<p>Dados do pacote selecionado:</p>
<ul>
  <li>Nome do Pacote: {{$package_name}}</li>
  <li>Preço do Pacote: {{number_format($package_price,2)}}</li>
</ul>
