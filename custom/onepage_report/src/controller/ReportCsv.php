<?php

namespace Drupal\onepage_report\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\onepage_report\Model\reportDatabase;
use Symfony\Component\HttpFoundation\Response;

use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Query\Condition;



/**
 * Clase para generar CSV.
 */
class ReportCsv extends ControllerBase {

  /**
   * Variables para consultas.
   *
   * @var \Drupal\onepage_report\Model\reportDatabase
   */
  protected $reportDatabase;

  /**
   * Generación de un reporte en Csv.
   *
   * Devuelve los resultados de una consulta en un archivo descargable en
   * formato Csv para su manipulación.
   *
   * @param Symfony\Component\HttpFoundation\Request $request
   *   Request informarion from Symfony packages.
   */
  public function csv(Request $request = NULL) {
    $results = $this->reportSQL();
    $headers = [
        'id' => 'id Registro',
        'nombre' => 'Nombre',
        'email' => 'Correo Electronico',
        'telefono' => 'Telefono',
        'terminos' => 'Acepto Terminos',
        'date_register' => 'Fecha registro',
    ];
    $output = '';
    foreach ($headers as $key => $value) {
      // $output .= "'".$value . "';";
      $output .= $value . ";";
    }
    $output = trim($output, ';');
    $output .= "\r\n";
    // print_r($results->0);
    foreach ($results as $key => $result) {
      foreach ($headers as $key => $hvalue) {
        if (isset($result->$key) && !empty($result->$key)) {
            $output .= '"' . $result->$key . '";';
        }
      }
      $output = trim($output, ';'); 
      $output .= "\r\n";
    }
    $response = new Response();
    // $response->headers->set('Content-Type', 'application/vnd.ms-excel');
    // $response->headers->set('Content-Disposition', 'attachment; filename=reportUsers.csv');
    // $response->headers->set('Expires', '0');
    // $response->headers->set('Cache-Control', 'must-revalidate');
    // $response->headers->set('Pragma', 'public');
    $response->headers->set('Content-Type',   'application/vnd.ms-excel;  charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename=reportUsers.csv');
    $response->headers->set('Expires', '0');
    $response->headers->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
    $response->headers->set('Cache-Control', 'private');
    $response->setContent($output);

    return $response;

        //reportSQL

  }
  public function reportSQL(){
    $connection = \Drupal::database();
    $query = $connection->select('onepage_user', 'ou');
    $query->fields('ou', [
      'id',
      'nombre',
      'email',
      'telefono',
      'terminos',
      'date_register',
    ]);
    return $query->execute();

  }
}