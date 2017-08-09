@extends('layouts.master')

@section('title')
   Welcome!
@endsection

@section('content')
   @include('includes.message-block')
   <div class="row">
      <div class="col-md-6">
         <h3>Sign Up</h3>
         <form action="{{ route('signup') }}" method="post">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
               <label for="email">E-Mail</label>
               <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
            </div>
            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
               <label for="first_name">Name</label>
               <input class="form-control" type="text" name="first_name" id="first_name" value="{{ Request::old('first_name') }}">
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
               <label for="password">Password</label>
               <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
            </div>

            <div class="form-group {{ $errors->has('college') ? 'has-error' : '' }}">
               <label for="college">College</label>
               <input class="form-control" type="text" name="college" id="college" value="{{ Request::old('college') }}">
            </div>

            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
               <label for="department">Department</label>
               <input class="form-control" type="text" name="department" id="department" value="{{ Request::old('department') }}">
            </div>

            <label for="birthday">Birthday</label>
            <div id="datepicker" class="input-group date {{ $errors->has('date') ? 'has-error' : '' }}">
               <input type="text" class="form-control" name="birthday"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>

            <br />

            <button type="submit" class="btn btn-primary">Submit</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
         </form>
      </div>
      <div class="col-md-6">
         <h3>Sign In</h3>
         <form action="{{ route('signin') }}" method="post">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
               <label for="email">Your E-Mail</label>
               <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
               <label for="password">Your Password</label>
               <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
         </form>
      </div>
   </div>
@endsection
