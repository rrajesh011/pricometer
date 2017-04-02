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
                    <button type="submit" class="btn btn-success" data-toggle="tooltip" form="offer-form"
                            title="<?php echo $button_save ?>"><i class="fa fa-save"></i> <?php echo $button_save ?>
                    </button>
                    <a href="<?php echo $cancel ?>" class="btn btn-danger" data-toggle="tooltip"
                       title="<?php echo $button_cancel ?>"><i class="fa fa-times"></i> <?php echo $button_cancel ?></a>
                </div>
            </header>
            <div class="card-block">
                <form action="<?php echo $action ?>" enctype="multipart/form-data" id="offer-form" method="post"
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
                        <label for="input-name" class="col-md-2 control-label"><?php echo $entry_store ?></label>
                        <div class="col-md-10 form-control-wrapper">
                            <?php
                            if (!empty($stores)) {
                                echo '<select name="store_id" class="select2" id="select-store" data-placeholder="Select Offer Corresponding to Store">';
                                echo '<option value></option>';
                                foreach ($stores as $store) {
                                    $selected = '';
                                    if ($store['store_id'] == $store_id) {
                                        $selected = 'selected';
                                    }
                                    echo '<option ' . $selected . ' value="' . $store['store_id'] . '">' . $store['name'] . '</option>';
                                }
                                echo '<option value="New">Add New Store</option>';
                                echo '</select>';
                            }
                            ?>

                            <?php echo $error_store ? '<div class="form-control-feedback">' . $error_store . '</div>' : '' ?>
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
                </form>
            </div>

            <!--Modal-->
            <div class="modal fade" id="addNewStoreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="storeFormModal" class="form-horizontal" role="form" method="post" action="#">
                            <div class="modal-header">
                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                    <i class="font-icon-close-2"></i>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Add Store</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="input-store-name" class="form-control-label">Store Name</label>
                                    <input class="form-control" type="text" id="input-store-name" name="stores[name]"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="input-aff-id" class="form-control-label">Affiliate ID</label>
                                    <input class="form-control" type="text" id="input-aff-id"
                                           name="stores[affiliate_id]" required>
                                </div>
                                <div class="form-group">
                                    <label for="input-aff-url" class="form-control-label">Affiliate URL</label>
                                    <input class="form-control" type="text" id="input-aff-url"
                                           name="stores[affiliate_url_alias]" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close
                                </button>
                                <button type="submit" class="btn btn-rounded btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!--.modal-->
        </section>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.select2').select2({empty: true, allowClear: true});
        $html = '';
        $('#select-store').select2().on('select2:close', function () {
            var el = $(this);
            if (el.val() === 'New') {
                $('#addNewStoreModal').modal('show');
            }
        });

        $('#storeFormModal').submit(function (e) {
            e.preventDefault();
            var $this = $(this);
            $(this).find('button[type="submit"]').attr('disabled', true).text('Submitting...');
            $.post($('#base').val() + 'admin/offers/store_add', {data: $('form#storeFormModal').serialize()}, function (response) {
                if (response) {
                    $('.select2').trigger('change.select2');
                    $this.find('button[type="submit"]').attr('disabled', false).text('Save Changes');
                    $('#storeFormModal')[0].reset();
                    $('#addNewStoreModal').modal('hide');
                }
            });
        });
    });
</script>