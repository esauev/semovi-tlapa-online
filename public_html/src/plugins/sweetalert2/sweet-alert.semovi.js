!function ($) {
    "use strict";

    var SweetAlert = function () {
    };

    const fcDanger = 'form-control-danger';
    const fcSucess = 'form-control-success';

    // Esau
    SweetAlert.prototype.init = function () {

        // Semovi login
        $('#btnLogin').click(function () {

            if(validation()) {
                swal({
                        type: 'info',
                        title: 'Validando datos',
                        showConfirmButton: false,
                        timer: 500
                }).then(function () {
                    return new Promise(function (resolve) {
                        let fData = new FormData();
                        fData.append("email" , $("input[name='email']").val())
                        fData.append("password" , $("input[name='password']").val())
                        
                        $.ajax({
                            type: "POST",
                            url: "/semovi/validUser",
                            contentType: false,
                            processData : false,
                            data: fData,
                            dataType: 'json',
                            success: function(response, textStatus, xhr) {
                                console.log("response: ",  response, "text: " , textStatus, "xhr: " , xhr)
                                if(response.code === 0){
                                    swal({
                                        type: 'success',
                                        title: 'Logueado correctamente!',
                                        showConfirmButton: false,
                                        timer: 3000
                                    }).then(function() {
                                        window.location.href = "/home";
                                    })
                                } else {
                                    swal({
                                        type: 'error',
                                        title: 'Error: ' + response.code + '\n Mensaje: ' + response.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    })
                                }
                                resolve()
                            }
                        })
                        .fail(function(error){
                            console.log(error)
                            resolve()
                        })
                        
                    })
                })
            }
        })

    },
        //init
        $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing
    function ($) {
        "use strict";
        $.SweetAlert.init()
    }(window.jQuery);

function validation() {
    let email = validateEmptyField("Email requerido", "input[name='email']", "input")
    let password = validateEmptyField("Password requerido", "input[name='password']", "input")
    let emailV = emailValid("Email invalido!", "input[name='email']", "input")
    if(!email || !password || !emailV){
        return false
    }
    return true
}
    

let setErrors = (message, field, isError = true, type) => {
    let name = "error-message-" + $(field).attr('name');
    if (isError) {
        let errorP = $("#" + name +"").text();
        // console.log(errorP)
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
    // console.log(field, message, isError)
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

let emailValid = (message, field, type = 'input') => {
    
    let email = $(field).val();
    
    var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

    if (caract.test(email) == false){
        return !setErrors(message, field, true, type);
    } else {
        return !setErrors("", field, false, type);
    }
}