/**
 * Nombre:		  	    pagina_tipo_servicio_cuenta_partida.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2008-12-10 09:07:36
 */
function pagina_tipo_servicio_cuenta_partida(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var cmpGestion,cmpIdGestion;
	var	cmpIdServicio,cmpIdPartida;
	var	cmpIdCuenta,cmpIdAuxiliar;
	var cmpFechaReg,cmpDescTipoServicio;
	var	cmpIdUo,id_gestion_filtro,g_id_gestion;
	var data='';
	//---DATA STORE
	var ds=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_servicio_cuenta_partida/ActionListarTipoServicioCuentaPartida.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_servicio_cuenta_partida',totalRecords:'TotalCount'
		},[		
		'id_tipo_servicio_cuenta_partida','desc_tipo_servicio',
		'id_cuenta',
		'desc_cuenta',
		'id_partida',
		'desc_partida',
		'id_gestion',
		'denominacion_empresa',
		'gestion_gestion',
		'desc_gestion','gestion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_tipo_servicio','id_auxiliar','desc_auxiliar','id_tipo_adq','nombre',
		'id_servicio',
		'desc_servicio',
		'id_presupuesto',
		'desc_presupuesto','detalle_usado'
		]),remoteSort:true});

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
	//DATA STORE COMBOS
    var ds_cuenta=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','sw_oec','sw_aux'])
	});	
	function renderPartida(value,p,record){return String.format('{0}',record.data['desc_partida'])}

     var ds_gestion=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?estado=abierto'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});
	
	var ds_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarSerField.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio','desc_tipo_servicio'])
		});

	var ds_auxiliar=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_persona',
			totalRecords:'TotalCount'
		},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','desc_presupuesto','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti',
																																										'id_unidad_organizacional','desc_unidad_organizacional','id_fuente_financiamiento','denominacion','id_parametro',																																						'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																																										'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])
	});	
   
	//FUNCIONES RENDER
	function renderHaber(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>',
																		'<br><b>Gestion: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
																		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
																		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>',  
																		'</div>');	
	
	function render_id_servicio(value, p, record){return String.format('{0}', record.data['desc_servicio']);}
	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

	function renderAuxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}

	function render_id_tipo_servicio(value, p, record){return String.format('{0}', record.data['desc_tipo_servicio']);}
	var tpl_id_tipo_servicio=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','{descripcion}','</div>');
	
	function render_id_tipo_adq(value, p, record){return String.format('{0}', record.data['nombre']);}
	var tpl_id_tipo_adq=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','{descripcion}','</div>');

	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_servicio_cuenta_partida
	//en la posici�n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_servicio_cuenta_partida',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name: 'gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	
