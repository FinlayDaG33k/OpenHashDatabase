				<nav class="navbar navbar-default">
       				<div class="container">
       					<div class="navbar-header">
       						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
       							<span class="sr-only">Toggle navigation</span>
       							<span class="icon-bar"></span>
       							<span class="icon-bar"></span>
       							<span class="icon-bar"></span>
       						</button>
       						<a class="navbar-brand" href="#">OpenHashDatabase</a>
       					</div>
          				<div class="navbar-collapse collapse">
            				<ul class="nav navbar-nav">
              					<li <?php if(strtolower($action) == "home"){echo 'class="active"';}?>><a href="?action=home">Home</a></li>
              					<li <?php if(strtolower($action) == "about"){echo 'class="active"';}?>><a href="?action=about">About</a></li>
              					<li <?php if(strtolower($action) == "contact"){echo 'class="active"';}?>><a href="?action=contact">Contact</a></li>
            				</ul>
          				</div>
        			</div>
     			 </nav>