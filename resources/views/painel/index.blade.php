@extends("painel.includes.default")

@section("page_title", "Dashboard")

@section("breadcumbs")
<ol class="breadcrumb">
  <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li> -->
  <li class="active"> <i class="fa fa-dashboard"></i> Dashboard</li>
</ol>
@endsection

@section("content")
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{$args["subscription_count"]}}</h3>

        <p>Inscrições confirmadas</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{$args["subscription_rate"]}}<sup style="font-size: 20px">%</sup></h3>

        <p>Taxa de Conversão</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$args["person_count"]}}</h3>

        <p>Cadastros</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="{{url("/person/list")}}" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3><sup style="font-size: 20px">R$ </sup>{{number_format($args["subscription_priceTotal"],2)}}</h3>

        <p>Total de Vendas</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right">
        <li class="active"><a href="#sales-package" data-toggle="tab">Pacotes</a></li>
        <li class="pull-left header"><i class="fa fa-inbox"></i> Vendas</li>
      </ul>
      <div class="tab-content no-padding">
        <div class="chart tab-pane active" id="sales-package" style="position: relative; height: 600px;"></div>
      </div>
    </div>
    <!-- /.nav-tabs-custom -->

  </section>
  <!-- right col -->
</div>
<!-- /.row (main row) -->

@endsection

@section("scripts")
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<script>
  //Donut Chart
  var donut = new Morris.Donut({
    element: 'sales-package',
    resize: true,
    data: [
      @foreach($args["subscription_list"] as $subs)
        {label: "{{$subs["label"]}}", value: {{$subs["value"]}}},
      @endforeach
    ],
    hideHover: 'auto'
  });
</script>
@endsection