// txt id_gestion
	Atributos[1]={
		validacion:{
			name:'id_gestion',
			fieldLabel:'Gestion',
			allowBlank:false,			
			emptyText:'Gestion...',
			desc: 'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.denominacion#GESTIO.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'65%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'65%',
			onSelect:function(record){ 				
				componentes[1].setValue(record.data.id_gestion);				
				componentes[1].collapse();				
		        componentes[9].setValue(record.data.gestion);	
			}	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'EMPRES_3.denominacion#GESTIO_3.gestion',
		id_grupo:0
	};
		
	filterCols_servicio=new Array();
    filterValues_servicio=new Array();
    filterCols_servicio[0]='servicio.id_tipo_adq';
    filterValues_servicio[0]='%';
    filterCols_servicio[1]='servicio.estado';
    filterValues_servicio[1]='%';
	
	Atributos[2]={
		validacion:{
			name:'id_servicio',
			desc:'desc_servicio',
			fieldLabel:'Servicio',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			store:ds_servicio,
			renderer:render_id_servicio,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			width_grid:230,
			width:300,
			pageSize:10,
			direccion:direccion,
			filterCols:filterCols_servicio,
			filterValues:filterValues_servicio,
			grid_indice:2
		},
		tipo:'LovServicio',
		save_as:'id_servicio',
		filtro_0:true,
		defecto:'',
		filterColValue:'SERVI.codigo#SERVI.nombre',
		id_grupo:1
	};
	
	Atributos[3]={
		validacion:{
			name:'id_partida',
			desc:'desc_partida',
			fieldLabel:'Partida',
			tipo:'gasto',//determina el action a llamar
			gestion:1,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderPartida,
			onSelect:function(record){ 				
				//Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
				componentes[3].setValue({id:record.data.id_partida,desc:record.data.desc_partida});				
				componentes[3].collapse();				
				componentes[4].store.baseParams={m_id_partida:record.data.id_partida,sw_reg_comp:'si'};				
				componentes[4].modificado=true;		
			},	
			width_grid:350,
			width:300,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovPartida',
		filtro_0:true,
		filterColValue:'PARTID.nombre_partida#PARTID.codigo_partida',
		save_as:'id_partida',
		id_grupo:2
	};

	Atributos[4]= {
		validacion:{
			name:'id_cuenta',
			desc:'desc_cuenta',
			allowBlank:true,
			fieldLabel:'Cuenta',
			tipo:'ingreso',//determina el action a llamar
			gestion:1,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderHaber,
			width_grid:350,
			width:300,
			pageSize:10,
			onSelect:function(record){ 				
				//Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
				componentes[4].setValue({id:record.data.id_cuenta,desc:record.data.desc_cuenta});				
				componentes[4].collapse();				
				ds_auxiliar.baseParams={cuenta:record.data.id_cuenta};				
				componentes[5].modificado=true;		
			},	
			direccion:direccion
		},
		tipo:'LovCuenta',
		filtro_0:true,
		filterColValue:'CUENTA.nombre_cuenta',
		save_as:'id_cuenta',
		id_grupo:2
	};
	
	Atributos[5]= {
		validacion: {
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:true,			
			emptyText:'Auxiliar...',
			name:'id_auxiliar',     //indica la columna del store principal ds del que proviane el id
			desc:'nombre_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			queryParam:'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:renderAuxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:300 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'AUXILI.nombre_auxiliar',
		defecto: '',
		save_as:'id_auxiliar',
		id_grupo:2
	};

	Atributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Dia no valido',
			grid_visible:false,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		form:false,
		filtro_0:false,
		filterColValue:'SECUPA.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:''	
	};

	Atributos[7]={
			validacion:{
				name:'desc_tipo_servicio',
				fieldLabel:'Tipo de Servicio',
				allowBlank:false,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:200,
				width:'100%',
				disable:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form: false,
			filterColValue:'TIPSER.nombre',
			filtro_0:false
		};
		
	// txt id_unidad_organizacional
	Atributos[8]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			emptyText:'Presupuesto....',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:350,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:3
	};
	
	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name: 'bandera',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Relacion Tipo Servicio-Cuenta Partida',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_servicio_cuenta_partida=new DocsLayoutMaestro(idContenedor);
	layout_tipo_servicio_cuenta_partida.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_servicio_cuenta_partida,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
    var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_btnEliminar=this.btnEliminar;
	var Cm_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
    ///////////////////////////////////
	// DEFINICI�N DE LA BARRA DE MEN�//
	///////////////////////////////////
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_servicio_cuenta_partida/ActionEliminarTipoServicioCuentaPartida.php'},
		Save:{url:direccion+'../../../control/tipo_servicio_cuenta_partida/ActionGuardarTipoServicioCuentaPartida.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_servicio_cuenta_partida/ActionGuardarTipoServicioCuentaPartida.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		grupos:[
		{
			tituloGrupo:'Gestion',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Servicio',
			columna:0,
			id_grupo:1
		},
		{
			tituloGrupo:'Partida-Cuenta',
			columna:0,
			id_grupo:2
		},
		{
			tituloGrupo:'Unidad Organizacional',
			columna:0,
			id_grupo:3
		}],
		height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Tipo Servicio-Cuenta Partida'}};
	
	this.btnNew=function(){
	    CM_ocultarGrupo('Oculto');
	     ClaseMadre_getComponente('id_presupuesto').disable();
		CM_btnNew();
	}
	this.btnEdit=function(){
		data='';
	    var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		   var SelectionsRecord=sm.getSelected();
	       CM_ocultarGrupo('Oculto');
		   CM_btnEdit();
		}else{
		    Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}
	
	this.btnEliminar=function(){
		data='';
	    var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		   var SelectionsRecord=sm.getSelected();
	   	 if(SelectionsRecord.data.detalle_usado!=''){
	   	 	
	   	 	data='id_tipo_servicio_cuenta_partida_0='+SelectionsRecord.data.id_tipo_servicio_cuenta_partida;
	   	 	Ext.MessageBox.show({
           title: 'NOTA',
           msg: 'Existen registros asociados a esta parametrizacion <br />'+SelectionsRecord.data.detalle_usado+'<br />Desea Continua?',
           width:305,
           buttons: Ext.MessageBox.YESNO,
           fn: getObservaciones,
           icon:Ext.MessageBox.QUESTION
           
       });
	   	 }else{
	   	  	
	      CM_btnEliminar();
	   	 }
		   
		}else{
		    Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}
	
	 function getObservaciones(btn,text){
		if(btn!='no'){
			
		   
			Ext.Ajax.request({
			url:direccion+"../../../control/tipo_servicio_cuenta_partida/ActionEliminarTipoServicioCuentaPartida.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:Cm_conexionFailure,
			timeout:100000000
		});
	}
	 }
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			//btn_reporte_solicitud_compra();
			ClaseMadre_btnActualizar();
		}
		else{
			Cm_conexionFailure();
		}
	}
	
	
	function btn_reporte(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				//if(NumSelect!=0){

				//	var SelectionsRecord=sm.getSelected();
					//var data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;

					window.open(direccion+'../../../control/_reportes/tipo_servicio_cuenta_partida/ActionReporteTipoServicioCuentaPartida.php')

				
			}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	    cmpGestion=ClaseMadre_getComponente('gestion');
	    cmpIdGestion=ClaseMadre_getComponente('id_gestion');
		cmpIdServicio=ClaseMadre_getComponente('id_servicio');
		cmpIdPartida=ClaseMadre_getComponente('id_partida');
		cmpIdCuenta=ClaseMadre_getComponente('id_cuenta');
		cmpIdAuxiliar=ClaseMadre_getComponente('id_auxiliar');
		cmpFechaReg=ClaseMadre_getComponente('fecha_reg');
		cmpDescTipoServicio=ClaseMadre_getComponente('desc_tipo_servicio');
		cmpIdUo=ClaseMadre_getComponente('id_unidad_organizacional'); 
		ClaseMadre_getComponente('bandera').setValue('no');
		bandera='no';
	    for(var i=0;i<Atributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		var onIdGestionSelect=function(e){			
			 id_gestion_filtro=cmpIdGestion.getValue();
				cmpIdPartida.store.baseParams={m_id_gestion:id_gestion_filtro};
				cmpIdPartida.modificado=true;
				ClaseMadre_getComponente('id_presupuesto').enable();
				ClaseMadre_getComponente('id_presupuesto').setValue('');
				ClaseMadre_getComponente('id_presupuesto').reset();
				ds_presupuesto.baseParams={sw_inv_gasto:'si', m_id_gestion:id_gestion_filtro};
				ClaseMadre_getComponente('id_presupuesto').modificado=true;
			};
		var onIdPartidaSelect=function(e){			
			var id=cmpIdPartida.getValue();
				cmpIdCuenta.store.baseParams={m_id_partida:id,m_id_gestion:id_gestion_filtro};
				cmpIdCuenta.modificado=true;
				};		
	  cmpIdGestion.on('select',onIdGestionSelect);
	  cmpIdGestion.on('change',onIdGestionSelect);  
	  cmpIdPartida.on('select',onIdPartidaSelect);
	  cmpIdPartida.on('change',onIdPartidaSelect)  
	}
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_tipo_servicio_cuenta_partida.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte',btn_reporte,true,'ver_presol','Reporte Cuenta Partida');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	   
	var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
	var tpl_gestion_cmb=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	var gestion =new Ext.form.ComboBox({
			store:ds_cmb_gestion,
			displayField:'gestion',
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'gestion...',
			selectOnFocus:true,
			width:100,
			valueField:'id_gestion',
			tpl:tpl_gestion_cmb
		});
	gestion.on('select',function (combo, record, index){g_id_gestion=gestion.getValue();
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:g_id_gestion
			}	
		});	
	});
    this.AdicionarBotonCombo(gestion,'gestion');
	layout_tipo_servicio_cuenta_partida.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
    ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}