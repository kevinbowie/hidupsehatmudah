<script type="text/javascript" src="try.js"></script>
<div id="login-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header" align="center">
      			<img id="img_logo" class="img-circle" src="http://bootsnipp.com/img/logo.jpg"></img>
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        		</button>
      		</div>
      		<div id="div-forms">
      			<!-- <form id="login-form" method="post" action="CRUDController@login"> -->
      			{!! Form::open(['method' => 'POST', 'action' => 'CRUDController@login', 'id' => 'login-form']) !!}
	      			<div class="modal-body">
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
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
			        	<button type="submit" class="btn btn-primary" id="save">Login</button>
			      	</div>
      			<!-- </form> -->
      			{!! Form::close() !!}
		     </div>
    	</div>
  	</div>
</div>