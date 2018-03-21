<h3>{{env("APP_NAME")}} - Recuperar Senha</h3>
<p>Recebemos uma solicitação de alteração de senha para o seu cadastro na {{env("APP_NAME")}}.</p>
<p>Caso você tenha realmente solicitado a alteração de senha, por favor, clique no seguinte link: <a href="{{$link}}">{{$link}}</a></p>.
<p>Caso você não tenha solicitado a alteração de senha, por favor, desconsidere esse email.</p>
<p>O link irá expirar no dia {{date("d/m/Y",time()+(60*60*24))}} às {{date("H:i",time()+(60*60*24))}}.</p>
