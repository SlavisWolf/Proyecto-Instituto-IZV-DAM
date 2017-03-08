<?php get_header();
?>

<?php 

            the_post();
            $imagenDestacada = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),"full");
            $imagenPost = $imagenDestacada[0];
            if($imagenPost=='') {
                $imagenPost = get_template_directory_uri()."/inc/images/defecto.png";
            }
    ?>
    
    <div class ='cabeceraPagina' style='background-image: url(<?php echo $imagenPost ?>)'>
                
    </div>
    
    <div class="container">
        
        <div class="row">
            
            <div class="col-md-8 postsIndex">
                
                <div class="col-md-12">
                            <p><?php the_category();?></p>
                            <h3 class="titulosPosts"><?php the_title()?></a></h3>
                        </div>
                        
                        <div class="col-md-12">
                            <h5><?php _e("By ","mi_school")?><span class="autorPost"><?php the_author();?></span>&nbsp;<?php the_time('j-M-Y'); ?></h5>
                        </div>
                        <div class="col-md-12">
                            <?php the_content()?>
                        </div>
                        
                        <div class="col-md-12">
                             <h5><i class="fa fa-tags" aria-hidden="true">&nbsp;</i><?php the_tags(""); ?></h5>
                        </div>
                        
                        
                        <div class="comentariosPost">
                            <?php comments_template();?>     
                        </div>
                
            </div>
            
            
            <div class="col-md-4 sidebarIndex">
                
                <?php get_sidebar()?> 
                
            </div>
            
        </div>
        
        
    </div>

<?php get_footer(); ?>