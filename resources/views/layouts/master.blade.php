<!DOCTYPE html>
<html lang=en>
<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>@yield('title')</title>
   <link rel="stylesheet" href="{{ URL::to('src/css/bootstrap.css') }}">
   <link rel="stylesheet" href="{{ URL::to('src/css/simple-sidebar.css') }}">
   <link rel="stylesheet" href="{{ URL::to('src/css/bootstrap-datepicker.css') }}">
   <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
</head>
<body>
   @include('includes.header')
   <div class="container">
      @yield('content')
   </div>

   <div class="modal fade" tabindex="-1" role="dialog" id="opinion-modal">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title">Submit your opinion anonymously!</h4>
            </div>
            <div class="modal-body">
               <form>
                  <div class="form-group">
                     <label for="opinion-body">Your opinion</label>
                     <textarea class="form-control" name="opinion-body" id="opinion-body" rows="5"></textarea>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" id="modal-opinion-save">Submit</button>
            </div>
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->

   <script>
   var token = '{{ Session::token() }}';
   var urlOpinion = '{{ route('opinion') }}';
   </script>

   <script src="{{ URL::to('src/js/jquery.js') }}"></script>
   <script src="{{ URL::to('src/js/bootstrap.js') }}"></script>
   <script src="{{ URL::to('src/js/bootstrap-datepicker.js') }}"></script>
   <script src="{{ URL::to('src/js/app.js') }}"></script>

</body>
</html>
