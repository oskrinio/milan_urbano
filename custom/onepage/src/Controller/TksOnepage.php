<?php

namespace Drupal\onepage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
* Controller routines for page example routes.
*/

class TksOnepage extends ControllerBase {
    
    /**
     * {@inheritdoc}
     */
    protected function getModuleName() {
        return 'onepage_tks';
    }


     /**
     * Constructs a simple page.s
     *
     * The router _controller callback, maps the path
     *
     * _controller callbacks return a renderable array for the content area of the
     * page. The theme system will later render and surround the content with the
     * appropriate blocks, navigation, and styling.
     */

    public function View() {
      return [
          '#theme' => 'onepage-tks',
          '#attached' => array(
              'library' => array(
                'onepage/onepage',
              ),
            ),      
      ];
    }
}
