                   <div class="postIndividual">
                       
                        <?php $imagenDestacada = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),"medium");
                                $imagenPost = $imagenDestacada[0];
                                if($imagenPost=='') {
                                    $imagenPost = get_template_directory_uri()."/inc/images/defecto.png";
                                }
                        ?>
                        
                        <div class="col-md-12"><img src="<?php echo $imagenPost;?>" class="imagenPost"/></div>
                        
                        
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
                            <h5><i class="fa fa-comment-o" aria-hidden="true">&nbsp;</i><?php comments_number(__("No comments","mi_school") , __("1 comments","mi_school") ,__("% comments","mi_school") ); ?></h5>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="">
            					<h5><a href="<?php  echo get_permalink(); ?>"><?php _e("More","mi_school") ;?>&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i></a></h5>
            				</div>
                        </div>
                    
                    </div>
                    