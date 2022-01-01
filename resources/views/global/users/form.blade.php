<div class="card-body">    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Email') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su email de ingreso', 'readonly']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Nueva Contraseña') !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese su contraseña']) !!}                
            </div>
        </div>
    </div>
</div>
<!-- /.card-body -->