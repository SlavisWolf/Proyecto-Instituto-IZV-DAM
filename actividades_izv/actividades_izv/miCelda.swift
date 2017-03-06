//
//  miCelda.swift
//  actividades_izv
//
//  Created by dam on 16/2/17.
//  Copyright © 2017 Virginia y Antonio. All rights reserved.
//

import UIKit

class miCelda: UITableViewCell {
    
    @IBOutlet weak var cImagen: UIImageView!
    @IBOutlet weak var cTitulo: UILabel!
    @IBOutlet weak var cResumen: UILabel!
    @IBOutlet weak var cFecha: UILabel!

    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
        
        
    }

}
