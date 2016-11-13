/*
LIBRERIA DE FUNCIONES ESPECIALES
* MANEJO DE FORMULARIOS
*

*/
function vacio(cadena)
{                                    // DECLARACION DE CONSTANTES
	var blanco = " \n\t" + String.fromCharCode(13); // blancos
	// DECLARACION DE VARIABLES
	var i;                             // indice en cadena
	var es_vacio;                      // cadena es vacio o no
	for(i = 0, es_vacio = true; (i < cadena.length) && es_vacio; i++) // INICIO
	es_vacio = blanco.indexOf(cadena.charAt(i)) != - 1;
	return(es_vacio);
}
// Validación de campos de hora


function verifica_hora( hora )
{
	//para HH:MM PM/AM
	//var er_fh = /^(1|01|2|02|3|03|4|04|5|05|6|06|7|07|8|08|9|09|10|11|12)\:([0-5]0|[0-5][1-9])\ (AM|PM)$/
	//para HH:MM
	var er_fh = /^(1|01|2|02|3|03|4|04|5|05|6|06|7|07|8|08|9|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|00|0)\:([0-5]0|[0-5][1-9]|[0-9])$/
	//para HH:MM:SS
	var er_fh2 = /^(1|01|2|02|3|03|4|04|5|05|6|06|7|07|8|08|9|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|00|0)\:([0-5]0|[0-5][1-9]|[0-9])\:([0-5]0|[0-5][1-9]|[0-9])$/
	if ( !(er_fh.test(hora)) && !(er_fh2.test(hora)))

	{
		return true;
	}

	return false;
}

/*verifica si es numero*/
function verifica_numero(cadena)
{                                    // DECLARACION DE CONSTANTES
	var blanco = "0123456789";
	// DECLARACION DE VARIABLES
	var i;                             // indice en cadena
	var es_vacio;                      // cadena es vacio o no
	for(i = 0, es_vacio = true; (i < cadena.length); i++) // INICIO
	{
		es_vacio = blanco.indexOf(cadena.charAt(i)) == - 1;
		if(es_vacio == true)
		break;
	}
	return(es_vacio);
}

function verifica_texto(cadena)
{                                    // DECLARACION DE CONSTANTES
	var blanco = " áéíóúÁÉÍÓÚqwertyuiopasdfghjklñzxcvbnmQWERTYUIOPASDFGHJKLÑZXCVBNM\\n\\t" + String.fromCharCode(13)+ String.fromCharCode(10);
	// DECLARACION DE VARIABLES
	var i;                             // indice en cadena
	var es_vacio;                      // cadena es vacio o no
	for(i = 0, es_vacio = true; (i < cadena.length); i++) // INICIO
	{
		es_vacio = blanco.indexOf(cadena.charAt(i)) == - 1;
		if(es_vacio == true)
		break;
	}
	return(es_vacio);
}


function verifica_alfanumerico(cadena)
{                                    // DECLARACION DE CONSTANTES
	var blanco = " @/*+{}[].,;:-_1234567890!\"!·$%/()|\\áéíóúÁÉÍÓÚqwertyuiopasdfghjklñzxcvbnmQWERTYUIOPASDFGHJKLÑZXCVBNM\\n\\t" + String.fromCharCode(13)+ String.fromCharCode(10);
	// DECLARACION DE VARIABLES
	var i;                             // indice en cadena
	var es_vacio;                      // cadena es vacio o no
	for(i = 0, es_vacio = true; (i < cadena.length); i++) // INICIO
	{
		es_vacio = blanco.indexOf(cadena.charAt(i)) == - 1;
		if(es_vacio == true)
		break;
	}
	return(es_vacio);
}
/* dice si cadena es un email (alfanum@alfanum.alfanum[.alfanum]) o no, don- */
/* de alfanum son caracteres alfanumericos u otros                           */
function verifica_email(cadena, otros)
{ otros ="";
// DECLARACION-INICIALIZACION VARIABLES
var i, j;                          // indice en cadena
var es_email = 0 < cadena.length;  // cadena es email o no
i = salta_alfanumerico(cadena, 0, otros); // INICIO
if(es_email = 0 < i)               // lee "alfanum*"
if(es_email = (i < cadena.length))
if(es_email = cadena.charAt(i) == '@') // lee "alfanum@*"
{
	i++;
	j = salta_alfanumerico(cadena, i, otros);
	if(es_email = i < j)       // lee "alfanum@alfanum*"
	if(es_email = j < cadena.length)
	if(es_email = cadena.charAt(j) == '\.')
	{                    // lee "alfanum@alfanum.*"
		j++;
		i = salta_alfanumerico(cadena, j, otros);
		if(es_email = j < i) // lee "alfanum@alfanum.alfanum*"
		while(es_email && (i < cadena.length))
		if(es_email = cadena.charAt(i) == '\.')
		{
			i++;
			j = salta_alfanumerico(cadena, i, otros);
			if(es_email = i < j) // lee "alfanum@alfanum.alfanum[.alfanum]*"
			i = j;
		}
	}
}
return(!es_email);
}


/* dice si cadena es url (http://... ) o no                                     */
function verifica_url(cadena)
{                                    // DECLARACION DE CONSTANTES
	var http = "http://";              // protocolo HTTP
	// DECLARACION DE VARIABLES
	var es_url;                        // cadena es url o no
	if(cadena.length <= 7)             // INICIO
	es_url = false;                  // no cabe "http://*"
	else
	es_url = http.indexOf(cadena.substring(0, 7)) != - 1; // lee "http://*"
	return(es_url);
}


/* salta caracteres alfanumericos y otros a partir de  cadena[i]  y  da  si- */
/* guiente posicion                                                          */
function salta_alfanumerico(cadena, i, otros)
{                                    // DECLARACION DE VARIABLES
	var j;                             // indice en cadena
	var car;                           // caracter de cadena
	var alfanum;                       // cadena[j] es alfanumerico u otros
	for(j = i, alfanum = true; (j < cadena.length) && alfanum; j++) // INICIO
	{
		car = cadena.charAt(j);
		alfanum = alfanumerico(car) || (otros.indexOf(car) != -1);
	}
	if(!alfanum)                       // lee "alfanumX"
	j--;
	return(j);
}

/* dice si car es alfanumerico                                               */
function alfanumerico(car)
{
	return(alfabetico(car) || numerico(car));
}


/* dice si car es alfabetico                                                 */
function alfabetico(car)               // DECLARACION DE CONSTANTES
{                                    // caracteres alfabeticos
	var alfa = "_ABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚabcdefghijklmnñopqrstuvwxyz";
	return(alfa.indexOf(car) != - 1);  // INICIO
}


/* dice si car es numerico                                                   */
function numerico(car)
{                                    // DECLARACION DE CONSTANTES
	var num = "0123456789";            // caracteres numericos
	return(num.indexOf(car) != - 1);   // INICIO
}