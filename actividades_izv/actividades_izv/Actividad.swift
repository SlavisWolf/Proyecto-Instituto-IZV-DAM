//
//  Actividad.swift
//  actividades_izv
//
//  Created by dam on 3/2/17.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//
import Foundation

struct Actividad {
    
    var id:Int
    var titulo:String
    var descripcion:String
    var resumen:String
    var fecha:Date
    var hora_salida:Date
    var hora_vuelta:Date
    var foto:String?
    var profesor:Profesor?
    var grupo:Grupo?
    
    //constantes para los formatos de fecha
    let formatoFecha = "YYYY-MM-dd"
    let formatoFechaSpain = "dd/MM/YYYY"
    let formatoHora = "HH:mm:ss"
    let formateadorFecha = DateFormatter()
    
    static let URL_IMAGE_FOLDER = ClienteRest.urlProyecto + "/img/"
    static let URL_SUBIR_IMAGENES = Actividad.URL_IMAGE_FOLDER + "php/subirImagen.php"
    
    //constructor vacio
    init () {
        self.id = -1
        self.titulo = ""
        self.descripcion = ""
        self.resumen = ""
        self.fecha = Date()
        self.hora_salida = Date()
        self.hora_vuelta = Date()
        self.foto = nil
        self.profesor = nil
        self.grupo = nil
    }
    
    
    
    // el 1º constructor le pasaremos fechas como tal
    init(id:Int = -1,titulo:String,descripcion:String,resumen:String,fecha:Date,hora_salida:Date,hora_vuelta:Date,foto:String?,profesor:Profesor,grupo:Grupo) {
        self.id = id
        self.titulo = titulo
        self.descripcion = descripcion
        self.resumen = resumen
        self.foto = foto
        self.profesor = profesor
        self.grupo = grupo
        self.fecha = fecha
        self.hora_salida = hora_salida
        self.hora_vuelta = hora_vuelta
    }
    
    
    // el segundo constructor leera la fecha y la hora directamente del JSON por eso cogera el String y lo transformara al tipo fecha de Swift
    init(id:Int = -1,titulo:String,descripcion:String,resumen:String,fecha:String,hora_salida:String,hora_vuelta:String,foto:String? ,profesor:Profesor,grupo:Grupo) {
        
        
        self.id = id
        self.titulo = titulo
        self.descripcion = descripcion
        self.resumen = resumen
        self.foto = foto
        self.profesor = profesor
        self.grupo = grupo
        
        //conversion de los strings dados en fechas
        formateadorFecha.dateFormat = formatoFecha
        self.fecha = formateadorFecha.date(from: fecha)! // ponemos la exclamación porque estamos seguros de que siempre va  adevovler algún  valor, ya que la base de datos controla que este campo no este vacio.
        formateadorFecha.dateFormat = self.formatoHora
        self.hora_salida = self.formateadorFecha.date(from: hora_salida)!
        self.hora_vuelta = self.formateadorFecha.date(from: hora_vuelta)!
    }
    
    init (_ dic:[String:Any]) {
        
        self.id = dic["id"] as! Int
        self.titulo = dic["titulo"] as! String
        self.descripcion = dic["descripcion"] as! String
        self.resumen = dic["resumen"] as! String
        self.foto = dic["foto"] as? String
        self.profesor = dic["profesor"] as? Profesor
        self.grupo = dic["grupo"] as? Grupo
        
        formateadorFecha.dateFormat = formatoFecha
        self.fecha = formateadorFecha.date(from:dic["fecha"] as! String)!
        formateadorFecha.dateFormat = self.formatoHora
        self.hora_salida = self.formateadorFecha.date(from:dic["hora_salida"] as! String)!
        self.hora_vuelta = self.formateadorFecha.date(from:dic["hora_vuelta"] as! String)!
    }
    
    
    
    
    
    func getFechaCadena() -> String {
        self.formateadorFecha.dateFormat = self.formatoFecha
        return self.formateadorFecha.string(from: self.fecha)
    }
    
    func getFechaCadenaSpain() -> String {
        self.formateadorFecha.dateFormat = self.formatoFechaSpain
        return self.formateadorFecha.string(from: self.fecha)
    }
    
    func getHoraSalidaCadena() -> String {
        formateadorFecha.dateFormat = formatoHora
        return self.formateadorFecha.string(from: self.hora_salida)
    }
    
    
    func getHoraVueltaCadena() -> String {
        formateadorFecha.dateFormat = formatoHora
        return self.formateadorFecha.string(from: self.hora_vuelta)
    }
    
    func getHoraSalidaCadena12h() -> String { // AM PM VERSION
        self.formateadorFecha.timeStyle = .short
        return self.formateadorFecha.string(from: self.hora_salida)
    }
    
    func getHoraVueltaCadena12h() -> String {
        self.formateadorFecha.timeStyle = .short
        return self.formateadorFecha.string(from: self.hora_vuelta)
    }
    
    func actividadToDiccionario() -> [String:Any?] {
        var dic = ["titulo":self.titulo,"descripcion":self.descripcion,"fecha":self.getFechaCadena(),"hora_salida":self.getHoraSalidaCadena(),"hora_vuelta":self.getHoraVueltaCadena(),"profesor_id":self.profesor!.id,"grupo_id":self.grupo!.id] as [String : Any]
        
        if self.foto != nil {
            dic.updateValue(self.foto!, forKey:"foto")
        }
        return dic
    }
}
