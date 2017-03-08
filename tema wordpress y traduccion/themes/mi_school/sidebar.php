<div class="buscar">
    
    <h3><?php _e("Search","mi_school") ?></h3>
     <?php get_search_form();?>
</div>


<div class="recientes">
                    <h3><?php _e("Last Entries","mi_school")?></h3>
                    
                    <ul class="listaSideBar">
                        <?php  wp_get_archives(
                                                array("type" => "postbypost", 
                                                        "limits" => 5, 
                                                        //"before" => "<i class='fa fa-arrow-circle-o-right' aria-hidden='true'>&nbsp;</i>",
                                                    ) 
                                                ); // esto se hace para que solo te devuelva los ultimos post, sin meses.?>
                    </ul>
</div>


<div class="widgets">
        <?php
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widgets')): ?>
            <div class="warning">
                <?php _e("You have not widgets to this theme","mi_school") ?>
                
            </div>
            <?php endif; ?>

</div>

<div class="categorias">
                    <h3><?php _e("Categories","mi_school")?></h3>
                    
                    <ul class="listaSideBar">
                        <?php wp_list_categories('title_li&show_count=true'); //el  parametro, lo que hace es quitar el título param que no salga 2 veces?>
                    </ul>
</div>