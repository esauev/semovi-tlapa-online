// Editar datos de licencia

let driverName = $("input[name='driver_name']"); //document.querySelector("[name=driver_name]");
$("#div-save-card").attr("hidden", true)

$(".tab-wizard-cards").steps({
	headerTag: "h5",
	bodyTag: "section",
	transitionEffect: "fade",
	titleTemplate: '<span class="step">#index#</span> #title#',
	labels: {
		finish: "Siguiente",
		next: "Siguiente",
		previous: "Atras",
	},
	onStepChanged: function (event, currentIndex, priorIndex) {
		$('.steps .current').prevAll().addClass('disabled');
	},
	// Triggered when clicking the Previous/Next buttons
	onStepChanging: function(event, currentIndex, newIndex) {
		// console.log(event, currentIndex, newIndex)
		// valida retorno
		// isValidContainer(currentIndex - 1);
		$("a[href='#finish']").removeAttr("hidden")
		$("input[name='driver_photo']").removeAttr("disabled")
		$("input[name='driver_signature']").removeAttr("disabled")
		$("input[name='driver_fingerprint']").removeAttr("disabled")
		$("#div-save-card").attr("hidden", true)
		// valida para pasar al siguiente
		let isValidStep = isValidContainer(newIndex - 1);
		if (isValidStep === false || isValidStep === null) {
			return false;
		}
		return true;
	},
	// Triggered when clicking the Finish button
	onFinishing: function(event, currentIndex) {
		// console.log(event, currentIndex)
		let isValidStep = isValidContainer(currentIndex);
		if (isValidStep === false || isValidStep === null) {
			return false;
		}
		return true;
	},
	onFinished: function (event, currentIndex) {
		$("a[href='#finish']").attr("hidden", true)
		$("input[name='driver_photo']").attr('disabled','disabled')
		$("input[name='driver_signature']").attr('disabled','disabled')
		$("input[name='driver_fingerprint']").attr('disabled','disabled')
		$("#div-save-card").removeAttr("hidden")
		console.log(event, currentIndex, "enviar POST")
	}
});


let isValidContainer = (index) => {
	// console.log(index)
	switch (index) {
		case 0:
			let name = validateEmptyField("Nombre requerido", "input[name='driver_name']", "input")
			let lastName = validateEmptyField("Apellido paterno requerido", "input[name='driver_last_name']", "input")
			let secondLastName = validateEmptyField("Apellido materno requerido", "input[name='driver_second_last_name']", "input") 
			let borndate = validateEmptyField("Fecha de nacimiento requerido", "input[name='driver_borndate']", "input")
			let sex = validateEmptyField("Seleccione un sexo", "select[name='driver_sex']", "select")
			let typeBlood = validateEmptyField("Seleccione un tipo de sangre", "select[name='driver_type_blood']", "select")
			let curp = validateEmptyField("CURP requerido", "input[name='driver_curp']", "input")
			let nationality = validateEmptyField("Seleccione nacionalidad", "select[name='driver_nationality']", "select")
			let stateOfDate = validateEmptyField("Seleccione entidad de nacimiento", "select[name='driver_state_of_date']", "select")
			let curpValid = validateFieldCurp("CURP invalido", "input[name='driver_curp']", "input")
			if (name === false || lastName === false || secondLastName === false || borndate === false || sex === false || typeBlood === false || curp === false || curpValid ===false || nationality === false || stateOfDate === false) {
				return false
			}
			return true
		break;
		case 1:
			let street = validateEmptyField("Calle y n&uacute;mero requerido", "input[name='driver_address_street']", "input")
			let suburb = validateEmptyField("Colonia requerida", "input[name='driver_address_suburb']", "input")
			let postalCode = validateEmptyField("C&oacute;digo postal requerido", "input[name='driver_address_postal_code']", "input")
			let postalCodeValid = validateFieldCP("C&oacute;digo postal invalido", "input[name='driver_address_postal_code']", "input")
			let state = validateEmptyField("Seleccione entidad", "select[name='state']", "select")
			let city = validateEmptyField("Seleccione municipio", "select[name='city']", "select")
			if (street === false || suburb === false || postalCode === false || state === false || city === false || postalCodeValid === false) {
				return false
			}
			return true
		break;
		case 2:
			let typeCard = validateEmptyField("Seleccione tipo de licencia", "select[name='driver_type_card']", "select")
			let validaty = validateEmptyField("Seleccione vigencia", "select[name='driver_validaty']", "select")
			let restrictions = validateEmptyField("Restricci&oacute;n requerido", "input[name='driver_restrictions']", "input")
			let contactFullname = validateEmptyField("Contacto requerido", "input[name='driver_contact_fullname']", "input")
			let contacPhone = validateEmptyField("Tel&eacute;fono de contacto requerido", "input[name='driver_contac_phone']", "input")
			let contacPhoneValid = validateFieldPhone("Tel&eacute;fono invalido ingrese 10 d&iacute;gitos", "input[name='driver_contac_phone']", "input")
			if (typeCard === false || validaty === false || restrictions === false || contactFullname === false || contacPhone === false || contacPhoneValid === false) {
				return false
			}
			return true
		break;
		case 3:
			let img = $("input[name='driver_photo']").prop("files")[0]
			let imgS = $("input[name='driver_signature']").prop("files")[0]
			let imgF = $("input[name='driver_fingerprint']").prop("files")[0]
			
			if(img !== undefined ) {
				let photo = validateEmptyField("Seleccione una foto", "input[name='driver_photo']", "input")
				let photoValid = validateFieldImg("Formato invalido! solo acepta .png, .jpg o .jpeg", "input[name='driver_photo']", "input")
				let photoSize = validateFieldImgSize("Seleccione una imagen menor a 2 MB", "input[name='driver_photo']", "file")
				if (photo === false || photoValid === false || photoSize === false) {
					return false
				}
			} else if(imgS !== undefined){
				let signature = validateEmptyField("Seleccione imagen con la firma", "input[name='driver_signature']", "input")
				let signatureValid = validateFieldImg("Formato invalido! solo acepta .png, .jpg o .jpeg", "input[name='driver_signature']", "input")
				let signatureSize = validateFieldImgSize("Seleccione una imagen menor a 2 MB", "input[name='driver_signature']", "file")
				if (signature === false || signatureValid === false || signatureSize === false) {
					return false
				}
			} else if(imgF !== undefined){
				let fingerprint = validateEmptyField("Seleccione imagen con la huella", "input[name='driver_fingerprint']", "input")
				let fingerprintValid = validateFieldImg("Formato invalido! solo acepta .png, .jpg o .jpeg", "input[name='driver_fingerprint']", "input")
				let fingerprintSize = validateFieldImgSize("Seleccione una imagen menor a 2 MB", "input[name='driver_fingerprint']", "file")
				if (fingerprint === false || fingerprintValid === false || fingerprintSize === false) {
					return false
				}
			} else {
				return true
			}

		break;
	
		default:
			return true
		break;
	}
}


