<div class="card-body">    
    <div class="row">        
        <div class="col-md-12">
            {!! Form::label('Actividad') !!}
            <div class="input-group">                
                {!! Form::text('activity', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la actividad']) !!}                
            </div>
        </div>                
    </div>    
    <div class="row">                
        <div class="col-md-12">
            {!! Form::label('Descripción') !!}
            <div class="input-group">                
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows'=> '2' ,'placeholder' => 'Ingrese la descripción de la actividad']) !!}                
            </div>
        </div>        
    </div>    
</div>
<!-- /.card-body -->