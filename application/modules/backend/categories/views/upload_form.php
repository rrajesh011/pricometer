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
        if ($this->session->flashdata('success')) {
            echo '<div class="alert alert-success alert-icon alert-close alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<i class="font-icon font-icon-ok"></i>
							' . $this->session->flashdata('success') . '
						</div>';

        }
        ?>
        <section class="card">
            <header class="card-header card-header-md">
                <i class="fa fa-upload"></i> <?php echo $text_form; ?></header>

            <div class="card-block">
                <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data"
                      id="category-form-upload">
                    <div class="form-group">
                        <input type="file" name="files[]" id="file-excel" multiple="multiple" class="form-control-file"
                               accept="<?php echo $accept_type ?>">
                        <input type="hidden" name="file_id" value="">
                        <?php echo isset($error_file) ? '<div class="form-control-feedback">' . $error_file . '</div>' : '' ?>
                    </div>
                    <button value="1" name="upload" type="submit" class="btn btn-success" data-toggle="tooltip"
                            form="category-form-upload"
                            title="<?php echo $button_upload ?>">
                        <i class="fa fa-upload"></i> <?php echo $button_upload ?>
                    </button>
                    <a href="<?php echo $cancel ?>" class="btn btn-danger" data-toggle="tooltip"
                       title="<?php echo $button_cancel ?>"><i class="fa fa-times"></i> <?php echo $button_cancel ?></a>


                </form>
            </div>
        </section>

        <section class="card col-md-6 col-sm-12">
            <header class="card-header card-header-md">
                <i class="fa fa-save"></i> Uploaded Files
                <span data-toggle="tooltip" title="Already Data has been extracted from these files">
                    <i class="fa fa-question-circle"></i>
                </span>
            </header>
            <div class="card-block">
                <div class="col-md-12">
                    <form action="<?php echo $action_file_update ?>" method="post" enctype="multipart/form-data"
                          role="form">
                        <?php foreach ($uploaded_files as $i => $file): ?>
                            <div class="checkbox-bird">
                                <input type="checkbox" name="fileName[]" value="<?php echo $file['name'] ?>"
                                       id="saved-check-bird-<?= $i ?>">
                                <label class="text-success" for="saved-check-bird-<?= $i ?>"><?php echo $file['name'] ?>
                                    <?php
                                    $class = '';
                                    if ($file['status'] == 'Locked') {
                                        $class = "label label-pill label-warning ";
                                    }
                                    if ($file['status'] == 'Modified') {
                                        $class = "label label-pill label-custom ";
                                    }
                                    if ($file['status'] == 'File Not Found') {
                                        $class = "label label-pill label-danger ";
                                    }
                                    ?>
                                    <span class="<?= $class ?> pull-right"><?= $file['status'] ?></span>
                                    <input type="hidden" name="status" value="<?= $file['status'] ?>">
                                </label>
                            </div>
                        <?php endforeach; ?>
                        <?php echo isset($error_file) ? '<div class="text-danger">' . $error_file . '</div>' : '' ?>
                        <div class="m-t-2">
                            <button type="submit" value="1" name="file_update" class="btn btn-primary-outline">
                                <i class="fa fa-file-excel-o"></i> Update
                            </button>
                            <button type="submit" value="1" name="file_remove_db" class="btn btn-danger-outline">
                                <i class="fa fa-file-excel-o"></i> Remove
                            </button>
                            <button type="reset" class="btn btn-info-outline"><i
                                    class="icon-font glyphicon glyphicon-repeat"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="card col-md-6 col-sm-12">
            <header class="card-header card-header-md">
                <i class="glyphicon glyphicon-import"></i> New Excel Files
                <span data-toggle="tooltip" title="File available to import">
                    <i class="fa fa-question-circle"></i>
                </span>
            </header>
            <div class="card-block">
                <div class="col-md-12">
                    <form action="<?php echo $action_file_import ?>" method="post" enctype="multipart/form-data"
                          role="form">
                        <?php foreach ($available_files as $k => $file): ?>
                            <div class="checkbox-bird">
                                <input type="checkbox" id="check-bird-<?= $k ?>" name="file[]" value="<?= $file ?>">
                                <label class="text-info"
                                       for="check-bird-<?= $k ?>"><?php echo pathinfo($file)['basename'] ?></label>
                            </div>
                        <?php endforeach; ?>
                        <?php echo isset($error_file) ? '<div class="text-danger">' . $error_file = '' . '</div>' : '' ?>
                        <div class="m-t-2">
                            <button type="submit" value="1" name="file_import" class="btn btn-primary-outline"><i
                                    class="fa fa-download"></i> Import Data
                            </button>
                            <button type="submit" value="1" name="file_remove_local" class="btn btn-danger-outline"><i
                                    class="fa fa-trash-o"></i> Remove
                            </button>
                            <button type="reset" class="btn btn-info-outline"> Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </div>
</div>