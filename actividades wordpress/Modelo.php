<?php


class Modelo {
    
    private $gestor;
    
    function __construct(){
        $bs = new Bootstrap();
        $this->gestor = $bs->getEntityManager();
        $this->gestor->getEventManager()->addEventSubscriber(
                new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit('utf8', 'utf8_unicode_ci')
);
    }
    public function insert($objeto){
        $this->gestor->persist($objeto);
        $this->gestor->flush();
        return $objeto->getId();
    }
    
    private function delete($id,$tipo){
        try {
            $objeto = $this->gestor->find($tipo, $id);
            $this->gestor->remove($objeto);//borro provisional
            $this->gestor->flush();//definitivo
            return true;
        }
        catch (Exception $e ) {
            return false;
        }
    }
    
    private function get($id, $tipo){
        return array( $this->gestor->find($tipo, $id) );
    }
    
    private function getAll($tipo){ //devuelve todos los elementos de un tipo cocnreto
    
        if ($tipo=="Actividad") { // consulta magica
            $sql = "select * from actividad
                        order by if(fecha= date(now()),1,0) desc,
                                if(datediff(fecha,date(now())) > 0, - datediff(fecha,date(now())), null) desc,
                                datediff(fecha,date(now())) desc,
                                hora_salida";
                                
                                
            $stmt = $this->gestor->getConnection()->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll();
            return $this->crearArrayActividadesConArray2D($datos);
        }
        else {
            $repositorio= $this->gestor->getRepository($tipo);
            return  $repositorio->findAll(); // devuelve un array
        }
    }
    
    private function getFindBy ($tabla,$wheres) { // consulta personalizada
        return $this->gestor->getRepository($tabla)
                                   ->findBy($wheres);

    }
    
    private function getNumFilas($tipo) {
        $sql = "select count(*) as filas from $tipo";
        $stmt = $this->gestor->getConnection()->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetchAll();
        return $datos[0]['filas'];
    }
    
    //PROFESOR 
    
    
   public function deleteProfesor($id){
       return  $this->delete($id,'Profesor');
    }
    
    public function updateProfesor(Profesor $objeto){
        try {
            $profe = $this->gestor->find('Profesor', $objeto->getId());
            $profe->actualizarProfesor($objeto);
            $this->gestor->flush();//commit
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
    
    public function getProfesor($id){
        return $this->get($id,'Profesor');
    }
    
    public function getProfesores($args=array()){
         return !$args ? $this->getAll('Profesor') : $this->getFindBy('Profesor',$args);
    }
    
    //GRUPOS
    
    public function deleteGrupo($id){
        return $this->delete($id,'Grupo');
    }
    public function updateGrupo(Grupo $objeto){
        try {
            $grupo = $this->gestor->find('Grupo', $objeto->getId());
            $grupo->actualizarGrupo($objeto);
            $this->gestor->flush();//commit
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
    public function getGrupo($id){
        return $this->get($id,'Grupo');
    }
    
     
    public function getGrupos($args=array()){
         return !$args ? $this->getAll('Grupo') : $this->getFindBy('Grupo',$args);
    }
    
     //Actividades
    
    public function deleteActividad($id){
        return $this->delete($id,'Actividad');
    }
    
    public function updateActividad(Actividad $objeto){
        try {
            $actividad = $this->gestor->find('Actividad', $objeto->getId());
            $actividad->actualizarActividad($objeto);
            $this->gestor->flush();//commit
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
    
    public function getActividad($id){
        return $this->get($id,'Actividad');
    }
    
    
    public function getActividades($args=array()){
         return !$args ? $this->getAll('Actividad') : $this->getFindBy('Actividad',$args);
    }
    
    public function getActividadesLimit($pagina,$numActividades = 5) { // añadido para la paginación
        
        $posInicial = $pagina *  $numActividades - $numActividades;
        $sql = "select * from actividad
                        order by if(fecha= date(now()),1,0) desc,
                                if(datediff(fecha,date(now())) > 0, - datediff(fecha,date(now())), null) desc,
                                datediff(fecha,date(now())) desc,
                                hora_salida
                                limit $posInicial,$numActividades";
                                
            $stmt = $this->gestor->getConnection()->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll();
            return $this->crearArrayActividadesConArray2D($datos);
    }
    
    public function getNumActividades() {
           return $this->getNumFilas('actividad');
    }
    
    private function  crearArrayActividadesConArray2D($datos) {
         $resultado;
            
            foreach ($datos as $fila) {
                $actividad = new Actividad();
                $actividad->setId((int)$fila["id"]);
                $actividad->setTitulo($fila["titulo"]);
                $actividad->setDescripcion($fila["descripcion"]);
                $actividad->setResumen($fila["resumen"]);
                $actividad->setFecha(date_create($fila["fecha"]));
                $actividad->setHora_salida(date_create($fila["hora_salida"]));
                $actividad->setHora_vuelta(date_create($fila["hora_vuelta"]));
                $actividad->setFoto($fila["foto"]);
                $actividad->setProfesor($this->getProfesor($fila["profesor_id"])[0]);
                $actividad->setGrupo($this->getGrupo($fila["grupo_id"])[0]);
                $resultado[] = $actividad;
            }
            return $resultado;
    }
}