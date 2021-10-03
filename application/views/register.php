<div class="container d-flex flex-row justify-content-around align-items-center align-content-center registration">
      <div class="col-4 offset-4 register-form ">
			<?php echo form_open(base_url().'register/register_account'); ?>
                <ion-icon name="happy-outline" id="register-icon"></ion-icon>   
                <h2 class="text-center align-content-center">Sign Up</h2>
                    <div class="form-group">
						<input type="text" class="form-control" placeholder="Email" required="required" name="register_email" id ="email">
					</div>    
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="register_username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="register_password">
                    </div>
                    <div class="form-group">
						<input type="password" class="form-control" placeholder="Confirmed Password" required="required" name="register_confirm_password">
                    </div>
                    <?php echo $error; ?>
					<div class="form-group">
					</div>
					<div class="g-recaptcha" data-sitekey="6LflI9caAAAAACU0hf2Gex9sRiLlWDvlHpxpTBSz"></div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="register-submit">Sign Up Now</button>
					</div>
					<div class="clearfix">
						<a href="<?php echo base_url(); ?>login" class="float-right" id="already-button">Already had account? Log in now!</a>
					</div>    
					
			<?php echo form_close(); ?>
			
			

			</script>
	</div>
</div>