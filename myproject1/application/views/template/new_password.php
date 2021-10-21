<div class="container d-flex flex-row justify-content-around align-items-center align-content-center new_password">
    <ul class="navbar-nav my-lg-0 d-flex d-xl-flex flex-column align-items-xl-center justify-content-center align-content-center">
        <?php echo form_open(base_url().'login/set_password?reset_token='.$reset_token); ?>
        <p> Please enter your new password: </p>
        <div class="form-group">
			<input type="password" class="form-control" placeholder="New Password" required="required" name="new_password">
        </div>
        <div class="form-group">
		    <input type="password" class="form-control" placeholder="Confirmed Password" required="required" name="new_confirm_password">
        </div>
        <?php echo $error; ?>
        <div class="form-group d-flex d-xl-flex flex-row align-items-xl-center justify-content-center align-content-center">
			<button type="submit" class="btn btn-primary btn-block" id="new-password-submit">Set new password</button>
		</div>
    </ul>
</div>