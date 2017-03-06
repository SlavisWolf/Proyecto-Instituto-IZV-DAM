//
//  ViewController.swift
//  actividades_izv
//
//  Created by dam on 3/2/17.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//

import UIKit


class ViewController: UIViewController,ResponseReceiber,UITableViewDelegate,UITableViewDataSource{
    //elementos interfaz tabla
    @IBOutlet weak var miTabla: UITableView!
    @IBOutlet weak var nuevobt: UIBarButtonItem!
    @IBOutlet weak var refrescarbt: UIBarButtonItem!
   
    
    
    private var profesores:[Profesor] = []
    private var grupos:[Grupo] = []
    private var actividades:[Actividad] = []
    
    var filaSeleccionada:Int = -1
    //var ultimaActividad:Actividad? = nil
    private var respuesta = 0

    override func viewDidLoad() {
        super.viewDidLoad()
    leerDatosCompletosServidor() //carga los arrays con todos los datos

        
        miTabla.dataSource=self
        miTabla.delegate=self
        
        
        // Do any additional setup after loading the view, typically from a nib.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        print("memoria")
        // Dispose of any resources that can be recreated.
    }
    
    func onDataReceived(data:Data) {
        
        //print (String(data:data, encoding: .utf8)!)
        
        if  let lista = try? JSONSerialization.jsonObject(with: data) as? [[String: Any]] {
            if lista!.count > 0 {
                cargarArray(tipo:comprobarClaseObjetoDic(lista![0]),datos: lista!)
            }
        }
            
        else { // si devuelve el id o una actu, recarga los datos
            self.actualizarDatos()
        }
        /*if let id = Int( String(data: data, encoding: .utf8)! ) { // DEVUELVE ID DEL ELEMENTO INSERTADO
         
         self.ultimaActividad!.id = id
         self.actividades.append(self.ultimaActividad!) // hay que meterlo en la posicion indicada
         miTabla.reloadData()
         }*/

    }
    func onErrorReceivingData(message:String) {
        print ("Ha habido el siguiente error:" + message)
    }
    private  func comprobarClaseObjetoDic(_ dic:[String:Any]) -> String {
    
        
        if dic["nombre"] != nil {
            return "Profesor"
        }
        if dic["aula"] != nil {
            return "Grupo"
        }
        
        if dic["titulo"] != nil {
            return "Actividad"
        }
        return "Algo has hecho,petardo."
    }
    
    private func cargarArray(tipo:String,datos:[[String:Any]]) {
        respuesta += 1
        switch tipo {
            case "Profesor":
                for diccionario in datos {
                    profesores.append(Profesor(diccionario))
                }
            
            
            case "Grupo":
                for diccionario in datos {
                    grupos.append(Grupo(diccionario))
                }
            
            case "Actividad":
                for var diccionario in datos { // si no ponemos var lo toma como una constante
                    // tenemos que consultar los arrays para que se guarde un objeto, no un id, el array actividades debe ser el ultimo en llenarse para funcionar correctamente.
                    let profe = profesores.filter({$0.id == diccionario["profesor_id"] as! Int}).first
                    diccionario.updateValue(profe!, forKey: "profesor")
                    let grupo = grupos.filter({$0.id == diccionario["grupo_id"] as! Int}).first
                    diccionario.updateValue(grupo!, forKey: "grupo")
                    actividades.append(Actividad (diccionario))
                }
                miTabla.reloadData()
                //cargar tabla
            default:
                print ("Ha habido algún error.")
        }
        
        if respuesta == 2 {
          conectarServidor(destino: "actividad", metodo:"GET")
        }
    }
    
    
    private func leerDatosCompletosServidor(){
        
        if self.respuesta != 0 { self.respuesta = 0}
        let metodo = "GET"
        conectarServidor(destino: "profesor", metodo:metodo)
        
        conectarServidor(destino: "grupo", metodo:metodo)
        
        //conectarServidor(destino: "actividad", metodo:metodo)
    }
    
    private func conectarServidor(destino:String,metodo:String,datos:Data? = nil) {
        let cliente = ClienteRest(destino:destino,respuesta:self,metodo:metodo,datos:datos)
        cliente!.request()
    }
    
    //MARK: funciones de tabla
    
    func numberOfSections(in tableView: UITableView) -> Int {
        return 1
    }
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
       return actividades.count//count array
        
    }

    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        
        let cell: miCelda = tableView.dequeueReusableCell(withIdentifier: "celdaTabla", for: indexPath) as! miCelda
        if actividades.count == 0 {
            return cell
        }
        let titulo = actividades[indexPath.row].titulo
        let fecha = actividades[indexPath.row].getFechaCadena()
        let resumen = actividades[indexPath.row].resumen
        
        cell.imageView!.image = UIImage(named: "Image")
        
        if let foto = actividades[indexPath.row].foto {
            // añade  una imagen de una url a un ImageView
            cell.imageView?.image = nil
            ClienteRest.loadImageFromUrl(url: Actividad.URL_IMAGE_FOLDER + foto, view: cell.cImagen)
        }
        
        
        
        cell.cFecha.text = fecha
        cell.cTitulo.text = titulo
        cell.cResumen.text = resumen
        cell.backgroundColor = colorForIndex(index: indexPath.row )
       

        //imagen
        return cell
    }
    
    
    func colorForIndex(index: Int) -> UIColor {
     
        let itemCount=actividades.count
        let color = (CGFloat(index) / CGFloat(itemCount)) * 0.8
        return UIColor(red: 0, green: color, blue: 0.0, alpha: 0.3)
    }
    
   
    
    
    
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) { // evento onclick en celdas
        
        filaSeleccionada = indexPath.row
        self.performSegue(withIdentifier:"SegueActualizar" ,sender:self)
        
    }
    
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if segue.identifier=="SegueNuevo" {
            if let vista = segue.destination as? (ViewActividad) {
                vista.profesores = self.profesores
                vista.grupos = self.grupos
            }
        }
        
        else if segue.identifier=="SegueActualizar" {
            if let vista = segue.destination as? (ViewActividad) {
                vista.profesores = self.profesores
                vista.grupos = self.grupos
                vista.a = actividades[filaSeleccionada]
            }
        }
        
    }
    
  
    //MARK: acciones botones
    
    @IBAction func accionRecargar(_ sender: Any) {
        // reiniciamos todo t volvemos a leer el servidor
        profesores = []
        grupos = []
        actividades = []
        leerDatosCompletosServidor()
    }
       @IBAction func actionBorrar(_ sender: Any) {
        //codigo necesario para borrar una celda
       // miTabla.deleteRows(at: <#T##[IndexPath]#>, with: <#T##UITableViewRowAnimation#>)
        
    }
    

    
    // este codigo se ejecutara cuando volvamos de la actividad a la lista
    @IBAction func unwindToListaActividades(sender: UIStoryboardSegue) {
            if let sourceViewControler = sender.source as? ViewActividad {
                if sourceViewControler.guardarDatosActividad() {
                    sourceViewControler.enviarDatosServidor(respuesta: self)
                }
            }
    }
    
    @IBAction func unwindToListaActividadesBorrar(sender: UIStoryboardSegue) {
        if let sourceViewControler = sender.source as? ViewActividad {
            let cliente = ClienteRest(destino: "actividad/" + String(sourceViewControler.a.id), respuesta: self, metodo: "delete", datos: nil)
            cliente?.request()
        }
    }
    
    private func actualizarDatos() {
        self.respuesta = 0
        profesores.removeAll()
        grupos.removeAll()
        actividades.removeAll()
        leerDatosCompletosServidor()
    }
}

