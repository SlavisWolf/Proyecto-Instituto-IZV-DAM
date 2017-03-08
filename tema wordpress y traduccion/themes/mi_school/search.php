<?php get_header();
?>

<div class="cabeceraPagina cabeceraSearch">
                <h1>
                    <?php
                    $numPost = $wp_the_query->post_count;
                    
                    if ($numPost>1) {
                        echo $numPost;
                        _e(" Posts Found","mi_school");
                    }
                    elseif($numPost==1) {
                        echo $numPost;
                        _e(" Post Found","mi_school");
                    }
                    else  {
                        _e("No Posts Found","mi_school");
                    }
                 ?>
                </h1>
</div>

<div class="container">
    
    <div class="row">
        <div class="col-md-8 postsIndex">
            <h2 class="bottomMargin"> <?php  printf( __("Search results for %s","mi_school"),'<span class="searchResult">'.esc_html(get_search_query()).'</span>') ?></h2>
            
             <?php
                        while (have_posts() ) : the_post() ;
                    ?>
                    
                    <?php  get_template_part("inc/content","post");?> 
                
                  <hr class="hrnoticias">
            <?php endwhile; ?>
            
        </div>
        
        <div class="col-md-4 sidebarIndex">
            <?php get_sidebar()?> 
        </div>
    </div>
    
    
</div>

<?php get_footer(); ?>