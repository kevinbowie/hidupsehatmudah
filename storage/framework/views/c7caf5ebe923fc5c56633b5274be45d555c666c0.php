<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
    <script type="text/javascript" src="jquery-ui-1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap-birthday.js"></script>
    <style type="text/css">	
		body{
			background: url("images/bg1.jpg") no-repeat center;
		    background-size: cover;
		    color: black;
		}
    </style>
</head>
<body>
<?php echo $__env->make('navbar/navbar_1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="container">
<?php echo $__env->make('login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php if(Session::has('message')): ?>
	<div class='alert alert-danger'><?php echo e(Session::get('message')); ?></div>
<?php endif; ?>
<form method="post" onSubmit="return validateForm()">
	<!-- <div class="col-sm-9"> -->
		<h1>Tentang Anda</h1>
		<div class="row">
			<div class="col-sm-5 form-group">
				<label>Nama Depan</label>
				<input type="text" name="first_name" placeholder="Masukkan nama depan" class="form-control">
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('first_name'); ?>

				<?php endif; ?>
			</div>
			<div class="col-sm-5 form-group">
				<label>Nama Belakang</label>
				<input type="text" name="last_name" placeholder="Masukkan nama belakang" class="form-control">
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('last_name'); ?>

				<?php endif; ?>
			</div>
		</div>	
		<div class="row">		
			<div class="col-sm-5 form-group">
				<label>Username</label>
				<input type="text" name="usernames" placeholder="Masukkan username" class="form-control">
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('usernames'); ?>

				<?php endif; ?>
			</div>	
			<div class="col-sm-5 form-group">
				<label>Email</label>
				<input type="email" name="emails" placeholder="Masukkan email" class="form-control">
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('emails'); ?>

				<?php endif; ?>	
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5 form-group">
				<label>Password</label>
				<input type="password" name="passwords" placeholder="Masukkan password" class="form-control">
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('passwords'); ?>

				<?php endif; ?>
			</div>	
			<div class="col-sm-5 form-group">
				<label>Ketik Ulang Password</label>
				<input type="password" name="repassword" placeholder="Ketik ulang password" class="form-control">
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-3 form-group">
				<label for="gender">Jenis Kelamin</label>
				<select class="form-control" name="gender">
					<option value="0" selected>Jenis Kelamin</option>
					<option value="Male">Pria</option>
					<option value="Female">Wanita</option>
				</select>
			</div>	
			<div class="col-sm-8 form-group">
				<label>Tanggal Lahir</label>
				<div class="form-group">
			      	<div class="col-lg-10">
			        	<input type="text" name="birth" value="" id="row-col"/>
			        	<input type="hidden" name="birthday" value="">
			        	<input type="hidden" name="age" class="form-control" readonly>
			      	</div>
			    </div>
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('birthday'); ?>

				<?php endif; ?>
			</div>	
		</div>		
		<h1>Lain-Lain</h1>
		<div class="row">
			<div class="col-sm-3 form-group">
				<label>Tinggi Badan</label>
				<input type="text" name="height" placeholder="Masukkan tinggi badan" class="form-control">
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('height'); ?>

				<?php endif; ?>
			</div>		
			<div class="col-sm-3 form-group">
				<label>Berat Badan</label>
				<input type="text" name="weight" placeholder="Masukkan berat badan" class="form-control">
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('weight'); ?>

				<?php endif; ?>
			</div>	
			<div class="col-sm-3 form-group">
				<label for="activity">Aktivitas Fisik</label>
				<select class="form-control" name="activity">
					<option value="0" selected>Aktivitas</option>
					<option value="Rest">Sangat Ringan</option>
					<option value="Light">Ringan</option>
					<option value="Normal">Biasa</option>
					<option value="Heavy">Berat</option>
					<option value="Very Heavy">Sangat Berat</option>
				</select>
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('activity'); ?>

				<?php endif; ?>
			</div>	
		</div>		
		<div class="row">
			<div class="col-sm-3">
				<button class="btn btn-primary" type="button" onClick="countBMR()">Hitung</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 form-group">
				<label>IMT</label>
				<input type="text" name="imt" placeholder="Index Massa Tubuh" class="form-control" readonly>
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('height'); ?>

				<?php endif; ?>
			</div>		
			<div class="col-sm-3 form-group">
				<label>BB Ideal</label>
				<input type="text" name="ideal" placeholder="Berat Badan Ideal" class="form-control" readonly>
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('weight'); ?>

				<?php endif; ?>
			</div>	
			<div class="col-sm-3 form-group">
				<label id="kal">Kalori</label>
				<input type="text" name="calories" class="form-control" readonly>
				<?php if(count($errors) > 0): ?>
					<br>
					<?php echo $errors->first('weight'); ?>

				<?php endif; ?>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-3 form-group">
				<label>Protein</label>
				<input type="text" name="protein" class="form-control" readonly>
			</div>		
			<div class="col-sm-3 form-group">
				<label>Lemak</label>
				<input type="text" name="lipid" class="form-control" readonly>
			</div>	
			<div class="col-sm-3 form-group">
				<label>Karbohidrat</label>
				<input type="text" name="carbohydrate" class="form-control" readonly>
			</div>	
		</div>	
	<button type="submit" class="btn btn-primary">Daftar</button><p></p>				
	<!-- </div> -->
</form></div>
</body>
</html>


<script type="text/javascript">
$(document).ready(function () {
    $('#row-col').bootstrapBirthday({
      	widget: {
	        wrapper: {
	          tag: 'div',
	          class: 'row'
	        },
	        wrapperYear: {
	          use: true,
	          tag: 'div',
	          class: 'col-sm-4'
	        },
	        wrapperMonth: {
	          use: true,
	          tag: 'div',
	          class: 'col-sm-4'
	        },
	        wrapperDay: {
	          use: true,
	          tag: 'div',
	          class: 'col-sm-3'
	        },
	        selectYear: {
	          name: 'birthday[year]',
	          class: 'form-control'
	        },
	        selectMonth: {
	          name: 'birthday[month]',
	          class: 'form-control'
	        },
	        selectDay: {
	          name: 'birthday[day]',
	          class: 'form-control'
	        }
	    }
    });
});

function countBMR(){
	var weight = $('input[name="weight"]').val();
	var height = $('input[name="height"]').val();
    var bmr =  weight * 24;
    var aktivitas = $('select[name="activity"]').val();
    var gender = $('select[name="gender"]').val();
    var day = $('select[name="birthday[day]"]').val();
    var month = $('select[name="birthday[month]"]').val();
    var year = $('select[name="birthday[year]"]').val();
    var date = new Date(year + "-" + month + "-" + day);
    var today = new Date();
    var age = Math.floor((today-date) / (365.25 * 24 * 60 * 60 * 1000));
    var w_ideal = (height-100) * 0.9;
    var imt = Math.round(weight/(height*height/10000));
    var calories;

    if (height > 0 && weight > 0 && aktivitas != 0 && gender != 0 && ! isNaN(age)){
	    if (aktivitas == 'Rest')
	    	aktivitas = 1.2;
	    else if (aktivitas == 'Light')
	    	aktivitas = 1.375;
	    else if (aktivitas == 'Normal')
	    	aktivitas = 1.55;
	    else if (aktivitas == 'Heavy')
	    	aktivitas = 1.725;
	    else if (aktivitas == 'Very Heavy')
	    	aktivitas = 1.9;

	    if (gender == "Male")
	    	calories = 66 + (13.7 * weight) + (5 * height) - (6.8 * age);
	    else
	    	calories = 655 + (9.6 * weight) + (1.8 * height) - (4.7 * age);

	    calories *= aktivitas;

	    if (weight < w_ideal){
	    	calories += 500;
	    	$('label#kal').text("Kalori (Naikkan Berat Badan)");
	    }
	    else if (weight > w_ideal){
	    	calories -= 500;
	    	$('label#kal').text("Kalori (Turunkan Berat Badan)");
	    }
	    calories = Math.round(calories);
	    var protein = Math.round(calories*0.15);
	    var lemak = Math.round(calories*0.25);
	    var karbo = calories - lemak - protein;
	    $('input[name="age"]').val(age);
		$('input[name="imt"]').val(imt);
		$('input[name="ideal"]').val(w_ideal);
		$('input[name="calories"]').val(calories);
		$('input[name="protein"]').val(protein);
		$('input[name="carbohydrate"]').val(karbo);
		$('input[name="lipid"]').val(lemak);
	}
	else
		alert('Harap Diisi Kolom Jenis Kelamin, Tinggi Badan, Berat Badan, Tanggal Lahir dan Aktivitas Fisik !');
		return false;
}

function validateForm(){
	var fname = $('input[name="first_name"]');
	var lname = $('input[name="last_name"]');
	var username = $('input[name="usernames"]');
	var pass = $('input[name="passwords"]');
	var repass = $('input[name="repassword"]');
	var email = $('input[name="emails"]');
	var gender = $('select[name="gender"]');
	var bdaymon = $('select[name="birth[month]"]');
	var bdayday = $('select[name="birth[day]"]');
	var bdayyear = $('select[name="birth[year]"]');
	var height = $('input[name="height"]');
	var weight = $('input[name="weight"]');
	var activity = $('select[name="activity"]');
	var imt = $('input[name="imt"]');
	var flag = false;
	var bday = $('input[name="birthday"]');
	if(fname.val().trim() == ""){
		alert("Nama depan belum diisi");
		fname.focus();
	}	
	else if(lname.val().trim() == ""){
		alert("Nama belakang belum diisi");
		lname.focus();
	}
	else if(username.val().trim() == ""){
		alert("Username belum diisi");
		username.focus();
	}
	else if(email.val().trim() == ""){
		alert("Email belum diisi");
		email.focus();
	}
	else if(pass.val().trim() == ""){
		alert("Password belum diisi");
		pass.focus();
	}
	else if(repass.val().trim() == ""){
		alert("Repassword belum diisi");
		repass.focus();
	}
	else if(repass.val().trim() != pass.val().trim()){
		alert("Password dan Repassword tidak sama!");
		pass.focus();
	}
	else if(gender.val() == 0){
		alert("Jenis kelamin belum dipilih");
		gender.focus();
	}
	else if(height.val().trim() == ""){
		alert("Tinggi badan belum diisi");
		height.focus();
	}
	else if(weight.val().trim() == ""){
		alert("Berat badan belum diisi");
		weight.focus();
	}
	else if(bdaymon.val() == 0){
		alert("Bulan lahir belum dipilih");
		bdaymon.focus();
	}
	else if(bdayday.val() == 0){
		alert("Tanggal lahir belum dipilih");
		bdayday.focus();
	}
	else if(bdayyear.val() == 0){
		alert("Tahun lahir belum dipilih");
		bdayyear.focus();
	}
	else if(! imt.val() > 0){
		alert("Anda belum menghitung kalori");
		imt.focus();
	}
	else if(activity.val() == 0){
		alert("Aktivitas belum dipilih");
		activity.focus();
	}
	else{
		bday.val($('input[name="birth"]').val());
		flag = true;
	}
	return flag;
}
</script>