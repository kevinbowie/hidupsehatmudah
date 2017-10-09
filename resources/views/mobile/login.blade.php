<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<script src="../bootstrap/js/jquery.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<style type="text/css">
		img#img_logo{
			width: 30%;
			height: 35%;
		}		
		button {
		    background-color: #4CAF50;
		    color: white;
		    padding: 14px 20px;
		    margin: 8px 0;
		    border: none;
		    cursor: pointer;
		    width: 100%;
		}
		button:hover {
		    opacity: 0.8;
		}
		body{
	     	font: 400 15px/1.8 Lato, sans-serif;
      		/*background: url("../images/bg1.jpg") no-repeat center;
      		background-size: 100%;*/
  		}
	</style>
</head>
<body>
	<div class="container">
		<div class="text-center"><img id="img_logo" class="img-circle" src="../images/2.jpg"></img></div>
		{!! Form::open(['method' => 'POST', 'action' => 'MobileController@login', 'id' => 'login-form']) !!}
			<div id="div-login-msg">
				<div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
				<span id="text-login-msg">
				@if (Session::has('msglogin'))
					{{ Session::get('msglogin') }}
				@else
					Masukkan username dan password
				@endif
				</span>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon">Username</div>
  				<input id="login_username" class="form-control" name="username" placeholder="Username" required="required" type="text" value="{{ old('username') }}"></input>
			</div>
				@if (count($errors) > 0)
				<br>
				{!! $errors->first('username') !!}
			@endif 
		</div>
		<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon">Password</div>
  				<input id="login_password" class="form-control" name="password" placeholder="Password" required="required" type="password"></input>
			</div>
				@if (count($errors) > 0)
				<br>
				{!! $errors->first('password') !!}
			@endif
		</div>
		<button class="btn btn-default" type="submit" id="login">Login</button>
		<!-- </form> -->
		{!! Form::close() !!}
	</div>
</body>
</html>
