jQuery.fn.autoWidth = function(options)
{
  var settings = {
        limitWidth   : false
  }
  
  if(options) {
        jQuery.extend(settings, options);
    };
    
    var maxWidth = 0;
  //alert($(this).width());
   /*$(this).find("label").each(function(){
        if (.width() > maxWidth){
          if(settings.limitWidth && maxWidth >= settings.limitWidth) {
            maxWidth = settings.limitWidth;
          } else {
            maxWidth = .width();
          }
        }
  });  */
  /*r = 0;
  alert(this.filter(':first').attr('for'));
  while (this.filter(':first').width() == 0) {
	//do nothing
	setTimeout('alert(r)', 2000);
	r++;
	if (r == 2) { break; }
  }*/
  
  this.each(function(){
        if ($(this).width() > maxWidth){
          if(settings.limitWidth && maxWidth >= settings.limitWidth) {
            maxWidth = settings.limitWidth;
          } else {
            maxWidth = $(this).width();
          }
        }
  });
  /*$(this).find("label").each(function(){
		.width(maxWidth);
  });*/
  /*if ($(this).attr('for') == 'nombre') {
	alert($(this).width());
  }*/

  this.width(maxWidth);
  
  //alert(maxWidth);
  //alert($(this).width());
}
/* Ajustar margen izq. de listados lst (Ver 'lst' en metadata.txt) */
jQuery.fn.setMargin = function(options) {
	this.each(function(){
		$(this).css('margin-left', ($(this).siblings('label').width() + 20) + 'px' );
	});
}
/* Usamos esto pq Firefox cierra el form x su cuenta y el ajaxForm():clearForm no funcionaba */
jQuery.fn.clearFormElems = function(options)
{
    $(this).find(':input').each(function() {
		if ($(this).attr('disabled') || $(this).attr('data-dval')) { // no borrar elementos con valor predefinido (_val)
			return;// y elementos disabled (para cuando se dan de alta varios registros seguidos)
		}
        switch(this.type) {
			case 'select-multiple':
            case 'select-one':
				this.selectedIndex = 0;
				break;
            case 'password':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
				break;
			case 'hidden':
				if ($(this).next('.lstcant').length) {
					$(this).val('');
					$(this).siblings('.lst').html('<div class="lstvacio" style="text-align:center; padding-top: 5px;"><i>Listado vac�o</i></div>');
				}
				break;
        }
    });
	//Clear multiselect
	$(this).find('a.multiSelect').not('[data-ro],[data-dval]').each(function(index) {
		$(this).children('span').html('&nbsp;');
		$(this).parent().children(':input[id=' + $(this).attr('id') + '][type=hidden]').val('');
		$(this).parent().children('div.multiSelectOptions').find("label.checked").each(function(index) {
			$(this).removeClass("checked");
		});
	});
}
/* Funcion para mostrar divs relativos a un form element (button,input,etc), utiliza validationEngine.jquery.css 
   Ver default parameters al comienzo de la funcion */
