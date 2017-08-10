<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <script src="bootstrap/js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <style>
  body {
      font: 400 15px/1.8 Lato, sans-serif;
      color: #333;
      background: url("images/bg green.jpg") no-repeat center;
      background-size: cover;
  }
  h3{
      margin: 10px 0 30px 0;
      letter-spacing: 10px;      
      font-size: 20px;
      color: #111;
  }
  .container {
      padding: 80px 120px;
  }
  .person {
      border: 10px solid transparent;
      margin-bottom: 25px;
      width: 80%;
      height: 80%;
      opacity: 0.7;
  }
  .person:hover {
      border-color: #f1f1f1;
  }
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
    }
  }
  .bg-1 {
      background: #2d2d30;
      color: #bdbdbd;
  }
  .bg-1 h3 {color: #fff;}
  .bg-1 p {font-style: italic;}
  .list-group-item:first-child {
      border-top-right-radius: 0;
      border-top-left-radius: 0;
  }
  .list-group-item:last-child {
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
  }
  .btn{
	  margin-top:5px;
  }
  .navbar-btn {
	  margin-right: 8px;
  }
  .form-control{
	  margin-top:8px;
	  margin-bottom:8px;
	  margin-right: 8px; 
  }

  .form-group1{
	  margin-top:-12px;
  }
  .form-group2{
	 float:right;
	 margin-right:1px;
  }
  .input-group{
	  width:300px;
  }
  .input-group1{
	  width:900px;
	  height: 400px;
  }  
  textarea {
      resize: none;
  }
  p{
	  margin-top:15px;
  }
  </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

@if (Auth::user()->access_id == 1)
  @include('navbar/navbar_adm')
@else
  @include('navbar/navbar_2')
@endif

@include('profile_modal')
<div class="container"> 
  @if (Session::has('update'))
    <div class="alert alert-success">{{ Session::get('update') }}</div>
  @elseif (Session::has('failed'))
    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
  @endif       
  <h2 class="text-center">PROFIL</h2>       
  <table class="table table-hover">
    <tbody>
      <tr>
        <td><p>Nama Depan</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="firstname" class="form-control" value="<?php echo $user->first_name; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Nama Belakang</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="lastname" class="form-control" value="<?php echo $user->last_name; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Username</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Password</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="password" name="password" class="form-control" value="*****" readonly="readonly">
            </div>
            <div><button type="button" class="btn btn-default edit" data-toggle='modal' data-target='#password-modal'>Ubah</button></div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Email</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="email" class="form-control" value="<?php echo $user->email; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Jenis Kelamin</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="gender" class="form-control" value="<?php echo $user->gender; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Tinggi Badan</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="height" class="form-control" value="<?php echo $user->height; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Berat Badan</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="weight" class="form-control" value="<?php echo $user->weight; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Tanggal Lahir</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <?php $date = $user->birthday; $date = date("d-m-Y", strtotime($date)); ?>
              <input type="text" name="birthday" class="form-control" value="<?php echo $date; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Aktivitas Fisik</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <?php
                $aktivitas = "";
                if ($user->physic_activity == 'Rest')
                  $aktivitas = "Sangat Ringan";
                else if ($user->physic_activity == 'Light')
                  $aktivitas = "Ringan";
                else if ($user->physic_activity == 'Normal')
                  $aktivitas = "Biasa";
                else if ($user->physic_activity == 'Heavy')
                  $aktivitas = "Berat";
                else if ($user->physic_activity == 'Very Heavy')
                  $aktivitas = "Sangat Berat";
              ?>
              <input type="text" name="activity" class="form-control" value="<?php echo $aktivitas ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><p>Berat Ideal</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="goal" class="form-control" value="<?php echo $user->bb_ideal; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
      <tr>
        <td><p>Kebutuhan Kalori</p></td>
        <td>
          <div class="form-group">
            <div class="col-sm-9">
              <input type="text" name="bmr" class="form-control" value="<?php echo $user->calories; ?>" readonly="readonly">
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-default edit" data-toggle='modal' data-target='#edit-modal'>Ubah Profil</button></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>
<script>
$(document).ready(function(){
  $('.edit').click(function(){
    $("#edit-modal").on('show.bs.modal', function(e){
      var firstname = $('table input:eq(0)').val();
      var lastname = $('table input:eq(1)').val();
      var username = $('table input:eq(2)').val();
      var email = $('table input:eq(4)').val();
      var gender = $('table input:eq(5)').val();
      var height = $('table input:eq(6)').val();
      var weight = $('table input:eq(7)').val();
      var birthday = $('table input:eq(8)').val();
      var activity = $('table input:eq(9)').val();
      var goal = $('table input:eq(10)').val();
      $(e.currentTarget).find('input:eq(0)').val(firstname);
      $(e.currentTarget).find('input:eq(1)').val(lastname);
      $(e.currentTarget).find('input:eq(2)').val(username);
      $(e.currentTarget).find('input:eq(3)').val(email);
      $(e.currentTarget).find('select[name="gender"]').val(gender);
      $(e.currentTarget).find('input:eq(4)').val(height);
      $(e.currentTarget).find('input:eq(5)').val(weight);
      $(e.currentTarget).find('select[name="activity"]').val(activity);
      $(e.currentTarget).find('input:eq(8)').val(goal);
      var birth = birthday.split('-');
      if (birth[0].substring(0, 1) == 0)
        birth[0] = birth[0].substring(1, 2);
      if (birth[1].substring(0, 1) == 0)
        birth[1] = birth[1].substring(1, 2);
      $(e.currentTarget).find('select[name="birthday[day]"]').val(birth[0]);
      $(e.currentTarget).find('select[name="birthday[month]"]').val(birth[1]);
      $(e.currentTarget).find('select[name="birthday[year]"]').val(birth[2]);
    });
  });
});
</script>

</body>
</html>
