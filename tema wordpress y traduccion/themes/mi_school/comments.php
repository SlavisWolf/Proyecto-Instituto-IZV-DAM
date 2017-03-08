<hr>
<?php comment_form();?>
<hr>

    <?php 
    
        if (have_comments()) : 
            echo "<i class='fa fa-comment-o' aria-hidden='true'>&nbsp;</i> ". get_comments_number(). __(" comments","mi_school");
            ?>

            <h3 class="bottomPadding"><?php _e("Comments of ","mi_school");?><span class="tituloComentarios"><?php the_title() ?></span></h3>
            <ol class="comment-list">
            <?php
            wp_list_comments(array(
                                    'style'         => 'ol',
                                    'short_ping'    => true,
                                    'avatar_size'   => 70
                                )
                          );

            echo "</ol>";
            
            //echo "<h1>".get_comment_pages_count()."</h1>";
                
            if (get_comment_pages_count() > 1  && get_option('page_comments')) :
                ?>
                
                <nav class='navigation comment-navigation' role='navigation'>
                   <!-- <h1 class="screen reader text section heading">PRUEBA</h1> -->
                    <div class="nav_previous"><?php previous_comments_link(__("Older comments","mi_school")); ?></div>
                    <div class="nav_next"><?php next_comments_link(__("Recent comments","mi_school")); ?></div                               
                </nav>
                
                <?php 
            endif;
                
            if ( !comments_open() && get_comments_number() ) : ?>
                <p class="comentariosCerrados"><?php _e("Comments are closed","mi_school")?></p>
                
                <?php 
            endif;
        endif;        
    ?>




    