let setErrors = (message, field, isError = true, type) => {
	let name = "error-message-" + $(field).attr('name');
	if (isError) {
		let errorP = $("#" + name +"").text();
		console.log(errorP)
		if(errorP.length === 0)
			if(type === 'input')
				$(field).addClass("form-control-danger").after( "<p id='" + name + "' class='has-danger'>" + message + "</p>" );
			else if(type === 'select'){
				$(field).addClass("form-control-danger").next().after( "<p id='" + name + "' class='has-danger'>" + message + "</p>" );
			} else if (type === 'file') {
				$(field).addClass("form-control-danger").after( "<p id='" + name + "' class='has-danger'>" + message + "</p>" );
			}
		else
			$(field).addClass("form-control-danger");
	} else {
		if (type === 'input') {
			$(field).removeClass("form-control-danger").next().remove("p");
		} else if(type === 'select'){
			$(field).removeClass("form-control-danger").next().next().remove("p");
		} else if (type === 'file') {
			$(field).removeClass("form-control-danger").next().next().remove("p");
		}
	}
	console.log(field, message, isError)
	return isError;
}

let validateEmptyField = (message, field, type = 'input') => {
	
	let fieldValue = $(field).val();
	
	if (fieldValue.trim().length === 0) {
		return !setErrors(message, field, true, type);
	} else {
		return !setErrors("", field, false, type);
	}
}

let validateFieldCurp = (message, field, type = 'input') => {
	
	let curp = $(field).val().toUpperCase();

	if (!curpValida(curp)) {
		return !setErrors(message, field, true, type);
	} else {
		return !setErrors("", field, false, type);
	}
}

//Función para validar una CURP
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);
	
    if (!validado)  //Coincide con el formato general?
    	return false;
    
    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma      = 0.0,
            lngDigito    = 0.0;
        for(var i=0; i<17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }
  
    if (validado[2] != digitoVerificador(validado[1])) 
    	return false;
        
    return true; //Validado
}

