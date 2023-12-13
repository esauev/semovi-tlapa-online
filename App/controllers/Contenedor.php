<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\MasterDom;

class Contenedor {

    /**
     * Este metodo retorna la seccion header
     */
    public function header($extra = ''){
        $dominio = MasterDom::getDomain();
        $html =<<<HTML
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>SEMOVI - Tlapa</title>

		<!-- Site favicon -->
		<link rel="apple-touch-icon" sizes="180x180" href="$dominio/img/sistema/logo-tlapa.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="$dominio/img/sistema/favicon-32x32.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="$dominio/img/sistema/favicon-16x16.png" />

		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<!-- Google Font -->
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="$dominio/vendors/styles/core.css" />
		<link rel="stylesheet" type="text/css" href="$dominio/vendors/styles/icon-font.min.css" />
		<link rel="stylesheet" type="text/css" href="$dominio/vendors/styles/style.css" />

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85" ></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag() {
				dataLayer.push(arguments);
			}
			gtag("js", new Date());

			gtag("config", "G-GBZ3SGGX85");
		</script>
		<!-- Google Tag Manager -->
		<script>
			(function (w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != "dataLayer" ? "&l=" + l : "";
				j.async = true;
				j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, "script", "dataLayer", "GTM-NXZMQSS");
		</script>
		<!-- End Google Tag Manager -->
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div class="container-fluid d-flex justify-content-between align-items-center" >
				<div class="brand-logo">
					<a href="/semovi">
						<img src="$dominio/img/sistema/semovi-tlapa.svg" alt="" />
					</a>
				</div>
				<div class="login-menu">
					<ul>
						<li><a href="https://exatechdevelopments.com/" target="_blank">By EXATECH</a></li>
					</ul>
				</div>
			</div>
		</div>
HTML;
        return $html;
}

    /**
     * Este metodo retorna la seccion footer
     */
    public function footer($extra = ''){
        $dominio = MasterDom::getDomain();
        $html=<<<HTML
        <!-- js -->
		<script src="$dominio/vendors/scripts/core.js"></script>
		<script src="$dominio/vendors/scripts/script.min.js"></script>
		<script src="$dominio/vendors/scripts/process.js"></script>
		<script src="$dominio/vendors/scripts/layout-settings.js"></script>
		<!-- add sweet alert js & css in footer -->
	    <script src="$dominio/src/plugins/sweetalert2/sweetalert2.all.js"></script>
        <script src="$dominio/src/plugins/sweetalert2/sweet-alert.semovi.js"></script>
		<!-- Google Tag Manager (noscript) -->
		<noscript>
			<iframe
				src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
				height="0"
				width="0"
				style="display: none; visibility: hidden"></iframe>
		</noscript>
		<!-- End Google Tag Manager (noscript) -->
	</body>
</html>
HTML;
       return $html;
    }

}
