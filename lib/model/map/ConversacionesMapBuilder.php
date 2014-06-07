<?php



class ConversacionesMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ConversacionesMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('CONVERSACIONES');
		$tMap->setPhpName('Conversaciones');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID_CONVERSACION', 'IdConversacion', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NOMBRE', 'Nombre', 'string', CreoleTypes::CHAR, false, 50);

		$tMap->addColumn('PROPIETARIO', 'Propietario', 'string', CreoleTypes::VARCHAR, false, 30);

	} 
} 