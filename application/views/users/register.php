<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/style.css">
    </head>
    <body>
        <div class="login-container d-flex align-items-center justify-content-center">
            <?php $attributes = array('class' => 'login-form text-center');?>
            <?php echo form_open('users/register_validation', $attributes);?>
                <h1 class="mb-5 font-weight-light text-uppercase">Expense</h1>
                <div class="form-group">
                    <input type="text" name="username" class="form-control rounded-pill form-control-lg" placeholder="Username">
                    <span class="text-danger"><?php echo form_error('username'); ?></span>
                    <?php if($this->session->flashdata('check_username_exists')):?>
                        <?php echo '<span class="text-danger">'.$this->session->flashdata('check_username_exists').'</span>';?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control rounded-pill form-control-lg" placeholder="Password">
                    <span class="text-danger"><?php echo form_error('password'); ?></span>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm-password" class="form-control rounded-pill form-control-lg" placeholder="Confirm Password">
                    <span class="text-danger"><?php echo form_error('confirm-password'); ?></span>
                </div>
                <button type="submit" class="btn btn-primary btn-block rounded-pill">Register</button>
                <p class="mt-3 font-weight-normal login-reg-msg">Already have an account? <a href="login">Sign In</a></p>
            <?php echo form_close();?>
        </div>
    </body>
</html>