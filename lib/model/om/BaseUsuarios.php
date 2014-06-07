<?php


abstract class BaseUsuarios extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id_usuario;


	
	protected $nombre;


	
	protected $telefono;


	
	protected $estado;

	
	protected $collMensajess;

	
	protected $lastMensajesCriteria = null;

	
	protected $collUsuConvs;

	
	protected $lastUsuConvCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getIdUsuario()
	{

		return $this->id_usuario;
	}

	
	public function getNombre()
	{

		return $this->nombre;
	}

	
	public function getTelefono()
	{

		return $this->telefono;
	}

	
	public function getEstado()
	{

		return $this->estado;
	}

	
	public function setIdUsuario($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id_usuario !== $v) {
			$this->id_usuario = $v;
			$this->modifiedColumns[] = UsuariosPeer::ID_USUARIO;
		}

	} 
	
	public function setNombre($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nombre !== $v) {
			$this->nombre = $v;
			$this->modifiedColumns[] = UsuariosPeer::NOMBRE;
		}

	} 
	
	public function setTelefono($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->telefono !== $v) {
			$this->telefono = $v;
			$this->modifiedColumns[] = UsuariosPeer::TELEFONO;
		}

	} 
	
	public function setEstado($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->estado !== $v) {
			$this->estado = $v;
			$this->modifiedColumns[] = UsuariosPeer::ESTADO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id_usuario = $rs->getInt($startcol + 0);

			$this->nombre = $rs->getString($startcol + 1);

			$this->telefono = $rs->getInt($startcol + 2);

			$this->estado = $rs->getString($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Usuarios object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UsuariosPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			UsuariosPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(UsuariosPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = UsuariosPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setIdUsuario($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += UsuariosPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMensajess !== null) {
				foreach($this->collMensajess as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUsuConvs !== null) {
				foreach($this->collUsuConvs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

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


			if (($retval = UsuariosPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMensajess !== null) {
					foreach($this->collMensajess as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUsuConvs !== null) {
					foreach($this->collUsuConvs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UsuariosPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getIdUsuario();
				break;
			case 1:
				return $this->getNombre();
				break;
			case 2:
				return $this->getTelefono();
				break;
			case 3:
				return $this->getEstado();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UsuariosPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdUsuario(),
			$keys[1] => $this->getNombre(),
			$keys[2] => $this->getTelefono(),
			$keys[3] => $this->getEstado(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UsuariosPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setIdUsuario($value);
				break;
			case 1:
				$this->setNombre($value);
				break;
			case 2:
				$this->setTelefono($value);
				break;
			case 3:
				$this->setEstado($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UsuariosPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdUsuario($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNombre($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTelefono($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEstado($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(UsuariosPeer::DATABASE_NAME);

		if ($this->isColumnModified(UsuariosPeer::ID_USUARIO)) $criteria->add(UsuariosPeer::ID_USUARIO, $this->id_usuario);
		if ($this->isColumnModified(UsuariosPeer::NOMBRE)) $criteria->add(UsuariosPeer::NOMBRE, $this->nombre);
		if ($this->isColumnModified(UsuariosPeer::TELEFONO)) $criteria->add(UsuariosPeer::TELEFONO, $this->telefono);
		if ($this->isColumnModified(UsuariosPeer::ESTADO)) $criteria->add(UsuariosPeer::ESTADO, $this->estado);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(UsuariosPeer::DATABASE_NAME);

		$criteria->add(UsuariosPeer::ID_USUARIO, $this->id_usuario);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getIdUsuario();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setIdUsuario($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNombre($this->nombre);

		$copyObj->setTelefono($this->telefono);

		$copyObj->setEstado($this->estado);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMensajess() as $relObj) {
				$copyObj->addMensajes($relObj->copy($deepCopy));
			}

			foreach($this->getUsuConvs() as $relObj) {
				$copyObj->addUsuConv($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setIdUsuario(NULL); 
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
			self::$peer = new UsuariosPeer();
		}
		return self::$peer;
	}

	
	public function initMensajess()
	{
		if ($this->collMensajess === null) {
			$this->collMensajess = array();
		}
	}

	
	public function getMensajess($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMensajesPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMensajess === null) {
			if ($this->isNew()) {
			   $this->collMensajess = array();
			} else {

				$criteria->add(MensajesPeer::ID_USUARIO, $this->getIdUsuario());

				MensajesPeer::addSelectColumns($criteria);
				$this->collMensajess = MensajesPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MensajesPeer::ID_USUARIO, $this->getIdUsuario());

				MensajesPeer::addSelectColumns($criteria);
				if (!isset($this->lastMensajesCriteria) || !$this->lastMensajesCriteria->equals($criteria)) {
					$this->collMensajess = MensajesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMensajesCriteria = $criteria;
		return $this->collMensajess;
	}

	
	public function countMensajess($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMensajesPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MensajesPeer::ID_USUARIO, $this->getIdUsuario());

		return MensajesPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMensajes(Mensajes $l)
	{
		$this->collMensajess[] = $l;
		$l->setUsuarios($this);
	}


	
	public function getMensajessJoinConversaciones($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMensajesPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMensajess === null) {
			if ($this->isNew()) {
				$this->collMensajess = array();
			} else {

				$criteria->add(MensajesPeer::ID_USUARIO, $this->getIdUsuario());

				$this->collMensajess = MensajesPeer::doSelectJoinConversaciones($criteria, $con);
			}
		} else {
									
			$criteria->add(MensajesPeer::ID_USUARIO, $this->getIdUsuario());

			if (!isset($this->lastMensajesCriteria) || !$this->lastMensajesCriteria->equals($criteria)) {
				$this->collMensajess = MensajesPeer::doSelectJoinConversaciones($criteria, $con);
			}
		}
		$this->lastMensajesCriteria = $criteria;

		return $this->collMensajess;
	}

	
	public function initUsuConvs()
	{
		if ($this->collUsuConvs === null) {
			$this->collUsuConvs = array();
		}
	}

	
	public function getUsuConvs($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseUsuConvPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsuConvs === null) {
			if ($this->isNew()) {
			   $this->collUsuConvs = array();
			} else {

				$criteria->add(UsuConvPeer::ID_USUARIO, $this->getIdUsuario());

				UsuConvPeer::addSelectColumns($criteria);
				$this->collUsuConvs = UsuConvPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(UsuConvPeer::ID_USUARIO, $this->getIdUsuario());

				UsuConvPeer::addSelectColumns($criteria);
				if (!isset($this->lastUsuConvCriteria) || !$this->lastUsuConvCriteria->equals($criteria)) {
					$this->collUsuConvs = UsuConvPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUsuConvCriteria = $criteria;
		return $this->collUsuConvs;
	}

	
	public function countUsuConvs($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseUsuConvPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UsuConvPeer::ID_USUARIO, $this->getIdUsuario());

		return UsuConvPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addUsuConv(UsuConv $l)
	{
		$this->collUsuConvs[] = $l;
		$l->setUsuarios($this);
	}


	
	public function getUsuConvsJoinConversaciones($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseUsuConvPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsuConvs === null) {
			if ($this->isNew()) {
				$this->collUsuConvs = array();
			} else {

				$criteria->add(UsuConvPeer::ID_USUARIO, $this->getIdUsuario());

				$this->collUsuConvs = UsuConvPeer::doSelectJoinConversaciones($criteria, $con);
			}
		} else {
									
			$criteria->add(UsuConvPeer::ID_USUARIO, $this->getIdUsuario());

			if (!isset($this->lastUsuConvCriteria) || !$this->lastUsuConvCriteria->equals($criteria)) {
				$this->collUsuConvs = UsuConvPeer::doSelectJoinConversaciones($criteria, $con);
			}
		}
		$this->lastUsuConvCriteria = $criteria;

		return $this->collUsuConvs;
	}

} 