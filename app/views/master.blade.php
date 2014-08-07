<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
@section('title')
   Testing
@show  
</title>  
{{ HTML::style('public/bs/css/bootstrap.min.css') }}
{{ HTML::style('public/bs/css/bootstrap-theme.min.css') }}
<style>
.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  background-color: #eeeeea;
}
</style>
{{ HTML::script('public/js/helpers.js') }}
{{ HTML::script('public/js/jquery-1.11.1.min.js') }}
{{ HTML::script('public/bs/js/bootstrap.min.js') }}
{{ HTML::script('public/js/crud.js') }}
</head>    
<body>

<div class="container">
	@yield('content')
</div>


</body>
</html>