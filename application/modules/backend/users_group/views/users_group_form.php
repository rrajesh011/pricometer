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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user-group"
              class="form-horizontal">
            <section class="card">
                <header class="card-header card-header-lg">
                    <i class="fa fa-plus"></i> <?php echo $text_form; ?>
                </header>
                <div class="card-block">
                    <div class="col-md-12 form-group">
                        <label for="input-name" class="col-md-3 control-label"><?php echo $entry_name ?></label>
                        <div class="col-md-9 form-control-wrapper">
                            <input id="input-name" type="text" class="form-control" name="name"
                                   placeholder="<?php echo $entry_name ?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="input-access" class="col-md-3 control-label"><?php echo $entry_access ?></label>
                        <div class="col-md-9 form-control-wrapper">
                            <div class="col-md-12 col-sm-12"
                                 style="padding: 20px;border-radius:3px;border: 1px solid rgba(197, 214, 222, .7);overflow: auto;height: 150px;">
                                <?php $i = 1;
                                foreach ($permissions as $value): ?>
                                    <?php if (in_array($value, $access)) { ?>
                                        <div class="checkbox-bird green">
                                            <input type="checkbox" name="permission[access][]" id="check-bird-<?= $i ?>" checked>
                                            <label for="check-bird-<?= $i ?>"><?= $value ?></label>
                                        </div>
                                    <?php } else { ?>
                                        <div class="checkbox-bird green">
                                            <input type="checkbox" name="permission[access][]" id="check-bird-<?= $i ?>" value="<?= $value ?>">
                                            <label for="check-bird-<?= $i ?>"><?= $value ?></label>
                                        </div>
                                    <?php }
                                    $i++; endforeach; ?>
                            </div>
                            <a style="color: #1e91cf;"
                               onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a>
                            / <a style="color: #1e91cf;"
                                 onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="input-access" class="col-md-3 control-label"><?php echo $entry_modify ?></label>
                        <div class="col-md-9 form-control-wrapper">
                            <div class="col-md-12 col-sm-12"
                                 style="padding: 20px;border-radius:3px;border: 1px solid rgba(197, 214, 222, .7);overflow: auto;height: 150px;">
                                <?php $j=1;foreach ($permissions as $value): ?>
                                    <?php if (in_array($value, $modify)) { ?>
                                        <div class="checkbox-bird green">
                                            <input type="checkbox" name="permission[modify][]" id="check-bird-<?= $j ?>"
                                                   checked>
                                            <label for="check-bird-<?= $j ?>"><?= $value ?></label>
                                        </div>
                                    <?php } else { ?>
                                        <div class="checkbox-bird green">
                                            <input type="checkbox" name="permission[modify][]"
                                                   id="check-bird-<?= $j ?>">
                                            <label for="check-bird-<?= $j ?>"><?= $value ?></label>
                                        </div>
                                    <?php }
                                    $j++; endforeach; ?>
                            </div>
                            <a style="color: #1e91cf;"
                               onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a>
                            / <a style="color: #1e91cf;"
                                 onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                        </div>
                    </div>
                    <div class="col-md-9 form-group-wrapper">
                        <button type="submit" class="btn btn-success"><?php echo $button_save ?></button>
                        <a href=<?php echo $cancel?> class="btn btn-danger"><?php echo $button_cancel ?></a>
                    </div>
                </div>
            </section>
        </form>
    </div><!--.container-fluid-->
</div><!--.page-content-->