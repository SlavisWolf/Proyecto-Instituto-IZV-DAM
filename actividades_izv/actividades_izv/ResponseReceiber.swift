//
//  ResponseReceiber.swift
//  actividades_izv
//
//  Created by dam on 8/2/17.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//

import Foundation

protocol ResponseReceiber { // protocolo es lo equivalente a una interfaz en Jav
    
    func onDataReceived(data:Data)
    func onErrorReceivingData(message:String)
}
