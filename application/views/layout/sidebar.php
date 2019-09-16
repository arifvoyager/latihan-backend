<?php
    if ($sidebar == 'download-list') {
        ?>
            <div class="sidebar-list download-sidebar">
                <?php 
                    $get_download   = $this->db->get_where('cd_posts', array('posts_type' => 'download', 'posts_lang' => $LANG['code']), 'posts_sort', 'ASC', '3', '0');

                    foreach ($get_download->result() as $download) :
                        ?>
                            <div class="dl-sidebar-item">
                                <span><?php echo $download->posts_title; ?></span>
                                <a href="<?php echo base_url('pubs/file/'.$download->posts_file); ?>" target="_blank">
                                    <i class="fa fa-cloud-download"></i>
                                </a>
                            </div>
                        <?php
                    endforeach;
                ?>
            </div>
        <?php
    } else if ($sidebar == 'member-list') {
        $array_organizations = array(
            'id' => 'organisasi',
            'en' => 'organizations'
        );
        ?>
            <div class="sidebar-list">
                <label><?php echo GET_LABEL('TITLE_MEMBERS', $LANG['code']); ?></label>
                <div class="sidebar-content">
                    <?php 
                        $get_member     = $this->db->query('SELECT * FROM cd_member WHERE member_status = "Active" ORDER BY RAND() LIMIT 0,4');
                        foreach ($get_member->result() as $member) :
                            echo '<a href="'.base_url($array_organizations[$LANG['code']].'/profile/'.$member->member_slug).'">'.$member->member_name.'</a>';
                        endforeach;
                    ?>
                    <a class="see-more-link" href="<?php echo base_url(); ?>"><?php echo GET_LABEL('LINK_SEE_MORE', $LANG['code']); ?> &raquo;</a>
                </div>
            </div>
        <?php
    } else if ($sidebar == 'contact-us') {
        ?>
            <div class="sidebar-list contact-us">
                <label><?php echo GET_LABEL('TITLE_CONTACT_US', $LANG['code']); ?></label>
                <div class="sidebar-content">
                    <h4><?php echo GET_COMPANY('company_name'); ?></h4>
                    <span><?php echo GET_LABEL('LABEL_ALAMAT', $LANG['code']); ?> : </span>
                    <p><?php echo GET_COMPANY('company_address'); ?></p>
                    <span><?php echo GET_LABEL('LABEL_MOBILE', $LANG['code']); ?> : </span>
                    <p><?php echo GET_COMPANY('company_phone'); ?></p>
                    <span><?php echo GET_LABEL('LABEL_FAX', $LANG['code']); ?> : </span>
                    <p><?php echo GET_COMPANY('company_fax'); ?></p>
                    <span><?php echo GET_LABEL('LABEL_EMAIL', $LANG['code']); ?> : </span>
                    <p><?php echo GET_COMPANY('company_email'); ?></p>
                </div>
            </div>

        <?php
    } else if ($sidebar == 'popular-news') {
        $array_news = array(
            'id' => 'berita',
            'en' => 'news'
        );
        ?>
            <div class="sidebar-list">
                <div class="news-popular">
                    <label><?php echo GET_LABEL('TITLE_POPULAR_NEWS', $LANG['code']); ?></label>
                    <?php 
                        $populer_news   = $this->db->get_where('cd_posts', array('posts_type' => 'news', 'posts_lang' => $LANG['code']), 'posts_reads', 'DESC', 5, 0);
                        
                        foreach ($populer_news->result() as $pop_news):
                            echo '<a href="'.base_url($array_news[$LANG['code']].'/d/'.$pop_news->posts_slug).'">'.$pop_news->posts_title.'</a>';
                        endforeach; 
                    ?>
                </div>
            </div>
        <?php
    } else if ($sidebar == 'upcoming-events') {
        $array_event = array(
            'id' => 'acara',
            'en' => 'events'
        );
        ?>
            <div class="sidebar-list">
                <div class="events-upcoming">
                    <label class="title"><?php echo GET_LABEL('TITLE_UPCOMING_EVENTS', $LANG['code']); ?></label>
                    <?php
                        $today          = date('Y-m-d');

                        $get_events_up  = $this->db->query('SELECT * FROM cd_posts WHERE posts_type = "events" AND posts_lang = "'.$LANG['code'].'" AND (posts_start_date >= "'.$today.'" OR posts_end_date >= "'.$today.'") ORDER BY posts_start_date ASC LIMIT 0, 3');

                        foreach($get_events_up->result() as $events_up):
                            $date_start       = date("d", strtotime($events_up->posts_start_date));
                            $month_start      = date("M", strtotime($events_up->posts_start_date));
                            $year_start       = date("Y", strtotime($events_up->posts_start_date));
                            $date_end         = date("d", strtotime($events_up->posts_end_date));
                            $month_end        = date("M", strtotime($events_up->posts_end_date));
                            $year_end         = date("Y", strtotime($events_up->posts_end_date));
                            ?>
                                <div class="ep-list" onclick="javascript:location.href='<?php echo base_url($array_event[$LANG['code']].'/d/'.$events_up->posts_slug); ?>'">
                                    <div class="ep-list-desc">
                                        <span><?php echo $events_up->posts_title; ?></span>
                                    </div>
                                    <div class="ep-list-date">
                                        <label class="label-date"><?php echo GET_LABEL('TITLE_DATE_EVENT', $LANG['code']); ?></label>
                                        <span class="month-events"><?php echo $date_start.'-'.$month_start.'-'.$year_start; ?></span>
                                        <span class="month-events">s/d</span>
                                        <span class="month-events"><?php echo $date_end.'-'.$month_end.'-'.$year_end; ?></span>
                                    </div>
                                    <div class="fl-clear"></div>
                                </div>
                            <?php
                        endforeach;
                    ?>
                </div>
            </div>
        <?php
    }
?>

