
<?php
        /*
                Template Name:actividades
        */
        
      require_once('/home/ubuntu/workspace/clases/AutoCarga.php');
      require_once('/home/ubuntu/workspace/clases/vendor/autoload.php');
      $modelo = new Modelo();
      
      const URL_IMAGENES = "https://proyecto-actividades-instituto-slaviswolf.c9users.io/img/";
      
      $paginaActual = 1;
      
      const NUM_ACTIVITIES_PAG=5; 
      
      if ( isset($_GET['pagina'] ) ) {
        $paginaActual = $_GET['pagina'];
      }
  
      
      $actividades = $modelo->getActividadesLimit($paginaActual,NUM_ACTIVITIES_PAG); // todas las actividades ya ordenadas y con el limit añadido, num de actividades por defecto 5, para que coja mas de 5 pasale el numero que consideres como 2º parametro. :)
      get_header();
?>

<div class ='cabeceraPagina cabeceraActividades'>
                <h1><?php _e("Activities","mi_school")?></h1>
</div>


<div class="container">
        <div class="row">
               <div class="col-md-8 capaActividades">
                       
                       
                               
                               <?php 
                                foreach ($actividades as $actividad) {
                                        ?>  
                                        <div class="actividad col-md-12 bottomMargin">
                                                <h3 class="tituloActividad">-oOoOo-  <?php echo $actividad->getTitulo()?>  -oOoOo-</h3>
                                                
                                                <div class="col-md-6 bottomMargin">
                                                     <?php 
                                                        $foto = $actividad->getFoto();
                                                        if ($foto == "") 
                                                                $foto = get_template_directory_uri()."/inc/images/defecto.png"; // misma foto por defecto que las noticias
                                                        else 
                                                                $foto = URL_IMAGENES . $foto;
                                                     ?>   
                                                     <img class="fotoActividad" src="<?php echo $foto;?>"/>
                                                </div>
                                                <div class="col-md-6 caracteristicasExcursion bottomMargin">
                                                        <p><i class="fa fa-graduation-cap" aria-hidden="true">&nbsp;</i> <?php echo  $actividad->getProfesor()->getNombreCompleto(); ?></p>
                                                        <p><i class="fa fa-users" aria-hidden="true">&nbsp;</i> <?php echo  $actividad->getGrupo()->getCurso();?></p>
                                                        <p><i class="fa fa-calendar" aria-hidden="true">&nbsp;</i> <?php echo  $actividad->getFecha()->format('d/m/Y');?></p>
                                                        <p><i class="fa fa-clock-o" aria-hidden="true">&nbsp;</i> <?php echo  $actividad->getHora_salida()->format('H:i') . "-" .  $actividad->getHora_vuelta()->format('H:i');?></p>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                        <p class="descripcion">
                                                     <b> <u>Descripción:</u>  </b>
                                                            <?php
                                                        
                                                                echo $actividad->getDescripcion();
                                                        ?></p>
                                                      
                                                </div>
                                                
                                        </div>
                                        <hr class="conestilo">
                                <?php        
                                }
                               ?>
                               
                               
                               <?php 
                               //PAGINACION
                               $numFilasRs = $modelo->getNumActividades();
                              /*echo  $numFilasRs;
                               echo NUM_ACTIVITIES_PAG;*/
                                if($numFilasRs>NUM_ACTIVITIES_PAG) {
                                    
                                        $urlPagina = get_page_link(get_the_ID());
                                        //echo "<p class='paginacion'><span class='pagina'>".__("Page","mi_school")."</span>&nbsp&nbsp";
                                        
                                        $condicion = $numFilasRs / NUM_ACTIVITIES_PAG; 
                                        if ($numFilasRs%NUM_ACTIVITIES_PAG!=0)
                                            $condicion++;
                                            
                                        if ($paginaActual>1) {
                                            $actual = $paginaActual-1;
                                            echo "<a  href='$urlPagina?pagina=$actual'>&lt;&lt;</a>&nbsp"; //__("Before","mi_school")
                                        }
                                        
                                        
                                        for($i=1;$i<=$condicion;$i++){
                                            
                                            if ($i == $paginaActual) {
                                                echo "<span class='paginaActual'>$i</span>";
                                            }
                                            else {
                                                 echo "<a href='$urlPagina?pagina=$i'>$i</a>";
                                            }
                                            echo "&nbsp;&nbsp;";
                                        }
                                        
                                        if($paginaActual<$condicion) {
                                            $actual = $paginaActual+1;
                                            echo "<a  href='$urlPagina?pagina=$actual'>&gt;&gt;</a>&nbsp"; //__("Next","mi_school")
                                        }
                                        echo "</p>";
                                }
                               ?>
                       
               </div> 
                
                <div class="col-md-4 sidebarIndex">
                         <?php get_sidebar()?> 
                </div>
        </div>
</div>

<?php get_footer(); ?>
