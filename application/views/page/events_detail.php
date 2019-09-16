<?php
    $events                 = $this->db->get_where('cd_posts', array('posts_type' => 'events', 'posts_lang' => $LANG['code'], 'posts_slug' => $this->uri->segment(3)))->row();

    if ($pages->posts_images != '') {
        $background_image   = 'style="background-image: url('.base_url('pubs/uploads/'.$pages->posts_images).');"';
    } else {
        $background_image   = '';
    }
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
                <div class="events-detail col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <label class="title"><?php echo $events->posts_title; ?></label>
                    <?php echo $events->posts_content; ?>
                </div>
                <div class="events-upcoming col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label class="title"><?php echo GET_LABEL('TITLE_UPCOMING_EVENTS', $LANG['code']); ?></label>
                    <?php
                        $today          = date('Y-m-d H:i:s');

                        $get_events_up  = $this->db->query('SELECT * FROM cd_posts WHERE posts_type = "events" AND posts_lang = "'.$LANG['code'].'" AND (posts_start_date >= "'.$today.'" OR posts_end_date >= "'.$today.'") ORDER BY posts_start_date ASC LIMIT 0, 3');

                        foreach($get_events_up->result() as $events_up):
                            $date_start       = date("d", strtotime($events_up->posts_start_date));
                            $month_start      = date("M", strtotime($events_up->posts_start_date));
                            $year_start       = date("Y", strtotime($events_up->posts_start_date));
                            $date_end         = date("d", strtotime($events_up->posts_end_date));
                            $month_end        = date("M", strtotime($events_up->posts_end_date));
                            $year_end         = date("Y", strtotime($events_up->posts_end_date));
                            ?>
                                <div class="ep-list" onclick="javascript:location.href='<?php echo base_url($this->uri->segment(1).'/d/'.$events_up->posts_slug); ?>'">
                                    <div class="ep-list-desc">
                                        <span><?php echo $events_up->posts_title; ?></span>
                                    </div>
                                    <div class="ep-list-date">
                                        <label><?php echo GET_LABEL('TITLE_DATE_EVENT', $LANG['code']); ?></label>
                                        <span class="month-events"><?php echo $date_start.' - '.$month_start.' - '.$year_start; ?></span>
                                        <span class="month-events">s/d</span>
                                        <span class="month-events"><?php echo $date_end.' - '.$month_end.' - '.$year_end; ?></span>
                                    </div>
                                    <div class="fl-clear"></div>
                                </div>
                            <?php
                        endforeach;
                    ?>
                </div>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>
