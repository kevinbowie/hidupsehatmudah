
<style type="text/css">
.alignleft{
	float: left;
}

.alignright{
	float: right;
}
</style>

<script type="text/javascript" src="bootstrap/js/bootstrap-birthday.js"></script>
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
						<input type="text" value="" name="firstname" class="form-control input-small">
						<label for="latname">Nama Belakang</label>
						<input type="text" value="" name="lastname" class="form-control input-small">
						<label for="username">Username</label>
						<input type="text" value="" name="username" class="form-control input-small">
						<label for="email">Email</label>
						<input type="email" value="" name="email" class="form-control input-small">
						<label for="gender">Jenis Kelamin</label>
						<select class="form-control" name="gender">
							<option value="0" selected>Jenis Kelamin</option>
							<option value="Male">Pria</option>
							<option value="Female">Wanita</option>
						</select>
						<label for="height">Tinggi Badan</label>
						<input type="number" value="" name="height" class="form-control input-small">
						<label for="weight">Berat Badan</label>
						<input type="number" value="" name="weight" class="form-control input-small">
						<label>Tanggal Lahir</label>
						<div class="form-group">
				        	<input type="text" name="birth" value="" id="row-col">
				        	<input type="hidden" name="bday" value="">
					    </div>
						<label for="activity">Aktivitas Fisik</label>
						<select class="form-control" name="activity">
							<option value="0">Aktivitas</option>
							<option value="Rest">Sangat Ringan</option>
							<option value="Light">Ringan</option>
							<option value="Normal">Biasa</option>
							<option value="Heavy">Sering</option>
							<option value="Very Heavy">Sangat Berat</option>
						</select>
						<label for="goal">Berat Ideal</label>
						<input type="text" value="" name="goal" class="form-control input-small" readonly>
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
	
$(document).ready(function(){
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