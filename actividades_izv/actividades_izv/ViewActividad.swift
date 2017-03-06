//
//  ViewActividad.swift
//  actividades_izv
//
//  Created by LoveApple on 18/02/2017.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//

import Foundation
import UIKit


class ViewActividad:UIViewController,UIImagePickerControllerDelegate,UINavigationControllerDelegate   {
    
     // variables
    
    
    @IBOutlet weak var etTitulo: UITextField!
    @IBOutlet weak var tvDescripcion: UITextView!
    @IBOutlet weak var imagenActividad: UIImageView!
    @IBOutlet weak var FechaLa: UILabel!
    @IBOutlet weak var SalidaLa: UILabel!
    @IBOutlet weak var VueltaLa: UILabel!
    @IBOutlet weak var ProfesorLa: UILabel!
    @IBOutlet weak var grupoLa: UILabel!
    @IBOutlet weak var btEdit: UIBarButtonItem!
    @IBOutlet weak var Scroller: UIScrollView!
    @IBOutlet weak var detalles: UIStackView!
    
    

    public var a:Actividad = Actividad()
    //public var posicion:Int = -1
    //estas 2 variables almacenaran los profesores que se mostraran en el dialogo
    
    public var profesores:[Profesor] = []
    public var grupos:[Grupo] = []
    public var profesoresDialog:[[String:String]] = []
    public var gruposDialog:[[String:String]] = []
    
    private var fotoHaCambiado = false
    
   
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        //vista.addSubview(Scroller)
        
        //MARK : scroll 
        
        
         /*Scroller.isScrollEnabled = true
        Scroller.addSubview(imagenActividad)
        Scroller.addSubview(detalles)
        Scroller.contentSize.height=20000
        Scroller.contentSize.width=10000
        
        
        
        //scroller.contentSize  = CGSize(width: 400, height: 2400)
        Scroller.autoresizingMask = UIViewAutoresizing.flexibleHeight
        */
        if a.id != -1        { // si editamos una actividad saltara esto
            etTitulo.text = a.titulo
            tvDescripcion.text = a.descripcion
            FechaLa.text = a.getFechaCadena()
            SalidaLa.text = a.getHoraSalidaCadena12h()
            VueltaLa.text = a.getHoraVueltaCadena12h()
            ProfesorLa.text = a.profesor!.nombreCompleto
            grupoLa.text = a.grupo!.curso
            if let foto = self.a.foto {
                ClienteRest.loadImageFromUrl(url: Actividad.URL_IMAGE_FOLDER + foto, view: self.imagenActividad)
            }
        }
        
        else { // activamos los enabled
            
            
            etTitulo.isEnabled = true
            tvDescripcion.isEditable = true
            FechaLa.isUserInteractionEnabled = true
            SalidaLa.isUserInteractionEnabled = true
            VueltaLa.isUserInteractionEnabled = true
            ProfesorLa.isUserInteractionEnabled = true
            grupoLa.isUserInteractionEnabled = true
            btEdit.tintColor = UIColor.green
        }
        
        //INICIALIZAR LOS ELEMENTOS DE LOS DIALOGOS
        
        for p in profesores {
            profesoresDialog.append(["value" : String(p.id),"display" : p.nombreCompleto])
        }
        
        
        for g in grupos {
            gruposDialog.append(["value":String(g.id),"display":g.curso])
        }
        
        //GESTORES RECOGNIZER PARA AÑADIR EVENTO ONCLICK A LOS LABELS
        
