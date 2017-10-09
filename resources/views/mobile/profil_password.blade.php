<!DOCTYPE html>
<html>
<head>
	<title>GANTI PASSWORD</title>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" />
  	<script src="../../bootstrap/js/jquery.js"></script>
  	<script src="../../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<form method="post" action="<?php route('gantipassword'); ?>">
			<h2 class="text-center title">GANTI PASSWORD</h2>
			@if (Session::has('failed'))
				<div class="alert alert-danger">{{ Session::get('failed') }}</div>
			@endif       
          	<div class="form-group">
				<label for="old">Password Lama</label>
				<input type="password" value="" name="oldpassword" class="form-control input-small" required="required">
			</div>
          	<div class="form-group">
				<label for="new">Password Baru</label>
				<input type="password" value="" name="password" class="form-control input-small" required>
			</div>
			<div class="form-group">
				<label for="renew">Ketik Ulang Password Baru</label>
				<input type="password" value="" name="repassword" class="form-control input-small" required>
			</div>
			<div class="text-center">
				<button class="btn btn-primary" id="password" type="submit">Simpan</button>
			</div>
		</form>
	</div>
</body>
</html>

<script type="text/javascript">
$('button#password').click(function(){	
	var oldpass = $('input[name="oldpassword"]');
	var repass = $('input[name="repassword"]');
	var pass = $('input[name="password"]');
	flag = false;
	if (oldpass.val().trim() == ""){
		alert("Password lama belum diisi");
		oldpass.focus();
	}
	else if (pass.val().trim() == ""){
		alert("Password baru belum diisi");
		pass.focus();
	}
	else if (repass.val().trim() == ""){
		alert("Repassword belum diisi");
		repass.focus();
	}
	else if (repass.val().trim() != pass.val().trim()){
		alert("Password dan Repassword tidak sama!");
		pass.focus();
	}
	else
		flag = true;
	return flag;
});
</script>