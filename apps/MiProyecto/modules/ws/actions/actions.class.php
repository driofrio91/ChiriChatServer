<?php

/**
 * ws actions.
 *
 * @package    MiProyecto
 * @subpackage ws
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class wsActions extends sfActions {
//http://prueba.local/ws/createConversacion?json={%22Owner%22:%22Danny%22,%22Nombre%22:%220%22:{%22Nombre%22:%22Danny%22,%22telefono%22:%2269696966%22,%22estado%22:%22%22},%221%22:{%22Nombre%22:%22Alejandro%22,%22telefono%22:%22454545454%22,%22estado%22:%22%22}}
//    /**
//     * Executes index action
//     *
//     */
//    public function executeIndex() {
//        //$this->forward('default', 'module');
//        $this->saludo = 'Hola Mundo';
//    }
//
//    public function executeAccion2() {
//        $this->saludo = 'hola mundo 2';
//    }
//
//    public function executeRecibir() {
//        $json = json_decode($_REQUEST['json'], true);
//        if (is_array($json)) {
//            error_log('entro en el if');
//            $this->json = $json;
//        }
//    }

    /**
     * Metodo que nos devolvera una lista de usuarios actuales
     * @return type
     */
    public function executeUsuarios() {

        $peticion = json_decode($_REQUEST['json'],TRUE);
        
        $allUsers = array();
        
            $c = new Criteria();

            $c->add(UsuariosPeer::TELEFONO, $peticion['Telefono'], Criteria::NOT_EQUAL);
            
            $usuarios = UsuariosPeer::doSelect($c);

            foreach ($usuarios as $valor) {
                
                $users = array('id_usuario' => $valor->getIdUsuario(),
                    'nombre' => $valor->getNombre(),
                    'telefono' => $valor->getTelefono(),
                    'estado' => $valor->getEstado());
                  //  echo var_export($users);
                array_push($allUsers, $users);
            

            
        }
        $this->json_users = $this->getJson($allUsers);
    }

    public function executeInsertUsuario() {

        $jsonNewUser = json_decode($_REQUEST['json'], true);
        //Comprobamos que json nos devuelva una array
        if (is_array($jsonNewUser)) {
            //Compruebo si el telefono que nos ha dado el usuario ya existe
            $c = new Criteria();

            $c->add(UsuariosPeer::TELEFONO, $jsonNewUser['telefono']);

            $usuario = UsuariosPeer::doSelectOne($c);

            if ($usuario instanceof Usuarios) {

                $usuario->setNombre($jsonNewUser['nombre']);
                $usuario->setEstado($jsonNewUser['estado']);
                $usuario->save();
            } else {

                if (!is_array($usuario)) {

                    //Creamos el nuevo usuario
                    $usuario = new Usuarios();
                    $usuario->setNombre($jsonNewUser['nombre']);
                    $usuario->setTelefono($jsonNewUser['telefono']);
                    $usuario->setEstado($jsonNewUser['estado']);

                    $usuario->save();

                    $id = $usuario->getPrimaryKey();
                    //Creamos un JSON con los datos del usuario
                    //Esto es de prueba para ver que se crea, el cliente
                    //no tiene que conocer su id en la DB 
                    $jsonUser = array('nombre' => $usuario->getNombre(),
                        'telefono' => $usuario->getTelefono(),
                        'estado' => $usuario->getEstado(),
                        'id_usuario' => $usuario->getPrimaryKey());
                    //llamamos la metodo que nos devulve un json
                    $this->Usuario = $this->getJson($jsonUser);

                    // $temp = new GCM();
                    // $temp->sendGCM(array());
                }
            }
            $JsonOldUser = array('nombre' => $usuario->getNombre(),
                'telefono' => $usuario->getTelefono(),
                'estado' => $usuario->getEstado(),
                'id_usuario' => $usuario->getPrimaryKey());

            $this->Usuario = $this->getJson($JsonOldUser);
        } else {
            //Codigo para enviar el response code
        }
    }

    /**
     * Metodo que nos crera una nueva conversacion.
     */
    public function executeCreateConversacion() {

        $peticion = json_decode($_REQUEST['json'], true);
        //Compruebo que so la perticion que me ha llegado es un array
        if (is_array($peticion)) {
            //Creo el objeto conversacon
            $conversacion = new Conversaciones();
            $temp = $peticion['owner'];
            error_log($temp.'antes de guardar conversacion');
            
            $conversacion->setPropietario($peticion['owner']);
            $conversacion->setNombre($peticion['nombre']);

            $conversacion->save();

            //Recuper la array de participantes de la conversacion
            $participantes = $peticion['participantes'];

            //Compruebo que la array de participantes es una array
            if (is_array($participantes)) {
                /* @var $participantes arrayList con los datos del los usuarios
                 * que participan en esa conversacion.
                 * Por cada participante genero un registro en la tabla USU-CONV */
                foreach ($participantes as $usuario) {

                    $usu_conver = new UsuConv();
                    $usu_conver->setIdUsuario($usuario['id_usuario']);
                    error_log("Despues de insertar el id");
                    $usu_conver->setIdConversacion($conversacion->getPrimaryKey());
                    error_log('key conversation'. $conversacion->getPrimaryKey());
                   
                    $usu_conver->save();
                    error_log("despues de guardar");
                }
                
                $resultDispositivo = array('id_conver' => $usu_conver->getIdConversacion(),
                    'nombre' => $conversacion->getNombre(),
                    'participantes' => $participantes);
                
                $this->result = $this->getJson($resultDispositivo);
            }
        }
    }

    /**
     * Metodo que recivira un JSON con los datos de la conversacion a borrar
     */
    public function executeDeleteConversacion() {

        $peticion = json_decode($_REQUEST['json'], true);

        if (is_array($peticion)) {


            $id_conversacion = $peticion['id'];

            $propietario = $peticion['owner'];

            //Criteria para comprobar que existe esa conversacion
            $c = new Criteria();

            $c->add(ConversacionesPeer::ID_CONVERSACION, $id_conversacion);

            $c->add(ConversacionesPeer::PROPIETARIO, $propietario);

            $conversacion = ConversacionesPeer::doSelectOne($c);

            //Si el resultado es una instancia de CONVERSACIONES la eliminara
            if ($conversacion instanceof Conversaciones) {


                $conversacion->delete();
            }
        } else {
            //Aqui voy aponer el response por si el JSON no es valido
        }
    }

    /**
     * Metodo que guardara un nuevo mensaje perteneciente a la conversacion, 
     * llamara al metodo @see RecuperarID(), pasandole un ID de conversacion, 
     * y el id del usuario al que pertenece el mensaje, 
     * 
     * 
     */
    public function executeNewMensaje() {

        $json = json_decode($_REQUEST['json'], true);

        if (is_array($json)) {
            //Aqui recupero los datos del mensaje y creo el objeto mensaje
            $mensaje = new Mensajes();
            
            $mensaje->setTexto($json['texto']);
            $mensaje->setIdUsuario($json['idUsuario']);
            $mensaje->setIdConversacion($json['idConver']);
            $mensaje->setDate(date(DATE_RFC2822));

            $mensaje->save();

            $newMensaje = array('id' => $mensaje->getPrimaryKey(),
                'texto' => $mensaje->getTexto(),
                'idUsuario' => $mensaje->getIdUsuario(),
                'idConver' => $mensaje->getIdConversacion());
            
            $this->mensaje = $this->getJson($newMensaje);
        } else {
            //Datos del response no validos
            
        }
    }

    /**
     * Metodo que me devolvera todos los mensajes, mayores al id que le pase
     * 
     */
    public function executeRecuperarMensajes() {

        $peticion = json_decode($_REQUEST['json'], true);

        if (is_array($peticion)) {

            echo 'Despues del if';
            $c = new Criteria();
            $c->add(MensajesPeer::ID_CONVERSACION, $peticion['idConversacion']);
            $c->add(MensajesPeer::ID_MENSAJE, $peticion['idMensaje'], Criteria::GREATER_EQUAL);
            $mensajes = MensajesPeer::doSelect($c);

            if (is_array($mensajes)) {

                $mensajesPedidos = array();

                foreach ($mensajes as $value) {

                    $mensaje = array(
                        'idMensaje' => $value->getIdMensaje(),
                        'texto' => $value->getTexto(),
                        'idUsuario' => $value->getIdUsuario(),
                        'idConversacion' => $value->getIdConversacion(),
                        'date' => $value->getDate());

                    array_push($mensajesPedidos, $mensaje);
                }

                $this->mensajesPedidos = $this->getJson($mensajesPedidos);
            } else {
                //No hay mensajes
            }
        } else {
            //JSON mal formado, no recubo una array
            $this->mensajesPedidos = 'JSON mal formado';
        }
    }

    /**
     * Comantada la linea del comienzo del metodo que le pasa un IdConversacion,
     * para pruebas le paso un id por POST
     */
