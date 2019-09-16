<style type="text/css">
    th {
        background-color: #f1f4f5;
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
                                <table id="loadDataTables" data-mobile-responsive="true">
                                    <thead>
                                        <tr>
                                            <th data-field="language_uid" class="col-md-1">NO</th>
                                            <th data-field="language_flag">FLAG</th>
                                            <th data-field="language_caption">CAPTION</th>
                                            <th data-field="language_home">HOME</th>
                                            <th data-field="language_status" data-halign="center" data-align="center" class="col-md-2">STATUS</th>
                                            <th data-field="language_default" data-halign="center" data-align="center" class="col-md-2">DEFAULT</th>
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

                <div class="row row-lg">
                    <div class="col-sm-12">
                        <h4 class="example-title">Note</h4>
                        <p>For additional languages, do not forget to do adjustments on file <strong>routes.php</strong></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Page -->

<script type="text/javascript">
    $(document).ready(function($) {
        
      // Example Bootstrap Table Events
      // ------------------------------
      (function() {
        $('#loadDataTables').bootstrapTable({
          url: "<?php echo base_url("jpanel/lang/getData"); ?>",
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
        });

        var $result = $('#examplebtTableEventsResult');
        
      })();
        
    });
      
    function operateFormatter(value, row, index) {
        return [
                '<button type="button" class="btn btn-xs btn-icon btn-primary btn-outline btn-showhide" title="Show/Hide"><i class="icon wb-eye" aria-hidden="true"></i></button> ',
                '<button type="button" class="btn btn-xs btn-icon btn-primary btn-outline btn-setdefault" title="Set as Default"><i class="icon wb-star" aria-hidden="true"></i></button> '
        ].join('');
    }
      
    window.operateEvents = {
        'click .btn-setdefault': function (e, value, row, index) {
            $.ajax({
                url : BASE_URL + 'jpanel/lang/setDefault',
                type: 'POST',
                data: { 
                    UID : row['language_uid'], 
                    DEFAULT : row['language_default']
                },
                success: function (response) {
                    //- SHOW MESSAGE
                    window.location = pathname;
                }
            });
            
            //console.log(value, row, index);
        },
        
        'click .btn-showhide': function (e, value, row, index) {
            $.ajax({
                url : BASE_URL + 'jpanel/lang/setStatus',
                type: 'POST',
                data: { 
                    UID : row['language_uid'], 
                    STATUS : row['language_status']
                },
                success: function (response) {
                    //- SHOW MESSAGE
                    window.location = pathname;
                }
            });
        }
    }
    
</script>