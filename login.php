<?php
	$thisPage ="login";
	require_once("header.php");
	
	// if(isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true){
	// 	header("Location: app.php");
    //     exit();
	// }

	if(isset($_SESSION["login-form"])){
		$uname_preset = $_SESSION["login-form"]["login-uname"];
		unset($_SESSION["login-form"]);
	}
?>
    <div id="login-container">
			<div id="login-box">
			
				<!-- user login elements -->
				<h1 class="ubuntu-font login-box-title">
					<?php
						if(isset($_SESSION["new_user"])){
							echo "Registration Successful.";
							unset($_SESSION["new_user"]);
						}
						else{
							echo "Welcome Back.";
						}
					?>
					</h1>
				<form id="login-form" action="login_handler.php" method="POST">
					<input label="text" class="ubuntu-font login-form-input" 
						<?php
							if(isset($uname_preset)){
								echo 'value="'.$uname_preset.'"';
							}
						?>
					name="login-uname" placeholder="Username" required>
					<input label="text" type="password" class="ubuntu-font login-form-input" name="login-pw" placeholder="Password" required>
					<input type="submit" class="ubuntu-font user-form-submit" value="Sign In">
				</form>
				<div class="errors-container">
						<?php
							if(isset($_SESSION["login-errors"])){
								echo '<div class="errors ubuntu-font">'.$_SESSION["login-errors"].'</div><br>';
								unset($_SESSION["login-errors"]);
							}
						?>
				</div>
			</div>		
		</div>

<?php
	require_once("footer.php");
?>