

(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{"required":{    			// Add your regex rules here, you can take telephone as an example
						"regex":"none",
						"alertText":"* Este campo es obligatorio",
						"alertTextCheckboxMultiple":"* Por favor elija una opción",
						"alertTextCheckboxe":"* Esta casilla es obligatoria"},
					"length":{
						"regex":"none",
						"alertText":"* Entre ",
						"alertText2":" y ",
						"alertText3": " caracteres máximo permitidos"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* Checks allowed Exceeded"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"* Por favor seleccione ",
						"alertText2":" opciones"},	
					"confirm":{
						"regex":"none",
						"alertText":"* Su campo no concuerda"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"* Número de teléfono incorrecto"},						
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"* Dirección de correo incorrecta"},	
					"date":{
                         "regex":"/[0-9]{1,2}\-\[0-9]{1,2}\-\^[0-9]{4}$/",
						 //"regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"* Fecha inválida, debe estar en el formato DD/MM/YYYY"},
					"onlyNumber":{
						"regex":"/^[0-9,\.]+$/",
						"alertText":"* Sólo se permiten números"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"* No se permiten caracteres especiales"},	
					"ajaxUser":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"* This user is available",	
						"alertTextLoad":"* Loading, please wait",
						"alertText":"* This user is already taken"},	
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"* This name is already taken",
						"alertTextOk":"* This name is available",	
						"alertTextLoad":"* Loading, please wait"},
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"* Sólo letras"}
					}	
		}
	}
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang()
});