<?php # this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1){
	die("Error, Contact webtoprint.midtown.com.ph");
} 
?>
<div id="mpci-top" class="mpci-float-left mpci-background">
		
		<?php 
			# display login, logout, sign up etc in the mpci-top right
			if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){?>
				<div class="mpci-menu-right">
					<ul>
						<?php 
						# print administrator's name at the top when the one who login is administrator.
						if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
							echo '<li><a href="?admin=admin" class="admin">'.$_SESSION['name'].'</a></li>';
						}else{
							# print user's name at the top when the one who login is the user.
							echo '<li><a href="" class="username">'.$_SESSION['name'].'</a></li>';
						}
						echo '<li><a href="?logout" class="logout">Logout</a></li>';
						?>
					</ul>
				</div>
		<?php }else{ ?>
				<div class="mpci-menu-right">
					<ul>
						<li><a href="#"   class="login"> Login</a></li>
						<li><a href="?signup=signup" class="signup">Sign Up</a></li>			
					</ul>
				</div>
		<?php	}	?>
		<!-- menu in the left -->
		<div class="mpci-menu-left">
			<ul>
				<?php 
				# display top right menu
				echo '<li><a class="mpci-home" 	href="'.$current_url.'">Home		     </a></li>';
				echo '<li><a class="calc" 		href="?calc=calc">	    Price Calculator </a></li>';
				echo '<li><a class="create"		href="?create=create">	Design    		 </a></li>';
				echo '<li><a class="term" 		href="?term=termofuse">	Term Of Use	     </a></li>';
				echo '<li><a class="contact"    href="?contact=contact">Contact Us		 </a></li>';
				echo '<li><a class="about"      href="#">         		Our Blog	     </a></li>';
				
				# display if the admin is not loggedin.
				if(isset($_SESSION['loggedin'])){
					if( isset($_SESSION['user']) && $_SESSION['user'] == true ){
						echo '<li><a class="cart" href="#">My Cart</a></li>';
					}
				}
				?>
			</ul>
		</div>

</div><!-- end of #mpci-top -->		