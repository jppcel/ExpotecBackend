@extends("painel.includes.default")

@section("page_title", "Registro de Presença")

@section("breadcumbs")
<ol class="breadcrumb">
  <li><a href="{{url("/")}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><i class="fa fa-flag-checkered"></i> Registro de Presença</li>
</ol>
@endsection

@section("content")
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-12 connectedSortable">

    <!-- general form elements -->
      <div class="box box-primary">
      <!-- form start -->
          <div class="form-group">
            <label for="name">Atividade</label>
            <select id="Activity_id" style="width:100%;">
              @foreach($args["activities"] as $activity)
                <option value="{{$activity->id}}">{{$activity->id}} - {{$activity->name}} - {{date("d/m/Y H:i:s",strtotime($activity->startDate))}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="Subscription_id">Código da Inscrição</label>
            <input type="number" class="form-control" id="Subscription_id" required="required">
          </div>
          <div class="form-group">
            <label for="name">Tipo de Registro</label><br>
            <label><input type="radio" class="type" value="1" name="type" /> 1 - Entrada</label>
            <label><input type="radio" class="type" value="2" name="type" /> 2 - Saída</label>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="button" class="btn btn-primary" id="send">Enviar</button>
        </div>
    </div>

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
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url("/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- Slimscroll -->
<script src="{{url("/plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>
<!-- FastClick -->
<script src="{{url("/plugins/fastclick/fastclick.js")}}"></script>
<script type="text/javascript" src="{{url("/dist/js/jquery.mask.min.js")}}"></script>

<script>
  $("#send").click(function(){
    $.ajax({
      type: "post",
      url: "{{env("APP_URL")}}/api/mobile/check/new/panel",
      data: "Activity_id="+$("#Activity_id").val()+"&Subscription_id="+$("#Subscription_id").val()+"&type="+$("input[name=type]:checked").val(),
      dataType: "json",
      success: function(data){
        if(data.ok == 1){
          alert("Registro ok");
          $("#Subscription_id").val("");
        }else{
          alert("ERRO!\n Mensagem: "+data.message);
        }
      }
    });
  });
</script>
@endsection
