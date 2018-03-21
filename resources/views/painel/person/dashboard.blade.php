@extends("painel.includes.default")

@section("page_title", "Dashboard: ".$args["person_dashboard"]->name)

@section("css")
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
  <style>
    .select2-selection__choice{
      color: #000 !important;
    }
    .select2-selection__choice[title="Admin"]{
      background: orange !important;
      color: #fff !important;
    }
    .select2-selection__choice[title="Super-Admin"]{
      background: red !important;
      color: #fff !important;
    }

    .modal{
      text-align: center;
    }
    #checks th, #checks td.center{
      text-align: center;
    }
  </style>
@endsection

@section("breadcumbs")
<ol class="breadcrumb">
  <li><a href="{{url("/")}}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{url("/person/list")}}"><i class="fa fa-users"></i> Pessoas</a></li>
  <li class="active"> <i class="fa fa-dashboard"></i> Dashboard: {{$args["person_dashboard"]->name}}</li>
</ol>
@endsection

@section("content")
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        @php($hasPaid = false)
        @foreach($args["person_dashboard"]->packages->all() as $subscription)
          @foreach($subscription->payment->all() as $payment)
            @if($payment->paymentStatus == 3)
              <h3>#{{$subscription->id}}</h3>
              @php($hasPaid = true)
              @php($args["person_subscription"] = $subscription)
            @endif
          @endforeach
        @endforeach
        @if(!$hasPaid)
          <h3>N.P.</h3>
        @endif
        <p>Inscrição Paga</p>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        @if($hasPaid)
          <h4><strong>{{$args["person_subscription"]->package->name}}</strong></h4>
        @else
          <h3>N.P.</h3>
        @endif

        <p>Pacote</p>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        @if($hasPaid)
          <h3><sup style="font-size: 20px">R$</sup> {{number_format($args["person_subscription"]->package->value,2)}}</h3>
        @else
          <h3>N.P.</h3>
        @endif

        <p>Valor do Pacote</p>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        @if($args["person_dashboard"]->user->is_admin == 1)
          <h3>Sim</h3>
        @else
          <h3>Não</h3>
        @endif

        <p>É admin?</p>
      </div>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-8 col-md-8 connectedSortable">
    <!-- Inscrições -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Inscrições</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <div class="box box-body">
        <table width="100%" class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Pacote</th>
              <th>Valor</th>
              <th>Pedidos</th>
            </tr>
          </thead>
          <tbody>
            @foreach($args["person_dashboard"]->packages->all() as $subscription)
              <tr>
                <td>{{$subscription->id}}</td>
                <td>{{$subscription->package->name}}</td>
                <td>{{number_format($subscription->package->value,2)}}</td>
                <td>
                  @foreach($subscription->payment->all() as $payment)
                    #{{$payment->id}} -
                    @if($payment->paymentStatus == 0)
                      <span class="badge bg-red">0 - Cancelado</span>
                    @else
                      @if($payment->paymentStatus == 1)
                        <span class="badge">1 - Aguardando Pagamento</span>
                        @if($args["is_admin"])<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalCancel_{{$payment->id}}" title="Efetuar Cancelamento do Pagamento"><i class="fa fa-times-circle"></i></button>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalConfirm_{{$payment->id}}" title="Efetuar Confirmação do Pagamento"><i class="fa fa-check-circle"></i></button>
                        <!-- Modal Cancelamento -->
                        <div class="modal fade modal-danger" id="modalCancel_{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Efetuar Cancelamento - Pagamento #{{$payment->id}}</h4>
                              </div>
                              <div class="modal-body">
                                <h2>Você tem certeza que pretende fazer isso?</h2><br>
                                Ao efetuar um cancelamento manual, o sistema não irá mais verificar com o sistema de pagamento se o pagamento foi efetuado ou não, e assim, caso o pagamento seja efetuado, não será possível inserir no sistema.<br>
                                <h4>Você deseja ainda assim efetuar o cancelamento?</h4>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                                <a class="btn btn-danger" href="{{url("/person/payment/cancel/".$args["person_dashboard"]->id."/".$payment->id)}}">Efetuar o cancelamento</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Modal Confirmação -->
                        <div class="modal fade modal-warning" id="modalConfirm_{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Efetuar Confirmação - Pagamento #{{$payment->id}}</h4>
                              </div>
                              <div class="modal-body">
                                <h2>Você tem certeza que pretende fazer isso?</h2><br>
                                Ao efetuar a confirmação da inscrição manual, o sistema não irá mais validar se o pagamento foi efetuado, e assim não poderá verificar se o pagamento dessa inscrição foi realmente feito.
                                <h4>Você deseja ainda assim efetuar a confirmação?</h4>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                                <a class="btn btn-danger" href="{{url("/person/payment/confirm/".$args["person_dashboard"]->id."/".$payment->id)}}">Efetuar a confirmação</a>
                              </div>
                            </div>
                          </div>
                        </div>@endif
                      @else
                        @if($payment->paymentStatus == 2)
                          <span class="badge bg-blue">2 - Pagamento Pendente</span>
                          @if($args["is_admin"])<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalCancel_{{$payment->id}}" title="Efetuar Cancelamento do Pagamento"><i class="fa fa-times-circle"></i></button>
                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalConfirm_{{$payment->id}}" title="Efetuar Confirmação do Pagamento"><i class="fa fa-check-circle"></i></button>
                          <!-- Modal Cancelamento -->
                          <div class="modal fade modal-danger" id="modalCancel_{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Efetuar Cancelamento - Pagamento #{{$payment->id}}</h4>
                                </div>
                                <div class="modal-body">
                                  <h2>Você tem certeza que pretende fazer isso?</h2><br>
                                  Ao efetuar um cancelamento manual, o sistema não irá mais verificar com o sistema de pagamento se o pagamento foi efetuado ou não, e assim, caso o pagamento seja efetuado, não será possível inserir no sistema.<br>
                                  <h4>Você deseja ainda assim efetuar o cancelamento?</h4>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                                  <a class="btn btn-danger" href="{{url("/person/payment/cancel/".$args["person_dashboard"]->id."/".$payment->id)}}">Efetuar o cancelamento</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Modal Confirmação -->
                          <div class="modal fade modal-warning" id="modalConfirm_{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Efetuar Confirmação - Pagamento #{{$payment->id}}</h4>
                                </div>
                                <div class="modal-body">
                                  <h2>Você tem certeza que pretende fazer isso?</h2><br>
                                  Ao efetuar a confirmação da inscrição manual, o sistema não irá mais validar se o pagamento foi efetuado, e assim não poderá verificar se o pagamento dessa inscrição foi realmente feito.
                                  <h4>Você deseja ainda assim efetuar a confirmação?</h4>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                                  <a class="btn btn-danger" href="{{url("/person/payment/confirm/".$args["person_dashboard"]->id."/".$payment->id)}}">Efetuar a confirmação</a>
                                </div>
                              </div>
                            </div>
                          </div>@endif
                        @else
                          @if($payment->isFree)
                            <span class="badge bg-green">3 - Ingresso Gratuito</span>
                          @else
                            <span class="badge bg-green">3 - Pagamento Confirmado</span>
                          @endif
                          <form action="{{url("/label/generate/one/".$subscription->id)}}" method="post" target="_blank">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="Subscription_id" value="{{ $subscription->id }}">
                            <select name="position">
                              @for($i=1;$i<=14;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                              @endfor
                            </select>
                            <button class="btn btn-success btn-sm" href="{{url("/label/generate/".$subscription->id)}}" title="Gerar Etiqueta para Impressão" target="_blank"><i class="fa fa-print"></i></button>
                          </form>
                        @endif
                      @endif
                    @endif<br/>{{date("d/m/Y H:i",strtotime($payment->created_at))}}
                    @if($payment->log)
                      <ul>
                      @foreach($payment->log->all() as $log)
                        <li>
                          {{$log->user->person->name}}: {{$log->from}} -> {{$log->to}}
                        </li>
                      @endforeach
                      </ul>
                    @endif
                  @endforeach
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @if(!$hasPaid)
      @if($args["adminController"]->hasPermission([4,5]))
        <!-- Inscrição -->
        <div class="box box-primary collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title">Efetuar Inscrição</h3>
            <div class="pull-right box-tools">
              <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                <i class="fa fa-plus"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="{{url("/person/payment/newSubscription")}}" method="post">
            <div class="box-body">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="Person_id" value="{{ $args["person_dashboard"]->id }}">
              <div class="form-group @if ($errors->has('name')) has-error @endif">
                @foreach($args["packages"] as $package)
                  @if($package->coupon == null || $args["is_super_admin"])
                  <label>
                    <input type="radio" name="Package_id" value="{{$package->id}}"> {{$package->name}} - R$ {{number_format($package->value,2)}}
                  </label> <br/>
                  @endif
                @endforeach
              </div>
              <div class="box-footer">
                <button type="reset" class="btn btn-info pull-left">Cancelar</button>
                <button type="submit" class="btn btn-info pull-right">Atualizar</button>
              </div>
            </div>
            <!-- /.box-body -->
          </form>
        </div>
      @endif
    @endif
    <!-- Cadastro -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Cadastro</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="{{url("/person/update/register")}}" method="post">
        <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="Person_id" value="{{ $args["person_dashboard"]->id }}">
          <div class="form-group @if ($errors->has('name')) has-error @endif">
            <label for="name">Nome</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Insira o nome da pessoa" value="{{ $args["person_dashboard"]->name }}" required="required">
            @if ($errors->has('name'))
              <label class="control-label" for="name"><i class="fa fa-times-circle-o"></i> {{ $errors->first('name') }}</label><br>
            @endif
          </div>
          <div class="form-group @if ($errors->has('email')) has-error @endif">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="fulano@sicrano.com"  value="{{ $args["person_dashboard"]->email }}" required="required">
            @if ($errors->has('email'))
              <label class="control-label" for="email"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}</label><br>
            @endif
            <small><strong>IMPORTANTE!</strong> Essa informação é única, ou seja, não é permitido multiplos cadastros com o mesmo endereço de email!</small>
          </div>
          <div class="form-group @if ($errors->has('document')) has-error @endif">
            <label for="cpf">Documento(CPF)</label>
            <input type="text" class="form-control" id="cpf" name="document" placeholder="xxx.xxx.xxx-xx" value="{{ $args["person_dashboard"]->document }}" required="required">
            @if ($errors->has('document'))
              <label class="control-label" for="cpf"><i class="fa fa-times-circle-o"></i> {{ $errors->first('document') }}</label><br>
            @endif
            <small><strong>IMPORTANTE!</strong> Essa informação também é única!</small>
          </div>
          <div class="form-group checkbox">
            <label>
              @php
                if(old('isStudent'))

              @endphp
              @if($args["person_dashboard"]->college || $args["person_dashboard"]->course)
                @php($isStudent = true)
              @else
                @php($isStudent = false)
              @endif

              {!! Form::checkbox('isStudent', 'isStudent', $isStudent, ['id' => 'isStudent']) !!} É aluno de alguma instituição?
            </label>
          </div>
          <div class="form-group isStudentOnly @if ($errors->has('college')) has-error @endif"@if(!$isStudent) style="display:none"@endif>
            <label for="college">Instituição</label>
            <input type="text" class="form-control" id="college" name="college" placeholder="Nome da IES" value="{{ $args["person_dashboard"]->college }}">
            @if ($errors->has('college'))
              <label class="control-label" for="college"><i class="fa fa-times-circle-o"></i> {{ $errors->first('college') }}</label><br>
            @endif
          </div>
          <div class="form-group isStudentOnly @if ($errors->has('course')) has-error @endif"@if(!$isStudent) style="display:none"@endif>
            <label for="course">Curso</label>
            <input type="text" class="form-control" id="course" name="course" placeholder="Nome do Curso" value="{{ $args["person_dashboard"]->course }}">
            @if ($errors->has('course'))
              <label class="control-label" for="course"><i class="fa fa-times-circle-o"></i> {{ $errors->first('course') }}</label><br>
            @endif
          </div>
          <div class="box-footer">
            <button type="reset" class="btn btn-info pull-left">Cancelar</button>
            <button type="submit" class="btn btn-info pull-right">Atualizar</button>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
    </div>
    <!-- Endereço -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Endereço</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="{{url("/person/update/address")}}" method="post">
        <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="Person_id" value="{{ $args["person_dashboard"]->id }}">
          <input type="hidden" id="City_id" name="City_id" @if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->city->id}}"@endif>
          <input type="hidden" id="TypeStreet_id" name="TypeStreet_id" @if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->typestreet->id}}"@endif>
          <div class="form-group @if ($errors->has('zipcode')) has-error @endif">
            <label for="name">CEP</label>
            <input type="text" name="zip" class="form-control" id="zipcode" placeholder="xxxxx-xxx"@if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->zip}}"@endif required="required">
            @if ($errors->has('zipcode'))
              <label class="control-label" for="name"><i class="fa fa-times-circle-o"></i> {{ $errors->first('zipcode') }}</label><br>
            @endif
            <small><strong>IMPORTANTE!</strong> Digite o CEP e tecle ENTER para preencher os campos.</small>
          </div>
          <div class="form-group @if ($errors->has('typestreet')) has-error @endif">
            <label for="typestreet">Tipo do Logradouro</label>
            <select name="typestreet" id="typestreet" class="form-control select2"  style="width: 100%;">
              <optgroup label="Tipo do Logradouro"></optgroup>
              <option value="">-- Selecione um --</option>
              @foreach($args["typestreet"] as $typestreet)
                <option value="{{$typestreet->id}}">{{$typestreet->name}}</option>
              @endforeach
            </select>
            @if ($errors->has('typestreet'))
              <label class="control-label" for="typestreet"><i class="fa fa-times-circle-o"></i> {{ $errors->first('typestreet') }}</label><br>
            @endif
          </div>
          <div class="form-group @if ($errors->has('street')) has-error @endif">
            <label for="street">Rua: </label>
            <input type="text" id="street" class="form-control" name="street" placeholder="Nome da Rua"@if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->street}}"@endif  required="required">
            @if ($errors->has('street'))
              <label class="control-label" for="street"><i class="fa fa-times-circle-o"></i> {{ $errors->first('street') }}</label><br>
            @endif
          </div>
          <div class="form-group @if ($errors->has('number')) has-error @endif">
            <label for="number">Número: </label>
            <input type="text" id="number" class="form-control" name="number" placeholder="Número"@if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->number}}"@endif  required="required">
            @if ($errors->has('number'))
              <label class="control-label" for="number"><i class="fa fa-times-circle-o"></i> {{ $errors->first('number') }}</label><br>
            @endif
          </div>
          <div class="form-group @if ($errors->has('complement')) has-error @endif">
            <label for="complement">Complemento: </label>
            <input type="text" id="complement" class="form-control" name="complement" placeholder="Complemento"@if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->complement}}"@endif >
            @if ($errors->has('complement'))
              <label class="control-label" for="complement"><i class="fa fa-times-circle-o"></i> {{ $errors->first('complement') }}</label><br>
            @endif
          </div>
          <div class="form-group @if ($errors->has('neighborhood')) has-error @endif">
            <label for="neighborhood">Bairro: </label>
            <input type="text" id="neighborhood" class="form-control" name="neighborhood" placeholder="Bairro"@if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->neighborhood}}"@endif  required="required">
            @if ($errors->has('neighborhood'))
              <label class="control-label" for="neighborhood"><i class="fa fa-times-circle-o"></i> {{ $errors->first('neighborhood') }}</label><br>
            @endif
          </div>
          <div class="form-group @if ($errors->has('neighborhood')) has-error @endif">
            <label for="neighborhood">Cidade/UF: </label>
            <input type="text" id="city" class="form-control" placeholder="Cidade"@if($args["person_dashboard"]->address) value="{{ $args["person_dashboard"]->address->city->name}}/{{ $args["person_dashboard"]->address->city->state->UF}}"@endif  readonly="readonly">
          </div>
          <div class="box-footer">
            <button type="reset" class="btn btn-info pull-left">Cancelar</button>
            <button type="submit" class="btn btn-info pull-right">Atualizar</button>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
    </div>


    <!-- Checks -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Registros de Presenças</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-hover" id="checks" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Inscrição</th>
              <th>Atividade</th>
              <th>Tipo</th>
              <th>Data e Hora</th>
              @if($args["adminController"]->hasPermission([3,4]))<th>Opções</th>@endif
            </tr>
          </thead>
          <tbody>
            @foreach($args["checks"] as $checks)
              @foreach($checks as $check)
              @if($check->registryType == 1 || $check->registryType == 3)
                <tr>
                  <td class="center">{{$check->id}}</td>
                  <td class="center">{{$check->subscription->id}}</td>
                  <td>{{$check->activity->name}}</td>
                  <td class="center">{{($check->type == "in") ? "Entrada" : "Saída"}}</td>
                  <td class="center">{{date("d/m/Y H:i:s",strtotime($check->checked_at)-(60*60*3))}}</td>
                  @if($args["adminController"]->hasPermission([3,4]) && !$check->subscription->certificate)<td class="center"><a href="{{url("/person/check/delete/".$check->id)}}" class='btn btn-danger btn-sm'><i class="fa fa-times"></i></a></td>@endif
                </tr>
              @endif
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>


    <!-- Certificados -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Certificados</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-hover" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Inscrição</th>
              <th>Evento</th>
              <th>Horas</th>
              <th>Chave</th>
            </tr>
          </thead>
          <tbody>
            @foreach($args["person_dashboard"]->packages->all() as $Subscription)
              @if($Subscription->certificate)
                <tr>
                  <td>{{$Subscription->certificate["id"]}}</td>
                  <td>{{$Subscription->id}}</td>
                  <td>{{$Subscription->package->event->name}}</td>
                  <td>{{$Subscription->certificate["hours"]}}</td>
                  <td>{{$Subscription->certificate["key"]}}</td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>


    <!-- Certificados -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Logs</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-hover" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Mensagem</th>
            </tr>
          </thead>
          <tbody>
            @foreach($args["person_dashboard"]->user->log->all() as $log)
              <tr>
                <td>{{$log->id}}</td>
                <td>{{$log->text}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <section class="col-lg-4 col-md-4 connectedSortable">
    <!-- Alterar Senha -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Alterar Senha</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="{{url("/person/update/password")}}" method="post">
        <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="Person_id" value="{{ $args["person_dashboard"]->id }}">
          <div class="form-group @if ($errors->has('password')) has-error @endif">
            <label for="password">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required="required">
            @if ($errors->has('password'))
              <label class="control-label" for="password"><i class="fa fa-times-circle-o"></i> {{ $errors->first('password') }}</label><br>
            @endif
            <small><strong>Obs:</strong> A senha deve ter no mínimo 8 caracteres e no máximo 60.</small>
          </div>
          <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
            <label for="password_confirmation">Confirmação de Senha</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmação da senha" required="required">
            @if ($errors->has('password_confirmation'))
              <label class="control-label" for="password_confirmation"><i class="fa fa-times-circle-o"></i> {{ $errors->first('password_confirmation') }}</label><br>
            @endif
          </div>
          <div class="box-footer">
            <button type="reset" class="btn btn-info pull-left">Cancelar</button>
            <button type="submit" class="btn btn-info pull-right">Atualizar</button>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
    </div>
    <!-- Telefones -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Telefone</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="{{url("/person/update/phone")}}" method="post">
        <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="Person_id" value="{{ $args["person_dashboard"]->id }}">
          <div class="form-group @if ($errors->has('phone')) has-error @endif">
            <label for="name">Telefone</label>
            <input type="text" id="phone" class="form-control" name="phone" placeholder="(xx) xxxxxxxxx"@if($args["person_dashboard"]->phones) value="{{ $args["person_dashboard"]->phones->ddd . $args["person_dashboard"]->phones->number }}"@endif >
            @if ($errors->has('phone'))
              <label class="control-label" for="phone"><i class="fa fa-times-circle-o"></i> {{ $errors->first('phone') }}</label><br>
            @endif
          </div>
          <div class="box-footer">
            <button type="reset" class="btn btn-info pull-left">Cancelar</button>
            <button type="submit" class="btn btn-info pull-right">Atualizar</button>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
    </div>
    @if($args["is_super_admin"])
    <!-- Admin -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Acesso Admin</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="{{url("/person/update/admin")}}" method="post">
        <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="Person_id" value="{{ $args["person_dashboard"]->id }}">
          <div class="form-group">
            <label>
              <input type="checkbox" id="is_admin" name="is_admin" @if($args["person_dashboard"]->user->is_admin == 1) checked="checked" @endif/> Acesso Admin?
            </label>
          </div>
          <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif" @if($args["person_dashboard"]->user->is_admin == 0) display="none" @endif>
            <label for="password_confirmation">Permissões</label>
            <select name="permissions[]" id="permissions" multiple="multiple" style="width: 100%">
              @foreach($args["permission"] as $permission)
                <option value="{{$permission->id}}">{{$permission->name}}</option>
              @endforeach
            </select>

            @if ($errors->has('password_confirmation'))
              <label class="control-label" for="password_confirmation"><i class="fa fa-times-circle-o"></i> {{ $errors->first('password_confirmation') }}</label><br>
            @endif
          </div>
          <div class="box-footer">
            <button type="reset" class="btn btn-info pull-left">Cancelar</button>
            <button type="submit" class="btn btn-info pull-right">Atualizar</button>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
    </div>
    @endif

    @php
      $hasSubscriptionWithCheck = false;
      foreach($args["person_dashboard"]->packages->all() as $subscription){
        if(count($subscription->checks->all()) > 0){
          $hasSubscriptionWithCheck = true;
        }
      }
    @endphp
    @if((($args["adminController"]->hasPermission([5]) && $args["is_admin"]) || $args["is_super_admin"]) && $hasSubscriptionWithCheck)
    <!-- Funções de Certificado -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Opções de Certificado</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        @foreach($args["person_dashboard"]->packages->all() as $subscription)
          @php
            foreach($subscription->payment->all() as $payment){
              if($payment->paymentStatus == 3){
                $thisPaid = true;
              }else{
                $thisPaid = false;
              }
            }
          @endphp
          @if($thisPaid)
            <h5>#<strong>{{$subscription->id}}</strong></h5>
            @if(count($subscription->checks->all()) == 0)<span>Não há registro de presença.</span>@endif
            @if(count($subscription->participates->all()) == 0 && count($subscription->checks->all()) > 0)
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalReGrow_{{$subscription->id}}"><i class="fa fa-clone"></i> Re-geminar Registros</button><br/>
              <!-- Modal Re-geminação -->
              <div class="modal fade modal-danger" id="modalReGrow_{{$subscription->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Efetuar a re-geminação dos registros de presença do inscrito</h4>
                    </div>
                    <div class="modal-body">
                      <h2>Você tem certeza que pretende fazer isso?</h2><br>
                      O inscrito terá as suas geminações anteriores excluídas e serão refeitas, assim fazendo necessário re-criar o certificado do mesmo.
                      <h4>Você deseja ainda assim efetuar a re-geminação?</h4>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                      <a class="btn btn-danger" href="{{url("/certificate/growChecks/".$subscription->id)}}">Efetuar a re-geminação</a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            @if(count($subscription->participates->all()) == 0 && !$subscription->certificate && count($subscription->checks->all()) > 0)
              <a class="btn btn-success" href="{{url("/certificate/calculateHours/".$subscription->id)}}" title="Efetuar o Calculo das Horas"  data-toggle="tooltip" data-original-title="Serve para calcular as horas da inscrição."><i class="fa fa-calculator"></i> Calcular Horas <span class="badge bg-orange">?</span></a><br/>
            @endif
            @if(count($subscription->participates->all()) > 0 && !$subscription->certificate && count($subscription->checks->all()) > 0)
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalApagarHoras_{{$subscription->id}}"><i class="fa fa-eraser"></i> Apagar Horas</button><br/>
              <!-- Modal Calcular Horas -->
              <div class="modal fade modal-danger" id="modalApagarHoras_{{$subscription->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Apagar as horas já calculadas</h4>
                    </div>
                    <div class="modal-body">
                      <h2>Você tem certeza que pretende fazer isso?</h2><br>
                      O inscrito terá as suas horas já calculadas excluídas, assim fazendo necessário re-criar calcular as horas e criar o novo certificado.
                      <h4>Você deseja ainda assim apagar as horas calculadas?</h4>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                      <a class="btn btn-danger" href="{{url("/certificate/deleteParticipations/".$subscription->id)}}">Apagar as horas</a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            @if(!$subscription->certificate && count($subscription->participates->all()) > 0 && count($subscription->checks->all()) > 0)
              <a class="btn btn-success" href="{{url("/certificate/generate/".$subscription->id)}}" title="Gerar Certificado" data-toggle="tooltip" data-original-title="Serve para gerar um certificado para a inscrição."><i class="fa fa-certificate"></i> Gerar Certificado <span class="badge bg-orange">?</span></a><br/>
            @endif

            @if($subscription->certificate)
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalReGrow_{{$subscription->id}}" title="Serve para apagar a geminação anterior e geminar novamente (considerar que este inscrito esteve em todo o período das atividades que ele teve algum registro de entrada e/ou saída)."><i class="fa fa-times-circle"></i> Deletar Certificado <span class="badge bg-orange">?</span></button>
              <!-- Modal Re-geminação -->
              <div class="modal fade modal-danger" id="modalReGrow_{{$subscription->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Deletar o certificado</h4>
                    </div>
                    <div class="modal-body">
                      <h2>Você tem certeza que pretende fazer isso?</h2><br>
                      O inscrito terá o seu certificado excluído e será necessário gerar um novo certificado posteriormente.
                      <h4>Você deseja ainda assim efetuar a exclusão do certificado?</h4>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                      <a class="btn btn-danger" href="{{url("/certificate/delete/".$subscription->id)}}">Efetuar a exclusão</a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endif
        @endforeach
      </div>
        <!-- /.box-body -->
    </div>
    @endif
    @if(!$args["person_dashboard"]->user->is_active || $args["is_admin"])
    <!-- Enviar o email de confirmação -->
    <div class="box box-primary collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Ativação de Usuário</h3>
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
            <i class="fa fa-plus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="box-footer">
          @if(!$args["person_dashboard"]->user->is_active && $args["is_admin"])
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalUserActivate" title="Efetuar a Ativação do Usuário">Ativar usuário</button>
          <!-- Modal Ativação -->
          <div class="modal fade modal-danger" id="modalUserActivate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Efetuar Ativação do Usuário</h4>
                </div>
                <div class="modal-body">
                  <h2>Você tem certeza que pretende fazer isso?</h2><br>
                  O usuário pode não ter tido a senha gerada, e com isso, não é possível gerar ela caso não tinha sido feita.
                  <h4>Você deseja ainda assim efetuar a ativação?</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                  <a class="btn btn-danger" href="{{url("/person/update/activate/".$args["person_dashboard"]->id)}}">Efetuar a ativação</a>
                </div>
              </div>
            </div>
          </div>
          @endif
          @if($args["person_dashboard"]->user->is_active && $args["is_admin"])
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalUserDisable" title="Efetuar a Ativação do Usuário">Desativar usuário</button>
          <!-- Modal Desativação -->
          <div class="modal fade modal-danger" id="modalUserDisable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Efetuar Desativação do Usuário</h4>
                </div>
                <div class="modal-body">
                  <h2>Você tem certeza que pretende fazer isso?</h2><br>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal">Não quero mais</button>
                  <a class="btn btn-danger" href="{{url("/person/update/disable/".$args["person_dashboard"]->id)}}">Efetuar a ativação</a>
                </div>
              </div>
            </div>
          </div>
          @endif
          @if(!$args["person_dashboard"]->user->is_active && !$args["person_dashboard"]->user->password)<a href="{{url("/person/update/sendConfirmation/".$args["person_dashboard"]->id)}}" class="btn btn-success">Enviar email de confirmação novamente</a>@endif
        </div>
      </div>
        <!-- /.box-body -->
    </div>
    @endif
  </section>
</div>
<!-- /.row (main row) -->

@endsection

@section("scripts")
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{url("plugins/morris/morris.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{url("plugins/sparkline/jquery.sparkline.min.js")}}"></script>
<!-- jvectormap -->
<script src="{{url("plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
<script src="{{url("plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url("plugins/knob/jquery.knob.js")}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{url("plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- datepicker -->
<script src="{{url("plugins/datepicker/bootstrap-datepicker.js")}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- Slimscroll -->
<script src="{{url("plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>
<!-- FastClick -->
<script src="{{url("plugins/fastclick/fastclick.js")}}"></script>
<script type="text/javascript" src="{{url("/dist/js/jquery.mask.min.js")}}"></script>

<script src="{{url("plugins/select2/select2.full.min.js")}}"></script>

<script>
  $typestreet = $("#typestreet").select2();
  $permissions = $("#permissions").select2({
      placeholder: "Selecione uma ou várias permissões"
  });
  $typestreet.on("select2:select", function (e) {
    // console.log("select2:select", e);
    $("#TypeStreet_id").val(e.params.data.id);
  });
  @if($args["person_dashboard"]->address)
    $typestreet.val({{$args["person_dashboard"]->address->TypeStreet_id}}).trigger("change");
  @endif
  @php($countPermissions = count($args["person_dashboard"]->user->permissions->all()))
  @php($i = 1)
  $permissions.val([ @foreach($args["person_dashboard"]->user->permissions->all() as $permission) {{$permission->permission->id}} @if($countPermissions > $i++),@endif @endforeach ]).trigger("change");
  $(document).ready(function(){
    $("input[name='isStudent']").on("click", function(){
      if($(this).is(":checked")){
        $(".isStudentOnly").show(300);
      }else{
        $(".isStudentOnly").hide(300);
      }
    });
    var phoneMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    phoneOptions = {
      onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };


    $('#cpf').mask('000.000.000-00', {reverse: false});
    $('#zipcode').mask('00000-000', {reverse: false});
    $('#phone').mask(phoneMaskBehavior, phoneOptions);

    $.getJSON("{{url("/api/web/zip/search")}}/"+$("#zipcode").val(), function(data){
      if(data.ok == 1){
        if(data.has.typestreet == 1){
          $("#typestreet").attr("disabled", "disabled");
          $("#TypeStreet_id").val(data.zip.typeStreet.id);
        }else{
          $("#typestreet").removeAttr("disabled");
        }
        if(data.has.street == 1){
          $("#street").attr("readonly", "readonly");
        }else{
          $("#street").removeAttr("readonly");
        }
        if(data.has.neighborhood == 1){
          $("#neighborhood").attr("readonly", "readonly");
        }else{
          $("#neighborhood").removeAttr("readonly");
        }
      }else{
        alert("O CEP informado não existe.");
      }
    });
  });
  $("#zipcode").keypress(function(e){
    if(e.which == 13){
      searchZIP();
      return false;
    }
  });
  function searchZIP(){
    $.getJSON("{{url("/api/web/zip/search")}}/"+$("#zipcode").val(), function(data){
      if(data.ok == 1){
        if(data.has.typestreet == 1){
          if(!$("#typestreet").attr('[disabled]')){
            $("#typestreet").attr("disabled", "disabled");
          }
          $typestreet.val(data.zip.typeStreet.id).trigger("change");
          $("#TypeStreet_id").val(data.zip.typeStreet.id);
        }else{
          $("#typestreet").removeAttr("disabled");
          $("#typestreet").val("");
        }
        if(data.has.street == 1){
          if(!$("#street").attr('[readonly]')){
            $("#street").attr("readonly", "readonly");
          }
          $("#street").val(data.zip.street);
        }else{
          $("#street").removeAttr("readonly");
          $("#street").val("");
        }
        if(data.has.neighborhood == 1){
          if(!$("#neighborhood").attr('[readonly]')){
            $("#neighborhood").attr("readonly", "readonly");
          }
          $("#neighborhood").val(data.zip.neighborhood);
        }else{
          $("#neighborhood").removeAttr("readonly");
          $("#neighborhood").val("");
        }
        $("#city").val(data.zip.city.name+"/"+data.zip.city.state.UF);
        $("#City_id").val(data.zip.city.id);
      }else{
        alert("O CEP informado não existe.");
      }
    });
  }
</script>
@endsection
