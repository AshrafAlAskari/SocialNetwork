@if($errors->count() > 0)
   <div class="row">
      <br />
      <div class="col-md-6 col-md-offset-3 alert alert-danger">
         @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
         @endforeach
      </div>
   </div>
@endif
@if(Session::has('message'))
   <div class="row">
      <br />
      <div class="col-md-6 col-md-offset-3 alert alert-success">
         {{Session::get('message')}}
      </div>
   </div>
@endif
@if(Session::has('alert'))
   <div class="row">
      <br />
      <div class="col-md-6 col-md-offset-3 alert alert-danger">
         {{Session::get('alert')}}
      </div>
   </div>
@endif
