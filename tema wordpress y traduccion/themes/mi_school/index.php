<?php get_header();
	 
?>
    <?php 
     $args = array(
                        'posts_per_page' => '1',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        ); // por defecto el 1º es el más reciente. tambien se puede usar showposts =>1
        $customQuery = new WP_Query($args);
    $idPostDestacado;
    if($customQuery->have_posts()) : while($customQuery->have_posts()) : $customQuery->the_post();


        $idPostDestacado = get_the_id();
         $imagenDestacada = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),"full");
            $imagenPost = $imagenDestacada[0];
            if($imagenPost=='') {
                $imagenPost = get_template_directory_uri()."/inc/images/defecto.png";
            }
    ?>
    
    <div class ='cabeceraPagina' style='background-image: url(<?php echo $imagenPost ?>)'>
                <h1><?php _e("News","mi_school")?></h1>
    </div>
    
    <div class="container post">
        
        <div class="row">
            
            <div class="col-md-12">
                <p><?php the_category();?></p>
                <h3><a href="<?php echo get_permalink()?>"><?php the_title()?></a></h3>
            </div>
            
            <div class="col-md-12">
                <h5><?php _e("By ","mi_school")?><span class="autorPost"><?php the_author();?></span>&nbsp;<?php the_time('j-M-Y'); ?></h5>
            </div>
            <div class="col-md-12">
                <?php the_excerpt()?>
            </div>
            
            <div class="col-md-4">
                 <h5><i class="fa fa-tags" aria-hidden="true">&nbsp;</i><?php the_tags(""); ?></h5>
            </div>
            
            <div class="col-md-4">
                <h5><i class="fa fa-comment-o" aria-hidden="true">&nbsp;</i><?php comments_number(__("No comments","mi_shool") , __("1 comments","mi_shool") ,__("% comments","mi_shool") ); ?></h5>
            </div>
            
            <div class="col-md-4">
                <div class="">
					<h5><a href="<?php echo get_permalink(); ?>"><?php _e("More","mi_school") ;?>&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i></a></h5>
				</div>
            </div>
            
        </div>

        <?php 
            endwhile; 
             wp_reset_postdata();
            else : 
                _e("There are not posts","mi_school") ;
            endif;
        ?>
        
        <div class="row">
            <div class="col-md-8 postsIndex">
                  <?php     
                            $paged = get_query_var ('paged') > 1 ? get_query_var ('paged') : 1;
                            
                            $args = array(                        
                            'post__not_in' => array($idPostDestacado),
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'paged' => $paged,                        
                            'nopaging' => false,  
                            ); 
                             $customQuery = new WP_Query($args);   
                             
                             $customQuery = new WP_Query($args);
                             if($customQuery->have_posts()) : while($customQuery->have_posts()) : $customQuery->the_post();
                             get_template_part("inc/content","post");?>
                             
                    <hr class="hrnoticias">
                    <?php 
                        endwhile;                                     
                        echo get_paginate_pagelink();
                        else : 
                            _e("There are not more posts","mi_school") ;
                        endif;
                        wp_reset_postdata();
                    ?>
            </div>
            
            <div class="col-md-4 sidebarIndex">
                 <?php get_sidebar()?> 
            </div>
        </div>
    </div>


<?php get_footer(); ?>
