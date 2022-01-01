<div class="card-body">    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('Email') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su email de ingreso', 'readonly']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('Contraseña') !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese su contraseña']) !!}                
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>¿Activo?</label>
                {!! Form::select('active', $active, null, array('class' => 'custom-select', 'placeholder' => 'Seleccione la condicion del usuario....')) !!}
            </div>
        </div>
    </div>
</div>
<!-- /.card-body -->