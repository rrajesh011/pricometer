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
        <section class="box-typical">
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
            if ($success || $success = $this->session->flashdata('success')) {
                echo '<div class="alert alert-success alert-icon alert-close alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<i class="font-icon font-icon-check-circle"></i>
							' . $success . '
						</div>';
            }
            ?>


            <div id="toolbar">
                <div class="bootstrap-table-header"><i class="fa fa-list"></i> <?php echo $text_list ?></div>
                <button onclick="return confirm('Are you sure?')" id="remove" form="form-category"
                        class="btn btn-danger remove" disabled>
                    <i class="font-icon font-icon-close-2"></i> Delete Selected
                </button>
                <a href="<?php echo $add ?>" class="btn btn-primary"><i
                        class="glyphicon glyphicon-plus"></i> Add New</a>
                <a href="<?php echo $import ?>" class="btn btn-success"><i class="glyphicon glyphicon-import"></i>
                    Import From Excel</a>
            </div>
            <form action="<?php echo $delete ?>" id="form-category" method="post">
                <div class="table-responsive">
                    <table id="table" class="table table-bordered"
                           data-toggle="table"
                           data-toolbar="#toolbar"
                           data-search="true"
                           data-show-refresh="true"
                           data-show-toggle="true"
                           data-show-columns="true"
                           data-show-export="true"
                           data-detail-formatter="detailFormatter"
                           data-minimum-count-columns="2"
                           data-show-pagination-switch="true"
                           data-pagination="true"
                           data-id-field="id"
                           data-page-list="[10, 25, 50, 100, ALL]"
                           data-show-footer="false">


                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="parentCheckbox"
                                       onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"/>
                            </th>
                            <th>Image</th>                            
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Status</th>
                            <th>Date Modified</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($products as $category) {
                            echo '<tr>';
                            echo '<td><input type="checkbox" name="selected[]"  value="' . $category['category_id'] . '"></td>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $category['name'] . '</td>';
                            echo '<td>' . get_button($category['status']) . '</td>';
                            echo '<td><span data-toggle="tooltip" title="' . $category['date_modified'] . '">' . time_elapsed_string($category['date_modified']) . '</span></td>';
                            echo '<td><a href="' . base_url('admin/categories/edit?category_id=' . $category['category_id'] . '&token=' . $token) . '" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                  <a href="' . base_url('admin/categories/delete?category_id=' . $category['category_id'] . '&token=' . $token) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are You Sure\')"><i class="fa fa-trash-o"></i></a>
                              </td>';
                            echo '</tr>';
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </section><!--.box-typical-->

    </div><!--.container-fluid-->
</div><!--.page-content-->


<style>
    .table th, td {
        text-align: center;
        vertical-align: top;
    }
</style>