<nav class="navbar navbar-inverse">
  	<div class="container-fluid">
    	<div class="navbar-header">
          <?php echo "<a class='navbar-brand' href='" . url('/') . "'>NamaWebsite</a>"; ?>
    	</div><!-- 
    	<ul class="nav navbar-nav">
      		<li><a href="#">Page 1</a></li>
      		<li><a href="#">Page 2</a></li>
    	</ul> -->
    	<ul class="nav navbar-nav navbar-right">
	      	<li class="active"><?php echo "<a href='" . url('register/') . "'>"; ?><span class="glyphicon glyphicon-user"></span> Daftar</a></li>
	      	<li>
	      		<a href="#" data-toggle="modal" data-target="#login-modal" id="login">
	      			<span class="glyphicon glyphicon-log-in"></span> Masuk
	      		</a>
	      	</li>
	    </ul>
  </div>
</nav> 