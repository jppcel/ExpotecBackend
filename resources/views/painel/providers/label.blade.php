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
      }
      .label{
        width: 49%;
        height: 35mm;
        margin-left: 1%;
        margin-bottom: 4mm;
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
        width: 100%;
        height: 56px;
      }
      .label div.text .name span{
        font-size: 1.2rem;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
        width: 100%;
        line-height: 56px;
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

      .nextPage{
        page-break-after: always;
        width: 100%;
        overflow: hidden;
        margin-bottom: 40mm;
      }

      .mTopPage{
        margin-top: 17mm;
      }

      .mBottomPage{
        margin-bottom: 17mm;
      }
    </style>
  </head>
  <body>
    @php($i=0)
    @foreach($subscriptions as $subscription)
    @if($i == 0)<div class="nextPage">@endif
      @if($subscription == false)
        <div class="label @if($i == 0 || $i == 1) mTopPage @endif  @if($i == 14 || $i == 15) mBottomPage @endif"></div>
      @else
        <div class="label @if($i == 0 || $i == 1) mTopPage @endif  @if($i == 14 || $i == 15) mBottomPage @endif">
          <div class="text">
            <div class="name"><span>
              @if(strlen($subscription->name) > 23)
                @php
                  $subsStr = explode(" ", $subscription->name);
                  echo $subsStr[0]." ".$subsStr[(count($subsStr)-1)];
                @endphp
              @else
                {{$subscription->name}}
              @endif
            </span></div>
            <div class="secondLine">
              @if($subscription->college)
                <div class="college">{{$subscription->college}}</div>
              @endif
              <div class="package">{{$subscription->package_name}}</div>
            </div>
          </div>
          <div class="qrcode">
            {!!QrCode::format("svg")->size(85)->margin(2)->generate($subscription->id)!!}
            {{$subscription->id}}
          </div>
        </div>
        @endif
      @if($i == 13 || $i == (count($subscriptions)-1))</div>@endif
      @if($i++ == 13)
        @php($i=0)
      @endif
    @endforeach
  </body>
</html>
