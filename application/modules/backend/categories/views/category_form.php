<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/separate/vendor/typeahead.min.css">
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
            <header class="card-header card-header-md">
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
                <form action="<?php echo $action ?>" enctype="multipart/form-data" id="category-form" method="post">
                    <div class="tabs-section-nav tabs-section-nav-inline">
                        <div class="tbl">
                            <ul class="nav" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab"
                                       aria-expanded="true">
                                        <?php echo $tab_general ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab"
                                       aria-expanded="false">
                                        <?php echo $tab_meta ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab"
                                       aria-expanded="false">
                                        <?php echo $tab_extra ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!--.tabs-section-nav-->

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tabs-1-tab-1" aria-expanded="true">
                            <div class="col-md-12 form-group m-t-1">
                                <label for="input-name" class="col-md-2 control-label"><?php echo $entry_name ?></label>
                                <div class="col-md-10 form-control-wrapper">
                                    <input id="input-name" type="text" class="form-control"
                                           name="categories_description[name]"
                                           value="<?php echo isset($categories_description['name']) ? $categories_description['name'] : '' ?>"
                                           placeholder="<?php echo $entry_name ?>">
                                    <?php echo isset($error_name) ? '<div class="text-danger">' . $error_name . '</div>' : '' ?>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="input-parent"
                                       class="col-md-2 control-label"><?php echo $entry_parent ?></label>
                                <div class="col-md-10 form-control-wrapper">
                                    <div class="typeahead-container">
                                        <div class="typeahead-field">
                                            <input type="text" name="path"
                                                   id="input-parent"
                                                   class="form-control" autocomplete="off"
                                                   placeholder="<?php echo $entry_parent ?>"
                                                   value="<?php echo $path ?>">
                                            <input type="hidden" name="parent_id"
                                                   value="<?php echo $parent_id ?>">
                                            <?php echo isset($error_parent) ? '<div class="text-danger">' . $error_parent . '</div>' : '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="input-description"
                                       class="col-md-2 control-label"><?php echo $entry_description ?></label>
                                <div class="col-md-10 form-control-wrapper">
                                <textarea
                                        class="tinymce form-control"
                                        name="categories_description[description]"
                                        id="input-description"
                                        rows="4"><?php echo isset($categories_description['description']) ? $categories_description['description'] : '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="input-sort-order"
                                       class="col-md-2 control-label"><?php echo $entry_sort_order ?></label>
                                <div class="col-md-10 form-control-wrapper">
                                    <input type="text" name="sort_order" id="input-sort-order" class="form-control"
                                           placeholder="<?php echo $entry_sort_order ?>"
                                           value="<?php echo $sort_order = 0 ?>">
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
                        </div>

                        <!--.tab-pane-->
                        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2" aria-expanded="false">
                            <div class="col-md-12 form-group m-t-1">
                                <label for="input-meta-title"
                                       class="col-md-2 control-label"><?php echo $entry_meta_title ?></label>
                                <div class="col-md-10 form-control-wrapper">
                                    <input id="input-name" type="text" class="form-control"
                                           name="categories_description[meta_title]"
                                           value="<?php echo isset($categories_description['meta_title']) ? $categories_description['meta_title'] : '' ?>"
                                           placeholder="<?php echo $entry_meta_title ?>">
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="input-meta-description"
                                       class="col-md-2 control-label"><?php echo $entry_meta_description ?></label>
                                <div class="col-md-10 form-control-wrapper">
                                <textarea
                                        class="form-control"
                                        name="categories_description[meta_description]"
                                        placeholder="<?php echo $entry_meta_description ?>"
                                        id="input-meta-description"
                                        rows="4"><?php echo isset($categories_description['meta_description']) ? $categories_description['meta_description'] : '' ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="input-meta-keyword"
                                       class="col-md-2 control-label"><?php echo $entry_meta_keyword ?></label>
                                <div class="col-md-10 form-control-wrapper">
                                <textarea
                                        class="form-control"
                                        name="categories_description[meta_keyword]"
                                        placeholder="<?php echo $entry_meta_keyword ?>"
                                        id="input-meta-keyword"
                                        rows="4"><?php echo isset($categories_description['meta_keyword']) ? $categories_description['meta_keyword'] : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <!--.tab-pane-->
                        <div role="tabpanel" class="tab-pane fade m-t-1" id="tabs-1-tab-3" aria-expanded="false">
                            <label for="input-image"
                                   class="col-md-2 control-label"><?php echo $entry_image ?></label>
                            <div class="col-md-10 form-control-wrapper">
                                <input type="file" name="image" id="input-image" class="form-control-file"
                                       placeholder="">
                                <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image"/>
                            </div>
                        </div>
                    </div><!--.tab-content-->
                </form>
            </div>
        </section>

        <section class="tabs-section">
        </section>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('input[name=\'path\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'autocomplete?token=<?php echo $token?>&filter_name=' + encodeURIComponent(request.term),
                    dataType: 'json',
                    success: function (json) {
                        json.unshift({
                            category_id: 0,
                            name: '<?php echo $text_none?>'
                        });
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['category_id']
                            }
                        }));
                    }
                })
            }, 'select': function (item) {
                $('input[name=\'path\']').val(item['label']);
                $('input[name=\'parent_id\']').val(item['value']);
            }
        });
    });
</script>