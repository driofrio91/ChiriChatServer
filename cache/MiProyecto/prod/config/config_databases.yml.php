<?php
// auto-generated by sfDatabaseConfigHandler
// date: 2014/06/06 19:02:38

$database = new sfPropelDatabase();
$database->initialize(array (
  'dsn' => 'mysql://root:admin@localhost/chirichat',
), 'propel');
$this->databases['propel'] = $database;