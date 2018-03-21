<h3>{{env("APP_NAME")}} - Pagamento Cancelado</h3>
<p>Olá {{$person_name}}!</p>
<p>Viemos por esta apenas informar que o seu pagamento para a inscrição #{{$subscription_id}} foi cancelado. Por esse motivo a inscrição também foi cancelada.</p>
<p>Caso ainda esteja no período de inscrições, você pode efetuar uma nova inscrição através do site do evento <a href="{{env("APP_URL_FRONT")}}/#/login">{{env("APP_NAME")}}</a>.
