@extends("painel.includes.default")

@section("page_title", "Dashboard: ".$args["person_dashboard"]->name)

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
  <div class="col-lg-3 col-xs-6">
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
  <div class="col-lg-3 col-xs-6">
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
  <div class="col-lg-3 col-xs-6">
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
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        @if($args["person_subscription"]->person->user->is_admin == 1)
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
  <section class="col-lg-12 connectedSortable">

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
@endsection
