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
      <form role="form" method="post">
        <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group @if ($errors->has('name')) has-error @endif">
            <label for="name">Nome</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Insira o nome da pessoa" value="{{ old('name') }}" required="required">
            @if ($errors->has('name'))
              <label class="control-label" for="name"><i class="fa fa-times-circle-o"></i> {{ $errors->first('name') }}</label><br>
            @endif
          </div>
          <div class="form-group @if ($errors->has('email')) has-error @endif">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="fulano@sicrano.com"  value="{{ old('email') }}" required="required">
            @if ($errors->has('email'))
              <label class="control-label" for="email"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}</label><br>
            @endif
            <small><strong>IMPORTANTE!</strong> Essa informação é única, ou seja, não é permitido multiplos cadastros com o mesmo endereço de email!</small>
          </div>
          <div class="form-group @if ($errors->has('document')) has-error @endif">
            <label for="cpf">Documento(CPF)</label>
            <input type="text" class="form-control" id="cpf" name="document" placeholder="xxx.xxx.xxx-xx" value="{{ old('document') }}" required="required">
            @if ($errors->has('document'))
              <label class="control-label" for="cpf"><i class="fa fa-times-circle-o"></i> {{ $errors->first('document') }}</label><br>
            @endif
            <small><strong>IMPORTANTE!</strong> Essa informação também é única!</small>
          </div>
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
          <div class="form-group checkbox">
            <label>
              <!-- <input type="checkbox" id="isStudent" name="isStudent"> É aluno de alguma instituição? -->
              @php
                if(old('isStudent'))

              @endphp
              @if(old('isStudent'))
                @php($isStudent = old('isStudent'))
              @else
                @php($isStudent = false)
              @endif

              {!! Form::checkbox('isStudent', 'isStudent', $isStudent) !!} É aluno de alguma instituição?
            </label>
          </div>
          </div>
          <div class="form-group isStudentOnly @if ($errors->has('college')) has-error @endif"@if(!$isStudent) style="display:none"@endif>
            <label for="college">Instituição</label>
            <input type="text" class="form-control" id="college" name="college" placeholder="Nome da IES" value="{{ old('college') }}">
            @if ($errors->has('college'))
              <label class="control-label" for="college"><i class="fa fa-times-circle-o"></i> {{ $errors->first('college') }}</label><br>
            @endif
          </div>
          <div class="form-group isStudentOnly @if ($errors->has('course')) has-error @endif"@if(!$isStudent) style="display:none"@endif>
            <label for="course">Curso</label>
            <input type="text" class="form-control" id="course" name="course" placeholder="Nome do Curso" value="{{ old('course') }}">
            @if ($errors->has('course'))
              <label class="control-label" for="course"><i class="fa fa-times-circle-o"></i> {{ $errors->first('course') }}</label><br>
            @endif
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
