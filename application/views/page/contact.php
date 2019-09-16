<!-- Validation Javascript file -->
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/formValidation.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/framework/bootstrap.js'); ?>" type="text/javascript"></script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDTZol7AloiPyrKWRwN0NXmR4MVs8RyAGA"></script>

<script>
    var map;
    function initialize() {
        var myLatlng = new google.maps.LatLng(<?php echo GET_COMPANY('company_latitude'); ?>, <?php echo GET_COMPANY('company_longitude'); ?>);
        
        var mapOptions = {
            zoom: 13,
            center: myLatlng
        };
        
        map = new google.maps.Map(document.getElementById('map-canvas'),
          mapOptions);
        
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php
     $CURRENT_LANG	= GET_CURRENT_LANG();

?>
<div class="page">
    <div class="page-banner">
        <div class="title-banner">
            <label>Kontak Kami</label>
        </div>
    </div>
    <div class="page-container">
        <div class="page-frame">
            <div class="page-contact-info col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <form name="contactForm" id="contactForm">
                    <label class="title"><?php echo GET_LABEL('TITLE_PAGE_CONTACT_FORM', $LANG['code']); ?></label>
                    <p>Anda juga bisa mencantumkan pertanyaan maupun saran di dalam formulir kontak.</p>
                    <div class="form-group">
                        <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="<?php echo GET_LABEL('PLACEHOLDER_NAME', $LANG['code']); ?>" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="contact_mobile" id="contact_mobile" placeholder="<?php echo GET_LABEL('PLACEHOLDER_MOBILE', $LANG['code']); ?>" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="contact_email" id="contact_email" placeholder="<?php echo GET_LABEL('PLACEHOLDER_EMAIL', $LANG['code']); ?>" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="contact_message" id="contact_message" placeholder="<?php echo GET_LABEL('PLACEHOLDER_MESSAGE', $LANG['code']); ?>" rows="8"></textarea>
                    </div>
                    <label class="button btn-bggreen btn-srad btn-p12" onclick="$('#contactForm').submit();"><?php echo GET_LABEL('BUTTON_SUBMIT', $LANG['code']); ?></label>
                </form>
            </div>
            <div class="page-contact-map col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <label class="title"><?php echo GET_LABEL('TITLE_PAGE_CONTACT_INFORMATION', $LANG['code']); ?></label>
                <!-- <div id="map-canvas"></div> -->
                <div class="maps">
                    <div id="map-canvas"></div>
                </div>
                <div class="pcm-left col-sm-12 col-sm-6 col-md-6 col-lg-6">
                    <span><?php echo GET_LABEL('LABEL_ALAMAT', $LANG['code']); ?> : </span>
                    <p><?php echo GET_COMPANY('company_address'); ?></p>
                    <div class="fl-clear"></div>
                </div>
                <div class="pcm-right col-sm-12 col-sm-6 col-md-6 col-lg-6">
                    <div>
                        <span><?php echo GET_LABEL('LABEL_MOBILE', $LANG['code']); ?> : </span><?php echo GET_COMPANY('company_phone'); ?>
                    </div>
                    <div>
                        <span><?php echo GET_LABEL('LABEL_FAX', $LANG['code']); ?> : </span><?php echo GET_COMPANY('company_fax'); ?>
                    </div>
                    <div>
                        <span><?php echo GET_LABEL('LABEL_EMAIL', $LANG['code']); ?> : </span><?php echo GET_COMPANY('company_email'); ?>
                    </div>
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="fl-clear"></div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/sweetalert/sweet-alert.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/sweetalert/sweet-alert.css'); ?>" rel="stylesheet">

<script type="text/javascript">
    $(document).ready(function() {
        $('#contactForm').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                contact_name: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_NAME', $LANG['code']); ?>'
                        }
                    }
                },
                contact_mobile: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_MOBILE', $LANG['code']); ?>'
                        }
                    }
                },
                contact_email: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_EMAIL', $LANG['code']); ?>'
                        },
                        emailAddress: {
                            message: '<?php echo GET_LABEL('ERROR_FORMAT_EMAIL', $LANG['code']); ?>'
                        }
                    }
                },
                contact_message: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_MESSAGE', $LANG['code']); ?>'
                        }
                    }
                }
            }
        })
        .on('success.form.fv', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('mainpage/sendMessage'); ?>',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    swal({
                        title: "<?php echo GET_LABEL('LABEL_SUCCESS_MESSAGE', $CURRENT_LANG['code']); ?>",
                        text: "<?php echo GET_LABEL('TEXT_SUCCESS_MESSAGE', $CURRENT_LANG['code']); ?>",
                        type: "success"
                    },
                    function () {
                        window.location.href = BASE_URL;
                    });
                }
            });
        });        
    });    
</script>