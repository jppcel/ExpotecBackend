@extends("painel.includes.default")

@section("page_title", "Listar Inscrições")

@section("breadcumbs")
<ol class="breadcrumb">
  <li><a href="{{url("/")}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="#"><i class="fa fa-users"></i> Pessoas</a></li>
  <li class="active"><i class="fa fa-list"></i> Listar Inscrições</li>
</ol>
@endsection

@section("content")
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-12 connectedSortable">
    <div class="box">
      <!-- /.box-header -->
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Evento</th>
            <th>Pacote</th>
            <th>Flags</th>
            <th>Opções</th>
          </tr>
          </thead>
          <tbody>
            @foreach($args["subscriptions"] as $subscription)
            <tr>
                <td>{{$subscription->id}}</td>
                <td>{{$subscription->person->name}}</td>
                <td>{{$subscription->package->event->name}}</td>
                <td>{{$subscription->package->name}}</td>
                <td>
                  @foreach($subscription->payment->all() as $payment)
                    @if($payment->paymentStatus == 0)
                      <span class="badge bg-red">0 - Cancelada</span>
                    @endif
                    @if($payment->paymentStatus == 1)
                      <span class="badge">1 - Aguardando Pagamento</span>
                    @endif
                    @if($payment->paymentStatus == 2)
                      <span class="badge bg-blue">2 - Pagamento Pendente</span>
                    @endif
                    @if($payment->paymentStatus == 3)
                      <span class="badge bg-green">3 - Pagamento Confirmado</span>
                    @endif
                  @endforeach
                </td>
                <td>
                  @if($payment->paymentStatus == 3)<a class="btn btn-success btn-sm" href="{{url("/label/generate/".$subscription->id)}}" title="Gerar Etiqueta para Impressão" target="_blank"><i class="fa fa-print"></i></a>@endif
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Opções</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.Left col -->
  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  <section class="col-lg-5 connectedSortable">


  </section>
  <!-- right col -->
</div>
<!-- /.row (main row) -->

@endsection

@section("scripts")
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{url("/plugins/morris/morris.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{url("/plugins/sparkline/jquery.sparkline.min.js")}}"></script>
<!-- jvectormap -->
<script src="{{url("/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
<script src="{{url("/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url("/plugins/knob/jquery.knob.js")}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{url("/plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- datepicker -->
<script src="{{url("/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

<script src="{{url("/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{url("/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url("/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- Slimscroll -->
<script src="{{url("/plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>
<!-- FastClick -->
<script src="{{url("/plugins/fastclick/fastclick.js")}}"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
@endsection
