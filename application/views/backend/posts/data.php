<style type="text/css">
    th {
        background-color: #f1f4f5;
    }
    
    .bootstrap-table {
        margin-top: -45px;   
    }
</style>
<!-- Page -->
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        <div class="page-header-actions">
            <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Add New" onclick="javascript:location.href='<?php echo base_url('jpanel/posts/addnew'); ?>'">
                <i class="icon wb-pencil" aria-hidden="true"></i>
            </button>
        </div>
        
    </div>
    <div class="page-content">
        <div class="panel">
            <div class="panel-body container-fluid" style="padding-top: 0px; padding-bottom: 5px;">
                
                <div class="row row-lg">

                    <!-- Example Styles -->
                    <div class="col-sm-12">
                        <!-- Example Events -->
                        <div class="example-wrap">
                            <div class="example">
                                <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                    <button type="button" class="btn btn-outline btn-default" data-toggle="tooltip" data-original-title="Add New" onclick="javascript:location.href='<?php echo base_url('jpanel/posts/addnew'); ?>'">
                                        <i class="icon wb-plus" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline btn-default" data-toggle="tooltip" data-original-title="Delete Selected" id="removeSelected">
                                        <i class="icon wb-trash" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <table id="loadDataTables" data-mobile-responsive="true">
                                    <thead>
                                        <tr>
                                            <th data-field="posts_lock_code" data-column-id="id" data-identifier="true" data-visible="false" data-filterable="true">ID</th>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="posts_title">TITLE PAGE</th>
                                            <th data-field="posts_category">CATEGORY</th>
                                            <th data-field="posts_tags">TAGS</th>
                                            <th data-field="posts_modified" data-halign="center" data-align="center" class="col-md-2">LAST MODIFIED</th>
                                            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents" class="col-md-2" data-halign="center" data-align="center">ACTION</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- End Example Events -->
                    </div>
                    <!-- End Example Styles -->       
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var DATA_SELECTED   = '';
    var rowIds          = [];
        rowIds.length   = 0;
    
    //GRID SELECT
    $("#loadDataTables").on("selected.rs.jquery.bootgrid", function(e, rows) {
        for (var i = 0; i < rows.length; i++) {
            rowIds.push(rows[i].posts_lock_code);
        }
    });

    //GRID UNSELECT
    $("#loadDataTables").on("deselected.rs.jquery.bootgrid", function(e, rows) {
        for (var i = 0; i < rows.length; i++) {
            var itemtoRemove = rows[i].posts_lock_code;
            rowIds.splice($.inArray(itemtoRemove, rowIds),1);
        }

    });
    
    $(document).ready(function($) {
        
        // Example Bootstrap Table Events
        // ------------------------------
        (function() {
            $('#loadDataTables').bootstrapTable({
                url: "<?php echo base_url("jpanel/posts/getData"); ?>",
                search: true,
                pagination: true,
                showRefresh: true,
                showToggle: false,
                showColumns: true,
                iconSize: 'outline',
                toolbar: '#loadDataTablesToolbar',
                icons: {
                    refresh: 'wb-refresh',
                    toggle: 'wb-order',
                    columns: 'wb-list-bulleted'
                }
            }).on('check.bs.table', function (e, row) {
                //$result.text('Event: check.bs.table, data: ' + JSON.stringify(row));
                rowIds.push(row.posts_lock_code);
                
            }).on('uncheck.bs.table', function (e, row) {
                //$result.text('Event: uncheck.bs.table, data: ' + JSON.stringify(row));
                var itemtoRemove = row.posts_lock_code;
                rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                
            }).on('check-all.bs.table', function (e, row) {
                //$result.text('Event: Check ALL');
                
                for (var i = 0; i < row.length; i++) {
                    rowIds.push(row[i].posts_lock_code);
                }
                
            }).on('uncheck-all.bs.table', function (e, row) {
                //$result.text('Event: Uncheck ALL');
                for (var i = 0; i < row.length; i++) {
                    var itemtoRemove = row[i].posts_lock_code;
                    rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                }
            });

        
        })();
        
    });
    
    function operateFormatter(value, row, index) {
        return [
                '<button type="button" class="btn btn-xs btn-icon btn-primary btn-outline btn-edit" title="Edit Data"><i class="icon wb-pencil" aria-hidden="true"></i></button> ',
                '<button type="button" class="btn btn-xs btn-icon btn-danger btn-outline btn-delete" title="Delete Data"><i class="icon fa-trash" aria-hidden="true"></i></button> '
        ].join('');
    }
    
    window.operateEvents = {
        'click .btn-edit': function (e, value, row, index) {
            window.location = BASE_URL + 'jpanel/posts/editdata/' + row['posts_lock_code'];
        },
        
        'click .btn-delete': function (e, value, row, index) {
            bootbox.dialog({
                title: "<i class='icon fa-question-circle'></i> Confirm",
                message: 'Are you sure delete ?',
                buttons: {

                    danger: {
                        label: "No",
                        className: "btn-danger",
                        callback: function () {
                            var pathname 	= window.location.href; 
                            window.location = pathname; 
                        }
                    },

                    success: {
                        label: "Yes",
                        className: "btn-success",
                        callback: function () {
                            
                            $.ajax({
                                url : BASE_URL + 'jpanel/posts/trash/',
                                type: 'POST',
                                data: {
                                    LOCK_CODE : row['posts_lock_code']
                                }, 
                                success: function (response) {
                                    //console.log(response);
                                    window.location = BASE_URL + 'jpanel/posts'
                                }
                            });
                            
                        }
                    }
                    
                }
            });
        },
        
    }
    
    $("#removeSelected").click(function() {
        var jsonString = JSON.stringify(rowIds);
        //console.log(jsonString);
        
        if(rowIds.length > 0) {
            bootbox.dialog({
                message: "Are you sure delete data ?",
                title: "Confirm",
                buttons: {

                    danger: {
                        label: "No",
                        className: "btn-danger",
                        callback: function () {
                            var pathname 	= window.location.href; 
                            window.location = pathname; 
                        }
                    },

                    success: {
                        label: "Yes",
                        className: "btn-success",
                        callback: function () {

                            $.ajax({
                                url : BASE_URL + 'jpanel/posts/trashSelected/',
                                type: 'POST',
                                data: {data : jsonString}, 
                                success: function (response) {
                                    console.log(response);
                                    window.location = BASE_URL + 'jpanel/posts'
                                }
                            });
                        }
                    }
                }
            });
        } else {
            bootbox.dialog({
                message: "No data selected",
                title: "Confirm",
                buttons: {

                    success: {
                        label: "OK",
                        className: "btn-success",
                        callback: function () {
                            var pathname 	= window.location.href; 
                            window.location = pathname; 
                        }
                    }
                }
            });
        }
    });

    
    
</script>