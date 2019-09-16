<div class="page">
    <div class="page-container page-search">
        <label class="title"><?php echo GET_LABEL('TITLE_SEARCH_PAGE', $LANG['code']); ?></label>
        <div class="sub-title">
            <label class="fl-left"><?php echo GET_LABEL('LABEL_SEARCH_RESULT', $LANG['code']).' "'.$this->session->userdata('keyword').'"'; ?></label>
            <label class="fl-right"><?php echo $count.' '.GET_LABEL('LABEL_RESULT_FOUND', $LANG['code']); ?></label>
            <div class="fl-clear"></div>
        </div>
        
        <?php 
            $category   = array(
                'news'      => array('id' => 'Berita', 'en' => 'News'),
                'events'    => array('id' => 'Acara', 'en' => 'Events'),
                'download'  => array('id' => 'Artikel', 'en' => 'Article'),
                'about'     => array('id' => 'Tentang Kami', 'en' => 'About Us')
            );
            
            $l_category   = array(
                'news'      => array('id' => 'berita', 'en' => 'news'),
                'events'    => array('id' => 'acara', 'en' => 'events'),
                'about'     => array('id' => 'tentang-kami', 'en' => 'about-us')
            );

            foreach ($result_search->result() as $result) :
                $link       = '';
                if ($result->posts_type == 'about') {
                    $link   = base_url($l_category['about'][$LANG['code']].'/d/'.$result->posts_slug);
                } else if ($result->posts_type == 'download') {
                    if ($result->posts_visibility == 'M') {
                        if ($this->session->userdata('sess_member_fi') != false) {
                            $link   = base_url('pubs/file/'.$result->posts_file);
                        } else {
                            $link   = base_url('member/login');
                        }
                    } else {
                        $link   = base_url('pubs/file/'.$result->posts_file);
                    }
                } else {
                    $link   = base_url($l_category[$result->posts_type][$LANG['code']].'/d/'.$result->posts_slug);
                }

                echo '<div class="result-list">';
                echo '    <label onclick="javascript:location.href=\''.$link.'\'">['.$category[$result->posts_type][$LANG['code']].'] - '.$result->posts_title.'</label>';

                if ($result->posts_type == 'download') {
                    if ($result->posts_visibility == 'M') {
                        echo '      <span>'.GET_LABEL('LABEL_ONLY_MEMBERS', $LANG['code']).'</span>';
                    }
                } else {
                    echo '    <a href="'.$link.'">'.$link.'</a>';
                }

                echo '    <p>'.$result->posts_shortdesc.'</p>';
                echo '</div>';
            endforeach;
        ?>
    </div>
</div>