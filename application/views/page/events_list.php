<link rel="stylesheet" href="<?php echo base_url('assets/fullcalender/css/fullcalendar.css'); ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url('assets/fullcalender/css/fullcalendar.print.css'); ?>" type="text/css" media="print" />
<script type="text/javascript" src="<?php echo base_url('assets/fullcalender/lib/moment.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/fullcalender/js/fullcalendar.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/fullcalender/js/lang-all.js'); ?>"></script>

<?php
    if ($pages->posts_images != '') {
        $background_image   = 'style="background-image: url('.base_url('pubs/uploads/'.$pages->posts_images).');"';
    } else {
        $background_image   = '';
    }

    $events = '';

    $get_events             = $this->db->get_where('cd_posts', array('posts_type' => 'events', 'posts_lang' => $LANG['code'], 'posts_status' => 'Y'), 'posts_date', 'ASC');

    foreach ($get_events->result() as $event):
        $events .= "{id : '".$event->posts_uid."', title : '".$event->posts_title."', start : '".$event->posts_start_date."', end : '".$event->posts_end_date."', className : 'events_title\" onclick=\"javascript:showEventDetail(\'".$event->posts_lock_code."\')'},";
    endforeach;

echo '</pre>';
?>

<div class="page">
    <div class="page-banner" <?php echo $background_image; ?>>
        <div class="title-banner">
            <label><?php echo $pages->posts_title; ?></label>
        </div>
    </div>
    <div class="page-container">
        <div class="breadcrumbs">
            <a href="<?php echo base_url(); ?>" id="home-breadcrumbs">Home</a>
            <i class="fa fa-angle-right"></i>
            <span><?php echo $pages->posts_subtitle; ?></span>
        </div>
        <div class="page-frame">
            <div class="page-events">
                <div class="events-list col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div id='calendar'></div>
                </div>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>

<div class="event-detail-popover">
    <div class="ed-popover">
    </div>
</div>
<script>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			editable: false,
			eventLimit: 4, // allow "more" link when too many events
            lang: 'id',
			events: [<?php echo $events; ?>],
            timeFormat: 'H:mm',
            eventRender: function( event, element, view ) {
                var title = element.find('.fc-title, .fc-list-item-title');          
                title.html(title.text());
            }
		});
        
    });
    
    function showEventDetail(lock_code) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('ajax/getEventsDetail'); ?>",
            data: {
                    lock_code   : lock_code
                },
            success: function(data){
                console.log(data);
                $('.ed-popover').html(data);
                $('.event-detail-popover').fadeToggle('slow');
            }
        });    
    }
    function closePopover() {
        $('.event-detail-popover').fadeToggle();
    }
    
</script>