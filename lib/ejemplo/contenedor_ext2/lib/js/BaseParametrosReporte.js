/*
**********************************************************
Nombre de la clase:	    BaseParametros
Propósito:				clse principal donde se definen las bases para hacer formularios que generen reportes o procesos especiales
para ENDE


Valores de Retorno:		 Invoca a funciones para el manejo de parametros

Fecha de Creación:		19 - 07 - 07
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function BaseParametrosReporte(paramConfig,parametrosDatos,ContenedorLayout,idContenedor){
	//********** Definicion de variables **********//
	var configuracion=new Array();
	//configuracion por defecto
	configuracion={TiempoEspera:10000};//tiempo de espera para dar fallo
	if(paramConfig.TiempoEspera!=null){configuracion.TiempoEspera=paramConfig.TiempoEspera;}
	var Formulario; // para el manejo del formulario
	var vectorDatos=new Array;
	var cantidadAtributosEntrada=parametrosDatos.length;
	var cantidadAtributos=parametrosDatos.length;

	/////////////////////////////////////////////////////////////
	//              CREACION DELOS COMPONENTES                 //
	////////////////////////////////////////////////////////////

	//-------- variables para el grid --------//


	var Componentes=new Array();
	var parametrosCM=new Array();
	for(var i=0;i<cantidadAtributos;i++){
		var  vA = parametrosDatos[i].validacion;
		if(parametrosDatos[i].tipo=='LovTriggerField'){	/* para el que va en el formulario*/
			parametrosDatos[i].validacion.contenedor_id=Componentes[parametrosDatos[i].validacion.indice_id];
			parametrosDatos[i].validacion.origen='formulario';
			Componentes[i]=new Ext.form[parametrosDatos[i].tipo](parametrosDatos[i].validacion);
		}
		else{
			Componentes[i]=new Ext.form[parametrosDatos[i].tipo](parametrosDatos[i].validacion);
		}
	}
	this.Init=function(){
		Ext.QuickTips.init();
		Ext.form.Field.prototype.msgTarget='under'; //muestra mensajes de error
	};
	this.iniciaFormulario=function(){
		
		
		
		Formulario = new Ext.form.Form({
			id:'formulario_'+idContenedor,
			labelWidth: Funcion_Formulario.labelWidth, // label settings here cascade unless overridden
			method:'post',
			fileUpload:true,
			url:Funcion_Formulario.url
		});
		Formulario.addButton('Enviar Datos',Funcion_Formulario.submit);
		//declaracion de los parametros y varibles del formulario
		// se arma la estructura del formulario
		for(var i=0;i<Funcion_Formulario.columnas.length;i++){
			Formulario.column( {width: Funcion_Formulario.columnas[i], style:'margin-left:10px', clear:true});
			for(var j=0;j<Funcion_Formulario.grupos.length;j++){
				if(Funcion_Formulario.grupos[j].columna==i){
					Formulario.fieldset({legend:Funcion_Formulario.grupos[j].tituloGrupo});
					for(var k=0;k<cantidadAtributosEntrada;k++){
						var id_grupo=0;
						if(parametrosDatos[k].id_grupo!=undefined&&parametrosDatos[k].id_grupo != null){
							id_grupo = parametrosDatos[k].id_grupo;}
							if(id_grupo==j){
								Formulario.add(Componentes[k]);
								vectorDatos[k]= Componentes[k];
							}
					}
					Formulario.end();// close the grupo
				}
			}
			Formulario.end()// close the column
		}
		Formulario.render('container_formulario-'+idContenedor);//dibuja el formulario
	};var iniciaFormulario=this.iniciaFormulario;


	////////////////////////////
	// FUNCION CONEXIONFAILURE//
	///////////////////////////

	function conexionFailure(resp1,resp2,resp3,resp4){
		Ext.MessageBox.hide();
		resp=resp1;     //error conexion yahoo
		if(resp3!=null){resp=resp3;}//error conexion en el ds de EXT
		var sw=false;
		if(resp.status==404&&!sw){
			var mensaje="<p>HTTP status: " + resp.status +" <br/> Status: " + resp.statusText +"<br/> No se encontro el Action requerido</p>";
			Ext.Msg.show({
				title: 'ERROR',
				msg: mensaje,
				minWidth:300,
				maxWidth :800,
				buttons: Ext.Msg.OK
				//width: 300,
			});
			sw=true;
			//registro de errores
			parametros_mensaje={
				origen:'Servidor',
				mensaje:mensaje,
				nivel:'3'
			}
		}
		if(resp.responseXML!=undefined&&resp.responseXML!= null&&!sw&&resp.responseXML.documentElement!=null&&resp.responseXML.documentElement!=undefined){
			var root = resp.responseXML.documentElement;
			if(root.getElementsByTagName('mensaje')[0]){
				var oMensaje = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
				var mensaje = "HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br>"+ oMensaje;
			}
			else{
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
			sw=true;
			//registro de errores
			var origen=undefined;
			
			/*if(root.getElementsByTagName('origen')[0]!= undefined && root.getElementsByTagName('origen')[0].firstChild.nodeValue != undefined){
				origen = root.getElementsByTagName('origen')[0].firstChild.nodeValue;
		
			}*/
			var query=undefined;
			if(root.getElementsByTagName('query')[0]!= undefined && root.getElementsByTagName('query')[0].firstChild.nodeValue != undefined){
				query=root.getElementsByTagName('query')[0].firstChild.nodeValue;
			}
			parametros_mensaje={
				origen:origen,
				mensaje:root.getElementsByTagName('mensaje')[0].firstChild.nodeValue,
				//procedimiento: root.getElementsByTagName('proc')[0].firstChild.nodeValue,
			//	nivel:root.getElementsByTagName('nivel')[0].firstChild.nodeValue,
				query:query
			};
		}
		else{
			if(resp.status == -1 && !sw){
				var mensaje = "<p>HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Tiempo de espera agotado</p>";
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					//width: 300,
				});
				sw=true;
				//-- registro de errores --//
				parametros_mensaje={
					origen:'Cliente',
					mensaje:mensaje,
					nivel:'3'
				};
			}
			if(resp.status==0&&!sw){
				var mensaje="HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Fallo en su conexión de Internet";
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					//width: 300,
				});
				sw=true;
				parametros_mensaje={
					origen:'Cliente',
					mensaje:mensaje,
					nivel:'3'
				};
			}
			if(!sw){
				var mensaje="respuesta indefinida, error en la transmision <br> respuesta obtenida:<br>"+ resp.responseText;
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					//width: 300,
				});
				//-- registro de errores --//
				parametros_mensaje={
					origen:'Servidor',
					mensaje:mensaje,
					nivel:'1'
				};
			}
		}

		//registro  de eventos
		ContenedorPrincipal.setEventoError(parametros_mensaje);
	};this.conexionFailure= conexionFailure;
	///////////////////
	//Def del Sucess //
	//////////////////
	this.procesoSuccess=function(){
		Ext.MessageBox.hide();
		Ext.Msg.show({
			title: 'Estado',
			msg: 'Proceso ejecutado satisfactoriamente.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
			//width: 300,
		});
	};var procesoSuccess=this.procesoSuccess;
	//validacion de campos
	this.ValidarCampos=function(){
		return Formulario.isValid();
	};var ValidarCampos=this.ValidarCampos;
	//limpiar invalidos
	this.limpiarInvalidos=function(){
		return Formulario.clearInvalid();
	};var limpiarInvalidos=this.limpiarInvalidos;
	//validacion de campos
	this.cancelar=function(){
		alert("cancelar");
	};var cancelar=this.cancelar;
	//tituilo pestaña
	this.obtenerTitulo=function(){
		return 'Reporte';
	};var obtenerTitulo= this.obtenerTitulo;
	//proceso de Submit
	this.submit=function(){
		if(ValidarCampos()){
			var postData = Funcion_Formulario.parametros;
			for(var i=0;i<cantidadAtributosEntrada;i++){
				if(parametrosDatos[i].save_as){
					if(parametrosDatos[i].tipo =='DateField'){
						hora=vectorDatos[i].getValue();
						if(hora != ""){//preguntamos si existe el objeto de fecha
							postData= postData+"&"+parametrosDatos[i].save_as+"="+ hora.dateFormat(parametrosDatos[i].dateFormat);
						}
						else{
							postData=postData+"&"+parametrosDatos[i].save_as+"="+ vectorDatos[i].getValue();
						}
					}
					else{
						postData= postData+"&"+parametrosDatos[i].save_as+"="+vectorDatos[i].getValue();
					}
				}
			}
			if(Funcion_Formulario.abrir_pestana===false){ //preguntamos si abre el resultado en alguna pestaña ??
				/*-----loading----*/
				Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});
				
				
			
				
				if(Funcion_Formulario.fileUpload==true){
					/*
					Formulario.submit({
					method:Funcion_Formulario.method,
					success:Funcion_Formulario.success,
					//argument:Funcion_Formulario.argument,
					failure:Funcion_Formulario.failure,
					timeout:Funcion_Formulario.timeout//TIEMPO DE ESPERA PARA DAR FALLO
					});*/
					
					Ext.Ajax.request({
					form:'formulario_'+idContenedor,
					url:Funcion_Formulario.url,
					params:postData,
					isUpload:Funcion_Formulario.fileUpload,
					method:Funcion_Formulario.method,
					success:Funcion_Formulario.success,
					argument:Funcion_Formulario.argument,
					failure:Funcion_Formulario.failure,
					timeout:Funcion_Formulario.timeout//TIEMPO DE ESPERA PARA DAR FALLO
				});
				}
				else{
				Ext.Ajax.request({
					url:Funcion_Formulario.url,
					params:postData,
					isUpload:Funcion_Formulario.fileUpload,
					method:Funcion_Formulario.method,
					success:Funcion_Formulario.success,
					argument:Funcion_Formulario.argument,
					failure:Funcion_Formulario.failure,
					timeout:Funcion_Formulario.timeout//TIEMPO DE ESPERA PARA DAR FALLO
				});
				}
			}
			else{
				if(Funcion_Formulario.navegador_pestana){
					window.open(Funcion_Formulario.url+'?'+postData);
				}
				else{//Abre la pestaña del detalle
				titulo=Funcion_Formulario.titulo_pestana();
				ContenedorLayout.loadTab(Funcion_Formulario.url+'?'+postData, titulo);
				}
			}
		}
	};var submit=this.submit;

	/////////////////////////////////////////////////////////////////////////////////////
	//--- Definicion de los parametros por defectos para las fucniones ---------------//
	////////////////////////////////////////////////////////////////////////////////////
	var Funcion_Formulario={
		cancelar:this.cancelar,
		submit:this.submit,
		success:this.procesoSuccess,
		failure:this.conexionFailure,//funcion que se ejecuta al fallar la conexion
		argument:{multi:false},
		timeout:configuracion.TiempoEspera,
		abrir_pestana:false,
		navegador_pestana:true,//abrir pest en otra ventana del navegador
		titulo_pestana:this.obtenerTitulo,
		url:'../../control',
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
	this.InitFunciones=function(param){
		if(param.Formulario){
			if(param.Formulario.submit!=null){Funcion_Formulario.submit=param.Formulario.submit;}
			if(param.Formulario.cancelar!=null){Funcion_Formulario.cancelar=param.Formulario.cancelar;}
			if(param.Formulario.constraintoviewport!=null){Funcion_Formulario.constraintoviewport=param.Formulario.constraintoviewport;}
			if(param.Formulario.fileUpload!=null){Funcion_Formulario.fileUpload=param.Formulario.fileUpload;}
			if(param.Formulario.method!=null){Funcion_Formulario.method=param.Formulario.method;}
			if(param.Formulario.labelWidth!=null){Funcion_Formulario.labelWidth=param.Formulario.labelWidth;}
			if(param.Formulario.columnas!=null){Funcion_Formulario.columnas= param.Formulario.columnas;}
			if(param.Formulario.grupos!=null){Funcion_Formulario.grupos = param.Formulario.grupos;}
			if(param.Formulario.abrir_pestana!=null){Funcion_Formulario.abrir_pestana = param.Formulario.abrir_pestana;}
			if(param.Formulario.navegador_pestana!=null){Funcion_Formulario.navegador_pestana=param.Formulario.navegador_pestana;}
			if(param.Formulario.parametros!=null){Funcion_Formulario.parametros = param.Formulario.parametros;}
			if(param.Formulario.url!=null){Funcion_Formulario.url=param.Formulario.url;}
			if(param.Formulario.failure!=null){Funcion_Formulario.failure=param.Formulario.failure;}
			if(param.Formulario.argument!=null){Funcion_Formulario.argument=param.Formulario.argument;}
			if(param.Formulario.timeout!=null){Funcion_Formulario.timeout=param.Formulario.timeout;}
			if(param.Formulario.titulo_pestana!=null){Funcion_Formulario.titulo_pestana=param.Formulario.titulo_pestana;}
			if(param.Formulario.success!=null){Funcion_Formulario.success=param.Formulario.success;}
		}
	};

	//-----   retorna un componete correspondiente al nombre intoroducido ----//
	this.getComponente=function(componente_name){
		parametrosDatos.length;
		var i = 0;
		for(i=0;i<parametrosDatos.length;i++){
			if(parametrosDatos[i].validacion.name===componente_name){
				break;
			}
		}
		return vectorDatos[i];
	};getComponente=this.getComponente;
	this.onResizePrimario=function(){
		ContenedorLayout.getLayout().layout();
	};
	// ocultar componente
	this.ocultarComponente=function(comp){
		comp.el.up('.x-form-item').down('label').update('');
		comp.hide()
	};ocultarComponente=this.ocultarComponente;

	this.mostrarComponente=function(comp){
		comp.el.up('.x-form-item').down('label').update(comp.fieldLabel);
		comp.show()
	};mostrarComponente=this.mostrarComponente;

	//oculta todos los componentes del formulario
	this.ocultarTodosComponente=function(){
		for(var i=1;i<parametrosDatos.length;i++){
			vectorDatos[i].el.up('.x-form-item').down('label').update('');
			vectorDatos[i].hide()
		}
	};ocultarTodosComponente=this.ocultarTodosComponente;

	//muestra todos los componentes del formulario
	this.motrarTodosComponente=function(){
		for(var i=1;i<parametrosDatos.length;i++){
			vectorDatos[i].el.up('.x-form-item').down('label').update(vectorDatos[i].fieldLabel);
			vectorDatos[i].show()
		}
	};mostrarTodosComponente=this.mostrarTodosComponente;
		this.Destroy=function(){
		delete paramConfig;
		delete parametrosDatos;
		delete ds;
		delete ContenedorLayout;
		delete idContenedor;
		delete Componentes;
		delete Componentes_grid;
		delete Componentes
		delete this;
	};Destroy=this.Destroy;
}
