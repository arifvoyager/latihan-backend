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
            <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Add New" onclick="javascript:location.href='<?php echo base_url('cms/subscribe/addnew'); ?>'">
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
                                    <button type="button" class="btn btn-outline btn-default" data-toggle="tooltip" data-original-title="Add New" onclick="javascript:location.href='<?php echo base_url('cms/subscribe/addnew'); ?>'">
                                        <i class="icon wb-plus" aria-hidden="true"></i>
                                    </button>
                                    -->
                                    <button type="button" class="btn btn-outline btn-default" data-toggle="tooltip" data-original-title="Export Data"  onclick="javascript:location.href='<?php echo base_url('cms/subscribe/export'); ?>'">
                                        <i class="icon wb-download" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <table id="loadDataTables" data-mobile-responsive="true">
                                    <thead>
                                        <tr>
                                            <th data-field="subs_id" data-column-id="id" data-identifier="true" data-visible="false" data-filterable="true">ID</th>
                                            <th data-field="subs_email">Email</th>
                                            <th data-field="subs_date" class="col-md-4" data-align="center">Subscribe Date</th>
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
            rowIds.push(rows[i].subs_id);
        }
    });

    //GRID UNSELECT
    $("#loadDataTables").on("deselected.rs.jquery.bootgrid", function(e, rows) {
        for (var i = 0; i < rows.length; i++) {
            var itemtoRemove = rows[i].subs_id;
            rowIds.splice($.inArray(itemtoRemove, rowIds),1);
        }

    });
    
    $(document).ready(function($) {
        
        // Example Bootstrap Table Events
        // ------------------------------
        (function() {
            $('#loadDataTables').bootstrapTable({
                url: "<?php echo base_url("cms/subscribe/getData"); ?>",
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
                rowIds.push(row.subs_id);
                
            }).on('uncheck.bs.table', function (e, row) {
                //$result.text('Event: uncheck.bs.table, data: ' + JSON.stringify(row));
                var itemtoRemove = row.subs_id;
                rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                
            }).on('check-all.bs.table', function (e, row) {
                //$result.text('Event: Check ALL');
                
                for (var i = 0; i < row.length; i++) {
                    rowIds.push(row[i].subs_id);
                }
                
            }).on('uncheck-all.bs.table', function (e, row) {
                //$result.text('Event: Uncheck ALL');
                for (var i = 0; i < row.length; i++) {
                    var itemtoRemove = row[i].subs_id;
                    rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                }
            });
        })();
    });
    
    $("#exportData").click(function() {
        $.ajax({
            url : BASE_URL + 'cms/subscribe/export',
            type: 'POST',
            success: function (response) {
                console.log(response);
                //window.location = BASE_URL + 'cms/subscribe'
            }
        });
    });
    
</script>