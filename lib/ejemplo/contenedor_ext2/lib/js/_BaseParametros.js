/*
**********************************************************
Nombre de la clase:	    BaseParametros
Propósito:				clse principal donde se definen las bases para hacer formularios que generen reportes o procesos especiales
para ENDE


Valores de Retorno:		 invoca a funciones para el manejo de parametros

Fecha de Creación:		25 - 05 - 07
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function BaseParametros(paramConfig,parametrosDatos){
	//********** Definicion de variables **********//


	var configuracion = new Array;
	//configuracion por defecto
	configuracion = {
		TiempoEspera:10000//tiempo de espera para dar falllo
	};

	//configuracion del tamaño de pagina

	if(paramConfig.TiempoEspera!=null)
	configuracion.TiempoEspera = paramConfig.TiempoEspera;

	var Formulario; // para el manejo del formulario
	var vectorDatos = new Array;
	var cantidadAtributosEntrada = parametrosDatos.length;
	var cantidadAtributos = parametrosDatos.length;

	/////////////////////////////////////////////////////////////
	//              CREACION DELOS COMPONENTES                 //
	////////////////////////////////////////////////////////////

	//-------- varibles para el grid --------//


	var Componentes = new Array();
	var parametrosCM = new Array();

	for(var i = 0; i < cantidadAtributos ; i ++)
	{
		var  vA = parametrosDatos[i].validacion;
		if(parametrosDatos[i].tipo == 'LovTriggerField')
		{
			/* para el que va en el formulario*/
			parametrosDatos[i].validacion.contenedor_id = Componentes[parametrosDatos[i].validacion.indice_id]//formulario
			parametrosDatos[i].validacion.origen = 'formulario'
			Componentes[i] = new Ext.form[parametrosDatos[i].tipo](parametrosDatos[i].validacion);
		}
		else
		{
			Componentes[i] = new Ext.form[parametrosDatos[i].tipo](parametrosDatos[i].validacion);
		}
	}



	this.Init = function()
	{
		Ext.QuickTips.init();
		/* -----------par el grid-----------------------*/
		Ext.form.Field.prototype.msgTarget = 'under'; //muestra mensajes de error
		//Ext.form.Field.prototype.msgTarget = 'qtip'; //muestra mensajes de error en el formulario

	}

	this.iniciaFormulario= function()
	{
		Formulario = new Ext.form.Form({

			//labelAlign: 'top',
			labelWidth: Funcion_Formulario.labelWidth, // label settings here cascade unless overridden
			//legend:'Options',
			method:Funcion_Formulario.method,
			//waitMsgTarget: 'box-bd', //DEFINE EL TIPO DE LOADING QUE SE VERA AL CARGAR
			fileUpload: Funcion_Formulario.upload
		});
		Formulario.addButton('Ejecutar',Funcion_Formulario.submit);
		Formulario.addButton('Cancelar',Funcion_Formulario.cancelar);

		///---------------  declaracion de los parametros y varibles del formulario	 --------------//




		//////////// se arma la estructura del formulario /////

		for(var i = 0 ; i < Funcion_Formulario.columnas.length; i ++)
		{

			Formulario.column( {width: Funcion_Formulario.columnas[i], style:'margin-left:10px', clear:true});

			for(var j = 0 ; j < Funcion_Formulario.grupos.length;j ++)
			{


				if(Funcion_Formulario.grupos[j].columna == i)
				{
					Formulario.fieldset({legend:Funcion_Formulario.grupos[j].tituloGrupo})

					for(var k = 0; k < cantidadAtributosEntrada ; k ++)
					{
						var id_grupo = 0;
						if(parametrosDatos[k].id_grupo != undefined && parametrosDatos[k].id_grupo != null)
						id_grupo = parametrosDatos[k].id_grupo;

						if(id_grupo == j)
						{
							Formulario.add(Componentes[k]);
							vectorDatos[k]= Componentes[k];

						}
					}
					Formulario.end()// close the grupo
				}
			}
			Formulario.end()// close the column
		}

		Formulario.render('formulario');//dibuja el formulario

	}
	var iniciaFormulario = this.iniciaFormulario;


	/* esta funcion  corre  cuando se el valor upload de l formulario es true , en ves de succes y failure*/
	////////////////////////////////////////////////////////////////////////////////////////////
	//        ----------------      FUNCION FormUpload					----------------------//
	//Funcion que se ejecuta previamente a conexion o succes ,   cuando se sube un archivo    //
	////////////////////////////////////////////////////////////////////////////////////////////
	function  FormUpload(o1)
	{

		if(o1.responseXML != undefined && o1.responseXML != null && o1.responseXML.documentElement!= null && o1.responseXML.documentElement != undefined)
		{
			var root = o1.responseXML.documentElement;

			if(root.getElementsByTagName('error')[0]!=undefined)
			{

				var oError = root.getElementsByTagName('error')[0].firstChild.nodeValue;
				if(oError == 'false')
				{
					Funcion_Formulario.success(o1);// paso al proceso encargado de los exitos
				}
				else
				{
					Funcion_Formulario.failure(o1);//// paso al proceso encargado de los fallos
				}
			}
			else
			{
				var mensaje = "respuesta indefinida, error en la transmision <br> respuesta obtenida:<br>"+ o1.responseText;
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					buttons: Ext.Msg.OK
					//width: 300,
				});

			}
		}
		else
		{
			var mensaje = "respuesta indefinida, error en la transmision <br> respuesta obtenida:<br>"+ o1.responseText;
			Ext.Msg.show({
				title: 'ERROR',
				msg: mensaje,
				minWidth:300,
				buttons: Ext.Msg.OK
				//width: 300,
			});

		}


	}

	////////////////////////////////////////////////////////////////////////////////////////////
	//        ----------------      FUNCION CONEXIONFAILURE            ---------------------- //
	//Muestra los mesajes de error cuando hay problemas en la conexion con la capa de control //
	////////////////////////////////////////////////////////////////////////////////////////////

	function conexionFailure (resp1,resp2,resp3,resp4)
	{
		Ext.MessageBox.hide();
		resp = resp1;     //error conexion yahoo
		if(resp3!=null)
		resp = resp3;     //error conexion en el ds de EXT
		var sw = false;

		if (resp.status == 404 && !sw)
		{
			var mensaje = "<p>HTTP status: " + resp.status +" <br/> Status: " + resp.statusText +"<br/> No se encontro el Action requerido</p>";

			Ext.Msg.show({
				title: 'ERROR',
				msg: mensaje,
				minWidth:300,
				maxWidth :800,
				buttons: Ext.Msg.OK
				//width: 300,
			});
			sw = true

			//-- registro de errores --//
			parametros_mensaje = {
				origen:'Servidor',
				mensaje:mensaje,
				nivel:'3'

			}

		}

		if(resp.responseXML != undefined && resp.responseXML != null && !sw && resp.responseXML.documentElement != null && resp.responseXML.documentElement!= undefined)
		{
			var root = resp.responseXML.documentElement;
			if(root.getElementsByTagName('mensaje')[0])
			{

				var oMensaje = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
				var mensaje = "HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br>"+ oMensaje;
			}
			else
			{
				var mensaje = "HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br>"+ resp.responseText;
			}
			Ext.Msg.show({
				title: 'ERROR',
				msg: mensaje,
				minWidth:300,
				maxWidth :800,
				buttons: Ext.Msg.OK
				//width: 300,
			});
			sw = true;

			//-- registro de errores --//
			var origen = undefined
			if(root.getElementsByTagName('origen')[0]!= undefined && root.getElementsByTagName('origen')[0].firstChild.nodeValue != undefined)
			origen = root.getElementsByTagName('origen')[0].firstChild.nodeValue
			var query = undefined
			if(root.getElementsByTagName('query')[0]!= undefined && root.getElementsByTagName('query')[0].firstChild.nodeValue != undefined)
			query=root.getElementsByTagName('query')[0].firstChild.nodeValue
			parametros_mensaje = {
				origen:origen,
				mensaje:root.getElementsByTagName('mensaje')[0].firstChild.nodeValue,
				procedimiento: root.getElementsByTagName('proc')[0].firstChild.nodeValue,
				nivel:root.getElementsByTagName('nivel')[0].firstChild.nodeValue,
				query:query
			}

		}
		else
		{
			if(resp.status == -1 && !sw)
			{
				var mensaje = "<p>HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Tiempo de espera agotado</p>";
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					//width: 300,
				});
				sw = true;
				//-- registro de errores --//
				parametros_mensaje = {
					origen:'Cliente',
					mensaje:mensaje,
					nivel:'3'

				}
			}
			if (resp.status == 0 && !sw)
			{
				var mensaje = "HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Fallo en su conexión de Internet";
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					//width: 300,
				});
				sw = true
				parametros_mensaje = {
					origen:'Cliente',
					mensaje:mensaje,
					nivel:'3'

				}

			}

			if(!sw)
			{

				var mensaje = "respuesta indefinida, error en la transmision <br> respuesta obtenida:<br>"+ resp.responseText;
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					//width: 300,
				});
				//-- registro de errores --//
				parametros_mensaje = {
					origen:'Servidor',
					mensaje:mensaje,
					nivel:'1'

				}

			}

		}

		// ----------- registro  de eventos ----------//

		if(window.parent.Docs.setEventoLog!= undefined)
		window.parent.Docs.setEventoError(parametros_mensaje);//ejecuta metodo en cotenedor pricipal docsX.js
		// ----------- fin  registro  de eventos ----------//


	}
	this.conexionFailure =  conexionFailure

	/////////////////////////////////////////////////////////////////////////////////////
	//--- 				Definicion del proceso de Success			    ---------------//
	////////////////////////////////////////////////////////////////////////////////////

	this.procesoSuccess = function()
	{
		Ext.MessageBox.hide();
		//Ext.MessageBox.alert('Estado', 'Proceso ejecutado satisfactoriamente.');
		Ext.Msg.show({
			title: 'Estado',
			msg: 'Proceso ejecutado satisfactoriamente.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
			//width: 300,
		});
		//alert('success')
	}
	var procesoSuccess= this.procesoSuccess;
	/////////////////////////////////////////////////////////////////////////////////////
	//---------- 				Validar CAmpos						    ---------------//
	////////////////////////////////////////////////////////////////////////////////////

	///validacion de campos //
	this.ValidarCampos = function()
	{
		return Formulario.isValid();
	}
	var ValidarCampos =  this.ValidarCampos;
	/////////////////////////////////////////////////////////////////////////////////////
	//------------	 				Limpiar Invalidos				    ---------------//
	////////////////////////////////////////////////////////////////////////////////////


	//limpiar invalidos
	this.limpiarInvalidos = function()
	{
		return Formulario.clearInvalid();
	}
	var limpiarInvalidos = this.limpiarInvalidos;


	/////////////////////////////////////////////////////////////////////////////////////
	//--- 				Definicion del proceso de Cancelar			    ---------------//
	////////////////////////////////////////////////////////////////////////////////////


	///validacion de campos //
	this.cancelar = function()
	{
		//alert("cancelar")
	}
	var cancelar=  this.cancelar;

	/////////////////////////////////////////////////////////////////////////////////////
	//--- 				Definicion titulo de pestaña    			    ---------------//
	////////////////////////////////////////////////////////////////////////////////////

	this.obtenerTitulo = function()
	{
		return 'Reporte';
	}
	var obtenerTitulo=  this.obtenerTitulo;


	/////////////////////////////////////////////////////////////////////////////////////
	//--- 				Definicion del proceso de Submit			    ---------------//
	////////////////////////////////////////////////////////////////////////////////////

	this.submit = function()
	{
		if(ValidarCampos())
		{
			var postData = Funcion_Formulario.parametros;

			for(var i = 0 ; i <  cantidadAtributosEntrada; i ++)
			{

				if(parametrosDatos[i].save_as)
				{
					if(parametrosDatos[i].tipo =='DateField')
					{
						hora =  vectorDatos[i].getValue();

						if(hora != "")//preguntamos si existe el objeto de fecha
						//postData= postData+"&"+parametrosDatos[i].save_as+"_0="+ hora.dateFormat(parametrosDatos[i].dateFormat);
						postData= postData+"&"+parametrosDatos[i].save_as+"="+ hora.dateFormat(parametrosDatos[i].dateFormat);
						else
						//postData= postData+"&"+parametrosDatos[i].save_as+"_0="+ vectorDatos[i].getValue();
						postData= postData+"&"+parametrosDatos[i].save_as+"="+ vectorDatos[i].getValue();
					}
					else
					{

						//postData= postData+"&"+parametrosDatos[i].save_as+"_0="+vectorDatos[i].getValue();
						postData= postData+"&"+parametrosDatos[i].save_as+"="+vectorDatos[i].getValue();
					}

				}
			}


			if(Funcion_Formulario.abrir_pestana === false) //preguntamos si abre el resultado en alguna pestaña ??
			{
				var hcallback;
				//fileUpload
				//si el formulario es de tipo UPLOAD recibe un tratamiento especial
				// si es de este tipo elde bebuguer no funcionara

				if(Funcion_Formulario.fileUpload == true)
				{
					var formObject = document.getElementById(Formulario.id);
					YAHOO.util.Connect.setForm(formObject,Funcion_Formulario.fileUpload);
					hcallback =
					{
						success:  Funcion_Formulario.success,
						upload:   FormUpload, //funcion que se ejecuta al respuesta de subir un archivo
						argument: Funcion_Formulario.argument,
						failure:  Funcion_Formulario.failure,
						timeout:  Funcion_Formulario.timeout//TIEMPO DE ESPERA PARA DAR FALLO
					};
				}
				else
				{
					hcallback =
					{
						success:  Funcion_Formulario.success,
						argument: Funcion_Formulario.argument,
						failure:  Funcion_Formulario.failure,
						timeout:  configuracion.timeout//TIEMPO DE ESPERA PARA DAR FALLO
					};
				}

				/*-----loading----*/
				Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});
				YAHOO.util.Connect.asyncRequest(Funcion_Formulario.method, Funcion_Formulario.url, hcallback, postData);
			}
			else
			{
				//Abre la pestaña del detalle
				titulo = Funcion_Formulario.titulo_pestana();
				//alert(titulo);
				Docs.loadTab(Funcion_Formulario.url+'?'+postData, titulo);


			}
		}
	}
	var submit = this.submit;



	/////////////////////////////////////////////////////////////////////////////////////
	//--- Definicion de los parametros por defectos para las fucniones ---------------//
	////////////////////////////////////////////////////////////////////////////////////

	var Funcion_Formulario={
		cancelar: this.cancelar,
		submit: this.submit,
		success: this.procesoSuccess,
		failure:  this.conexionFailure,//funcion que se ejecuta al fallar la conexion
		argument: {multi: false},
		timeout: configuracion.TiempoEspera,
		abrir_pestana: false,
		titulo_pestana: this.obtenerTitulo,
		url: '../../control',
		parametros:'',
		fileUpload:false,
		labelWidth:100,
		method:'post',
		columnas:[450],
		grupos:[
		{
			tituloGrupo:'Datos',
			columna:0,
			id_grupo:0
		}]
	};

	// -------------------- DEFINICION DE FUNCIONES --------------------//
	this.InitFunciones = function (param)
	{
		if(param.Formulario)
		{
			if(param.Formulario.submit != null)
			Funcion_Formulario.submit = param.Formulario.submit

			if(param.Formulario.cancelar != null)
			Funcion_Formulario.cancelar = param.Formulario.cancelar;

			if(param.Formulario.constraintoviewport != null)
			Funcion_Formulario.constraintoviewport = param.Formulario.constraintoviewport;

			if(param.Formulario.fileUpload != null)
			Funcion_Formulario.fileUpload = param.Formulario.fileUpload;

			if(param.Formulario.method != null)
			Funcion_Formulario.method = param.Formulario.method;

			if(param.Formulario.labelWidth != null)
			Funcion_Formulario.labelWidth = param.Formulario.labelWidth;

			if(param.Formulario.columnas!= null)
			Funcion_Formulario.columnas= param.Formulario.columnas;

			if(param.Formulario.grupos != null)
			Funcion_Formulario.grupos = param.Formulario.grupos;

			if(param.Formulario.abrir_pestana != null)
			Funcion_Formulario.abrir_pestana = param.Formulario.abrir_pestana;

			if(param.Formulario.parametros != null)
			Funcion_Formulario.parametros = param.Formulario.parametros;

			if(param.Formulario.url != null)
			Funcion_Formulario.url = param.Formulario.url;

			if(param.Formulario.failure!= null)
			Funcion_Formulario.failure= param.Formulario.failure;

			if(param.Formulario.argument!= null)
			Funcion_Formulario.argument= param.Formulario.argument;

			if(param.Formulario.timeout!= null)
			Funcion_Formulario.timeout= param.Formulario.timeout;

			if(param.Formulario.titulo_pestana!= null)
			Funcion_Formulario.titulo_pestana= param.Formulario.titulo_pestana;
			
			if(param.Formulario.success!= null)
			Funcion_Formulario.success = param.Formulario.success;
		}
	}

	//////////////////////////////////////////////////////////////////////////
	//---------------      DEFINICION DEMETODOS  	------------------------//
	//        Lugar reservado para la definiciond emetodos      			//
	//////////////////////////////////////////////////////////////////////////

	//-----   retorna un componete correspondiente al nombre intoroducido ----//
	
	this.getVectorDatos = function()
	{
		return vectorDatos;
	}
	getVectorDatos = this.getVectorDatos;
	
	this.getComponente = function(componente_name)
	{
		parametrosDatos.length;
		var i = 0;
		for (i = 0; i < parametrosDatos.length; i ++)
		{
			if(parametrosDatos[i].validacion.name === componente_name)
			{
				break;
			}
		}
		return vectorDatos[i];
	}
	getVectorDatos = this.getVectorDatos;


	//aregla la forma en que se ve el grid dentro del layout
	this.onResize = function() {
		//para areglar un problñema de safari
		if(navigator.userAgent.indexOf("Safari")!=-1)
		{

			var t = setTimeout('layout.layout()',50);
			//layout.layout()
		}

	}
	var onResize = this.onResize
}





