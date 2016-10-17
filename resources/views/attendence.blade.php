@extends('layouts.app')

@section('htmlheader_title')
	Attendence
@endsection

@section('htmlheader')
@parent
<style>
th, td{
    text-align: center;
}
tr:nth-child(even) {
    background-color: #f2f2f2;
}
th {
    background-color: #6f1b1b;
    color: white;
}
</style>
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
        	<div class="alert alert-success"></div>
        </div>
    </div>
    <div class="row">
		<div class="col-xs-12">
        	<div class="alert alert-danger"></div>
        </div>
    </div>
	<div class="row main" data-user="{{$user->id}}">
		<div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title"><b>My Attendence</b></h2>
              <div class="box-tools">
              	{!! csrf_field() !!}
		        <button type="button" class="btn btn-primary pull-left" id="checkin" style="margin-right:10px">Check In</button>        
		        <button type="button" class="btn btn-primary pull-right" id="checkout">Check Out</button>
              </div>
            </div>  
	          <div class="box-tools">
              	<ul class="pagination pagination-sm pull-right" style="margin:5px 10px 5px 0px;">
                  <li><a href="{{route('attendence'). "?month=". $prev_month . "&year=" . $prev_year}}">«</a></li>
                  <li><a href="">{{$month}}</a></li>
                  <li><a href="{{route('attendence'). "?month=". $next_month . "&year=" . $next_year}}">»</a></li>
                </ul>
              </div>       		
              
            <!-- /.box-header -->
            <div class="box-body no-padding">
              	<table class="table table-striped">
		            <thead>
		            <tr>
		                <th>Date</th>
		                <th>Check In</th>
		                <th>Check Out</th>
		                <th>Working Hour</th>
		            </tr>
		            </thead>
		            <tbody>
		            @for($i=1;$i<=$maxday;$i++)
		            @if($attendences->count() == 0)
		            <tr>
		                <td>{{$i}}</td><td></td><td></td><td></td>
		            </tr>
		            @else    
		            @foreach($attendences as $attendence)
		            <tr>
		                <td>{{$i}}</td>
		                @if($user->readTime("d", $attendence->check_in) == $i && $user->readTime("m", $attendence->check_in) == $curr_month && $user->readTime("Y", $attendence->check_in) == $prev_year)
		                <td>{{$user->readTime("h:i:sa", $attendence->check_in)}}</td>
		                <td>{{$user->readTime("h:i:sa", $attendence->check_out)}}</td>
		                <td>{{$attendence->working_hour}}</td>
		                @else
		                <td></td><td></td><td></td>
		                @endif
		            </tr>
		            @endforeach
		            @endif
		            @endfor
		            </tbody>
		        </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
          <!-- /.box -->
	</div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
(function($) {
$(document).ready(function(){
    $('.alert-success').hide();
    $('.alert-danger').hide();
    var current_time = new Date();
    var token = "{{Session::token()}}";
    var user_id = $(".main").data("user");
    //var chart = $("#myChart");
    //console.log(token);
    console.log(current_time);
    
    $("#checkin").click(function(){
        $.ajax({
            url : "{{route('attendence.in')}}",
            method: "POST",
            dataType: "json",
            data: {
                current_time: current_time,
                user_id : user_id,
                _token : token
            } 
        }).done(function(response){
            $('.alert-success').show();
            $('.alert-success').append('<p>'+response.success+'</p>');
            if(response.date.length !== 0){
            	$('tr:eq('+response.date+')').find('td:nth-child(2)').text(response.time);
            }
            if(response.late.length !== 0){
            	$('.alert-danger').show();
            	$('.alert-danger').append('<p>'+response.late+'</p>');
            }
        });
    });

    $("#checkout").click(function(){
        $.ajax({
            url : "{{route('attendence.out')}}",
            method: "POST",
            dataType: "json",
            data: {
                current_time: current_time,
                user_id : user_id,
                _token : token
            }
        }).done(function(response){
            $('.alert-success').show();
            $('.alert-success').append('<p>'+response.success+'</p>');
            $('tr:eq('+response.date+')').find('td:nth-child(3)').text(response.time);
            $('tr:eq('+response.date+')').find('td:nth-child(4)').text(response.working_time);
            if(response.short.length !== 0){
            	$('.alert-danger').show();
            	$('.alert-danger').append('<p>'+response.short+'</p>');
            }
        });
    });
    
});   
})(jQuery);
</script>
@endsection
