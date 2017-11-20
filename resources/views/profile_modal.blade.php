
<style type="text/css">
.alignleft{
	float: left;
}

.alignright{
	float: right;
}
</style>

<script type="text/javascript">
/* $(document).ready(function() {
	$('.form_date').datetimepicker({
	    weekStart: 1,
	    todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});

	$('#timepicker').timepicker({
	    minuteStep: 1,
	    template: 'modal',
	    appendWidgetTo: 'body',
	    showSeconds: true,
	    showMeridian: false,
	    defaultTime: false
	});
}); */
</script>

<?php
include ('dbconfig.php');
$data = array();

$connection = new createConn();
$userId = Auth::user()->id;
$ssql = "select first_name, last_name, email, username, gender, height, date_format(birthday, '%m-%d-%Y') as birthday, weight, physic_activity, bb_ideal 
		from user where id = '$userId'";
$connection->connect();
$result = mysqli_query($connection->myconn, $ssql);
$dtl=mysqli_fetch_array($result);
$data['fname'] = $dtl['first_name'];
$data['lname'] = $dtl['last_name'];
$data['email'] = $dtl['email'];
$data['username'] = $dtl['username'];
$data['gender'] = $dtl['gender'];
$data['height'] = $dtl['height'];
$data['weight'] = $dtl['weight'];
$data['birthday'] = $dtl['birthday'];
$data['physic_activity'] = $dtl['physic_activity'];
$data['bb_ideal'] = $dtl['bb_ideal'];

mysqli_close($connection->myconn);

$aktivitas = array(
	array("Rest", "Sangat Ringan"),
	array("Light", "Ringan"),
	array("Normal", "Biasa"),
	array("Heavy", "Sering"),
	array("Very Heavy", "Sangat Berat")
);

?>

<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="{{ url('profile/edit') }}">
	  	<div class="modal-body">
			<div class="container">
		    	<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
						<h2 class="text-center title">UBAH PROFIL</h2>
						<label for="firstname">Nama Depan</label>
						<input type="text" value="<?php echo $data['fname']; ?>" name="firstname" class="form-control input-small">
						<label for="latname">Nama Belakang</label>
						<input type="text" value="<?php echo $data['lname']; ?>" name="lastname" class="form-control input-small">
						<label for="username">Username</label>
						<input type="text" value="<?php echo $data['username']; ?>" name="username" class="form-control input-small">
						<label for="email">Email</label>
						<input type="email" value="<?php echo $data['email']; ?>" name="email" class="form-control input-small">
						<label for="gender">Jenis Kelamin</label>
						<select class="form-control" name="gender"> <?php
							if ($data['gender'] == 'Male') {?>
								<option value="Male" selected>Pria</option>
								<option value="Female">Wanita</option> <?php
							}
							else{ ?>
								<option value="Male">Pria</option>
								<option value="Female" selected>Wanita</option> <?php
							} ?>
						</select>
						<label for="height">Tinggi Badan</label>
						<input type="number" value="<?php echo $data['height']; ?>" name="height" class="form-control input-small">
						<label for="weight">Berat Badan</label>
						<input type="number" value="<?php echo $data['weight']; ?>" name="weight" class="form-control input-small">
						<label>Tanggal Lahir</label>
						<div class="form-group">
				        	<input type="text" name="birth" value="<?php echo $data['birthday']; ?>" id="row-col">
				        	<input type="hidden" name="bday" value="">
					    </div>
						<label for="activity">Aktivitas Fisik</label>
						<select class="form-control" name="activity"> <?php			
						for($i=0;$i<5;$i++){
							if ($aktivitas[$i][0] == $data['physic_activity'])
								echo "<option value='".$aktivitas[$i][0]."' selected>".$aktivitas[$i][1]."</option>";
							else
								echo "<option value='".$aktivitas[$i][0]."'>".$aktivitas[$i][1]."</option>";
						} ?>
						</select>
						<label for="goal">Berat Ideal</label>
						<input type="text" value="<?php echo $data['bb_ideal']; ?>" name="goal" class="form-control input-small" readonly>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
						<button class="btn btn-primary" id="edit" type="submit">Simpan</button></div>
		    	</div>
			</div>
	  	</div>
	</form>
</div>


<div id="password-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="{{ url('profile/password') }}">
	  	<div class="modal-body">
			<div class="container">
		    	<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
						<h2 class="text-center title">UBAH PASSWORD</h2>
						<label for="old">Password Lama</label>
						<input type="password" value="" name="oldpassword" class="form-control input-small">
						<label for="new">Password Baru</label>
						<input type="password" value="" name="password" class="form-control input-small">
						<label for="renew">Ketik Ulang Password Baru</label>
						<input type="password" value="" name="repassword" class="form-control input-small">
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
						<button class="btn btn-primary" id="password" type="submit">Simpan</button></div>
		    	</div>
			</div>
	  	</div>
	</form>
</div>

<script type="text/javascript">
	
$(document).ready(function(){/*
	  var birth = birthday.split('-');
	  if (birth[0].substring(0, 1) == 0)
	    birth[0] = birth[0].substring(1, 2);
	  if (birth[1].substring(0, 1) == 0)
	    birth[1] = birth[1].substring(1, 2);
	  $(e.currentTarget).find('select[name="birthday[day]"]').val(birth[0]);
	  $(e.currentTarget).find('select[name="birthday[month]"]').val(birth[1]);
	  $(e.currentTarget).find('select[name="birthday[year]"]').val(birth[2]);*/

	$('button#edit').click(function(){
		var bday = $('input[name="bday"]');
		var bdayday = $('select[name="birthday[day]"]').val();
		var bdaymon = $('select[name="birthday[month]"]').val();
		var bdayyear = $('select[name="birthday[year]"]').val();
		var birthday = bdayyear + "-" + bdaymon + "-" + bdayday;
		bday.val(birthday);
	});

	$('button#password').click(function(){	
		var repass = $('input[name="repassword"]');
		var pass = $('input[name="password"]');
		flag = false;
		if(pass.val().trim() == ""){
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
		else
			flag = true;
		return flag;
	});

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
</script>