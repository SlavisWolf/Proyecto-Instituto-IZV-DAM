//
//  Cliente.swift
//  actividades_izv
//
//  Created by dam on 8/2/17.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//

import Foundation
import UIKit
class ClienteRest {
    
    
    //URL C9 
    //  "https://proyecto-actividades-instituto-slaviswolf.c9users.io"
    
    
    //url local
    // "http://192.168.208.16/proyecto_instituto"
    
    static let urlProyecto = "https://proyecto-actividades-instituto-slaviswolf.c9users.io"

    static let urlApi: String = ClienteRest.urlProyecto + "/ios/"
    
    let configuracion = URLSessionConfiguration.default
    
    let datos:Data?
    let metodo:String
    let respuesta:ResponseReceiber
    var sesion: URLSession
    var url: URL
    //var urlDestino: String
    var urlPeticion: URLRequest
    
    init? (destino:String,respuesta:ResponseReceiber, metodo:String,datos:Data?) { //tiene ? el init porq el constructor puede devolver nil si la url no es valida
        
        self.metodo = metodo
        self.datos = datos
        self.respuesta = respuesta
        self.sesion = URLSession(configuration: self.configuracion)
        
        guard let url = URL(string: ClienteRest.urlApi + destino) else { return nil} // por este return el constructor es nil
        self.url=url
        urlPeticion = URLRequest(url:self.url)
        self.urlPeticion.httpMethod = self.metodo
        
        if self.metodo != "GET" && self.datos != nil  {
            /*guard let json = try?  // ya le pasamos directamente el JSON
             JSONSerialization.data(withJSONObject: self.datos as Any,
             options: []) else {
             return nil;
             }*/
            self.urlPeticion.addValue("application/json",
                                      forHTTPHeaderField: "Content-Type")
            self.urlPeticion.httpBody = self.datos
        }
    }
    
    func request() { // hacemos la conexion en 2º plano
        
        let tarea = self.sesion.dataTask(with: self.urlPeticion,
                                         completionHandler: self.callBack)
        tarea.resume()
    }
    
    
    
    static func loadImageFromUrl(url: String, view: UIImageView){
        
        // Create Url from string
        let url = URL(string: url)!
        let sesion = URLSession(configuration: URLSessionConfiguration.default)
        // hace la peticion al servidor, despues se ejecutara la funcion que hay entre los corchetes, el cual tiene las variables que el servidor devolvera.
        let task = sesion.dataTask(with: url) { (responseData, responseUrl, error) -> Void in
            
            if responseData != nil{
                DispatchQueue.main.async { // ejecuta el codigo en 2º plano.
                    view.image = UIImage(data: responseData!)
                }
            }
        }
        //ejecutamos
        task.resume()
    }
    
    static func uploadImageToUrl(urlCadena:String, imagen:UIImage, nombreImagen:String) {
        
        
        print(urlCadena)
        print(nombreImagen)
        let url = URL(string: urlCadena)
        let sesion = URLSession(configuration: URLSessionConfiguration.default)
        var peticion = URLRequest(url:url!)
        peticion.httpMethod = "POST"
        peticion.addValue("application/json",forHTTPHeaderField: "Content-Type")
        
        
        let image_data =  UIImageJPEGRepresentation(imagen, 1)
        
        //codificamos la imagen a base 64 y obtenemos el string para enviarselo al servidor.
        let imagenDataString = image_data?.base64EncodedString()
        // codificamos
        if let datos = try? JSONSerialization.data(withJSONObject: ["imagen" : imagenDataString, "nombreFichero" : nombreImagen], options: []) {
            peticion.httpBody = datos
            let tarea = sesion.dataTask(with: peticion) { (responseData, responseUrl, error) -> Void in
                
                if responseData != nil{
                    print(String (data: responseData! , encoding:.utf8) )
                }
                else {
                    print("no devuelve nada")
                }
            }

            tarea.resume()
        }
        
    }
    
    
    private func callBack(_ data: Data?, _ respuesta: URLResponse?, _ error: Error?) {
        DispatchQueue.main.async {
            guard error == nil else {
                //print("error")
                self.respuesta.onErrorReceivingData(message: "Error en la recepción")
                return
            }
            guard let datosRespuesta = data else {
                //print("error data")
                self.respuesta.onErrorReceivingData(message: "Error sin datos")
                return
            }
            //print("ui thread")
            self.respuesta.onDataReceived(data: datosRespuesta)
        }
    }
}