//    public function executeRecuperarId() {
    /**
     * Metodo que obtendra todos los id de los usuarios que pertenezcan a una 
     * conversacion y se los pasara al metodo @see EnviarMensaje().
     * 
     * @param type $idConversacion
     * @param type $idOrigen
     * $mensaje->getIdConversacion(), $mensaje->getIdUsuario(), 
     */
    public function RecuperarID($mensaje) {
//        //Compruebo si la conversacion existe
//        //////////////////////
//        $idConversacion = $_REQUEST['id'];
//        $idOrigen = $_REQUEST['origen'];
//        /////////////////////
        echo 'recperando id';
        $c = new Criteria();

        $c->add(ConversacionesPeer::ID_CONVERSACION, $mensaje->getIdConversacion());

        $conversacion = ConversacionesPeer::doSelectOne($c);
        //Conpruebo que el resultado es una instancia de conversaciones
        if ($conversacion instanceof Conversaciones) {
            echo 'la comversacion existe';
            $cUSU_CONV = new Criteria();

            $cUSU_CONV->add(UsuConvPeer::ID_CONVERSACION, $mensaje->getIdConversacion());

            $cUSU_CONV->addSelectColumn(UsuConvPeer::ID_USUARIO);

            $usu_conv = UsuConvPeer::doSelectRS($cUSU_CONV);

            while ($usu_conv->next()) {
                echo 'enviando id de usuario';
                $idEviar = $usu_conv->get(1);

                //TODO Linea que evita que te llegen tus propios mensajes
                // if ($idEviar != $mensaje->getIdUsuario()) {
                //Enviar el mensaje
                echo $idEviar . 'Recibe ====== Envia' . $mensaje->getIdUsuario();
                $this->EnviarMensaje($idEviar, $mensaje);
                //  }
            }
        }
    }

    /**
     * 
     * Metoto al que se le pasara el IdUsuario y recuperar el ID del GCM preteneciente
     * a ese usuario y llamara al metodo @see sendGCM() (que es el que envia las notificaciones
     * push) pasandole el id del GCM.
     * 
     * @param type $idUsuario
     */
    public function EnviarMensaje($idUsuario, $mensaje) {
        echo 'Metodo enviar mensaje';
        $c = new Criteria();

        $c->add(UsuariosPeer::ID_USUARIO, $idUsuario);

        $c->addSelectColumn(UsuariosPeer::ID_GCM);

        $result = UsuariosPeer::doSelectRS($c);

        while ($result->next()) {
            echo 'Enviando los push a la clase';
            // echo $mensaje;
            $gcm = new GCM();
            $gcm->sendGCM($result->get(1), $mensaje);
            //Eviar sl GCM
        }
    }

    /**
     * Metotod que recive el telefono del usuario y me devuelve su ID. 
     * 
     * @param type $telefono
     * @return null
     */
    public function getIDUsuario($telefono) {

        $c = new Criteria();

        $c->add(UsuariosPeer::TELEFONO, $telefono);

        //$c->addSelectColumn(UsuariosPeer::ID_USUARIO);
        $usuario = UsuariosPeer::doSelectOne($c);

        if ($usuario instanceof Usuarios) {

            return $usuario->getIdUsuario();
        } else {
            return null;
        }
    }

    ////////////////////////////////////////
    ////////////////Metodos/////////////////
    ////////////////////////////////////////

    /**
     * Metodo que convierte una array de objetos en un JSON
     * @param type $json
     * @return type JSON Object
     */
    public function getJson($json) {

        //header('Content-type: application/json');
        //$this->getResponse()->setContentType('application/json');
        $this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $json_users = json_encode($json);

        return $json_users;
    }

}
