<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \App\controllers\Contenedor;

class PageNotFound {

	private $_contenedor;

	function __construct(){
		$this->_contenedor = new Contenedor();
	}

	public function index(){
		$extraHeader =<<<html
html;
		$extraFooter =<<<html
html;

		$content =<<<html
            <!-- 404 Start -->
            <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="container px-lg-5 text-center">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                            <h1 class="display-1">404</h1>
                            <h1 class="mb-4">Page Not Found</h1>
                            <p class="mb-4">Lo sentimos, ¡la página que has buscado no existe en nuestro sitio web! ¿Quizás ir a nuestra página de inicio o intentar utilizar una búsqueda?</p>
                            <a class="btn btn-success rounded-pill py-3 px-5" href="/home">Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 404 End -->
html;
		
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
		View::set('content', $content);
        header("HTTP/1.0 404 Not Found");
		View::render('pagenotfound');
	}
}