let validateFieldCP = (message, field, type = 'input') => {
	
	let cp = $(field).val();

	if (!cpValida(cp)) {
		return !setErrors(message, field, true, type);
	} else {
		return !setErrors("", field, false, type);
	}
}

function cpValida(cp) {
	let cpR = /^\d{4,5}$/,
		validado = cp.match(cpR)

	if(!validado)
		return false;

	return true;
}

let validateFieldPhone = (message, field, type = 'input') => {
	
	let phone = $(field).val();

	if (!phoneValida(phone)) {
		return !setErrors(message, field, true, type);
	} else {
		return !setErrors("", field, false, type);
	}
}

function phoneValida(phone) {
	let cpR = /^\d{10}$/,
		validado = phone.match(cpR)

	if(!validado)
		return false;

	return true;
}

let validateFieldImg = (message, field, type = 'input') => {
	
	let imgName = $(field).val();
	let ext = imgName.substring(imgName.lastIndexOf('.') + 1).toLowerCase();
	console.log(ext)
	if (ext == "png" || ext == "jpeg" || ext == "jpg"){
		return !setErrors("", field, false, type);
	} else {
		return !setErrors(message, field, true, type);
	}
}



let validateFieldImgSize = (message, field, type = 'input') => {
	
	let img = $(field).prop("files")[0]
	// let ext = img.substring(img.lastIndexOf('.') + 1).toLowerCase();
	let size = 0;
	if(img !== undefined) {
		size = (img.size / (1024 ** 2));
	}
	console.log('size' + size)
	if (size <=0 || size > 2){
		return !setErrors(message, field, true, type);
	} else {
		return !setErrors("", field, false, type);
	}
}

// images change
const fcDanger = 'form-control-danger';
const fcSucess = 'form-control-success';

$("#driver_photo").on("change", () => {
	let file = $("#driver_photo").prop("files")[0]
	let path = $("#driver_photo").val()
	let ext = path.substring(path.lastIndexOf('.') + 1).toLowerCase();
	
	if (ext == "png" || ext == "jpeg" || ext == "jpg") {
		
		let reader = new FileReader();

		reader.onload = function (e) {
			$('#img_photo').remove()
			let img = new Image();
			img.src = e.target.result
			img.setAttribute('id', 'img_photo')
			img.setAttribute('style', 'width:360px; height:360px;')
			img.setAttribute('alt', '')
			
			$('#divImg_photo').append(img);
		}
		reader.readAsDataURL(file);
		$('#driver_photo').removeClass(fcDanger)
		$('#driver_photo').addClass(fcSucess)
		
	} else {
		path = "/img/driver/photos/default.png"
		$('#img_photo').attr('src', path);
		$('#driver_photo').addClass(fcDanger)
	}
})

$("#driver_signature").on("change", () => {
	let file = $("#driver_signature").prop("files")[0]
	let path = $("#driver_signature").val()
	let ext = path.substring(path.lastIndexOf('.') + 1).toLowerCase();
	
	if (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg") {
		
		let reader = new FileReader();

		reader.onload = function (e) {
			$('#img_signature').remove()
			let img = new Image();
			img.src = e.target.result
			img.setAttribute('id', 'img_signature')
			img.setAttribute('style', 'width:360px; height:360px;')
			img.setAttribute('alt', '')
			
			$('#divImg_signature').append(img);
		}
		reader.readAsDataURL(file);
		$('#driver_signature').removeClass(fcDanger)
		$('#driver_signature').addClass(fcSucess)
		
	} else {
		path = "/img/driver/docs/autography.png"
		$('#img_signature').attr('src', path);
		$('#driver_signature').addClass(fcDanger)
	}
})


$("#driver_fingerprint").on("change", () => {
	let file = $("#driver_fingerprint").prop("files")[0]
	let path = $("#driver_fingerprint").val()
	let ext = path.substring(path.lastIndexOf('.') + 1).toLowerCase();
	
	if (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg") {
		
		let reader = new FileReader();

		reader.onload = function (e) {
			$('#img_fingerprint').remove()
			let img = new Image();
			img.src = e.target.result
			img.setAttribute('id', 'img_fingerprint')
			img.setAttribute('style', 'width:360px; height:360px;')
			img.setAttribute('alt', '')
			
			$('#divImg_fingerprint').append(img);
		}
		reader.readAsDataURL(file);
		$('#driver_fingerprint').removeClass(fcDanger)
		$('#driver_fingerprint').addClass(fcSucess)
		
	} else {
		path = "/img/driver/docs/fingerprint.png"
		$('#img_fingerprint').attr('src', path);
		$('#driver_fingerprint').addClass(fcDanger)
	}
})