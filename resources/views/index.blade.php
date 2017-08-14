
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
      width: 70%; /* Set width to 100% */
	    height: 150px;
      margin: auto;
  }
  .carousel-caption h3 {
      color: #fff !important;
  }
  @media (max-width: 500px) {
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
  body{
    background: url("images/bg1.jpg") no-repeat center;
    background-size: cover;
  }
  .navbar{
    margin-bottom: auto;
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

	<h2 align="center">Apa yang kamu dapat</h2>

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
        <img src="images/1.jpeg" alt="Hidup Sehat" width="1000px" height="700">
        <div class="carousel-caption">
          <h1>Gaya Hidup Sehat</h1>
          <p>Mulai mendapatkan gaya hidup sehat yang lebih baik dan terencana sehingga menjadikannya sebagai kebiasaan hidup, 
			mulai dari pengaturan pola makan, olahraga, tidur, dan minum</p>
        </div>      
      </div>

      <div class="item">
        <img src="images/1.jpeg" alt="Hidup Sehat" width="1000" height="700">
        <div class="carousel-caption">
          <h1>Pengaturan Berat Badan</h1>
          <p>Mengatur kalori masuk dan kalori keluar sehingga berat badan menjadi terkontrol dan 
			dapat dimanfaatkan sebagai program menaikkan / menurunkan berat badan</p>
        </div>      
      </div>
    
      <div class="item">
        <img src="images/1.jpeg" alt="Hidup Sehat" width="1000" height="700">
        <div class="carousel-caption">
          <h1>Scoreboard</h1>
          <p>Anda tidak akan bosan dalam mengikuti program ini, karena anda dan user lainnya akan berlomba 
			memiliki streak (catatan kerutinan) yang terbaik</p>
        </div>      
      </div>
    <div class="item">
        <img src="images/1.jpeg" alt="Hidup Sehat" width="1000" height="700">
        <div class="carousel-caption">
          <h1>History</h1>
          <p>Anda dapat memantau histori gaya hidup sehat anda sebelumnya</p>
        </div>      
      </div>

    <div class="item">
        <img src="images/1.jpeg" alt="Hidup Sehat" width="1000" height="700">
        <div class="carousel-caption">
          <h1>Daftar Kalori</h1>
          <p>Daftar kalori makanan dan olahraga disediakan oleh aplikasi dan jika anda memiliki ide 
			untuk menambahkan daftar kalori maka anda dapat mengajukannya</p>
        </div>      
      </div>

    <div class="item">
        <img src="images/1.jpeg" alt="Hidup Sehat" width="1000" height="700">
        <div class="carousel-caption">
          <h1>Reminder</h1>
          <p>Kami juga menyediakan fitur reminder untuk anda agar perencanaan yang sudah dilakukan bisa terealisasi</p>
        </div>      
      </div>

    <div class="item">
        <img src="images/1.jpeg" alt="Hidup Sehat" width="1000" height="700">
        <div class="carousel-caption">
          <h1>Steps Counter</h1>
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
</div>
<br>
@include('navbar/navbar_footer')
</body>
</html>