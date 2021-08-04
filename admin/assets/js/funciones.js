var isIE = document.all?true:false;
var isNS = document.layers?true:false;

function RemoveBad(strTemp) {
	strTemp = strTemp.replace(/\<|\>|\"|\%|\;|\(|\)|\&|\+/g,"");
	return strTemp;
}

function soloNumeros(e,decReq) {
	var key = (isIE) ? event.keyCode : e.which;
	var obj = (isIE) ? event.srcElement : e.target;
	var isNum = (key > 47 && key < 58) ? true : false;
	var dotOK = (key==46 && decReq=='decOK' && (obj.value.indexOf(".")<0 || obj.value.length==0)) ? true:false;
	var isDel = (key==0 || key==8 ) ? true:false;
	var isEnter = (key==13) ? true:false;
	//e.which = (!isNum && !dotOK && isNS) ? 0 : key;
	return (isNum || dotOK || isDel || isEnter);
}

function eliminarComas(strTemp){		
	strTemp = strTemp.replace(/\,/g,"");
	return strTemp;	
}

// Removes leading whitespaces
function LTrim( value ) {
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
	
}
// Removes ending whitespaces
function RTrim( value ) {	
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
}

// Removes leading and ending whitespaces
function trim( value ) {
	return LTrim(RTrim(value));
}


function utf8Encode(argString){ 
  	if (argString === null || typeof argString === "undefined") {
	    return "";
	}
	var string = (argString + ""); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
	var utftext = "",
	start, end, stringl = 0;

	start = end = 0;
	stringl = string.length;
	for (var n = 0; n < stringl; n++){
	    var c1 = string.charCodeAt(n);
	    var enc = null;

	    if (c1 < 128) {
	      end++;
	    } else if (c1 > 127 && c1 < 2048) {
	      enc = String.fromCharCode(
	        (c1 >> 6) | 192, (c1 & 63) | 128
	      );
	    } else if ((c1 & 0xF800) != 0xD800) {
	      enc = String.fromCharCode(
	        (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
	      );
	    } else { // surrogate pairs
	      if ((c1 & 0xFC00) != 0xD800) {
	        throw new RangeError("Unmatched trail surrogate at " + n);
	      }
	      var c2 = string.charCodeAt(++n);
	      if ((c2 & 0xFC00) != 0xDC00) {
	        throw new RangeError("Unmatched lead surrogate at " + (n - 1));
	      }
	      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
	      enc = String.fromCharCode(
	        (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
	      );
	    }
	    if (enc !== null) {
	      if (end > start) {
	        utftext += string.slice(start, end);
	      }
	      utftext += enc;
	      start = end = n + 1;
	    }
	}

	if (end > start) {
	    utftext += string.slice(start, stringl);
	}
	return utftext;
}

function cargar(pagina,obj,metodo,variables){
    var loading = '<div id="page-loader" class="fade in"><span class="spinner"></span></div>';

    if(typeof(metodo) == "undefined" || metodo == ""){ metodo = "POST";}
    if(typeof(variables) == "undefined" || variables == ""){ variables = "";}
    $(obj).html(loading);
    $.ajax({
        url: pagina,
        type: metodo,
        async: true,
        data: variables,
        success: function(htmlcode){
            $(obj).html(htmlcode);
        },
        error: function(XMLHttpRequest, errMsg, exception){
            notificacion(errMsg,"error");
        }
    });
}

function validarFormulario(f,objEsp){
	/*	f: Objeto formulario (form)
		objEsp: Indica si se debe validar algún objeto no soportado por la librería Parsley.js */
	var objEsp = objEsp || false;
	var expreg = /_$/;
	var resp = false;

	if(objEsp){
		for (i=0; i<f.elements.length; i++){
			objeto = f.elements[i];
			if(expreg.test(objeto.id)){
				//CKEditor
				var patron = /ckeditor/g;
				if(patron.test(objeto.className)){
					$("#"+objeto.id).val(CKEDITOR.instances[objeto.id].getData());
				}
			}
		}
	}
	
	resp = $("#"+f.id).parsley().validate();

	return resp;
}

function notificacion(mensaje,tipo){
	var ruta_imagen = base_url + 'admin/assets/img/alert_100.png';
	var titulo = '¡Advertencia!';

	if(tipo == 'success'){
		ruta_imagen = base_url + 'admin/assets/img/success_100.png';
		titulo = 'Correcto';
	}

	if(tipo == 'error'){
		ruta_imagen = base_url + 'admin/assets/img/error_100.png';
		titulo = '¡Ha ocurrido un error!';
	}
	$.gritter.add({
		title: titulo,
		text: mensaje,
		image: ruta_imagen,
		sticky: false,
		time: '2000',
		class_name: 'my-sticky-class'
	});
	return false;
}

function confirmar(mensaje,funcion,var1){
	//event.preventDefault();
	var1 = var1 || '';
	swal({
		title: '¿Esta seguro?',
		text: mensaje,
		icon: 'info',
		buttons: {
			cancel: {
				text: 'Cancelar',
				value: false,
				visible: true,
				className: 'btn btn-default',
				closeModal: true,
			},
			confirm: {
				text: 'Confirmar',
				value: true,
				visible: true,
				className: 'btn btn-success'
			}
		}
	}).then((value) => {
			if(value){
				if(var1 != '') funcion(var1);
				else funcion();
			}
	});
}