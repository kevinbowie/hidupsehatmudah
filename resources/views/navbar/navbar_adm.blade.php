<nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
          <a class="navbar-brand" href="/">NamaWebSite</a>
      </div>
      <ul class="nav navbar-nav">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Daftar Kalori
              <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><?php echo "<a href='" . url('calories/food/') . "'>Makanan</a></li>"; ?>
              <li><?php echo "<a href='" . url('calories/exercise/') . "'>Olahraga</a></li>"; ?>
            </ul>
          </li>
          <li><?php echo "<a href='" . url('online/') . "'>User yang Online</a></li>"; ?>
          <li><?php echo "<a href='" . url('notification/') . "'>Notifikasi</a></li>"; ?>
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