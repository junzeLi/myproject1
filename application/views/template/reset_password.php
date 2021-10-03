<div class="container d-flex flex-row justify-content-around align-items-center align-content-center reset_password">
    <ul class="navbar-nav my-lg-0 d-flex d-xl-flex flex-column align-items-xl-center justify-content-center align-content-center">
        <?php echo form_open(base_url().'login/reset_email'); ?>
        <p> Please enter the email you used to sign up, an email will be sent to your email address for reseting password. </p>
        <div class="form-group d-flex d-xl-flex flex-row align-items-xl-center justify-content-center align-content-center">
			<input type="text" class="form-control" placeholder="Email" required="required" name="reset_email">
        </div>    
        <?php echo $error; ?>
        <div class="form-group d-flex d-xl-flex flex-row align-items-xl-center justify-content-center align-content-center">
			<button type="submit" class="btn btn-primary btn-block" id="reset-submit">Get email</button>
		</div>
    </ul>
</div>