<?php


abstract class BaseConversaciones extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id_conversacion;


	
	protected $nombre;


	
	protected $propietario;

	
	protected $collMensajess;

	
	protected $lastMensajesCriteria = null;

	
	protected $collUsuConvs;

	
	protected $lastUsuConvCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getIdConversacion()
	{

		return $this->id_conversacion;
	}

	
	public function getNombre()
	{

		return $this->nombre;
	}

	
	public function getPropietario()
	{

		return $this->propietario;
	}

	
	public function setIdConversacion($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id_conversacion !== $v) {
			$this->id_conversacion = $v;
			$this->modifiedColumns[] = ConversacionesPeer::ID_CONVERSACION;
		}

	} 
	
	public function setNombre($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nombre !== $v) {
			$this->nombre = $v;
			$this->modifiedColumns[] = ConversacionesPeer::NOMBRE;
		}

	} 
	
	public function setPropietario($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->propietario !== $v) {
			$this->propietario = $v;
			$this->modifiedColumns[] = ConversacionesPeer::PROPIETARIO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id_conversacion = $rs->getInt($startcol + 0);

			$this->nombre = $rs->getString($startcol + 1);

			$this->propietario = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Conversaciones object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ConversacionesPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ConversacionesPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ConversacionesPeer::DATABASE_NAME);
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
					$pk = ConversacionesPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setIdConversacion($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ConversacionesPeer::doUpdate($this, $con);
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


			if (($retval = ConversacionesPeer::doValidate($this, $columns)) !== true) {
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
		$pos = ConversacionesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getIdConversacion();
				break;
			case 1:
				return $this->getNombre();
				break;
			case 2:
				return $this->getPropietario();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ConversacionesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdConversacion(),
			$keys[1] => $this->getNombre(),
			$keys[2] => $this->getPropietario(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ConversacionesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setIdConversacion($value);
				break;
			case 1:
				$this->setNombre($value);
				break;
			case 2:
				$this->setPropietario($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ConversacionesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdConversacion($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNombre($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPropietario($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ConversacionesPeer::DATABASE_NAME);

		if ($this->isColumnModified(ConversacionesPeer::ID_CONVERSACION)) $criteria->add(ConversacionesPeer::ID_CONVERSACION, $this->id_conversacion);
		if ($this->isColumnModified(ConversacionesPeer::NOMBRE)) $criteria->add(ConversacionesPeer::NOMBRE, $this->nombre);
		if ($this->isColumnModified(ConversacionesPeer::PROPIETARIO)) $criteria->add(ConversacionesPeer::PROPIETARIO, $this->propietario);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ConversacionesPeer::DATABASE_NAME);

		$criteria->add(ConversacionesPeer::ID_CONVERSACION, $this->id_conversacion);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getIdConversacion();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setIdConversacion($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNombre($this->nombre);

		$copyObj->setPropietario($this->propietario);


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
			self::$peer = new ConversacionesPeer();
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

				$criteria->add(MensajesPeer::ID_CONVERSACION, $this->getIdConversacion());

				MensajesPeer::addSelectColumns($criteria);
				$this->collMensajess = MensajesPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MensajesPeer::ID_CONVERSACION, $this->getIdConversacion());

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

		$criteria->add(MensajesPeer::ID_CONVERSACION, $this->getIdConversacion());

		return MensajesPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMensajes(Mensajes $l)
	{
		$this->collMensajess[] = $l;
		$l->setConversaciones($this);
	}


	
	public function getMensajessJoinUsuarios($criteria = null, $con = null)
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

				$criteria->add(MensajesPeer::ID_CONVERSACION, $this->getIdConversacion());

				$this->collMensajess = MensajesPeer::doSelectJoinUsuarios($criteria, $con);
			}
		} else {
									
			$criteria->add(MensajesPeer::ID_CONVERSACION, $this->getIdConversacion());

			if (!isset($this->lastMensajesCriteria) || !$this->lastMensajesCriteria->equals($criteria)) {
				$this->collMensajess = MensajesPeer::doSelectJoinUsuarios($criteria, $con);
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

				$criteria->add(UsuConvPeer::ID_CONVERSACION, $this->getIdConversacion());

				UsuConvPeer::addSelectColumns($criteria);
				$this->collUsuConvs = UsuConvPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(UsuConvPeer::ID_CONVERSACION, $this->getIdConversacion());

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

		$criteria->add(UsuConvPeer::ID_CONVERSACION, $this->getIdConversacion());

		return UsuConvPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addUsuConv(UsuConv $l)
	{
		$this->collUsuConvs[] = $l;
		$l->setConversaciones($this);
	}


	
	public function getUsuConvsJoinUsuarios($criteria = null, $con = null)
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

				$criteria->add(UsuConvPeer::ID_CONVERSACION, $this->getIdConversacion());

				$this->collUsuConvs = UsuConvPeer::doSelectJoinUsuarios($criteria, $con);
			}
		} else {
									
			$criteria->add(UsuConvPeer::ID_CONVERSACION, $this->getIdConversacion());

			if (!isset($this->lastUsuConvCriteria) || !$this->lastUsuConvCriteria->equals($criteria)) {
				$this->collUsuConvs = UsuConvPeer::doSelectJoinUsuarios($criteria, $con);
			}
		}
		$this->lastUsuConvCriteria = $criteria;

		return $this->collUsuConvs;
	}

} 