jQuery.fn.show_msg = function(promptText,showArrow,color,promptPosition,delay,focuswidget) {
		var caller = $(this);
//function show_msg(caller,promptText,showArrow,color,promptPosition) {
		//default parameters
		if (color == null) { color = "green"; } //"green" "yellow" "red" "black"
		if (promptPosition == null) { promptPosition = "topRight"; } //"topRight" "topLeft" "centerRight" "bottomLeft" "bottomRight"
		if (showArrow == null) { showArrow = false; }
		if (delay == null) { delay = 0; } //number of milliseconds the message will stay, 0 for no limit
		to_focus = true;
		if (focuswidget == null) { to_focus = false; }
		
		var divFormError = document.createElement('div');
		var formErrorContent = document.createElement('div');
		
		$(divFormError).addClass("formError")
		if(color == "green"){ $(divFormError).addClass("greenPopup");
		} else if(color == "yellow"){ $(divFormError).addClass("yellowPopup")
		} else if(color == "black"){ $(divFormError).addClass("blackPopup") }
		
		$(formErrorContent).addClass("formErrorContent");
		
		$("body").append(divFormError);
		$(divFormError).append(formErrorContent);

		if(showArrow){		// NO TRIANGLE ON MAX CHECKBOX AND RADIO
			var arrow = document.createElement('div');
			$(arrow).addClass("formErrorArrow");
			$(divFormError).append(arrow);
			if(promptPosition == "bottomLeft" || promptPosition == "bottomRight"){
				$(arrow).addClass("formErrorArrowBottom")
				$(arrow).html('<div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div>');
			}
			if(promptPosition == "topLeft" || promptPosition == "topRight"){
				$(divFormError).append(arrow);
				$(arrow).html('<div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div>');
			}
		}
		//$(formErrorContent).html('<b>'+promptText+'</b><br><br><p align="right"><i>clic para cerrar</i></p>')
		$(formErrorContent).html('<b>'+promptText+'</b>')
	
		callerTopPosition = $(caller).offset().top;
		callerleftPosition = $(caller).offset().left;
		callerWidth =  $(caller).width();
		inputHeight = $(divFormError).height();
		
		/* POSITIONING */
		if(promptPosition == "topRight"){callerleftPosition +=  callerWidth -30; callerTopPosition += -inputHeight -10; }
		if(promptPosition == "topLeft"){ callerTopPosition += -inputHeight -10; }
		
		if(promptPosition == "centerRight"){ callerleftPosition +=  callerWidth +13; }
		
		if(promptPosition == "bottomLeft"){
			callerHeight =  $(caller).height();
			callerleftPosition = callerleftPosition;
			callerTopPosition = callerTopPosition + callerHeight + 15;
		}
		if(promptPosition == "bottomRight"){
			callerHeight =  $(caller).height();
			callerleftPosition +=  callerWidth -30;
			callerTopPosition +=  callerHeight + 15;
		}
		$(divFormError).css({
			top:callerTopPosition,
			left:callerleftPosition,
			opacity:0
		})
		$(divFormError).click(function() {
				$(this).animate({"opacity":0},function(){
					$(this).remove();
					if (to_focus){
						focuswidget.focus();
					}
				});
		});
		if (delay == 0) {
			$(formErrorContent).hover(function() {$(this).css("cursor", "pointer");}, function() {$(this).css("cursor", "");setTimeout(function(){$(divFormError).click();},700);});
		} else {
			window.tshowmsg = setTimeout(function(){$(divFormError).click();},delay);
			$(formErrorContent).hover(function() {clearTimeout(window.tshowmsg);$(this).css("cursor", "pointer");}, function() {$(this).css("cursor", "");setTimeout(function(){$(divFormError).click();},700);});
		}

		return $(divFormError).animate({"opacity":0.87},function(){return true;});	
}
/* Funcion para permutar los valores del value y el atributo que se pasa (usado para variable 'ati') */
jQuery.fn.switch_val = function(attr) {
	$(this).each(function(){
		if ($(this).val() == '') {
			$(this).attr(attr,'');
			return;
		}
		var tmp = $(this).attr(attr);
		$(this).attr(attr,$(this).val());
		$(this).val(tmp);
	});
}
/* Funcion para hacer autocomplete de campo de texto (ver variable 'atc' en metadata.txt) */
jQuery.fn.do_autocomplete = function(urlpath, ident) {
	this.each(function(){
		var wid = $(this).attr('atw');
		//alert(wid);
		if (!wid) { 
			wid = 300;
		} else if (wid == 1) {
			wid = $(this).width();
		}
		var mchars = $(this).attr('atr') || 4;
		//var fn = 'atc_selected_' + $(this).parents('fieldset').attr('id').replace('fieldset_','') + '_' + $(this).attr('id');
		var fn = 'atc_selected_' + ident + '_' + $(this).attr('id');
		var func = window[fn];
		if (! $.isFunction(func)) {
			func = null;
		}
		default_hook = null;
		if ($(this).attr('ati') !== undefined) {
			default_hook = function(v, d, el) {
				el.attr('ati', ''+d);
				if (func != null) {
					func (v, d, el);
				}
			}
		}
		thehook = default_hook != null ? default_hook : func;
		$(this).addClass("hasAtc");
		$(this).autocomplete( {minChars: mchars, width: wid, noCache: true, firstfield: true, onSelect: thehook, serviceUrl: urlpath + 'php/autocomplete.php?atcsearch=' + $(this).attr('atc')} );                
	});
}

