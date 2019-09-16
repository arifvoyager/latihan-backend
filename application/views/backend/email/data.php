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
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a></li>
            <li><a href="#">Apperance</a></li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
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
                                    &nbsp;
                                </div>
                                <table id="loadDataTables" data-mobile-responsive="true">
                                    <thead>
                                        <tr>
                                            <th data-field="email_flag">EMAIL TAGS</th>
                                            <th data-field="email_subject">SUBJECT</th>
                                            <th data-field="email_sender">SENDER</th>
                                            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents" class="col-md-1" data-halign="center" data-align="center">ACTION</th>
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
    
    $(document).ready(function($) {
        
        // Example Bootstrap Table Events
        // ------------------------------
        (function() {
            $('#loadDataTables').bootstrapTable({
                url: "<?php echo base_url("jpanel/email/getData"); ?>",
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
                rowIds.push(row.taxonomy_lock_code);
                
            }).on('uncheck.bs.table', function (e, row) {
                //$result.text('Event: uncheck.bs.table, data: ' + JSON.stringify(row));
                var itemtoRemove = row.taxonomy_lock_code;
                rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                
            }).on('check-all.bs.table', function (e, row) {
                //$result.text('Event: Check ALL');
                
                for (var i = 0; i < row.length; i++) {
                    rowIds.push(row[i].taxonomy_lock_code);
                }
                
            }).on('uncheck-all.bs.table', function (e, row) {
                //$result.text('Event: Uncheck ALL');
                for (var i = 0; i < row.length; i++) {
                    var itemtoRemove = row[i].taxonomy_lock_code;
                    rowIds.splice($.inArray(itemtoRemove, rowIds),1);
                }
            });

        
        })();
        
    });
    
    function operateFormatter(value, row, index) {
        return [
                '<button type="button" class="btn btn-xs btn-icon btn-primary btn-outline btn-edit" title="Edit"><i class="icon wb-envelope-open" aria-hidden="true"></i></button> '
        ].join('');
    }
    
    window.operateEvents = {
        'click .btn-edit': function (e, value, row, index) {
            window.location = BASE_URL + 'jpanel/email/editdata/' + row['email_lock_code'];
        }
        
    }
    
</script>