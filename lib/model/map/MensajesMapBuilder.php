<?php



class MensajesMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MensajesMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('MENSAJES');
		$tMap->setPhpName('Mensajes');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID_MENSAJE', 'IdMensaje', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TEXTO', 'Texto', 'string', CreoleTypes::CHAR, true, 250);

		$tMap->addForeignKey('ID_USUARIO', 'IdUsuario', 'int', CreoleTypes::INTEGER, 'USUARIOS', 'ID_USUARIO', true, null);

		$tMap->addForeignKey('ID_CONVERSACION', 'IdConversacion', 'int', CreoleTypes::INTEGER, 'CONVERSACIONES', 'ID_CONVERSACION', true, null);

		$tMap->addColumn('DATE', 'Date', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 