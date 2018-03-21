@extends("painel.includes.defaultLogin")

@section("page_title", "Login")

@section("breadcumbs")
<ol class="breadcrumb">
  <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li> -->
  <li class="active"> <i class="fa fa-dashboard"></i> Login</li>
</ol>
@endsection

@section("content")
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-6 connectedSortable">
    <div class="box box-primary">
      <!-- form start -->
      <form role="form" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">CPF</label>
            <input type="text" class="form-control" id="cpf" name="document" placeholder="xxx.xxx.xxx-xx">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Insira sua senha">
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <a href="{{env("APP_URL")}}" class="btn btn-default">Cancelar</a>
          <button type="submit" class="btn btn-info pull-right">Login</button>
        </div>
      </form>
    </div>

  </section>
</div>
<!-- /.row (main row) -->

@endsection

@section("scripts")
<script type="text/javascript" src="{{env("APP_URL")}}/dist/js/jquery.mask.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#cpf').mask('000.000.000-00', {reverse: false});
});
</script>
@endsection
