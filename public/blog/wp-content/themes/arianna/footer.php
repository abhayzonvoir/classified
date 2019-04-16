<?php
/**
 * The Footer for the theme.
 *
 */
?>
            </div>
    		<!-- MAIN BODY CLOSE -->
    		<!-- FOOTER OPEN -->
            <?php $arianna_option = arianna_global_var_declare('arianna_option');?>            
    		<div class="footer <?php if ( $arianna_option ['arianna_responsive-switch'] == 0 ){echo('arianna_site-container');}?>">
                <?php arianna_get_footer_instagram($arianna_option)?>
                <?php arianna_get_footer_widgets()?>
                <?php arianna_get_footer_lower();?>
    		
    		</div>
    		<!-- FOOTER close -->
            
        </div>
        <!-- page-wrap close -->
        
      </div>
      <!-- site-container close-->
    <?php arianna_footer_localize()?>
    <?php wp_footer(); ?> 
</body>
</html>