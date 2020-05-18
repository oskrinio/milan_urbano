<?php
/**
* @file
* Contains \Drupal\onepage\Form\datosUsuario.
*/
namespace Drupal\onepage\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;


class datosUsuario extends FormBase {
    public function getFormId() {
        return 'onepage_index';
    }
    protected function myForm( array $form, FormStateInterface $form_state) {
        $numberPhone = "";
        $pattern = '/([0-9]{3})([0-9]{3})([0-9]{4})/i';
        $substitute = '($1) $2-$3';
        $numberPhone = preg_replace($pattern, $substitute, $numberPhone);
        
        $form['nombre'] = [
            '#type' => 'textfield',
            '#maxlength' => 120,
            '#title' => '',
            '#title_display' => 'after',
            '#required' => TRUE,
            '#attributes' => [
                'placeholder' => $this->t('NOMBRE COMPLETO'),
                ],
        ];

        $form['email'] = array(
            '#type' => 'email',
            '#title' => '',
            '#title_display' => 'after',
            '#required' => TRUE,
            '#attributes' => [
                'placeholder' => $this->t('CORREO ELECTRONICO'),
            ]
          );
    
        $form['telefono'] = [
            '#type' => 'number',
            '#markup' => $numberPhone,
            '#title' => '',
            '#title_display' => 'after',
            '#required' => TRUE,
            '#attributes' => [
                'placeholder' => $this->t('TELÉFONO'),
            ]
        ];
        $option = [
            'attributes' => ['target' => '_blank'],
        ];

        $datos = $this->getNodeInfo();
        $url = Url::fromUri($datos["datos"]["field_link_terminos_y_condicione"], $option);
        $external_link = \Drupal::l(t('Aceptar Términos y condiciones'), $url);

        $form['terminos'] = [
            '#type' => 'checkbox',
            '#title' => $external_link,
            '#return_value' => 1,
            '#default_value' => 0,
        ];


        $form['#theme'] = 'onepage-index';
        $form['#attached']['library'][] = 'onepage/onepage';
        $form['#path'] = drupal_get_path('module', 'onepage') . '/images/';
        $form['#datos'] = $datos["node"];
    
        $form['#attributes']['novalidate'] = '';
        $form['#attributes']['autocomplete'] = 'off';
        $form['#action'] = "#";
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('ENVIAR'),
            '#button_type' => 'primary',
          );
        
        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form = $this->myForm($form, $form_state);
        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if ($form_state->getValue('terminos') != 1) {
            $form_state->setErrorByName('Terminos', $this->t('Por favor acepte terminos y condiciones'));
        }
    }
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
   
        $values = array(
            'nombre' => $form_state->getValue('nombre'),
            'email' => $form_state->getValue('email'),
            'telefono' => $form_state->getValue('telefono'),		
            'terminos' => $form_state->getValue('terminos'),		
	    );

        $insert = db_insert('onepage_user')
            -> fields(array(
                'nombre' => $values['nombre'],
                'email' => $values['email'],
                'telefono' => $values['telefono'],
                'terminos' => $values['terminos'],
                'date_register' => date("Y-m-d H:i:s"),
            ))
            ->execute();
        $url = Url::fromRoute('onepage.index');
        $form_state->setRedirectUrl($url);
        /* 
        drupal_set_message(t('Ok, the fields have been saved'));

        foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
        } */
    }
    public function getNodeInfo(){
        $entity_type ="content";
        $nid= 1;
        $node_storage = \Drupal::entityManager()->getStorage('node');
        $node = $node_storage->load($nid);
        $datos = array(
            "field_link_terminos_y_condicione" =>$node->get('field_link_terminos_y_condicione')->getValue()[0]["value"],
        );
        $campo = $node->get('field_slick_img');
        $valor = $campo->getValue();
        return array(
            "node" =>$node,
            "datos" =>$datos
        );
        

    }
}
