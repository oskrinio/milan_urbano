<?php

namespace Drupal\onpage_report\Model;

use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Query\Condition;

/**
 * Servicio para hacer consultas necesarias para el report.
 */
class reportDatabase {

  /**
   * Variable para formatear conexion con la base de datos.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor.
   */
  public function __construct(Connection $connection) {
    $this->database = $connection;
  }
  public function reportSQL(){
    
    $query = $this->database->select('onepage_user', 'ou');
    $query->fields('ou', [
      'id',
      'nombre',
      'email',
      'telefono',
      'terminos',
      'date_register',
    ]);
    return $query->execute()->fetchObject();

  }
}