//
//  Gruposwift
//  actividades_izv
//
//  Created by dam on 3/2/17.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//
// pojo-rest-presentadorpojoRest-interfaz


struct Grupo {
    
    var id:Int
    var aula:String
    var curso:String
    var actividades:[Actividad]
    
    init(id:Int = -1,aula:String,curso:String) {
        self.id = id
        self.aula = aula
        self.curso = curso
        actividades = []
    }
    
    init (_ dic:[String:Any]) {
        
        self.id = dic["id"] as! Int
        self.aula = dic["aula"] as! String
        self.curso = dic["curso"] as! String
        self.actividades = []
    }
    
    mutating public func addActividad(actividad:Actividad) {
        actividades.append(actividad)
    }
    
    mutating public func borrarActividad(indice:Int) {
        actividades.remove(at: indice)
    }
    
    
}
