<!--<home sidebar widget>-->
<?php 
    $arianna_option = arianna_global_var_declare('arianna_option');
?>
    <?php  if ( (is_front_page() && is_active_sidebar( 'home_sidebar' ) ) || ( !is_front_page() && (is_active_sidebar( 'page_sidebar' ) || is_active_sidebar( 'home_sidebar' )))):?>
		<div class="sidebar <?php if (isset($arianna_option['arianna_sidebar-position']) && ($arianna_option['arianna_sidebar-position'] == 'left')){echo 'left';}?>">
            <div class="sidebar-wrap <?php if ($arianna_option['arianna_sidebar-sticky'] == 1) echo "stick";?>" <?php if ($arianna_option['arianna_sidebar-sticky'] == 1) echo "id= 'sidebar-stick'";?>>
                <div class="sidebar-wrap-inner">
                    <?php 
                        if (is_front_page()) {
                                dynamic_sidebar('home_sidebar');
                        } else {
                            if ( is_active_sidebar( 'page_sidebar' )) {
                                dynamic_sidebar('page_sidebar');
                            } else {
                                    dynamic_sidebar('home_sidebar');
                            }
                        }
                    ?>  
                </div>	
            </div>
		</div>
    <?php endif; ?>
<!--</home sidebar widget>-->