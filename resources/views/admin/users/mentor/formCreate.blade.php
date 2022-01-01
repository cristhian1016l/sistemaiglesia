<div class="card-body">    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Seleccione el mentor') !!}
                <select name="miembro" class="form-control select2" style="width: 100%;" id="miselect">       
                    @foreach($miembros as $miembro)
                    <option value="<?php echo $miembro->CodCon ?>">{{ $miembro->ApeCon.' '.$miembro->NomCon }}</option>
                    @endforeach
                </select>
            </div>            
        </div>        
        <div class="col-md-6">
            <!-- <div class="form-group">
                {!! Form::label('Email') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su email de ingreso']) !!}
            </div> -->
            {!! Form::label('Email') !!}
            <div class="input-group">                
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su email de ingreso']) !!}
                <div class="input-group-append">
                <span class="input-group-text">@iglesiaprimitivaperu.org</span>
                </div>
            </div>
        </div>        
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('Contraseña') !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese su contraseña', 'id' => 'password']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('Repita su contraseña') !!}
                {!! Form::password('password_repeat', ['class' => 'form-control', 'placeholder' => 'Repita su contraseña']) !!}
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