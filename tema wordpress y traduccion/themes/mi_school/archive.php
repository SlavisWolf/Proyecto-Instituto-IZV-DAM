<?php get_header();
?>

<div class="cabeceraPagina headerArchive">
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
                 ?>
                </h1>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-8 postsIndex">
            <?php  
            
            if(is_category()) {
                echo '<h2>';
                printf(__('Posts by category: %s','mi_school'),'<span class="archiveTipo">'.single_cat_title('',false).'</span>');
                echo '</h2>';                
            }
    
            elseif(is_tag()) {
                echo '<h2>';
                printf(__('Posts by tag:  %s','mi_school'),'<span class="archiveTipo">'.single_tag_title('',false).'</span>');
                echo '</h2>';                
            }
            else {
                _e("...Archivos ....","shape");
            }
        ?>
    
         <?php
                     while (have_posts() ) : the_post() ;
                    ?>
                    
                    <?php  get_template_part("inc/content","post");?> 
                
                  <hr class="hrnoticias" /> 
            <?php endwhile; ?>
            
        </div>
        
        <div class="col-md-4 sidebarIndex">
            <?php get_sidebar()?> 
        </div>
    </div>
    
    
</div>

<?php get_footer(); ?>