$.fn.tagName = function() {
    return (typeof(this.get(0)) != "undefined") ? this.get(0).tagName : "undefined";
}

$.fn.hasAttr = function(atr) {
    return $(this).attr(atr) !== undefined;
}

$.fn.in_lst = function(txt) {
    if (! $(this).hasClass('.lst')) {
		return false;//this is not a lst widget
	}
	has_sep = false;
	dsuf = $(this).siblings(':input[data-lstsuf]');
	if (dsuf.length) {
		sep = ' ' + dsuf.attr('data-lstsuf') + ' ';
		if (txt.indexOf(sep) != -1) {
			has_sep = true;
			var arr = txt.split(sep);
		}
	}
	found = false;
	$(this).children('.lst-1').each(function(index){
		if ($(this).html() == txt) {
			found = true;
			return false;
		}
		if (has_sep) {
			var arr2 = $(this).html().split(sep);
			for(i=0;i<arr.length;i++){
				if ( $.inArray(arr[i],arr2) == -1) {
					return true; //continue to next item in each()
				}
			}
			found = true;
			return false;
		}
	});

	return found;
}

//Busca un texto en las celdas de un listado de widget LIST_AUTOFORM
//eg. $('#searchconsumoexplotaciones').in_listform('Declaraci�n')
//Devuelve true o false segun haya encontrado el texto.
$.fn.in_listform = function(txt) {
	if ($(this).attr('id').substr(0,6) != 'search') {
		return false; //this is not a LIST_AUTOFORM widget list
	}
	ret = false;
	$(this).find('.datanel').find('tbody').find('td').each(function() {
		if ($(this).children('a').text().indexOf(txt) != -1) {
			ret = true;
			return;
		}
	});
	
	return ret;
}

function jdialog(tx,title,modal,doptions) {
	jalert(tx,title,modal,false,null,doptions);
}

function jalert(tx,title,modal,showicon,okcb,doptions) {
	if (title == null) { title = 'Alerta'; }
	if (modal == null) { modal = true; }
	if (showicon == null) { showicon = true; }
	if (okcb == null) { okcb = function(){} }
	first = false;
	if ($('#jalertd').length > 0) {
		var dv = $('#jalertd');
	} else {
		first = true;
		var dv = document.createElement('div');
		$(dv).attr('id','jalertd');
	}
	//$(dv).addClass("formErrorArrow");
	$(dv).attr('title',title);
	if (showicon) {
		$(dv).html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;" />' + tx + '</p>');
	} else {
		$(dv).html(tx);
	}
	if (first) {
		$(dv).dialog({ autoOpen: false });
	}
	$(dv).dialog('option', 'modal', modal);
	$(dv).dialog('option', 'resizable', false);
	$(dv).dialog('option', 'width', 320); //$( this ).dialog( "close" ); return false;}
	$(dv).dialog('option', 'buttons', {Ok: function(event) { event.stopPropagation(); $(dv).dialog('close'); okcb(); return false; }} );
	if (doptions != null) {
		$(dv).dialog('option', doptions);
	}
	$(dv).dialog('open');
}

