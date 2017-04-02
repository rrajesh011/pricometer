<link rel="stylesheet" href="<?php echo base_url().'assets/admin/css/lib/bootstrap/bootstrap.min.css' ?>">
<div id="filemanager" class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Image Manager</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-5">
                    <a href="<?php echo $parent ?>" class="btn btn-primary" id="button-parent"
                       title="<?php echo $button_parent ?>" data-toggle="tooltip">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <a href="<?php echo $refresh; ?>" class="btn btn-success" id="button-refresh"
                       title="<?php echo $button_refresh ?>"
                       data-toggle="tooltip">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <button class="btn btn-info" id="button-upload" title="<?php echo $button_upload ?>"
                            data-toggle="tooltip">
                        <i class="fa fa-upload"></i>
                    </button>
                    <button class="btn btn-default" id="button-folder" title="<?php echo $button_folder ?>"
                            data-toggle="tooltip">
                        <i class="fa fa-folder"></i>
                    </button>
                    <button class="btn btn-danger" id="button-delete" title="<?php echo $button_delete ?>"
                            data-toggle="tooltip">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <div class="col-sm-7">
                    <div class="input-group">
                        <input type="text" name="search" value="<?php echo $filter_name?>" placeholder="<?php echo $entry_search?>" class="form-control">
                        <span class="input-group-btn">
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_search; ?>" id="button-search"
                                    class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr>
            <?php foreach (array_chunk($images, 4) as $image) { ?>
                <div class="row">
                    <?php foreach ($image as $image) { ?>
                        <div class="col-sm-3 col-xs-6 text-center">
                            <?php if ($image['type'] == 'directory') { ?>
                                <div class="text-center">
                                    <a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;">
                                        <i class="fa fa-folder fa-5x"></i>
                                    </a>
                                </div>
                                <label>
                                    <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>"/>
                                    <?php echo $image['name']; ?></label>
                            <?php } ?>
                            <?php if ($image['type'] == 'image') { ?>
                                <a href="<?php echo $image['href']; ?>" class="thumbnail">
                                    <img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>"
                                         title="<?php echo $image['name']; ?>"/>
                                </a>
                                <label>
                                    <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>"/>
                                    <?php echo $image['name']; ?></label>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        </div>
    </div>
</div>
<script>
    var base_url = $('#base').val();
    <?php if ($target) { ?>
    $('a.thumbnail').on('click', function (e) {
        e.preventDefault();

        <?php if ($thumb) { ?>
        $('#<?php echo $thumb; ?>').find('img').attr('src', $(this).find('img').attr('src'));
        <?php } ?>

        $('#<?php echo $target; ?>').val($(this).parent().find('input').val());

        $('#modal-image').modal('hide');
    });
    <?php } ?>
    $('a.directory').on('click', function (e) {
        e.preventDefault();

        $('#modal-image').load($(this).attr('href'));
    });

    $('.pagination a').on('click', function (e) {
        e.preventDefault();

        $('#modal-image').load($(this).attr('href'));
    });

    $('#button-parent').on('click', function (e) {
        e.preventDefault();

        $('#modal-image').load($(this).attr('href'));
    });

    $('#button-refresh').on('click', function (e) {
        e.preventDefault();
        $('#modal-image').load($(this).attr('href'));
    });

    $('input[name=\'search\']').on('keydown', function (e) {
        if (e.which == 13) {
            $('#button-search').trigger('click');
        }
    });
    $('#button-upload').on('click', function () {

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

        $('#form-upload input[name=\'file[]\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function () {
            if ($('#form-upload input[name=\'file[]\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: base_url + 'admin/filemanager/upload?&token=<?php echo $token; ?>&directory=<?php echo $directory ?>',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                        $('#button-upload').prop('disabled', true);
                    },
                    complete: function () {
                        $('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
                        $('#button-upload').prop('disabled', false);
                    },
                    success: function (json) {
                        if (json['error']) {
                            alert(json['error']);
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $('#button-refresh').trigger('click');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });
    $('#button-folder').popover({
        html: true,
        animation:true,
        placement: 'bottom',
        trigger: 'click',
        title: '<?php echo $entry_folder; ?>',
        content: function () {
            html = '<div class="input-group">';
            html += '  <input type="text" name="folder" value="" placeholder="<?php echo $entry_folder; ?>" class="form-control">';
            html += '  <span class="input-group-btn"><button type="button" title="<?php echo $button_folder; ?>" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
            html += '</div>';

            return html;
        }
    });
    $('#button-folder').on('shown.bs.popover', function () {
        $('#button-create').on('click', function () {
            $.ajax({
                url: base_url + 'admin/filemanager/folder?token=<?php echo $token; ?>&directory=<?php echo $directory; ?>',
                type: 'post',
                dataType: 'json',
                data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
                beforeSend: function () {
                    $('#button-create').prop('disabled', true);
                },
                complete: function () {
                    $('#button-create').prop('disabled', false);
                },
                success: function (json) {
                    if (json['error']) {
                        alert(json['error']);
                    }

                    if (json['success']) {
                        alert(json['success']);
                        $('#button-refresh').trigger('click');

                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });
    });

    $('#modal-image #button-delete').on('click', function (e) {
        if (confirm('<?php echo $text_confirm; ?>')) {
            $.ajax({
                url: base_url + 'admin/filemanager/delete?token=token',
                type: 'post',
                dataType: 'json',
                data: $('input[name^=\'path\']:checked'),
                beforeSend: function () {
                    $('#button-delete').prop('disabled', true);
                },
                complete: function () {
                    $('#button-delete').prop('disabled', false);
                },
                success: function (json) {
                    if (json['error']) {
                        alert(json['error']);
                    }

                    if (json['success']) {
                        alert(json['success']);

                        $('#button-refresh').trigger('click');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });
</script>