@extends("painel.includes.default")

@section("page_title", "Nova Pessoa")

@section("breadcumbs")
<ol class="breadcrumb">
  <li><a href="{{url("/")}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="#"><i class="fa fa-users"></i> Pessoas</a></li>
  <li class="active"><i class="fa fa-user-plus"></i> Nova Pessoa</li>
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
      <form role="form">
        <div class="box-body">
          <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Insira o nome da pessoa">
          </div>
          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="fulano@sicrano.com">
          </div>
          <div class="form-group">
            <label for="cpf">Documento(CPF)</label>
            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="xxx.xxx.xxx-xx">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" id="isStudent" name="isStudent"> É aluno de alguma instituição?
            </label>
          </div>
          <div class="form-group isStudentOnly" style="display:none">
            <label for="college">Instituição</label>
            <input type="text" class="form-control" id="college" name="college" placeholder="Nome da IES">
          </div>
          <div class="form-group isStudentOnly" style="display:none">
            <label for="course">Curso</label>
            <input type="text" class="form-control" id="course" name="course" placeholder="Nome do Curso">
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </form>
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
  $(document).ready(function(){
    $("#isStudent").on("click", function(){
      if($(this).is(":checked")){
        $(".isStudentOnly").show(300);
      }else{
        $(".isStudentOnly").hide(300);
      }
    });
    $('#cpf').mask('000.000.000-00', {reverse: false});
  });
</script>
@endsection
