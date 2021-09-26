<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/style.css">
    </head>
    <body>
        <div class="login-container d-flex">
            <?php $attributes = array('class' => 'login-form text-center');?>
            <?php echo form_open('users/login_validation', $attributes);?>
                    <h1 class="mb-5 font-weight-light text-uppercase">Expense</h1>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control rounded-pill form-control-lg" placeholder="Username">
                        <span class="text-danger"><?php echo form_error('username'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control rounded-pill form-control-lg" placeholder="Password">
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                        <?php if($this->session->flashdata('user_sign_in_error')):?>
                            <?php echo '<span class="text-danger">'.$this->session->flashdata('user_sign_in_error').'</span>';?>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="insert" value="Login" class="btn btn-primary btn-block rounded-pill">Login</button>
                    <p class="mt-3 font-weight-normal login-reg-msg">Don't have an account? <a href="register">Sign Up</a></p>
            <?php echo form_close(); ?>
        </div>
    </body>
</html>