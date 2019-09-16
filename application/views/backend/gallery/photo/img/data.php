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
                                <h4 class="example-title"><strong>Image Gallery : </strong><?php echo $GET_GALLERY_PHOTO->taxonomy_name; ?></h4>
                            
                                <div class="example" id="exampleZoomGallery">
                                    <?php
                                        $GET_IMG = $this->db->get_where("cd_posts", array('posts_parent' => $LOCK_CODE, 'posts_type' => 'photo', 'posts_category' => 'image-file'));
                                        foreach($GET_IMG->result() as $rsImgs):
                                    ?>
                                    <div class="col-sm-4">
                                        <a class="inline-block" href="<?php echo base_url('pubs/uploads/'.$rsImgs->posts_images); ?>" title="<?php echo $rsImgs->posts_title; ?>" data-source="<?php echo base_url('pubs/uploads/'.$rsImgs->posts_images); ?>">
                                            <img class="img-responsive" style="width: 100%" src="<?php echo base_url('pubs/uploads/'.$rsImgs->posts_images); ?>" alt="<?php echo $rsImgs->posts_title; ?>" />
                                        </a>
                                        <p class="pull-left">Sort : <?php echo $rsImgs->posts_sort; ?></p>
                                        <p class="pull-right" style="cursor: pointer; color: #f96868;" onclick="deleteImg('<?php echo $rsImgs->posts_lock_code; ?>')"><i class="icon fa-trash" aria-hidden="true"></i> Delete ?</p>
                                    </div>
                                    <?php
                                        endforeach;
                                        if($GET_IMG->num_rows() < 1) {
                                            echo '<div class="alert alert-icon alert-danger" role="alert">
                                                  <i class="icon wb-close" aria-hidden="true"></i>
                                                  <p>No images available</p>
                                                </div>';
                                        }
                                    ?>
                                    <div class="col-sm-12">
                                        <button onclick="javascript:location.href='<?php echo base_url('jpanel/gallery/addnew/galley_img'); ?>'" type="button" class="btn btn-success"><i class="icon wb-plus-circle" aria-hidden="true"></i> Add New</button>
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
      $('#exampleZoomGallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
          verticalFit: true,
          titleSrc: function(item) {
            return item.el.attr('title') +
              ' &middot; <a class="image-source-link" href="' + item.el
              .attr('data-source') +
              '" target="_blank">image source</a>';
          }
        },
        gallery: {
          enabled: true
        },
        zoom: {
          enabled: true,
          duration: 300, // don't foget to change the duration also in CSS
          opener: function(element) {
            return element.find('img');
          }
        }
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