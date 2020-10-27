<?php
    $thisPage = "register";
    require_once("header.php");
    $logger->addLog(print_r($_SESSION, true));

    if(isset($_SESSION["reg-form"])){ //data for persisting input if an error had occured
        $fname_preset =$_SESSION["reg-form"]["register-fname"];
        $lname_preset =$_SESSION["reg-form"]["register-lname"];
        $uname_preset =$_SESSION["reg-form"]["register-uname"];
        $email_preset =$_SESSION["reg-form"]["register-email"];
        $pw_preset =$_SESSION["reg-form"]["register-password"];
        $pwc_preset =$_SESSION["reg-form"]["register-password-confirm"];

        unset($_SESSION["reg-form"]);
    }
?>
    <div id="login-container">
		<div id="login-box">
			
            <h1 id="create-account-title" class="ubuntu-font login-box-title">Create Your Account:</h1>
            <form action="register_handler.php" id="registration-form" method="POST">
                <input label="text" class="ubuntu-font login-form-input" name="register-fname" 
                    <?php
                        if(isset($fname_preset)){
                            echo "value='".$fname_preset."'";
                        }
                    ?>
                placeholder="First Name" size="32" required>
                <input label="text" class="ubuntu-font login-form-input" name="register-lname" 
                        <?php
                            if(isset($lname_preset)){
                                echo "value='".$lname_preset."'";
                            }
                        ?>
                placeholder="Last Name" size="32" required>
                <input label="text" 
                    <?php 
                        if(isset($_SESSION["reg-errors"]["email"]) || isset($_SESSION["reg-errors"]["sameemail"])){
                            echo 'class="ubuntu-font login-form-input login-error"';
                        }
                        else{
                            echo 'class="ubuntu-font login-form-input"';
                        }

                        if(isset($email_preset)){
                            echo "value='".$email_preset."'";
                        }
                    ?>
                name='register-email' placeholder='Email' size='255' required>
                <input label="text"
                        <?php
                            if(isset($_SESSION["reg-errors"]["sameusername"])){
                                echo 'class="ubuntu-font login-form-input login-error"';
                            }
                            else{
                                echo 'class="ubuntu-font login-form-input"';
                            }

                            if(isset($uname_preset)){
                                echo "value='".$uname_preset."'";
                            }
                        ?>
                name="register-uname" placeholder="Username" size="64" required>
                <input label="text" type="password" class=
                    <?php 
                        if(isset($_SESSION["reg-errors"]["badpass"])){
                            echo '"ubuntu-font login-form-input login-error"';
                        }
                        else{
                            echo '"ubuntu-font login-form-input"';
                        }
                    ?>
               name="register-password" placeholder="Password" size="64" required> 
                <input label="text" type="password" class= 
                    <?php
                        if(isset($_SESSION["reg-errors"]["nomatch"])){
                            echo '"ubuntu-font login-form-input login-error"';
                        } 
                        else{
                            echo '"ubuntu-font login-form-input"';
                        }
                    ?>
                    name="register-password-confirm" placeholder="Confirm Password" size="64" required>
                <input type="submit" class="ubuntu-font user-form-submit" value="Register">
            </form>
            <!-- errors container -->
            <div class="errors-container">
                <?php
                    if(isset($_SESSION["reg-errors"])){
                        foreach($_SESSION["reg-errors"] as $error){
                            // foreach($error as $message){}
                            echo '<div class="errors ubuntu-font">'.$error.'</div><br>';
                            unset($_SESSION["reg-errors"]);
                        }
                    }
                ?>
            </div>
        </div>
    </div>

<?php
	require_once("footer.php");
?>