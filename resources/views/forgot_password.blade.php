<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
	<script type="text/javascript" src="jquery-ui-1.12.1/jquery-ui.js"></script>
</head>
<body>
@include ('navbar/navbar_1')
	{!! Form::open(['method' => 'POST']) !!}
		<div class="modal-body">
			<div id="div-login-msg">
				<div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
				<span id="text-login-msg">
					@if (Session::has('message'))
					{{ Session::get('message') }}
				@else
					Type your e-mail below to reset.
				@endif
				</span>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon">E-mail</div>
  				<input id="email" class="form-control" name="email" placeholder="" required="required" type="email"></input>
			</div>
				@if (count($errors) > 0)
				<br>
				{!! $errors->first('email') !!}
			@endif 
		</div>
  	</div>
  	<div class="modal-footer">
    	<button type="submit" class="btn btn-primary" id="send">Send</button>
  	</div>
	<!-- </form> -->
	{!! Form::close() !!}
</form>
</body>
</html>