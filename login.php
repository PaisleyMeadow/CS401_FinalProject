<?php
    require_once("header.php");
?>
    <div id="login-container">
			<div id="login-box">
			
				<!-- user login elements -->
				<h1 class="ubuntu-font login-box-title">Welcome Back.</h1>
				<form id="login-form" action="app.php" method="POST">
					<input label="text" class="ubuntu-font login-form-input" name="login-uname" placeholder="Username" required>
					<input label="text" type="password" class="ubuntu-font login-form-input" name="login-pw" placeholder="Password" required>
					<input type="submit" class="ubuntu-font user-form-submit" value="Sign In">
				</form>
			</div>		
		</div>

<?php
	require_once("footer.php");
?>