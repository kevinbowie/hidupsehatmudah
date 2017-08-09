
<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/jquery.prettyPhoto.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/animate.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/prettyPhoto.css">
	<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/main.css"> -->
	<script src="try.js"></script>
	<style type="text/css">
		
  .carousel-inner img {
      -webkit-filter: grayscale(90%);
      filter: grayscale(90%); /* make all photos black and white */ 
      width: 80%; /* Set width to 100% */
	  height: 450px;
      margin: auto;
  }
  .carousel-caption h3 {
      color: #fff !important;
  }
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
    }
  }

  footer {
      background-color: #2d2d30;
      color: #f5f5f5;
      padding: 32px;
  }
  footer a {
      color: #f5f5f5;
  }
  footer a:hover {
      color: #777;
      text-decoration: none;
  }
	</style>
</head>
<body>

@include('navbar/navbar_1')

@include('login')

@if (Session::has('messages'))
	<div class='alert alert-info'>{{ Session::get('messages') }}</div>
@endif
<div class="container">
		<h2>Tahukah anda ?</h2>
		<h3 style="margin-right: 700px;">Penduduk Indonesia hanya mengonsumsi buah dan sayur 2,5 porsi sehari (disarankan 5-9 porsi setiap harinya). *WHO</h3><br>
		<p style="margin-right: 250px; text-align: justify;">Data tahun 2013 menunjukkan proporsi rerata nasional perilaku konsumsi kurang sayur dan atau buah 93,5%, tidak tampak perubahan dibandingkan tahun 2007.
		Perilaku konsumsi makanan tertentu pada penduduk umur = 10 tahun paling banyak mengonsumsi bumbu penyedap (77,3%), 
		diikuti makanan dan minuman manis (53,1%), dan makanan berlemak (40,7%) (Riskesdas, 2013).</p>

	<h2 align="center">What you get</h2>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li> 
      <li data-target="#myCarousel" data-slide-to="5"></li>
      <li data-target="#myCarousel" data-slide-to="6"></li>    
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="images/slider/3.jpg" alt="New York" width="1200" height="700">
        <div class="carousel-caption">
          <h3>Gaya Hidup Sehat</h3>
          <p>Mulai mendapatkan gaya hidup sehat yang lebih baik dan terencana sehingga menjadikannya sebagai kebiasaan hidup, 
			mulai dari pengaturan pola makan, olahraga, tidur, dan minum</p>
        </div>      
      </div>

      <div class="item">
        <img src="images/slider/3.jpg" alt="Chicago" width="1200" height="700">
        <div class="carousel-caption">
          <h3>Pengaturan Berat Badan</h3>
          <p>Mengatur kalori masuk dan kalori keluar sehingga berat badan menjadi terkontrol dan 
			dapat dimanfaatkan sebagai program menaikkan / menurunkan berat badan</p>
        </div>      
      </div>
    
      <div class="item">
        <img src="images/slider/3.jpg" alt="Los Angeles" width="1200" height="700">
        <div class="carousel-caption">
          <h3>Scoreboard</h3>
          <p>Anda tidak akan bosan dalam mengikuti program ini, karena anda dan user lainnya akan berlomba 
			memiliki streak (catatan kerutinan) yang terbaik</p>
        </div>      
      </div>
    <div class="item">
        <img src="images/slider/3.jpg" alt="Los Angeles" width="1200" height="700">
        <div class="carousel-caption">
          <h3>History</h3>
          <p>Anda dapat memantau histori gaya hidup sehat anda sebelumnya</p>
        </div>      
      </div>

    <div class="item">
        <img src="images/slider/3.jpg" alt="Los Angeles" width="1200" height="700">
        <div class="carousel-caption">
          <h3>Daftar Kalori</h3>
          <p>Daftar kalori makanan dan olahraga disediakan oleh aplikasi dan jika anda memiliki ide 
			untuk menambahkan daftar kalori maka anda dapat mengajukannya</p>
        </div>      
      </div>

    <div class="item">
        <img src="images/slider/3.jpg" alt="Los Angeles" width="1200" height="700">
        <div class="carousel-caption">
          <h3>Reminder</h3>
          <p>Kami juga menyediakan fitur reminder untuk anda agar perencanaan yang sudah dilakukan bisa terealisasi</p>
        </div>      
      </div>

    <div class="item">
        <img src="images/slider/3.jpg" alt="Los Angeles" width="1200" height="700">
        <div class="carousel-caption">
          <h3>Steps Counter</h3>
          <p>Fitur pengukur berlari yang dapat digunakan melalui android</p>
        </div>      
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>

<!-- Container (TOUR Section) -->
<div id="tour" class="">
	<div class="container" text-center>
    	<h3 align="center">How it Works</h3>
  		<p><em>We love music!</em></p>
  		<p>We have created a fictional band website. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	</div>
</div>
<!-- Footer -->
<footer class="text-center">
  <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="">About Us</a></li>
        <li><a href="">Privacy Policy</a></li>
        <li><a href="">Contact Us</a></li>
      </ul>
    </div> 
</footer>
</body>
</html>