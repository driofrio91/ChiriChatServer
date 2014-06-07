<?php



class UsuariosMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.UsuariosMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('USUARIOS');
		$tMap->setPhpName('Usuarios');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID_USUARIO', 'IdUsuario', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NOMBRE', 'Nombre', 'string', CreoleTypes::CHAR, true, 50);

		$tMap->addColumn('TELEFONO', 'Telefono', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ESTADO', 'Estado', 'string', CreoleTypes::CHAR, false, 25);

	} 
} 