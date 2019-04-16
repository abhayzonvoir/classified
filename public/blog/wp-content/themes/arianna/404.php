<?php
/**
 * The template for 404 page (Not Found).
 *
 */
?>
<?php 
    get_header();
?>
<div class="page-404-wrap">
    <div class="page-404-content-wrap clear-fix">
        <div class="error-number">
            <h1><?php esc_html__('404', 'arianna'); ?></h1>
        </div>              
        <div id="arianna_404-wrap">
            <h4 class="arianna_error-title"><?php esc_html_e('Page not found','arianna'); ?></h4>
        	<div class="entry-content">			
                <h2><?php esc_html_e("Oops! The page you were looking for was not found. Perhaps searching can help.", 'arianna'); ?></h2>               
        	</div>	
        </div> <!-- end #arianna_404-wrap -->
    </div>
    <div class="search">
        <?php get_search_form(); ?>
    </div>
    
    <div class="redirect-home">
        <i class="fa fa-home"></i>
        <a href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e('Back to Homepage','arianna'); ?></a>
    </div>
</div>
<?php get_footer(); ?>
