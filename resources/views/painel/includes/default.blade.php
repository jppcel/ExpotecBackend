<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{env("APP_NAME")}} | @yield("page_title")</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{url("/bootstrap/css/bootstrap.min.css")}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url("/dist/css/AdminLTE.min.css")}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url("/dist/css/skins/_all-skins.min.css")}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url("/plugins/iCheck/flat/blue.css")}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{url("/plugins/morris/morris.css")}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url("/plugins/jvectormap/jquery-jvectormap-1.2.2.css")}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{url("/plugins/datepicker/datepicker3.css")}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url("/plugins/daterangepicker/daterangepicker.css")}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{url("/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">
  @yield("css")

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{url("/")}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
        @if(strlen(env("APP_NAME")) > 3)
          {{substr(strtoupper(env("APP_NAME")),0,3)}}
        @else
          {{strtouppercase(env("APP_NAME"))}}
        @endif
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{env("APP_NAME")}}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{$args["person_gravatar"]}}" class="user-image" alt="Imagem do Usuário no Gravatar">
              <span class="hidden-xs">{{$args["person"]->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{$args["person_gravatar"]}}" class="img-circle" alt="Imagem do Usuário no Gravatar">

                <p>
                  {{$args["person"]->name}}
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <!-- <div class="col-xs-6 text-center">
                    <a href="#">Alterar Senha</a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="#">Alterar Dados Cadastrais</a>
                  </div> -->
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{url("/logout")}}" class="btn btn-default btn-flat">Sair</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{$args["person_gravatar"]}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{$args["person"]->name}}</p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENU PRINCIPAL</li>
        <li>
          <a href="/">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        @if($args["adminController"]->hasPermission([1,4]))
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Pessoas</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url("/person/new")}}"><i class="fa fa-user-plus"></i> Nova Pessoa</a></li>
            <li><a href="{{url("/person/list")}}"><i class="fa fa-users"></i> Listar Pessoas</a></li>
            <li><a href="{{url("/person/subscriptions")}}"><i class="fa fa-list"></i> Listar Inscrições</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i>
            <span>Lista de Entrega</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url("/label/list/generate/3")}}" target="_blank"><i class="fa fa-check-square"></i> Pagamento Confirmado</a></li>
            <li><a href="{{url("/label/list/generate/2")}}" target="_blank"><i class="fa fa-spinner"></i> Pagamento Pendente</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-tag"></i>
            <span>Etiquetas</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url("/label/generate/3")}}" target="_blank"><i class="fa fa-check-square"></i> Pagamento Confirmado</a></li>
            <li><a href="{{url("/label/generate/2")}}" target="_blank"><i class="fa fa-spinner"></i> Pagamento Pendente</a></li>
          </ul>
        </li>
        @endif

        @if($args["adminController"]->hasPermission([2,4]))
        <li>
          <a href="{{url("/check/new")}}">
            <i class="fa fa-flag-checkered"></i>
            <span>Registro de Presença</span>
          </a>
        </li>
        @endif
        @if($args["adminController"]->hasPermission([6]) && $args["is_admin"] || $args["adminController"]->hasPermission([4]))
        <li class="treeview">
          <a href="#">
            <i class="fa fa-certificate"></i>
            <span>Certificados</span>
          </a>
          <ul class="treeview-menu">
            @if(count(\App\Participation::all()) == 0)
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-pencil-square-o"></i>
                  <span>Atualização de Registros</span>
                </a>
                <ul class="treeview-menu">
                  @if(count(\App\Participation::all()) == 0)<li><a href="{{url("/certificate/growChecks")}}"><i class="fa fa-clone"></i> Geminar Registros <span class="badge bg-orange" data-toggle="tooltip" data-original-title="Serve para considerar que todos os inscritos que tiveram registros de entrada ou saída de alguma atividade estiveram presentes em toda a atividade. Isso pode demorar um pouco para executar.">?</span></a></li>@endif
                  <!-- <li><a href="{{url("/person/new")}}"><i class="fa fa-user-plus"></i> Aplicar Saída para Registros<br> Pendentes <span class="badge bg-orange" title="Serve para dar saída em registros que só tenham a entrada ou que estão pendentes de saída.">?</span></a></li> -->
                  <!-- <li><a href="{{url("/person/new")}}"><i class="fa fa-user-plus"></i>  <span class="badge bg-orange" title="Serve para dar saída em registros que só tenham a entrada ou que estão pendentes de saída.">?</span></a></li> -->

                </ul>
              </li>
            @endif
            @if(count(\App\Certificate::all()) == 0)
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-user"></i>
                  <span>Horas</span>
                </a>
                <ul class="treeview-menu">
                  @if(count(\App\Participation::all()) == 0)<li><a href="{{url("/certificate/calculateHours")}}"><i class="fa fa-calculator"></i> Calcular Horas <span class="badge bg-orange" data-toggle="tooltip" data-original-title="Serve para efetuar o cálculo das horas para a certificação. Isso pode demorar um pouco.">?</span></a></li>@endif
                  @if(count(\App\Participation::all()) > 0)<li><a href="{{url("/certificate/deleteParticipations")}}"><i class="fa fa-eraser"></i> Deletar Horas Calculadas <span class="badge bg-orange" data-toggle="tooltip" data-original-title="Serve para apagar os calculos de horas efetuados. Isso pode demorar um pouco.">?</span></a></li>@endif
                </ul>
              </li>
            @endif
            @if(count(\App\Certificate::all()) == 0 && count(\App\Participation::all()) > 0)<li><a href="{{url("/certificate/generate")}}"><i class="fa fa-certificate"></i> Gerar certificados <span class="badge bg-orange" data-toggle="tooltip" data-original-title="Serve para gerar os certificados para os participantes do evento. Isso pode demorar um pouco.">?</span></a></li>@endif
            @if(count(\App\Certificate::all()) > 0)<li><a href="{{url("/certificate/delete")}}"><i class="fa fa-times-circle"></i> Deletar certificados <span class="badge bg-orange" data-toggle="tooltip" data-original-title="Serve para apagar os certificados para os participantes do evento. Isso pode demorar um pouco.">?</span></a></li>@endif
            <!-- <li><a href="{{url("/person/subscriptions")}}"><i class="fa fa-list"></i> Listar Inscrições</a></li> -->
          </ul>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield("page_title")
        <small>Painel de Controle</small>
      </h1>
      @yield("breadcumbs")
    </section>

    <!-- Main content -->
    <section class="content">
@yield("content")
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Versão</b> 0.0.10 BETA
    </div>
    <strong>&copy; 2017.</strong> Todos os direitos reservados.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab"></div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{url("plugins/jQuery/jquery-2.2.3.min.js")}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url("plugins/jQueryUI/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{url("bootstrap/js/bootstrap.min.js")}}"></script>
<!-- AdminLTE App -->
@yield("scripts")
<script src="{{url("dist/js/app.min.js")}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url("dist/js/pages/dashboard.js")}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url("dist/js/demo.js")}}"></script>

</body>
</html>
