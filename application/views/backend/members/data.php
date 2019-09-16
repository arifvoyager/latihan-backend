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
            <li><a href="<?php echo base_url('cms/cpanelx'); ?>">Home</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        <div class="page-header-actions">
            <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Add New" onclick="javascript:location.href='<?php echo base_url('cms/members/addnew'); ?>'">
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
                                <!--
                                    <button type="button" class="btn btn-outline btn-default" data-toggle="tooltip" data-original-title="Add New" onclick="javascript:location.href='<?php echo base_url('cms/members/addnew'); ?>'">
                                        <i class="icon wb-plus" aria-hidden="true"></i>
                                    </button>
                                    -->
                                    <button type="button" class="btn btn-outline btn-default" data-toggle="tooltip" data-original-title="Delete Selected" id="removeSelected">
                                        <i class="icon wb-trash" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <table id="loadDataTables" data-mobile-responsive="true">
                                    <thead>
                                        <tr>
                                            <th data-field="member_uid" data-column-id="id" data-identifier="true" data-visible="false" data-filterable="true">ID</th>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="member_logo" class="col-md-2" data-formatter="loadImage" data-align="center">Logo</th>
                                            <th data-field="member_name" data-align="center" class="col-md-3">Name</th>
                                            <th data-field="member_username" data-align="center">Username</th>
                                            <th data-field="type_of_member" data-align="center">Association Type</th>
                                            <th data-field="member_status" data-align="center">Status</th>
                                            <th data-field="member_password" data-align="center">Password</th>
                                            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents" class="col-md-1" data-halign="center" data-align="center; padding: 8px 0 !important;">Action</th>
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
            rowIds.push(rows[i].member_uid);
        }
    });

    //GRID UNSELECT
    $("#loadDataTables").on("deselected.rs.jquery.bootgrid", function(e, rows) {
        for (var i = 0; i < rows.length; i++) {
            var itemtoRemove = rows[i].member_uid;
            rowIds.splice($.inArray(itemtoRemove, rowIds),1);
        }

    });
    
    $(document).ready(function($) {
        
        // Example Bootstrap Table Events
        // ------------------------------
        (function() {
            $('#loadDataTables').bootstrapTable({
                url: "<?php echo base_url("cms/members/getData"); ?>",
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
                rowIds.push(row.member_uid);
                
            }).on('uncheck.bs.table', function (e, row) {
                //$result.text('Event: uncheck.bs.table, data: ' + JSON.stringify(row));
                var itemtoRemove = row.member_uid;
                rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                
            }).on('check-all.bs.table', function (e, row) {
                //$result.text('Event: Check ALL');
                
                for (var i = 0; i < row.length; i++) {
                    rowIds.push(row[i].member_uid);
                }
                
            }).on('uncheck-all.bs.table', function (e, row) {
                //$result.text('Event: Uncheck ALL');
                for (var i = 0; i < row.length; i++) {
                    var itemtoRemove = row[i].member_uid;
                    rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                }
            });

        
        })();
        
    });
    
    function loadImage(value, row, index) {
        if (value != '') {
            return "<img src='" + BASE_URL + '/pubs/uploads/' + row['member_logo'] + "' style='width: 100%; height: auto;'/>";
        } else {
            return "No Logo";
        }
    }
    
    function operateFormatter(value, row, index) {
        return [
                '<button type="button" class="btn btn-xs btn-icon btn-primary btn-outline btn-view" title="View Data"><i class="icon fa-eye" aria-hidden="true"></i></button> ',
                '<button type="button" class="btn btn-xs btn-icon btn-primary btn-outline btn-approve" title="Approve Member"><i class="icon fa-check" aria-hidden="true"></i></button> ',
                '<button type="button" class="btn btn-xs btn-icon btn-primary btn-outline btn-active" title="Active Member"><i class="icon fa-star" aria-hidden="true"></i></button> ',
                '<button type="button" class="btn btn-xs btn-icon btn-danger btn-outline btn-deactive" title="Deactive Member"><i class="icon fa-times" aria-hidden="true"></i></button> '
        ].join('');
    }
    
    window.operateEvents = {
        'click .btn-edit': function (e, value, row, index) {
            window.location = BASE_URL + 'cms/members/editdata/' + row['member_uid'];
        },
        
        'click .btn-view': function (e, value, row, index) {
            window.location = BASE_URL + 'cms/members/view/' + row['member_uid'];
        },
        'click .btn-approve': function (e, value, row, index) {
            bootbox.dialog({
                title: "<i class='icon fa-question-circle'></i> Confirm",
                message: 'Are you sure to approve this member ?',
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
                                url : BASE_URL + 'cms/members/approve/',
                                type: 'POST',
                                data: {
                                    UID : row['member_uid']
                                }, 
                                success: function (response) {
                                    console.log(response);
                                    window.location = BASE_URL + 'cms/members'
                                }
                            });
                            
                        }
                    }
                    
                }
            });
        },        
        'click .btn-active': function (e, value, row, index) {
            bootbox.dialog({
                title: "<i class='icon fa-question-circle'></i> Confirm",
                message: 'Are you sure to active this member ?',
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
                                url : BASE_URL + 'cms/members/active/',
                                type: 'POST',
                                data: {
                                    UID : row['member_uid']
                                }, 
                                success: function (response) {
                                    //console.log(response);
                                    window.location = BASE_URL + 'cms/members'
                                }
                            });
                            
                        }
                    }
                    
                }
            });
        },        
        'click .btn-deactive': function (e, value, row, index) {
            bootbox.dialog({
                title: "<i class='icon fa-question-circle'></i> Confirm",
                message: 'Are you sure to deactive this member ?',
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
                                url : BASE_URL + 'cms/members/deactive/',
                                type: 'POST',
                                data: {
                                    UID : row['member_uid']
                                }, 
                                success: function (response) {
                                    //console.log(response);
                                    window.location = BASE_URL + 'cms/members'
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
                                url : BASE_URL + 'cms/members/trashSelected/',
                                type: 'POST',
                                data: {data : jsonString}, 
                                success: function (response) {
                                    console.log(response);
                                    window.location = BASE_URL + 'cms/members'
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