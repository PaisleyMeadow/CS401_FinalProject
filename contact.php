<?php
    require_once("header.php");
?>

<div id="contact-container">
    <div id="contact-box">
        <h1 id="contact-title" class="ubuntu-font login-box-title">Questions? Comments?</h1>
        <form id="contact-form" action="#" method="POST">
            <input label="text" class="ubuntu-font contact-form-input" name="contact-fname" placeholder="First Name" required>
            <input label="text" class="ubuntu-font contact-form-input" name="contact-lname" placeholder="Last Name" required>
            <input label="text" class="ubuntu-font contact-form-input" name="contact-email" placeholder="Email" required>
            <textarea class="ubuntu-font contact-form-input" name="contact-message" placeholder="Message" required></textarea>
            <input type="submit" class="ubuntu-font user-form-submit" value="Send">
        </form> 
    </div>
</div>

<?php
	require_once("footer.php");
?>