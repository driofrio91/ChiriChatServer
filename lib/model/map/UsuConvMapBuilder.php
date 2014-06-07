<?php



class UsuConvMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.UsuConvMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('USU_CONV');
		$tMap->setPhpName('UsuConv');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ID_USUARIO', 'IdUsuario', 'int' , CreoleTypes::INTEGER, 'USUARIOS', 'ID_USUARIO', true, null);

		$tMap->addForeignPrimaryKey('ID_CONVERSACION', 'IdConversacion', 'int' , CreoleTypes::INTEGER, 'CONVERSACIONES', 'ID_CONVERSACION', true, null);

	} 
} 