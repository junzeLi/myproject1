<div class="container d-flex flex-row justify-content-around align-items-center align-content-center login-clean">
      <div class="col-4 offset-4 login-form ">
			<?php echo form_open(base_url().'login/check_login'); ?>
				<a href="<?php echo base_url(); ?>register" class="float-right" id="register-button">New to BLUE.? Sign up now!</a>
				<ion-icon name="lock-open-outline" id="login-icon"></ion-icon>   
				<h2 class="text-center align-content-center">Login</h2>    
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
					<div class="form-group">
					<?php echo $error; ?>
					</div>
					<!-- <div class="form-group">
						<input type="text" class="form-control" placeholder="What you see from the image?"  required="required" name="cap"></input>
					</div>
					<?php echo $cap_img ?>  
					-->
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="login-submit">Log in</button>
					</div>
					<div class="clearfix">
						<label class="float-left form-check-label"><input type="checkbox" name="remember"> Remember me</label>
						<a href="<?php echo base_url(); ?>login/reset" class="float-right" id="forgot-button">Forgot Password?</a>
						
					</div>    
			<?php echo form_close(); ?>
	</div>
</div>
