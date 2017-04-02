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
                <i class="fa fa-plus"></i> <?php echo $text_form ?>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success" data-toggle="tooltip" form="form-banner"
                            title="Save"><i class="fa fa-save"></i> Save
                    </button>
                    <a href="<?php echo $cancel ?>"
                       class="btn btn-danger" data-toggle="tooltip" title="Cancel"><i class="fa fa-times"></i>
                        Cancel</a>
                </div>
            </header>
            <div class="card-block">
                <form action="<?php echo $action ?>" enctype="multipart/form-data" id="form-banner" method="post">
                    <div class="col-md-12 form-group m-t-1">
                        <label for="input-name" class="form-control-label col-md-3"><?php echo $entry_name ?></label>
                        <div class="form-control-wrapper">
                            <div class="col-md-9">
                                <input type="text" name="name"
                                       id="input-name" value="<?php echo $name ?>"
                                       placeholder="<?php echo $entry_name ?>"
                                       class="form-control">
                                <?php echo $error_name != '' ? '<div class="form-control-feedback">' . $error_name . '</div>' : '' ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group m-t-1">
                        <label for="input-select" class="col-md-3 control-label"><?php echo $entry_status ?></label>
                        <div class="form-control-wrapper">
                            <div class="col-md-9">
                                <select id="input-select" name="status" class="bootstrap-select">
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

                    <table id="images" class="table table-bordered m-t-3">
                        <thead>
                        <tr>
                            <th><?php echo $entry_title ?></th>
                            <th><?php echo $entry_link ?></th>
                            <th><?php echo $entry_image ?></th>
                            <th><?php echo $entry_sort_order ?></th>
                            <th><?php echo $entry_action ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $image_row = 0;
                        if (!empty($banner_images)) {
                            foreach ($banner_images as $banner_image) { ?>
                                <tr id="image-row<?= $image_row ?>">
                                    <td class="text-left">
                                        <input type="text" name="banner_image[<?= $image_row ?>][title]"
                                               value="<?= $banner_image['title'] ?>"
                                               placeholder="<?= $entry_title ?>" class="form-control">
                                        <?php echo isset($error_banner_image[$image_row]) ? '<div class="text-danger">' . $error_banner_image[$image_row] . '</div>' : '' ?>
                                    </td>
                                    <td class="text-left">
                                        <input type="text" name="banner_image[<?= $image_row ?>][link]"
                                               value="<?= $banner_image['link'] ?>"
                                               placeholder="<?= $entry_link ?>" class="form-control">
                                    </td>
                                    <td class="text-left">
                                        <a href="" id="thumb-image-<?= $image_row ?>" data-toggle="image"
                                           class="img-thumbnail">
                                            <img src="<?= $banner_image['thumb'] ?>" alt="" title=""
                                                 data-placeholder="<?= $placeholder ?>">
                                        </a>
                                        <input type="hidden" name="banner_image[<?= $image_row ?>][image]"
                                               value="<?= $banner_image['image'] ?>"
                                               id="input-image<?= $image_row ?>" class="form-control">
                                    </td>
                                    <td class="text-left">
                                        <input type="text" name="banner_image[<?= $image_row ?>][sort_order]"
                                               value="<?= $banner_image['sort_order'] ?>"
                                               placeholder="<?= $entry_sort_order ?>" class="form-control">
                                    </td>
                                    <td class="text-left">
                                        <button type="button"
                                                onclick="$('#image-row<?php echo $image_row; ?>, .tooltip').remove();"
                                                data-toggle="tooltip" title="<?php echo $button_remove; ?>"
                                                class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                    </td>
                                </tr>
                                <?php
                                $image_row++;
                            }
                        } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-left">
                                <button type="button" onclick="addImage();"
                                        data-toggle="tooltip" title="<?php echo $button_banner_add; ?>"
                                        class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>
<script>
    var image_row =<?=$image_row?>;
    var tbody = '';
    function addImage() {
        tbody += '<tr id="image-row' + image_row + '">';
        tbody += '<td class="text-left"><input type="text" name="banner_image[' + image_row + '][title]" placeholder="<?php echo $entry_title?>" class="form-control" /></td>';
        tbody += '<td class="text-left"><input type="text" name="banner_image[' + image_row + '][link]" placeholder="<?php echo $entry_link?>" class="form-control" /></td>';
        tbody += '<td class="text-left"><a href="" id="thumb-image-' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder ?>" alt="" title="" data-placeholder="<?php echo $placeholder?>"></a><input type="hidden" name="banner_image[' + image_row + '][image]" value="<?php echo $placeholder ?>" id="input-image' + image_row + '"/></td>';
        tbody += '<td class="text-left"><input type="text" name="banner_image[' + image_row + '][sort_order]" class="form-control" placeholder="<?php echo $entry_sort_order?>"/></td>';
        tbody += '<td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + ', .tooltip\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        tbody += '</tr>';

        $('#images tbody').append(tbody);
        image_row++;
        tbody = '';
    }
</script>