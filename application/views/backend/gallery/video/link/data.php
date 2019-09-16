<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/magnific-popup/magnific-popup.css"); ?>">

<script src="<?php echo base_url("assets/backend/vendor/magnific-popup/jquery.magnific-popup.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/js/components/magnific-popup.js"); ?>"></script>

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
            <li><a href="<?php echo base_url('jpanel/gallery'); ?>">Gallery</a></li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        <div class="page-header-actions">
            <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Add New" onclick="javascript:location.href='<?php echo base_url('jpanel/gallery/addnew/galley_img'); ?>'">
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
                                <?php
                                    $GET_GALLERY_PHOTO = $this->db->get_where("cd_taxonomy", array('taxonomy_lock_code' => $LOCK_CODE, 'taxonomy_lang' => GET_DEFAULT_LANG()))->row();
                                ?>
                                <h4 class="example-title"><strong>Video Gallery : </strong><?php echo $GET_GALLERY_PHOTO->taxonomy_name; ?></h4>
                            
                                <div class="example" id="exampleZoomGallery">
                                    <?php
                                        $GET_VIDEO = $this->db->get_where("cd_posts", array('posts_parent' => $LOCK_CODE, 'posts_type' => 'video', 'posts_category' => 'video-link'));
                                        foreach($GET_VIDEO->result() as $rsVideo):
                                            $get_video_id   = str_replace('https://www.youtube.com/watch?v=', '', $rsVideo->posts_link);
                                            ?>
                                                <div class="col-sm-4">
                                                    <a class="popup-youtube" href="<?php echo $rsVideo->posts_link; ?>">
                                                        <img src="https://i1.ytimg.com/vi/<?php echo $get_video_id; ?>/mqdefault.jpg" />
                                                    </a>
                                                    <p class="pull-left">Sort : <?php echo $rsVideo->posts_sort; ?></p>
                                                    <p class="pull-right" style="cursor: pointer; color: #f96868;" onclick="deleteImg('<?php echo $rsVideo->posts_lock_code; ?>')"><i class="icon fa-trash" aria-hidden="true"></i> Delete ?</p>
                                                </div>
                                            <?php
                                        endforeach;
                                        if($GET_VIDEO->num_rows() < 1) {
                                            echo '<div class="alert alert-icon alert-danger" role="alert">
                                                  <i class="icon wb-close" aria-hidden="true"></i>
                                                  <p>No Video available</p>
                                                </div>';
                                        }
                                    ?>
                                    <div class="col-sm-12">
                                        <button onclick="javascript:location.href='<?php echo base_url('jpanel/gallery/addnew/galley_video'); ?>'" type="button" class="btn btn-success"><i class="icon wb-plus-circle" aria-hidden="true"></i> Add New</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
      // Example Popup Zoom Gallery
      // --------------------------
    $(document).ready(function() {
        $('.popup-youtube').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            gallery: {
              enabled: true
            },
            fixedContentPos: false
        });        
    });
    
    function deleteImg(LOCK) {
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
                                url : BASE_URL + 'jpanel/gallery/trash/galley_img',
                                type: 'POST',
                                data: {
                                    LOCK_CODE : LOCK
                                }, 
                                success: function (response) {
                                    //console.log(response);
                                    window.location = BASE_URL + 'jpanel/gallery/loads/<?php echo $this->session->userdata('sess_gallery_photo_img'); ?>' 
                                }
                            });
                            
                        }
                    }
                    
                }
            });
    }
</script>