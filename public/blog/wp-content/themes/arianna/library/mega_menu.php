<?php

/**
* CUSTOM WALKER
*---------------------------------------------------
*/ 


/*--- Frontend Walker ---*/
class arianna_Walker extends Walker_Nav_Menu {
    
    function start_el( &$output, $object, $depth = 0, $args = array(), $id = 0) {
        parent::start_el( $output, $object, $depth, $args );
        
        global $arianna_megamenu_carousel_el;
        
        $arianna_cat_menu = $object->arianna_megamenu;

        if ( $arianna_cat_menu == NULL ) {
             $arianna_cat_menu = '0'; 
        }    
        $arianna_option = arianna_global_var_declare('arianna_option');
        if (isset($arianna_option)):
            $fixed_nav = $arianna_option['arianna_fixed-nav-switch'];
        endif;
        $arianna_output = $arianna_posts = $arianna_menu_featured = $arianna_has_children = $arianna_carousel_item_num = NULL;
        $arianna_current_type = $object->object;
        $arianna_current_classes = $object->classes;
        if ( in_array('menu-item-has-children', $arianna_current_classes) ) { 
            $arianna_has_children = ' arianna_with-sub'; 
        }
        
        if (($object->menu_item_parent == '0')&($object->arianna_megamenu == '1')) {
            $arianna_carousel_id = "arianna_carousel-".$object->ID;
            if ($arianna_has_children == ' arianna_with-sub') { 
                $arianna_carousel_item_num = 3;
            } else { 
                $arianna_carousel_item_num = 4;
            }
            $arianna_megamenu_carousel_el[$arianna_carousel_id] = $arianna_carousel_item_num;
            wp_localize_script( 'arianna_customjs', 'megamenu_carousel_el', $arianna_megamenu_carousel_el );
        }

        if ( ( $arianna_cat_menu == 1 )  && ( $object->menu_item_parent == '0')) { 
            
            $output .= '<div class="arianna_mega-menu arianna_site-container">';               
            $arianna_cat_id = $object->object_id;
            $arianna_qry_amount = 9;    
            $arianna_args = array( 'cat' => $arianna_cat_id,  'post_type' => 'post',  'post_status' => 'publish',  'posts_per_page' => $arianna_qry_amount);
            $arianna_qry_latest = $arianna_img = $arianna_cat_link = NULL;
            $arianna_qry_latest = new WP_Query($arianna_args);
            $i = 1;
            
            foreach ( $arianna_qry_latest->posts as $arianna_post ) {
                    setup_postdata( $arianna_post ); 
                        
                    $arianna_post_id = $arianna_post->ID;
                                  
                    $arianna_img = arianna_get_thumbnail($arianna_post_id, 'arianna_330_220');
                    $arianna_permalink = get_permalink($arianna_post_id);
                    $arianna_cat_link = get_category_link($arianna_cat_id);
                    $arianna_cat_name = get_cat_name($arianna_cat_id);
                    $date = get_the_date( '', $arianna_post_id );
                    $arianna_post_title = arianna_the_excerpt_limit($arianna_post->post_title, 12);
                    $arianna_review_score =  arianna_review_score($arianna_post_id);
                    $thepost= get_post($arianna_post_id);
                    $comment_count = $thepost->comment_count;           
                    $arianna_posts .= ' <li class="arianna_sub-post">
                                    <div class="thumb">'. $arianna_img.$arianna_review_score.'</div>
                                    <h3 class="post-title"><a href="'.$arianna_permalink.'">'.$arianna_post_title.'</a></h3> 
                                   </li><!-- Test HTML -->'; 
                    
                $i++;
            }
            wp_reset_postdata();  
        }       
        
        if ( ( $arianna_cat_menu == 0 )  && ( $object->menu_item_parent == '0')&& ( in_array('menu-item-has-children', $arianna_current_classes) ) ) { 
            $output .= '<div class="arianna_dropdown-menu">';
        }

        
        if ( $arianna_posts != NULL ) {
                 $output .= '<div id="'.$arianna_carousel_id.'" class="arianna_sub-posts'.$arianna_has_children.' flexslider clear-fix">
                                <ul class="slides">'. $arianna_posts .'</ul>
                             </div>'; 
        } 
        if ( ($arianna_has_children == NULL) && ($object->arianna_megamenu == '1') ) {
                $arianna_closer = '</div>';
            } else {
                $arianna_closer = NULL;
            }
        $output .= $arianna_closer;

    
    }
    
    //start of the sub menu wrap
    function start_lvl( &$output, $depth=0, $args = array() ) {

        if ( $depth > 2 ) { return; }
        if ( $depth == 1 )  { $output .= '<ul class="arianna_sub-sub-menu">'; }
        if ( $depth == 0 )  { $output .= '<ul class="arianna_sub-menu">'; }
    }
 
    //end of the sub menu wrap
    function end_lvl( &$output, $depth=0, $args = array() ) {

        if ( $depth > 2 ) { return; }
        if ( $depth == 0 ) { $output .= '</ul></div>'; }
        if ( $depth == 1 ) { $output .= '</ul>'; }
        
    }    
}

