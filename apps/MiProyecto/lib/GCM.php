<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Esta clase tendra un metodo, el metodo que envia los datos a los servidores
 * de google.
 */
 class GCM {

    //URL a la que enviaremos los datos
    var $GCM_URL = 'https://android.googleapis.com/gcm/send';
    //
    var $apikey = "AIzaSyBIAjFIj1DkmQqPTRne8qhtUIqk4qj7NCQ";

    ////////////////////////////////////////

    public function sendGCM($reg1, $mensaje) {

        // Reemplazar con la verdadera clave de la API del servidor de Google APIs 

        // Reemplazar con el registro de un cliente verdadero IDs 
        $registrationIDs = array($reg1, $mensaje);
       // echo '<br>'.$reg1;
       // echo '<br>'.$mensaje.'<br>';
        // Mensaje que se enviará 
        //$mensaje = "Mensaje enviado directamente desde el servidor";
        //echo $mensaje;
        if ($mensaje instanceof Mensajes) {
            
            $temp = array("id" => $mensaje->getPrimaryKey(),
                            "texto" => $mensaje->getTexto(),
                            "idConver" => $mensaje->getIdConversacion(),
                            "idUsuario" => $mensaje->getIdUsuario());
            
            
            $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => array("mensaje" => $temp),
        );
        }
        $headers = array(
            'Authorization:key = ' . $this->apikey,
            'Content-Type: application/json'
        );

        // Abrir la conexión 
        $ch = curl_init();
        
        // Establecer el URL, número de la POST vars, POST   
        curl_setopt($ch, CURLOPT_URL, $this->GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($fields));


        // Ejecutar mensaje 
        $result = curl_exec($ch);

        // Cerrar la conexión 
        curl_close($ch);
        
       // echo is_null($result);
       
      //  echo $result;
        
    }
    
    

}
