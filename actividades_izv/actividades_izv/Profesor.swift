//
//  Profesor.swift
//  actividades_izv
//
//  Created by dam on 3/2/17.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//
// pojo-rest-presentadorpojoRest-interfaz


struct Profesor {
    var id:Int
    var nombre:String
    var apellidos:String
    var nombreCompleto:String {return self.nombre + " " + self.apellidos}
    var telefono:String
    var departamento:String
    var actividades:[Actividad]
    
    init(id:Int = -1,nombre:String,apellidos:String,telefono:String,departamento:String) {
        self.id = id
        self.nombre = nombre
        self.apellidos = apellidos
        self.telefono = telefono
        self.departamento = departamento
        self.actividades = []
    }
    
    
     init (_ dic:[String:Any]) {
        
        
        self.id = dic["id"] as! Int
        self.nombre = dic["nombre"] as! String
        self.apellidos = dic["apellidos"] as! String
        self.telefono = dic["telefono"] as! String
        self.departamento = dic["departamento"] as! String
        self.actividades = []
    }
    
   mutating public func addActividad(actividad:Actividad) {
        actividades.append(actividad)
    }
    
    mutating public func borrarActividad(indice:Int) {
        actividades.remove(at: indice)
    }
}
