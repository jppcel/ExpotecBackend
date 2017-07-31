<html>
  <head>
    <title>{{env("APP_NAME")}} - Gerador de Etiquetas</title>
    <link href="https://fonts.googleapis.com/css?family=Zilla+Slab:400,700" rel="stylesheet"/>
    <style>
      body{
        width: 216mm;
        height: 279mm;
        font-family: 'Zilla Slab', serif;
      }
      .label{
        width: 95mm;
        height: 27mm;
        padding: 3.45mm 3.3mm;
        margin: 2mm;
        float:left;
        background: #eee;
      }
      .label div.text{
        width: 73%;
        height: 27mm;
        text-align: center;
        float: left;
        margin-right: 1%;
      }
      .label div.text .name{
        font-size: 1.2rem;
      	display: flex;
      	flex-direction: column;
      	justify-content: center;
        width: 100%;
        height: 56px;
      }
      .label div.text .name span{
        font-size: 1.2rem;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
        width: 100%;
      }
      .label div.text .secondLine{
        width: 100%;
        height: 44.5px;
      }
      .label div.text .college{
        font-size: 0.9rem;
        display: block;
        width: 100%;
      }
      .label div.text .package{
        font-size: 0.8rem;
        display: block;
        width: 100%;
      }
      .label div.qrcode{
        width: 25%;
        height: 27mm;
        margin-left: 1%;
        text-align: center;
        float: left;
      	display: flex;
      	flex-direction: column;
      	justify-content: center;
      }
      .label div.qrcode img{
        width: 100%;
      }
    </style>
  </head>
  <body>
    @foreach($subscriptions as $subscription)
      <div class="label">
        <div class="text">
          <div class="name"><span>
            @if(strlen($subscription->person->name) > 34)
              @php
                $subsStr = explode(" ", $subscription->person->name);
                echo $subsStr[0]." ".$subsStr[(count($subsStr)-1)];
              @endphp
            @else
              {{$subscription->person->name}}
            @endif
          </span></div>
          <div class="secondLine">
            @if($subscription->person->college)<div class="college">{{$subscription->person->college}}</div>@endif
            <div class="package">{{$subscription->package->name}}</div>
          </div>
        </div>
        <div class="qrcode">
          <img src="{{env("APP_URL")}}/label/qrcode/{{$subscription->id}}">
          {{$subscription->id}}
        </div>
      </div>
    @endforeach
  </body>
</html>
