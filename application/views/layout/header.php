<?php 

$get_language       = $this->db->get_where('cd_language', array('language_status' => 'Y'));

?>



<header>

    <div class="header-top">

        <div class="header-logo col-xs-12 col-sm-5 col-md-5 col-lg-5 no-padding" onclick="javascript:location.href='<?php echo base_url(); ?>'">

            <img src="<?php echo base_url('pubs/uploads/'.GET_COMPANY('company_logo')); ?>" />

        </div>

        <div class="header-opt col-xs-12 col-sm-7 col-md-7 col-lg-7 no-padding">

            <div class="header-opt-top">

                <div class="header-multilanguage">

                    <div class="list-language">

                        <button type="button" class="btn btn-sm dropdown-toggle btn-lang fl-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <?php

                                $LANG_ACTIVE = $this->db->get_where('cd_language', array('language_code' => $LANG['code']));

                                echo $LANG_ACTIVE->row()->language_flag;

                            ?>

                            </span>

                            <span><?php echo $LANG_ACTIVE->row()->language_name; ?></span>

                            <span class="caret"></span>

                        </button>

                        <ul class="dropdown-menu lang-dropdown">

                            <?php

                                foreach($get_language->result() as $language):

                                    echo "<li onclick=\"set_language('".$language->language_code."')\" class=\"lang-list\">";

                                    echo "  <a href=\"#\">".$language->language_flag."</span>".$language->language_name."</a>";

                                    echo "</li>";

                                endforeach;

                            ?>

                        </ul>

                        <label class="fl-right"><?php echo GET_LABEL('LABEL_SELECT_LANGUAGE', $LANG['code']); ?></label>

                        <div class="fl-clear"></div>

                        <!--                                                                    

                        <ul class="multilanguage fl-right">

                            <?php 

                                foreach ($get_language->result() as $language):

                                    echo '<li onclick="javascript:set_language(\''.$language->language_code.'\');">'.$language->language_flag.'</li>';

                                endforeach;

                            ?>

                        </ul>

                        -->                        

                    </div>

                </div>

            </div>

            <div class="header-opt-bottom">

                <?php

                    if ($this->session->userdata('sess_member_fi') != false) { 

                        ?>

                            <div class="header-logout" onclick="javascript:location.href='<?php echo base_url('member/dologout'); ?>'">

                                <i class="fa fa-sign-out"></i>

                                <span>

                                    <?php echo GET_LABEL('LABEL_LOGOUT', $LANG['code']); ?>

                                </span>

                            </div>

                            <div class="header-login" onclick="javascript:location.href='<?php echo base_url('member'); ?>'">

                                <i class="fa fa-user"></i>

                                <span>

                                    <?php echo GET_LABEL('LABEL_MEMBER_AREA', $LANG['code']); ?>

                                </span>

                            </div>

                        <?php

                    } else {

                        ?>

                            <div class="header-register" onclick="javascript:location.href='<?php echo base_url('member/register'); ?>'">

                                <i class="fa fa-edit"></i>

                                <span>

                                    <?php echo GET_LABEL('LABEL_REGISTER', $LANG['code']); ?>

                                </span>

                            </div>

                            <div class="header-login" onclick="javascript:location.href='<?php echo base_url('member/login'); ?>'">

                                <i class="fa fa-sign-in"></i>

                                <span>

                                    <?php echo GET_LABEL('LABEL_LOGIN', $LANG['code']); ?>

                                </span>

                            </div>

                        <?php

                    }

                ?>

                <div class="form-search">

                    <i class="fa fa-search"></i>

                    <form method="post" action="<?php echo base_url('search'); ?>" name="searchForm" id="searchForm">

                        <input type="text" name="search-key" id="search-key" placeholder="<?php echo GET_LABEL('LABEL_SEARCH', $LANG['code']); ?>" />

                    </form>

                </div>

            </div>

            <div class="fl-clear"></div>

        </div>

        <div class="fl-clear"></div>

    </div>

    <div class="header-menu">

        <div class="header-menu-mobile">

            <span>MENU</span>

            <button type="button" id="menu-mobile-button">

                <i class="fa fa-list"></i>

            </button>

        </div>

        

        <ul class="main-menu">

            <?php

                $get_menu       = $this->db->get_where('cd_menu', array('menu_group' => 'Main Menu', 'menu_parent' => '0', 'menu_lang' => $LANG['code']), 'menu_sort', 'ASC');



                foreach ($get_menu->result() as $key=>$menu) {

                    $width_menu         = "width: calc(959px/".$get_menu->num_rows().");";

                    $get_child_menu     = $this->db->get_where('cd_menu', array('menu_parent' => $menu->menu_lock_code, 'menu_lang' => $LANG['code']));

                    $onclick_mobile     = '';

                    if ($menu->menu_caption == 'Home' || $menu->menu_caption == 'Beranda') {

                        $menu_link      = base_url();

                    } elseif ($menu->menu_caption == 'Berita' || $menu->menu_caption == 'News') {

                        $menu_link      = $menu_link      = "javascript:void();";

                    } else {

                        if ($menu->menu_link == '') {

                            if ($this->agent->is_mobile == true) { 

                                $menu_link      = "#";

                                $onclick_mobile = 'onclick="javascript:showSubMenu('.$key.');"';

                            } else {

                                $menu_link      = "javascript:void();";

                            }

                        } else {

                            $menu_link      = base_url($menu->menu_link);

                        }

                    }

                    

                    echo '<li class="li-main-menu">';

                    echo '  <a href="'.$menu_link.'" style="'.$width_menu.'" '.$onclick_mobile.'>'.$menu->menu_caption.'</a>';

                    

                    if ($get_child_menu->num_rows() > 0) {

                        echo '      <span class="plus-menu" id="plus-menu-'.$key.'" onclick="javascript:showSubMenu('.$key.');">+</span>';

                        echo '      <span class="minus-menu" id="minus-menu-'.$key.'" onclick="javascript:showSubMenu('.$key.');">&#8211;</span>';

                    }



                    echo '  <ul class="child-menu" id="child-menu-'.$key.'">';

                        if ($menu->menu_caption == 'Berita' || $menu->menu_caption == 'News') {

                            $get_news_category      = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'news_cat', 'taxonomy_lang' => $LANG['code']));

                            

                            foreach($get_news_category->result() as $news_category):

                                echo '  <li>';

                                echo '      <a href="'.base_url($menu->menu_slug).'/'.$news_category->taxonomy_slug.'">'.$news_category->taxonomy_value.'</a>';

                                echo '  </li>';

                            endforeach;

                        } else {

                            foreach ($get_child_menu->result() as $child_menu):

                                $page_info          = $this->db->get_where('cd_posts', array('posts_slug' => $child_menu->menu_link, 'posts_lang' => $LANG['code']))->row();

    

                                

                                /**

                                if ($page_info->posts_category == 'static') {

                                    $submenu_link       = 'page/'.$child_menu->menu_link;

                                } else {

                                    $submenu_link       = $menu->menu_link.'/'.$child_menu->menu_link;

                                }

                                **/

                                if ($page_info->posts_parent == '') {

                                    $submenu_link       = $child_menu->menu_link;

                                } else {

                                    $submenu_link       = $menu->menu_link.'/'.$child_menu->menu_link;

                                }

                        

                                echo '  <li>';

                                echo '      <a href="'.base_url($submenu_link).'">'.$child_menu->menu_caption.'</a>';

                                echo '  </li>';

                            endforeach;

                        }

                    echo '  </ul>';

                    

                    echo '</li>';

                    

                }

            ?>

        </ul>

    </div>

</header>



<script>

    $('#menu-mobile-button').click(

        function() {

            $('.main-menu').slideToggle();

        }

    );

    

    function showSubMenu(key) {

        $('#child-menu-'+key).slideToggle();

        if ($('#plus-menu-'+key).css('display') == 'block') {

            $('#minus-menu-'+key).show();

            $('#plus-menu-'+key).hide();

        } else if ($('#plus-menu-'+key).css('display') == 'none') {

            $('#minus-menu-'+key).hide();

            $('#plus-menu-'+key).show();

        }

    }

</script>