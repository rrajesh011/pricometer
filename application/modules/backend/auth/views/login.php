<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/separate/pages/login.min.css">
<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">
            <form class="sign-box" action="<?php echo base_url('admin/auth/login') ?>" method="post" role="form">
                <h6 class="panel-title text-center"><i class="fa fa-lock"></i> <?php echo $text_login; ?></h6>
                <?php
                if ($error_warning) {
                    echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $error_warning . '</div>';
                }
                ?>
                <div class="sign-avatar">
                    <img src="<?php echo base_url() ?>assets/admin/img/avatar-sign.png" alt="">
                </div>
                <header class="sign-title">Sign In</header>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="E-Mail or Username"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                </div>
                <div class="form-group">
                    <div class="checkbox float-left">
                        <input type="checkbox" id="signed-in"/>
                        <label for="signed-in">Keep me signed in</label>
                    </div>
                    <div class="float-right reset">
                        <a href="reset-password.html">Reset Password</a>
                    </div>
                </div>
                <button type="submit" class="btn btn-rounded"><?php echo $button_login ?></button>
            </form>
        </div>
    </div>
</div><!--.page-center-->