/*--- Backend Walker ---*/
class arianna_walker_backend extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {}
    function end_lvl( &$output, $depth = 0, $args = array() ) {}
    
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        ob_start();
        $item_id = esc_attr( $item->ID );
        if (empty($item->arianna_megamenu[0])) {
            $arianna_item_megamenu = NULL;
        } else {
            $arianna_item_megamenu = esc_attr ($item->arianna_megamenu[0]);
        }
        $removed_args = array( 'action','customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab',  '_wpnonce', );

        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( esc_html__( '%s (Invalid)' , 'arianna'), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( esc_html__('%s (Pending)' , 'arianna'), $item->title);
        }

        $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

        $submenu_text = '';
        if ( 0 == $depth )
            $submenu_text = 'style="display: none;"';

        ?>
        <li id="menu-item-<?php echo (esc_attr($item_id)); ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo esc_attr($submenu_text); ?>><?php esc_html_e( 'sub item' , 'arianna'); ?></span></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'arianna'); ?>">&#8593;</abbr></a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'arianna'); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo (esc_attr($item_id)); ?>" title="<?php esc_attr_e('Edit Menu Item', 'arianna'); ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? esc_url(admin_url( 'nav-menus.php' )) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, esc_url(admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) )) );
                        ?>"><?php esc_html_e( 'Edit Menu Item' , 'arianna'); ?></a>
                    </span>
                </dt>
            </dl>

            <div class="menu-item-settings" id="menu-item-settings-<?php echo (esc_attr($item_id)); ?>">
                <?php if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo (esc_attr($item_id)); ?>">
                            <?php esc_html_e( 'URL' , 'arianna'); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo (esc_attr($item_id)); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo (esc_attr($item_id)); ?>">
                        <?php esc_html_e( 'Navigation Label' , 'arianna'); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo (esc_attr($item_id)); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo (esc_attr($item_id)); ?>">
                        <?php esc_html_e( 'Title Attribute' , 'arianna'); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo (esc_attr($item_id)); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo (esc_attr($item_id)); ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo (esc_attr($item_id)); ?>" value="_blank" name="menu-item-target[<?php echo (esc_attr($item_id)); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php esc_html_e( 'Open link in a new window/tab' , 'arianna'); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo (esc_attr($item_id)); ?>">
                        <?php esc_html_e( 'CSS Classes (optional)' , 'arianna'); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo (esc_attr($item_id)); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo (esc_attr($item_id)); ?>">
                        <?php esc_html_e( 'Link Relationship (XFN)' , 'arianna'); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo (esc_attr($item_id)); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-arianna_megamenu description">
                    <?php if ($depth == 0 && ($item->object == 'category')) { ?>
                    <label for="edit-menu-item-arianna_megamenu-<?php echo (esc_attr($item_id)); ?>">Arianna Megamenu</label>
                    <input type="checkbox" id="edit-menu-item-arianna_megamenu-<?php echo (esc_attr($item_id)); ?>" name="menu-item-arianna_megamenu[<?php echo (esc_attr($item_id)); ?>]" value="1" <?php checked( $arianna_item_megamenu,1 ); ?> />
                    <?php } ?>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo (esc_attr($item_id)); ?>">
                        <?php esc_html_e( 'Description' , 'arianna'); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo (esc_attr($item_id)); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo (esc_attr($item_id)); ?>]">
                            <?php echo esc_html( $item->description ); // textarea escaped ?></textarea>
                        <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.' , 'arianna'); ?></span>
                    </label>
                </p>  
                <p class="field-move hide-if-no-js description description-wide">
                    <label>
                        <span><?php esc_html_e( 'Move' , 'arianna'); ?></span>
                        <a href="#" class="menus-move-up"><?php esc_html_e( 'Up one' , 'arianna'); ?></a>
                        <a href="#" class="menus-move-down"><?php esc_html_e( 'Down one' , 'arianna'); ?></a>
                        <a href="#" class="menus-move-left"></a>
                        <a href="#" class="menus-move-right"></a>
                        <a href="#" class="menus-move-top"><?php esc_html_e( 'To the top' , 'arianna'); ?></a>
                    </label>
                </p>

                <div class="menu-item-actions description-wide submitbox">
                    <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( esc_html__('Original: %s' , 'arianna'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo (esc_attr($item_id)); ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            esc_url(admin_url( 'nav-menus.php' ))
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php esc_html_e( 'Remove' , 'arianna'); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo (esc_attr($item_id)); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
                        ?>#menu-item-settings-<?php echo (esc_attr($item_id)); ?>"><?php esc_html_e('Cancel' , 'arianna'); ?></a>
                </div>

                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo (esc_attr($item_id)); ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo (esc_attr($item_id)); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        <?php
        $output .= ob_get_clean();
    }
}

if ( ! function_exists( 'arianna_megamenu_walker' ) ) { 
    function arianna_megamenu_walker($walker) {
            if ( $walker === 'Walker_Nav_Menu_Edit' ) {
                        $walker = 'arianna_walker_backend';
                  }
           return $walker;
        }
}
add_filter( 'wp_edit_nav_menu_walker', 'arianna_megamenu_walker');  

if ( ! function_exists( 'arianna_megamenu_walker_save' ) ) { 
    function arianna_megamenu_walker_save($menu_id, $menu_item_db_id) {

        if  (isset($_POST['menu-item-arianna_megamenu'][$menu_item_db_id])) {
                update_post_meta( $menu_item_db_id, '_menu_item_arianna_megamenu', $_POST['menu-item-arianna_megamenu'][$menu_item_db_id]);
        } else {
            update_post_meta( $menu_item_db_id, '_menu_item_arianna_megamenu', '0');
        }
    }
}
add_action( 'wp_update_nav_menu_item', 'arianna_megamenu_walker_save', 10, 2 );

if ( ! function_exists( 'arianna_megamenu_walker_loader' ) ) { 
    function arianna_megamenu_walker_loader($menu_item) {
            $menu_item->arianna_megamenu = get_post_meta($menu_item->ID, '_menu_item_arianna_megamenu', true);
            return $menu_item;
     }
}
add_filter( 'wp_setup_nav_menu_item', 'arianna_megamenu_walker_loader' );