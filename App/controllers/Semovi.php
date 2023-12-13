<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use App\controllers\dtos\CodeResponses;
use App\controllers\dtos\Response;
use App\models\Semovi as semoviDao;
use Core\MasterDom;
use \Core\View;
use stdClass;

class Semovi {

	private $_contenedor;

	function __construct(){
		$this->_contenedor = new Contenedor();
	}

	public function index(){
		$this->login();
	}

	public function login(){

		$dominio = MasterDom::getDomain();
		
		$content =<<<HTML
		<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center" >
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7">
						<!-- <img src="$dominio/vendors/images/login-page-img.png" alt="" /> -->
						<img src="$dominio/img/sistema/logo-tlapa.png" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Iniciar sesi&oacute;n</h2>
							</div>
							<form>
								<div class="input-group custom">
									<input type="text" name="email" class="form-control form-control-lg" placeholder="nombre@email.com" />
									<div class="input-group-append custom">
										<span class="input-group-text" >
											<i class="icon-copy dw dw-user1"></i>
										</span>
									</div>
								</div>
								<div class="input-group custom">
									<input type="password" name="password" class="form-control form-control-lg" placeholder="**********" />
									<div class="input-group-append custom">
										<span class="input-group-text">
											<i class="dw dw-padlock1"></i>
										</span>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
											<a id="btnLogin" class="btn btn-primary btn-lg btn-block" href="#">Log In</a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
HTML;

		View::set('header',$this->_contenedor->header());
		View::set('footer',$this->_contenedor->footer());
		View::set('content', $content);
		View::render('semovi');
	}

	public function validUser(){
		//$json = json_decode(file_get_contents('php://input'), TRUE);
        header('Content-Type: application/json; charset=utf-8');
		$response = new Response();
		try {
            $userData =  new stdClass();
            $userData->email = MasterDom::getData("email");
            $userData->password =  MasterDom::getData("password");
            
            $user = semoviDao::getUserPassword($userData);

            if($user !== null){
				// setear session con MasterDom
				MasterDom::creaSession((object)$user);
                $response->setCode(CodeResponses::$OK);
			    $response->setMessage(CodeResponses::$OK_MESSAGE);
            } else {
                $response->setCode(CodeResponses::$ERROR_SESSION_LOGIN);
			    $response->setMessage(CodeResponses::$ERROR_SESSION_LOGIN_MESSAGE);
            }
           
            // $response->setCode($_POST);
			// $response->setMessage($user);
		} catch (\Throwable $th) {
			$response->setCode(CodeResponses::$ERROR_GENERAL);
			$response->setMessage(CodeResponses::$ERROR_GENERAL_MESSAGE . " - " . $th->getMessage());
		}

		
		echo json_encode($response->expose());
	}

	public function out(){
		MasterDom::destruyeSession();
	}

}
