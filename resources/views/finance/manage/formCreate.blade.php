<div class="card-body">    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Seleccione la actividad') !!}
                <select name="activity" class="form-control select2" style="width: 100%;" id="miselect">       
                    @foreach($activities as $activity)
                        <option value="<?php echo $activity->id ?>">{{ $activity->activity }}</option>
                    @endforeach
                </select>
            </div>            
        </div>        
        <div class="col-md-6">            
            <div class="form-group">
                <label>Mes y año</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input name="date" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" data-mask>
                </div>
                <!-- /.input group -->
            </div>            
        </div>        
    </div>    
</div>
<!-- /.card-body -->