function jconfirm(tx,title,okcb,cancelcb,modal,doptions) {
	if (title == null) { title = 'Confirmaci�n'; }
	if (modal == null) { modal = true; }
	if (okcb == null) { okcb = function(event) { event.stopPropagation(); $(this).dialog('close'); };}
	if (cancelcb == null) { cancelcb = function(event) { event.stopPropagation(); $(this).dialog('close'); } }
	first = false;
	if ($('#jconfirmd').length > 0) {
		var dv = $('#jconfirmd');
	} else {
		first = true;
		var dv = document.createElement('div');
		$(dv).attr('id','jconfirmd');
	}
	//$(dv).addClass("formErrorArrow");
	$(dv).attr('title',title);
	$(dv).html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;" />' + tx + '</p>');
	if (first) {
		$(dv).dialog({ autoOpen: false });
	} else if ($(dv).dialog('isOpen')) {
		$(dv).dialog('close');
	}
	$(dv).dialog('option', 'modal', modal);
	$(dv).dialog('option', 'resizable', false);
	$(dv).dialog('option', 'width', 320); //$( this ).dialog( "close" ); return false;}
	acepcb = function(ev) {
		ev.stopPropagation(); $(this).dialog('close');
		okcb();
	}
	$(dv).dialog('option', 'buttons', {'Cancelar': cancelcb, 'Aceptar': acepcb} );
	if (doptions != null) {
		$(dv).dialog('option', doptions);
	}
	$(dv).dialog('open');
	$(dv).find('.ui-dialog-buttonpane > button:last').focus(); //set cancel button as default
}

/*fecha correcta devuelve '1'
  fecha incorrecta devuelve '0|mensaje de error' */
function valida_fecha(valor,allow_blank) {
	if (allow_blank == null) { allow_blank = false; }
	if (valor == '' && !allow_blank) {
		return '0|Debe especificar una fecha';
	}
	pattern = /[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}/; // only need to escape / char
	if (! valor.match(pattern)) {
		return '0|Fecha inv�lida, debe estar en el formato DD-MM-YYYY';
	}
	var arr = valor.split('/'); 
	dia = parseInt(arr[0],10);
	mes = parseInt(arr[1],10);
	anho = parseInt(arr[2],10);
	if (dia < 1 || dia > 31 || mes < 1 || mes > 12 || anho < 1 || anho > 3000) {
		return '0|Fecha fuera de rango';
	}
	switch (mes) {
		case 2:
		case 4:
		case 6:
		case 9:
		case 11:
			mesmaxday = 30;
			break;
		case 2: //febrero, 28 y 29 en a�os bisiestos
			if ((anho % 4 == 0) && ((anho % 100 != 0) || (anho % 400 == 0))) {
				mesmaxday = 29; //es bisiesto
			} else {
				mesmaxday = 28;
			}
			break;
		default:
			mesmaxday = 31;
			break;
	}
	if (dia > mesmaxday) {
		return '0|N�mero de d�as superior al m�ximo del mes';
	}
	
	return '1';  
}

function dateFormat(fecha){
    day = fecha.substring(0,2);
    month = fecha.substring(3,5);
    year = fecha.substring(6,10);
    return year+'-'+month+'-'+day;
            
    }
    
function actualiza_consumoinicial2(pk){
    if (hay_finobra(pk)){
        $('#fieldset_new_consumo').css('visibility','hidden');
    } else{
        $('#fieldset_new_consumo').css('visibility','visible');
        
        var msj = $('#msj_alerta_historico');
        if (msj.length > 0) {
            msj.remove();
        }
    }
}

function hay_finobra(pk){
    ret = $.ajax({type: 'GET',
				url: 'estado_consumo.php',
				data: 'op=hay_finobra&forpk='+pk,
				cache: false,
				async: false
			  }).responseText;
    return (ret == '1') ? true : false;
}

function actualiza_crearnuevo2(op,pk) {
	//op can be 'add' o 'del'
	//hay_finobra = $('#searchconsumoexplotaciones').in_listform('fin de obra');
        if (op == 'add' && hay_finobra(pk)) {
		$('a.enl3[alt^=Crear nuevo]').hide();//css('visibility','hidden');
	} else if (!hay_finobra(pk)) {
		$('a.enl3[alt^=Crear nuevo]').show();//css('visibility','visible');
	}
}

function actpestanaconsumo(pk){
    actualiza_crearnuevo2('add',pk);
    actualiza_consumoinicial2(pk);
}