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

        <?php
        if ($error_warning) {
            echo '<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<i class="font-icon font-icon-warning"></i>
							' . $error_warning . '
						</div>';
        }
        ?>

        <section class="card">
            <header class="card-header card-header-lg">
                <i class="fa fa-plus"></i> <?php echo $text_form; ?>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success" data-toggle="tooltip" form="category-form"
                            title="<?php echo $button_save ?>"><i class="fa fa-save"></i> <?php echo $button_save ?>
                    </button>
                    <a href="<?php echo $cancel ?>" class="btn btn-danger" data-toggle="tooltip"
                       title="<?php echo $button_cancel ?>"><i class="fa fa-times"></i> <?php echo $button_cancel ?></a>
                </div>
            </header>
            <div class="card-block">
                <form action="<?php echo $action ?>" enctype="multipart/form-data" id="category-form" method="post"
                      class="form-horizontal m-t-1">

                    <div class="col-md-12 form-group">
                        <label for="input-name" class="col-md-2 control-label"><?php echo $entry_name ?></label>
                        <div class="col-md-10 form-control-wrapper">
                            <input id="input-name" type="text" class="form-control"
                                   name="name"
                                   value="<?php echo $name ?>"
                                   placeholder="<?php echo $entry_name ?>">
                            <?php echo $error_name ? '<div class="form-control-feedback">' . $error_name . '</div>' : '' ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="input-affiliate-id"
                               class="col-md-2 control-label"><?php echo $entry_affiliate_id ?></label>
                        <div class="col-md-10 form-control-wrapper">
                            <input type="text" name="affiliate_id" id="input-affiliate-id" class="form-control"
                                   placeholder="<?php echo $entry_affiliate_id ?>"
                                   value="<?php echo $affiliate_id ?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="input-url-alias"
                               class="col-md-2 form-control-label"><?php echo $entry_affiliate_url_alias ?></label>
                        <div class="col-md-10 form-control-wrapper">
                            <input type="text" name="affiliate_url_alias" id="input-url-alias" class="form-control"
                                   placeholder="<?php echo $entry_affiliate_url_alias ?>"
                                   value="<?php echo $affiliate_url_alias ?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="input-status"
                               class="col-md-2 control-label"><?php echo $entry_status ?></label>
                        <div class="col-md-10 form-control-wrapper">
                            <select name="status" id="input-status" class="bootstrap-select">
                                <?php if ($status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="input-description"
                               class="col-md-2 control-label"><?php echo $entry_description ?></label>
                        <div class="col-md-10 form-control-wrapper">
                                <textarea
                                        class="tinymce form-control"
                                        name="description"
                                        id="input-description"
                                        rows="4"><?php echo $description ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>