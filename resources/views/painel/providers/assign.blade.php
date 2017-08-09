<html>
  <head>
    <title>{{env("APP_NAME")}} - Gerador de Etiquetas</title>
    <link href="https://fonts.googleapis.com/css?family=Zilla+Slab:400,700" rel="stylesheet"/>
    <style>
      body{
        width: 216mm;
        height: 279mm;
        font-family: 'Zilla Slab', serif;
        border: 0;
        margin: 0;
        padding: 0;
        text-transform: uppercase;
        text-align: center;
      }
      td{
        text-align: center;
      }
    </style>
  </head>
  <body>
    <table width="100%" border="1">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Pacote</th>
          <th>Status</th>
          <th width="20%">Assinatura</th>
        </tr>
      </thead>
      <tbody>
        @foreach($subscriptions as $subscription)
          <tr>
            <td>{{$subscription->id}}</td>
            <td>{{$subscription->person->name}}</td>
            <td>{{$subscription->package->name}}</td>
            <td>
              @if($subscription->onepayment->paymentStatus == 2)
                2 - Pagamento Pendente
              @endif
              @if($subscription->onepayment->paymentStatus == 3)
                3 - Pagamento Confirmado
              @endif
            </td>
            <td></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
