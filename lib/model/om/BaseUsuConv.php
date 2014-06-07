<?php


abstract class BaseUsuConv extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id_usuario;


	
	protected $id_conversacion;

	
	protected $aUsuarios;

	
	protected $aConversaciones;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getIdUsuario()
	{

		return $this->id_usuario;
	}

	
	public function getIdConversacion()
	{

		return $this->id_conversacion;
	}

	
	public function setIdUsuario($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id_usuario !== $v) {
			$this->id_usuario = $v;
			$this->modifiedColumns[] = UsuConvPeer::ID_USUARIO;
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
			$this->modifiedColumns[] = UsuConvPeer::ID_CONVERSACION;
		}

		if ($this->aConversaciones !== null && $this->aConversaciones->getIdConversacion() !== $v) {
			$this->aConversaciones = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id_usuario = $rs->getInt($startcol + 0);

			$this->id_conversacion = $rs->getInt($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating UsuConv object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UsuConvPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			UsuConvPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(UsuConvPeer::DATABASE_NAME);
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
					$pk = UsuConvPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += UsuConvPeer::doUpdate($this, $con);
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


			if (($retval = UsuConvPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UsuConvPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getIdUsuario();
				break;
			case 1:
				return $this->getIdConversacion();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UsuConvPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdUsuario(),
			$keys[1] => $this->getIdConversacion(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UsuConvPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setIdUsuario($value);
				break;
			case 1:
				$this->setIdConversacion($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UsuConvPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdUsuario($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIdConversacion($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(UsuConvPeer::DATABASE_NAME);

		if ($this->isColumnModified(UsuConvPeer::ID_USUARIO)) $criteria->add(UsuConvPeer::ID_USUARIO, $this->id_usuario);
		if ($this->isColumnModified(UsuConvPeer::ID_CONVERSACION)) $criteria->add(UsuConvPeer::ID_CONVERSACION, $this->id_conversacion);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(UsuConvPeer::DATABASE_NAME);

		$criteria->add(UsuConvPeer::ID_USUARIO, $this->id_usuario);
		$criteria->add(UsuConvPeer::ID_CONVERSACION, $this->id_conversacion);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getIdUsuario();

		$pks[1] = $this->getIdConversacion();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setIdUsuario($keys[0]);

		$this->setIdConversacion($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setIdUsuario(NULL); 
		$copyObj->setIdConversacion(NULL); 
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
			self::$peer = new UsuConvPeer();
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