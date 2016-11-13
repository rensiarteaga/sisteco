/**
 * Nombre:		  	    pagina_empleado_planilla.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2010-08-27 14:34:08
 */
function pagina_empleado_planilla_matriz(idContenedor,direccion,paramConfig,idContenedorPadre,maestro,Atributos,defStore)
{
	//var Atributos=new Array;
	var sw=0;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/empleado_planilla/ActionListarEmpleadoPlanillaDinamica.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado_planilla',
			totalRecords: 'TotalCount'

		},defStore),remoteSort:true});

	
/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_empleado_planilla
	//en la posiciï¿½n 0 siempre esta la llave primaria

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

var config={titulo_maestro:' (Maestro)',grid_maestro:'grid-'+idContenedor};
	var layout_empleado_planilla = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	var paramMenu={
			guardar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
			,
			excel:{crear:true,separador:false}
	};

	layout_empleado_planilla.init(config);
	
	//var layout_empleado_planilla = new DocsLayoutMaestro(idContenedor);
	//layout_empleado_planilla.init({titulo_maestro:'Planilla (Maestro)',titulo_detalle:'Funcionarios (Detalle)',grid_maestro:'grid-'+idContenedor});
		
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_empleado_planilla,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var enableSelect=this.EnableSelect;
	var cm_saveSuccess = this.saveSuccess;
	var cm_conexionFailure = this.conexionFailure;
	var grid=this.getGrid;
	var getCM=this.getColumnModel;
	
	//DEFINICIï¿½N DE FUNCIONES
	var paramFunciones={
	Save:{url:direccion+'../../../control/empleado_planilla/ActionGuardarEmpleadoPlanilla.php'},
	ConfirmSave:{url:direccion+'../../../control/empleado_planilla/ActionGuardarEmpleadoPlanilla.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Funcionarios'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.setReload = false
	this.reload=function(m){
		//Verifica el tipo de reload
		
		var datos=Ext.urlDecode(decodeURIComponent(m));
		
		
		if (maestro.id_tipo_planilla != datos.id_tipo_planilla){
			//actualizamos columnas
			Ext.MessageBox.show({
				title: 'Espere Por Favor...',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
				width:150,
				height:200,
				closable:false
			});


			Ext.Ajax.request({
				url:direccion+'../../../control/columna/ActionListarColumnaDinamica.php',	
				params: {id_tipo_planilla:<?php  echo $id_tipo_planilla;?>, estado:<?php echo $estado;?>},
				method:'POST',
				success:  inicia_matriz,
				failure:  _CP.conexionFailure
			});
			
			
			
			
		}
		
		Ext.apply(maestro,datos);
		
		//maestro.id_planilla=datos.id_planilla;
		

			//var datos=Ext.urlDecode(decodeURIComponent(m));
			//maestro.id_planilla=datos.id_planilla;

			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_planilla:maestro.id_planilla,
					id_tipo_planilla:maestro.id_tipo_planilla,
					estado:maestro.estado,
					desc_periodo:maestro.desc_periodo,
					gestion:maestro.gestion,
					defStore:cc

				}
			};
		
		
			this.btnActualizar();
			paramFunciones.Save.parametros='&id_planilla='+maestro.id_planilla;
			paramFunciones.ConfirmSave.parametros='&id_planilla='+maestro.id_planilla;
			this.iniciarEventosFormularios;
			this.InitFunciones(paramFunciones);
		
	
		
	};
		function btn_papeleta_sueldo(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_empleado_planilla='+SelectionsRecord.data.id_empleado_planilla;
					data= data +'&m_id_planilla='+SelectionsRecord.data.id_planilla;
					window.open(direccion+'../../../control/planilla/ActionPDFBoletaPago.php?'+data)
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	   //para iniciar eventos en el formulario
	  
	var onChange=function(c,i,h){  
		if(h){
			sw=0;//alert('ocultar');
		}else{
			sw=1;//	alert('mostrar');
		}
		Ext.Ajax.request({
								url:direccion+"../../../control/empleado_planilla/ActionGuardarEmpleadoPlanilla.php?id_grid="+c.getDataIndex(i)+'&id_planilla='+maestro.id_planilla+'&accion='+sw,
								method:'POST',
		//						success:terminadoD,
								failure:cm_conexionFailure,
								timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
							});
	}
	
	
	getCM().on('hiddenchange',onChange);
	}
	function btn_resumen_horario_mes(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado_planilla='+SelectionsRecord.data.id_empleado_planilla+'&m_nombre_completo='+SelectionsRecord.data.nombre_completo;
			data=data+"&vista_doble=si";
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_empleado_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/resumen_horario_mes/resumen_horario_mes.php?'+data,'Resumen Horarios',ParamVentana);
			layout_empleado_planilla.getVentana().on('resize',function(){
			layout_empleado_planilla.getLayout().layout();
			
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un funcionario');
		}

	}
	
	
		
	 function successUpdateMatriz(resp){
		
		_CP.HideLoding();

		if(resp.responseXML&&resp.responseXML.documentElement){
			var root = resp.responseXML.documentElement;
		
			var error =root.getElementsByTagName('error')[0].firstChild.nodeValue;
		     if(error=='false'){
				
				Ext.mensajes.msg('Grabación exitosa', 'Actualización terminada');
				ds.commitChanges();
			}
			else{
				
			 	ds.rejectChanges() 
				
			}	
			
		
			//this.ds.reload();
		}
		
	}
		
	 function myconexionFailure(a,b,c,d,e){
		console.log('error')
		ds.rejectChanges() 
		_CP.HideLoding();

		cm_conexionFailure (a,b,c,d,e);	
		
	}
	
	
	
this.ConfirmSave=function(){
		
		var filas=ds.getModifiedRecords();
		
	 	//dirty
	 	
	 	
	
		if(filas.length >0){//cant de regis modif > 0?
			if(confirm("Esta seguro de guardar los cambios?"))
			{
				
				
			
				var data = {};
				var _id_emp_pla  =[];
				var _id_col  =[];
				var _id_val  =[];
				
				//recorre todoas las filas modificadas
				for(var i=0;i<filas.length;i++ ){
					
					//recorres todos las columnas modificadas
					var m = filas[i].modified;
				        for(var n in m){
				            if(typeof m[n] != "function"){
				            	
				            	_col=n.split('_');
				                
				              /* data.push({id_empleado_planilla: filas[i].data['id_empleado_planilla'],
				            	          valor:filas[i].data[n],
				            	          id_columna:_col[1]})*/
				            
				            	 _id_emp_pla.push(filas[i].data['id_empleado_planilla']);
								 _id_col.push(_col[1]);
								 _id_val.push(filas[i].data[n]);
				             
				            	          /*
				             data.push([filas[i].data['id_empleado_planilla'],
				            	          filas[i].data[n],
				            	          _col[1]])*/
				            
				            }
				       
				        }
					
				}
				
				_CP.loadingShow();
				
				Ext.Ajax.request({
					url:'../../../sis_kardex_personal/control/empleado_planilla/ActionGuardarEmpleadoPlanillaMatriz.php',
					params:'x='+   Ext.util.JSON.encode({id_empleado_planilla:_id_emp_pla,id_columna:_id_col,valor:_id_val}),
					method:'POST',
					success:successUpdateMatriz,
					failure:myconexionFailure,
					timeout:_CP.getConfig().ss_tiempo_espera//TIEMPO DE ESPERA PARA DAR FALLO
				});
				
				
				
			}
		}
		
		
		
		
	}

	
	function btn_reporte(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				//g_gestion=gestion_combo.getValue();
				//if(NumSelect!=0){
				//	var SelectionsRecord=sm.getSelected();
					//var data='&txt_gestion='+gestion_combo.getValue();
													//control/_reportes/relacionar_cuenta_partida/PDFTipoServicioCuentaPartida.php
					window.open(direccion+'../../../control/empleado_planilla/ActionReporteEmpleadoPlanilla.php')	;		
	}	
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_empleado_planilla.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	var CM_getBoton=this.getBoton;
	//this.AdicionarBoton('../../../lib/imagenes/copy.png','Papeleta de Sueldo',btn_papeleta_sueldo,true,'papeleta_sueldo','');
	//this.AdicionarBoton('../../../lib/imagenes/copy.png','Resumen Horarios',btn_resumen_horario_mes,true,'resumen_horario_mes','');
	
	this.AdicionarMenuBotonSimple({text:'Horarios', 
		                           nombre:'horarios',
		                           icon:'../../../lib/imagenes/copy.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Papeleta de Sueldo',
		                        	       nombre:'papeleta_sueldo',
		                        	       handler:btn_papeleta_sueldo,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	       },
		                        	       {text:'Resumen Horarios',
			                        	       nombre:'resumen_horario_mes',
			                        	       handler:btn_resumen_horario_mes,
			                        	       icon:'../../../lib/imagenes/copy.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
	

	
	

	
	
	var cc='{';
	
	for(var n=0;n<defStore.length;n++){
		
		if(n== defStore.length -1){
			cc=cc+defStore[n]+"}";
			
		}
		else{
		cc=cc+defStore[n]+",";
		}
	
	}
	
	
	


		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_planilla:maestro.id_planilla,
				id_tipo_planilla:maestro.id_tipo_planilla,
				estado:maestro.estado,
				
					desc_periodo:maestro.desc_periodo,
					gestion:maestro.gestion,
				defStore:cc
			}
		});
	this.iniciaFormulario();
	
	iniciarEventosFormularios();

	layout_empleado_planilla.getLayout().addListener('layout',this.onResize);
	_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	_CP.HideLoding();
}