<?php


abstract class BaseMensajes extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id_mensaje;


	
	protected $texto;


	
	protected $id_usuario;


	
	protected $id_conversacion;


	
	protected $date;

	
	protected $aUsuarios;

	
	protected $aConversaciones;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getIdMensaje()
	{

		return $this->id_mensaje;
	}

	
	public function getTexto()
	{

		return $this->texto;
	}

	
	public function getIdUsuario()
	{

		return $this->id_usuario;
	}

	
	public function getIdConversacion()
	{

		return $this->id_conversacion;
	}

	
	public function getDate($format = 'Y-m-d H:i:s')
	{

		if ($this->date === null || $this->date === '') {
			return null;
		} elseif (!is_int($this->date)) {
						$ts = strtotime($this->date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [date] as date/time value: " . var_export($this->date, true));
			}
		} else {
			$ts = $this->date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setIdMensaje($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id_mensaje !== $v) {
			$this->id_mensaje = $v;
			$this->modifiedColumns[] = MensajesPeer::ID_MENSAJE;
		}

	} 
	
	public function setTexto($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->texto !== $v) {
			$this->texto = $v;
			$this->modifiedColumns[] = MensajesPeer::TEXTO;
		}

	} 
	
	public function setIdUsuario($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id_usuario !== $v) {
			$this->id_usuario = $v;
			$this->modifiedColumns[] = MensajesPeer::ID_USUARIO;
		}

		if ($this->aUsuarios !== null && $this->aUsuarios->getIdUsuario() !== $v) {
			$this->aUsuarios = null;
		}

	} 
	
	public function setIdConversacion($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id_conversacion !== $v) {
			$this->id_conversacion = $v;
			$this->modifiedColumns[] = MensajesPeer::ID_CONVERSACION;
		}

		if ($this->aConversaciones !== null && $this->aConversaciones->getIdConversacion() !== $v) {
			$this->aConversaciones = null;
		}

	} 
	
	public function setDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->date !== $ts) {
			$this->date = $ts;
			$this->modifiedColumns[] = MensajesPeer::DATE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id_mensaje = $rs->getInt($startcol + 0);

			$this->texto = $rs->getString($startcol + 1);

			$this->id_usuario = $rs->getInt($startcol + 2);

			$this->id_conversacion = $rs->getInt($startcol + 3);

			$this->date = $rs->getTimestamp($startcol + 4, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Mensajes object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MensajesPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MensajesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MensajesPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aUsuarios !== null) {
				if ($this->aUsuarios->isModified()) {
					$affectedRows += $this->aUsuarios->save($con);
				}
				$this->setUsuarios($this->aUsuarios);
			}

			if ($this->aConversaciones !== null) {
				if ($this->aConversaciones->isModified()) {
					$affectedRows += $this->aConversaciones->save($con);
				}
				$this->setConversaciones($this->aConversaciones);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MensajesPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setIdMensaje($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MensajesPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aUsuarios !== null) {
				if (!$this->aUsuarios->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUsuarios->getValidationFailures());
				}
			}

			if ($this->aConversaciones !== null) {
				if (!$this->aConversaciones->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aConversaciones->getValidationFailures());
				}
			}


			if (($retval = MensajesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MensajesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getIdMensaje();
				break;
			case 1:
				return $this->getTexto();
				break;
			case 2:
				return $this->getIdUsuario();
				break;
			case 3:
				return $this->getIdConversacion();
				break;
			case 4:
				return $this->getDate();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MensajesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdMensaje(),
			$keys[1] => $this->getTexto(),
			$keys[2] => $this->getIdUsuario(),
			$keys[3] => $this->getIdConversacion(),
			$keys[4] => $this->getDate(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MensajesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setIdMensaje($value);
				break;
			case 1:
				$this->setTexto($value);
				break;
			case 2:
				$this->setIdUsuario($value);
				break;
			case 3:
				$this->setIdConversacion($value);
				break;
			case 4:
				$this->setDate($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MensajesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdMensaje($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTexto($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIdUsuario($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIdConversacion($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDate($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MensajesPeer::DATABASE_NAME);

		if ($this->isColumnModified(MensajesPeer::ID_MENSAJE)) $criteria->add(MensajesPeer::ID_MENSAJE, $this->id_mensaje);
		if ($this->isColumnModified(MensajesPeer::TEXTO)) $criteria->add(MensajesPeer::TEXTO, $this->texto);
		if ($this->isColumnModified(MensajesPeer::ID_USUARIO)) $criteria->add(MensajesPeer::ID_USUARIO, $this->id_usuario);
		if ($this->isColumnModified(MensajesPeer::ID_CONVERSACION)) $criteria->add(MensajesPeer::ID_CONVERSACION, $this->id_conversacion);
		if ($this->isColumnModified(MensajesPeer::DATE)) $criteria->add(MensajesPeer::DATE, $this->date);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MensajesPeer::DATABASE_NAME);

		$criteria->add(MensajesPeer::ID_MENSAJE, $this->id_mensaje);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getIdMensaje();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setIdMensaje($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTexto($this->texto);

		$copyObj->setIdUsuario($this->id_usuario);

		$copyObj->setIdConversacion($this->id_conversacion);

		$copyObj->setDate($this->date);


		$copyObj->setNew(true);

		$copyObj->setIdMensaje(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MensajesPeer();
		}
		return self::$peer;
	}

	
	public function setUsuarios($v)
	{


		if ($v === null) {
			$this->setIdUsuario(NULL);
		} else {
			$this->setIdUsuario($v->getIdUsuario());
		}


		$this->aUsuarios = $v;
	}


	
	public function getUsuarios($con = null)
	{
		if ($this->aUsuarios === null && ($this->id_usuario !== null)) {
						include_once 'lib/model/om/BaseUsuariosPeer.php';

			$this->aUsuarios = UsuariosPeer::retrieveByPK($this->id_usuario, $con);

			
		}
		return $this->aUsuarios;
	}

	
	public function setConversaciones($v)
	{


		if ($v === null) {
			$this->setIdConversacion(NULL);
		} else {
			$this->setIdConversacion($v->getIdConversacion());
		}


		$this->aConversaciones = $v;
	}


	
	public function getConversaciones($con = null)
	{
		if ($this->aConversaciones === null && ($this->id_conversacion !== null)) {
						include_once 'lib/model/om/BaseConversacionesPeer.php';

			$this->aConversaciones = ConversacionesPeer::retrieveByPK($this->id_conversacion, $con);

			
		}
		return $this->aConversaciones;
	}

} 