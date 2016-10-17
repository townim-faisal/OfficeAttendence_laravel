@extends('layouts.app')

@section('htmlheader_title')
	Settings - Attendence
@endsection


@section('main-content')

    @if (count($errors) > 0)
    <div class="row">
    <div class="col-xs-12">
        <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    </div>    
    </div>
    @endif

    @if(Session::has('success'))
    <div class="row">
    <div class="col-xs-12">
        <div class="alert alert-success">
            <p> {!! Session::get('success') !!} </p>
        </div>
    </div>
    </div>
    @endif

    <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Settings</b></h3>
          <p><i>note: Enter all field as h:m:s i.e 09:00:00. But Time For Check Out field will be as h:m i.e. 09:00. And please choose time for cron job before all user's check-in time.</i></p>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <form action="" method="post">
        {!! csrf_field() !!}
          <div class="box-body">
            <div class="form-group">
              <label for="">Total Working Hour</label> 
              <input type="text" class="form-control" name="working_hour" value="{{$attendence_settings->total_work_hour}}">
            </div>
            <div class="form-group">
              <label for="">Arrival Time</label>
              <input type="text" class="form-control" name="arrival_time" value="{{$attendence_settings->arrival_time}}">
            </div>
            <div class="form-group">
              <label for="">Daily Cron Job Time</label>
              <input type="text" class="form-control" name="cron_time" value="{{$attendence_settings->cron_time}}">
            </div>
            <div class="form-group">
              <label for="">Time For Check Out If User Forgets</label>
              <input type="text" class="form-control" name="check_out" value="{{$attendence_settings->check_out_fixed}}">
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>  
      </div>        
    </div>
    </div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
(function($) {
$(document).ready(function(){
    var current_time = new Date();
    var token = "{{Session::token()}}";
});   
})(jQuery);
</script>
@endsection
