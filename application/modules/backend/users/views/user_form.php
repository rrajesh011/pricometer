<div class="page-content">
    <div class="container-fluid">
        <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h3><?php echo $heading_title ?></h3>
                        <ol class="breadcrumb breadcrumb-simple">
                            <?php foreach ($breadcrumbs as $breadcrumb) {
                                echo '<li><a href="' . $breadcrumb['href'] . '">' . $breadcrumb['text'] . '</a></li>';
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </header>
        <?php if ($error_warning) {
            echo '<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<i class="font-icon font-icon-warning"></i>
							' . $error_warning . '
						</div>';
        } ?>
        <section class="card">
            <div class="card-block">
                <form id="form-signup_v1" name="form-signup_v1" method="POST" action="<?php echo $action ?>">
                    <div class="row m-t-lg">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="signup_v2-name"><?php echo $entry_name ?></label>
                                <div class="form-control-wrapper">
                                    <input id="signup_v2-name"
                                           class="form-control"
                                           name="name"
                                           type="text"
                                           value="<?php echo $name ?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signup_v1-username"><?php echo $entry_username ?></label>
                                <div class="form-control-wrapper">
                                    <input id="signup_v1-username"
                                           class="form-control"
                                           name="username"
                                           value="<?php echo $username ?>"
                                           type="text">
                                    <?php if ($error_username) { ?>
                                        <div class="text-danger"><?php echo $error_username; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signup_v1-email"><?php echo $entry_email ?></label>
                                <div class="form-control-wrapper">
                                    <input id="signup_v1-email"
                                           class="form-control"
                                           name="email"
                                           type="text"
                                           value="<?php echo $email ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signup_v1-group"><?php echo $entry_status ?></label>
                                <div class="form-control-wrapper">
                                    <select name="status" id="signup_v1-status" class="bootstrap-select">
                                        <?php if ($status) {
                                            echo '<option value=0>' . $text_disabled . '</option>';
                                            echo '<option value=1 selected>' . $text_enabled . '</option>';
                                        } else {
                                            echo '<option value=0 selected>' . $text_disabled . '</option>';
                                            echo '<option value=1>' . $text_enabled . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="signup_v1-password"><?php echo $entry_password ?></label>
                                <div class="form-control-wrapper">
                                    <input id="signup_v1-password"
                                           class="form-control"
                                           name="password"
                                           value="<?php echo $password ?>"
                                           type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"
                                       for="signup_v1-password-confirm"><?php echo $entry_confirm ?></label>
                                <div class="form-control-wrapper">
                                    <input id="signup_v1-password-confirm"
                                           class="form-control"
                                           name="password_confirm"
                                           value="<?php echo $confirm ?>"
                                           type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signup_v1-group"><?php echo $entry_user_group ?></label>
                                <div class="form-control-wrapper">
                                    <select name="user_group_id" id="signup_v1-group" class="bootstrap-select">
                                        <option value=1>Administrator</option>
                                        <option value=2>User</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div><!--.row-->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><?php echo $button_save ?></button>
                        <a href="<?php echo $cancel ?>" class="btn btn-danger"><?php echo $button_cancel ?></a>
                    </div>
                </form>
            </div>
        </section>
    </div><!--.container-fluid-->
</div><!--.page-content-->