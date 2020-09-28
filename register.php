<?php
    require_once("header.php");
?>
    <div id="login-container">
			<div id="login-box">
			
            <h1 id="create-account-title" class="ubuntu-font login-box-title">Create Your Account:</h1>
            <form action="app.php" id="registration-form">
                <input label="text" class="ubuntu-font login-form-input" name="register-fname" placeholder="First Name" required>
                <input label="text" class="ubuntu-font login-form-input" name="register-lname" placeholder="Last Name" required>
                <input label="text" class="ubuntu-font login-form-input" name="register-email" placeholder="Email" required>
                <input label="text" class="ubuntu-font login-form-input" name="register-uname" placeholder="Username" required>
                <input label="text" type="password" class="ubuntu-font login-form-input" name="register-password" placeholder="Password" required>
                <input label="text" type="password" class="ubuntu-font login-form-input" name="register-password-confirm" placeholder="Confirm Password" required>
                <input type="submit" class="ubuntu-font user-form-submit" value="Register">
            </form>
			</div>		
		</div>

<?php
	require_once("footer.php");
?>