<style type="text/css">
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
}
</style>

<nav class="navbar navbar-inverse">
  	<div class="container-fluid">
    	<div class="navbar-header">
      		<a class="navbar-brand" href="/">Hidup Sehat Mudah</a>
    	</div>
    	<ul class="nav navbar-nav">
      		<li><?php echo "<a href='" . url('todolist/') . "'>Agenda Kegiatan</a></li>"; ?>
          <li><?php echo "<a href='" . url('goals/') . "'>Grafik</a></li>"; ?>
          <li><?php echo "<a href='" . url('scoreboard/') . "'>Papan Skor</a></li>"; ?>
            
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Lainnya
              <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-submenu">
                <a class="test" href="#">Daftar Kalori<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><?php echo "<a href='" . url('calories/food/') . "'>Makanan</a></li>"; ?>
                  <li><?php echo "<a href='" . url('calories/exercise/') . "'>Olahraga</a></li>"; ?>
                </ul>
              </li>
              <li class="dropdown-submenu">
                <a class="test" href="#">Menu Makan<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><?php echo "<a href='" . url('menu/food/owner/') . "'>Menu Anda</a></li>"; ?>
                  <li><?php echo "<a href='" . url('menu/food/shared/') . "'>Menu yang Dibagikan</a></li>"; ?>
                </ul>
              </li>
            </ul>
          </li>

          <li><?php echo "<a href='" . url('steps/') . "'>Langkah</a></li>"; ?>
    	</ul>
    	<ul class="nav navbar-nav navbar-right">
	      	<li class="active"><?php echo "<a href='" . url('profile/') . "'><span class='glyphicon glyphicon-user'></span>Profil</a></a></li>"; ?>
	      	<li>
	      		<?php echo "<a href='" . url('logout/') . "'>"; ?>
	      			<span class="glyphicon glyphicon-log-out"></span>Keluar</a>
	      		</a>
	      	</li>
	    </ul>
  </div>
</nav> 


<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>