@extends('layouts.app')

@section('htmlheader_title')
	Settings - Access Control
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
</style>
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
          <h3 class="box-title"><b>Access Control List</b></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body no-padding">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>User</th>
              <th>Admin</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
              <form action="" method="post">
              {!! csrf_field() !!}
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                <td><input type="checkbox" {{ $user->hasRole('User') ? 'checked' : '' }} name="role_user"></td>
                <td><input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin"></td>
                <td><button type="submit" class="btn btn-primary btn-xs">Assign Roles</button></td>
              </form>
            </tr>  
            @endforeach
            </tbody>
          </table> 
        </div>
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