        //PROFESOR
        let profeGestureRecognizer = UITapGestureRecognizer(target: self, action: #selector(ViewActividad.tapProfesor))
        ProfesorLa.addGestureRecognizer(profeGestureRecognizer)
        
        //GRUPO
        let grupoGestureRecognizer = UITapGestureRecognizer(target: self, action: #selector(ViewActividad.tapGrupo))
        grupoLa.addGestureRecognizer(grupoGestureRecognizer)
        
        //FECHA
        let fechaGestureRecognizer = UITapGestureRecognizer(target: self, action: #selector(ViewActividad.tapFecha))
        FechaLa.addGestureRecognizer(fechaGestureRecognizer)
        
        //HORA_SALIDA
        let salidaGestureRecognizer = UITapGestureRecognizer(target: self, action: #selector(ViewActividad.tapSalida))
        SalidaLa.addGestureRecognizer(salidaGestureRecognizer)
        
        //HORA_VUELTA
        let vueltaGestureRecognizer = UITapGestureRecognizer(target: self, action: #selector(ViewActividad.tapVuelta))
        VueltaLa.addGestureRecognizer(vueltaGestureRecognizer)
        
        //IMAGEN
        
        let imagenGestureRecognizer = UITapGestureRecognizer(target: self, action: #selector(ViewActividad.tapImagen))
        imagenActividad.addGestureRecognizer(imagenGestureRecognizer)
    }
    

    
    
    
    
    func tapImagen(gestureRecognizer: UIGestureRecognizer) {
        
        print("el recognizer funciona")
        
        var imagePicker = UIImagePickerController()
        imagePicker.delegate = self
        imagePicker.allowsEditing = true
        imagePicker.sourceType = UIImagePickerControllerSourceType.photoLibrary
        self.present(imagePicker, animated: true, completion: nil)
    }
    
    
    func tapProfesor(gestureRecognizer: UIGestureRecognizer) {
        
        PickerDialog().show( "Profesores",doneButtonTitle: "Aceptar", cancelButtonTitle: "Cancelar", options: profesoresDialog, selected: a.profesor != nil ? String(a.profesor!.id) : nil) {
            (value) -> Void in
            
            let valor = Int((value))!
            self.a.profesor =  self.profesores.filter({$0.id == valor}).first //asignamos a actividad el profesor seleccionado
            self.ProfesorLa.text = self.a.profesor!.nombreCompleto
        }
    }
    
    func tapGrupo(gestureRecognizer: UIGestureRecognizer) {
        
        PickerDialog().show( "Grupos",doneButtonTitle: "Aceptar", cancelButtonTitle: "Cancelar", options: gruposDialog, selected: a.grupo != nil ? String(a.grupo!.id) : nil) {
            (value) -> Void in
            
            let valor = Int((value))!
            self.a.grupo =  self.grupos.filter({$0.id == valor}).first //asignamos a actividad el profesor seleccionado
            self.grupoLa.text = self.a.grupo!.curso
        }
        
    }
    
    func tapFecha(gestureRecognizer: UIGestureRecognizer) {
        
        let fechaMinima = Date().addingTimeInterval(172800) // la fecha minima son 2 dias despues del dia actual.
        let fechaMaxima = self.obtenerFechaMaximaDatePickerDialog()
        
        
        DatePickerDialog().show("Fecha Actividad", doneButtonTitle: "Aceptar", cancelButtonTitle: "Cancelar",defaultDate:self.a.fecha,minimumDate: fechaMinima,maximumDate: fechaMaxima, datePickerMode: .date) {
            (date) -> Void in
            
            if ((date) != nil) {
                self.a.fecha = (date)!
                self.FechaLa.text = self.a.getFechaCadenaSpain()
            }
        }
    }
    
    
    func tapSalida(gestureRecognizer: UIGestureRecognizer) {
        
        DatePickerDialog().show("Hora de Salida", doneButtonTitle: "Aceptar", cancelButtonTitle: "Cancelar",defaultDate:self.a.hora_salida, datePickerMode: .time) {
            (date) -> Void in
            
            if ((date) != nil) {
                self.a.hora_salida = (date)!
                self.SalidaLa.text = self.a.getHoraSalidaCadena12h()
            }
        }
    }
    
    
    func tapVuelta(gestureRecognizer: UIGestureRecognizer) {
        
        DatePickerDialog().show("Hora de Vuelta", doneButtonTitle: "Aceptar", cancelButtonTitle: "Cancelar",defaultDate:self.a.hora_vuelta, datePickerMode: .time) {
            (date) -> Void in
            
            if ((date) != nil) {
                self.a.hora_vuelta = (date)!
                self.VueltaLa.text = self.a.getHoraVueltaCadena12h()
            }
        }
    }
    
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    private func obtenerFechaMaximaDatePickerDialog () -> Date {
        let formateadorFecha = DateFormatter()
        
        formateadorFecha.dateFormat = "YYYY"
        var annoActual = Int(formateadorFecha.string(from: Date()))! // obtenemos el año actual
        formateadorFecha.dateFormat = "M"
        let mesActual = Int(formateadorFecha.string(from: Date()))! // obtenemos el mes actual
        let rango = 9 ... 12 // rango de meses, desde septiembre hasta diciembre para el inicio del curso
        if rango.contains(mesActual)  { // para comptemplar el hecho de que el curso empieza en septiembre, pero acaba al año siguiente.
            annoActual += 1
        }
        
        formateadorFecha.dateFormat = "YYYY-M-dd"
        return formateadorFecha.date(from: String (annoActual) + "-6-13")! // hemos decidido que el 13 de junio es el ultimo dia de ese año en el que se pueden  programar excursiones
        
    }
    
    
    public func enviarDatosServidor(respuesta:ResponseReceiber) {
        
        if self.fotoHaCambiado {
            let fechaUnix = String (Date.timeIntervalSinceReferenceDate )
            let quitarPunto = fechaUnix.replacingOccurrences(of: ".", with: "")
            let imagenName = String (self.a.id) + quitarPunto + ".jpg" // subir fotos al servidor
            self.a.foto = imagenName
            ClienteRest.uploadImageToUrl(urlCadena: Actividad.URL_SUBIR_IMAGENES, imagen: self.imagenActividad.image!, nombreImagen: imagenName)
        }
        
        
        if let datos = try? JSONSerialization.data(withJSONObject: self.a.actividadToDiccionario(), options: []) { //convertimos el objeto actividad a Json
            
            var destino = "actividad"
            let metodo:String
            
            if  self.a.id != -1 { // UPDATE
                destino += "/" + String(self.a.id) // indicamos que actividad queremos actualizar
                metodo = "put" // indicamos que la consulta es tipo update
            }
            else { // INSERT
                metodo = "post"
            }
            ClienteRest(destino:destino,respuesta:respuesta,metodo:metodo,datos:datos)?.request()
        }
        
    }
    
    
    public func guardarDatosActividad() ->Bool {
        let titulo = self.etTitulo.text
        let descripcion = self.tvDescripcion.text
        let fecha = self.FechaLa.text
        let salida = self.SalidaLa.text
        let vuelta = self.VueltaLa.text
        let profe = self.ProfesorLa.text
        let grupo = self.grupoLa.text
        
        //Comprobamos que todos los campos tienen valor  o no son nulos excepto la foto que va aparte.
        if (titulo ?? "").isEmpty || (descripcion ?? "").isEmpty || (fecha ?? "").isEmpty || (salida ?? "").isEmpty || (vuelta ?? "").isEmpty || (profe ?? "").isEmpty || (grupo ?? "").isEmpty {
            
            print ("false")
            return false
        }
        
        //print ("entra donde no debe")
        self.a.titulo = titulo!
        self.a.descripcion = descripcion!
        // fecha no es necesario puesto que se añade a la actividad en el momento en que se cambia al igual que salida, vuelta, grupos  y profesores
        return true
        
    }
    
    @IBAction func accionEditar(_ sender: Any) {
        cambiarEditable()
    }
    private func cambiarEditable() {
        etTitulo.isEnabled = !etTitulo.isEnabled
        tvDescripcion.isEditable = !tvDescripcion.isEditable
        FechaLa.isUserInteractionEnabled = !FechaLa.isUserInteractionEnabled
        SalidaLa.isUserInteractionEnabled = !SalidaLa.isUserInteractionEnabled
        VueltaLa.isUserInteractionEnabled = !VueltaLa.isUserInteractionEnabled
        ProfesorLa.isUserInteractionEnabled = !ProfesorLa.isUserInteractionEnabled
        grupoLa.isUserInteractionEnabled = !grupoLa.isUserInteractionEnabled
        
        self.btEdit.tintColor = etTitulo.isEnabled ? UIColor.green : UIColor.purple
    }
    
    // añadido para la galeria
    func imagePickerController(_ picker: UIImagePickerController, didFinishPickingMediaWithInfo info: [String : Any]) {
        
        self.fotoHaCambiado = true
        imagenActividad.image = info[UIImagePickerControllerOriginalImage] as? UIImage
        self.dismiss(animated: true, completion: nil)
        
    }
}
