/**
* Nombre:		  	    pagina_declaracion_main.js
* Proposito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creacion:		2008-05-13 18:03:05
*/
function pagina_declaracion(idContenedor,direccion,paramConfig){
	
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var dialog;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/declaracion/ActionListarDeclaracion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_declaracion',totalRecords:'TotalCount'
		},[
		'id_declaracion',
		'mes',
		'estado',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_gestion',
		'id_empresa',
		'id_usuario',
		'gestion',
		'empresa',
		'usuario',
		'id_periodo',
		'id_moneda',
		'desc_periodo',
		'desc_moneda',
		'archivo',
		'id_parametro'
	]),remoteSort:true});
	
	//DATA STORE COMBOS
	var ds_id_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
	});
	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	
	var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','periodo','fecha_inicio','fecha_final'])
	});
	
	ds_periodo.baseParams={
		id_gestion:0
	}
	
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	function render_id_empresa(value, p, record){return String.format('{0}', record.data['empresa']);}
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['usuario']);}
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	function render_id_periodo(value, p, record){return String.format('{0}', record.data['desc_periodo']);}
	
	function render_archivo(value, p, record){
		return '<a href="'+ direccion+"../../../control/archivos/"+value+'">'+value+'</a>';
	}
	
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','{gestion}','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{simbolo}</FONT>','</div>');
	var tpl_id_periodo=new Ext.Template('<div class="search-item">','<b>Periodo:{periodo}</b>','<br><FONT COLOR="#B5A642">Fecha inicio:{fecha_inicio} Fecha fin:{fecha_final}</FONT>','</div>');

	/////////////////////////
	// Definicion de datos //
	/////////////////////////

	//en la posicion 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_declaracion',
			fieldLabel:'Id Declaracion',
			inputType:'hidden',
			width_grid:100,
			grid_visible:true,
			grid_editable:false,
			align:'right',
			grid_indice:-1
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:4
		},
		tipo: 'Field',
		form:false,
		filtro_0:true,
		filterColValue:'DECLAR.estado'
	};
	
	Atributos[2]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg.',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			align:'center',
			grid_indice:6
		},
		form:false,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'DECLAR.fecha_reg',
		dateFormat:'m-d-Y'
	};

	Atributos[3]={
		validacion:{
			name:'id_gestion',
			fieldLabel:'Gestion',
			allowBlank:false,			
			emptyText:'Gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:false,
			mode:'remote',
			queryDelay:150,
			pageSize:10,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:250,
			disabled:false,
			align:'center',
			grid_indice:1
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion'
	}; 
	
	Atributos[4]={
		validacion:{
			name:'id_empresa',
			fieldLabel:'Empresa',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			renderer:render_id_empresa,
			align:'center',
			grid_indice:3
		},
		tipo: 'Field',
		form:false,
		filtro_0:false,
		filterColValue:'EMPRES.codigo'
	};
	
	Atributos[5]={
		validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:200,
			renderer:render_id_usuario,
			grid_indice:5
		},
		tipo: 'Field',
		form:false,
		filtro_0:true,
		filterColValue:'USUARI.nombre_completo'
	};
	
	Atributos[6]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'80%',
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'80%',
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,		
		filterColValue:'CUDOC.desc_moneda.nombre'
	};

	Atributos[7]={
		validacion:{
			name:'id_periodo',
			fieldLabel:'Periodo',
			allowBlank:false,
			desc: 'desc_periodo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_periodo,
			valueField: 'id_periodo',
			displayField: 'periodo',
			queryParam: 'filterValue_0',
			filterCol:'PERIOD.periodo',
			typeAhead:false,
			tpl:tpl_id_periodo,
			//filterCols:filterCols_periodo,
			//filterValues:filterValues_periodo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:12,
			minListWidth:'80%',
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_periodo,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'80%',
			disabled:false,
			align:'right',
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,		
		filterColValue:'DECLAR.periodo'
	};
	
	Atributos[8]={
		validacion:{
			name:'archivo',
			fieldLabel:'Archivo',
			grid_visible:true,
			grid_editable:false,
			width_grid:160,
			renderer:render_archivo
		},
		tipo: 'Field',
		form:false,
		filtro_0:false
	};
		
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
 
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Declaraciï¿½n',grid_maestro:'grid-'+idContenedor};
	var layout=new DocsLayoutMaestro(idContenedor);
	layout.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var CM_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnEdit=this.btnEdit;
	var cmbtnActualizar=this.btnActualizar;
	var Cm_getDialog=this.getDialog;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_getFormulario=this.getFormulario;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var enableSelect=this.EnableSelect;
	var cm_EnableSelect=this.EnableSelect;
	var CM_getBoton=this.getBoton;
	
	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENU//
	///////////////////////////////////
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICION DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/declaracion/ActionEliminarDeclaracion.php'},
		Save:{url:direccion+'../../../control/declaracion/ActionGuardarDeclaracion.php'},
		ConfirmSave:{url:direccion+'../../../control/declaracion/ActionGuardarDeclaracion.php'},
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Declaraciï¿½n'}
	};

	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//
	this.EnableSelect=function(sm,row,rec){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
	}
	
	function btn_validar_ejecucion(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			Ext.MessageBox.show({
				title: 'Procesando',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Validando Ejecución ...</div>",
				width:200,
				height:200,
				closable:false
			});
			
			//Llamada a la funcion de validacion
			Ext.Ajax.request({
				url:direccion+"../../../control/declaracion/ActionValidarEjecucion.php",
				method:'POST',
				params:{cantidad_ids:'1',id_declaracion_0:SelectionsRecord.data.id_declaracion},
				success:function(resp){
					var root = resp.responseXML.documentElement;
					var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
					if(error=='1'){
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
						return;
					} else {
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
					}
					ds.load({params:{
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}});
				},
				failure:CM_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro');
		}
	}
	
	function btn_validar_acumulado(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			Ext.MessageBox.show({
				title: 'Procesando',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Validando Ejecución Acumulada y Periodos Anteriores ...</div>",
				width:200,
				height:200,
				closable:false
			});
			
			//Llamada a la funcion de validacion
			Ext.Ajax.request({
				url:direccion+"../../../control/declaracion/ActionValidarAcumulado.php",
				method:'POST',
				params:{cantidad_ids:'1',id_declaracion_0:SelectionsRecord.data.id_declaracion},
				success:function(resp){
					var root = resp.responseXML.documentElement;
					var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
					if(error=='1'){
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
						return;
					} else {
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
					}
					ds.load({params:{
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}});
				},
				failure:CM_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro');
		}
	}
	
	function btn_generar_sigma(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
	
		if(NumSelect==1){
			if(confirm('¿Esta seguro de generar la Ejecucion Presupuestaria?')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando ...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/declaracion/ActionGenerarEjecucion.php",
					method:'POST',
					params:{cantidad_ids:'1',id_declaracion_0:SelectionsRecord.data.id_declaracion},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
						ds.load({params:{
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros
						}});
					},
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}	
		} else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro');
		} 
	}

	function btn_ver_datos(){
		this.btnActualizar;

		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_declaracion='+SelectionsRecord.data.id_declaracion;
			data=data+'&m_gestion='+SelectionsRecord.data.gestion;
			data=data+'&m_mes='+SelectionsRecord.data.mes;
			data=data+'&m_estado='+SelectionsRecord.data.estado;
			data=data+'&m_id_gestion='+SelectionsRecord.data.id_gestion;
			data=data+'&m_id_gestion='+SelectionsRecord.data.id_gestion;
			data=data+'&m_id_parametro='+SelectionsRecord.data.id_parametro;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			
			layout.loadWindows(direccion+'../../../../sis_sigma/vista/cab_cbte/cab_cbte.php?'+data,'Cabecera',ParamVentana);

			layout.getVentana().on('resize',function(){
				layout.getLayout().layout();
			});
		}else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro');
		}
	}
	
	function btn_validar_sigma(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			Ext.MessageBox.show({
				title: 'Procesando',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Validando Transferencia al SIGMA	 ...</div>",
				width:200,
				height:200,
				closable:false
			});
			
			//Llamada a la funcion de validacion
			Ext.Ajax.request({
				url:direccion+"../../../control/declaracion/ActionValidarSigma.php",
				method:'POST',
				params:{cantidad_ids:'1',id_declaracion_0:SelectionsRecord.data.id_declaracion},
				success:function(resp){
					var root = resp.responseXML.documentElement;
					var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
					if(error=='1'){
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
						return;
					} else {
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
					}
					ds.load({params:{
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}});
				},
				failure:CM_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro');
		}
	}
		
	// funcion de tipo "gasto e inversion" adicionado en fecha 28 de marzo
	function btn_excel_gasto_inversion(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
	
		if(NumSelect==1){	
			Ext.MessageBox.confirm("Atencion","¿Esta seguro de exportar a Excel los datos de Inversion y Gasto?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Gasto e Inversion',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando...</div>",
					width:200,
					height:200,
					closable:false
				});
				
				var SelectionsRecord=sm.getSelected();	
				var data='id_declaracion='+SelectionsRecord.data.id_declaracion;
				data=data+'&tipo_reporte=2';
				
				window.open(direccion+'../../../../sis_sigma/control/declaracion/ActionPDFEjecGastoInv.php?'+data);
				
				Ext.MessageBox.hide();
			} });
		}else{
			Ext.MessageBox.alert('...', 'Debe selecionar un registro');}
	}
		
	// funcion de tipo "Recurso" adicionado en fecha 28 de marzo
	function btn_excel_recurso(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			Ext.MessageBox.confirm("Atencion","¿Esta seguro de exportar a Excel los datos de Recursos?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Recurso',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando ...</div>",
					width:200,
					height:200,
					closable:false
				});
				
				var SelectionsRecord=sm.getSelected();	
				var data='id_declaracion='+SelectionsRecord.data.id_declaracion;
				data=data+'&tipo_reporte=2';
				
				window.open(direccion+'../../../../sis_sigma/control/declaracion/ActionPDFEjecRecurso.php?'+data);
				
				Ext.MessageBox.hide();
			} });
		}else{
			Ext.MessageBox.alert('...', 'Debe Selecion un registro');
		}
	}
	
	function btn_verif_arch() {
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Verificando archivos ...</div>",
					width:200,
					height:200,
					closable:false
				});
				
				//Llamada a la funcion de verificacion
				Ext.Ajax.request({
					url:direccion+"../../../control/declaracion/ActionVerificarArchivos.php",
					method:'POST',
					params:{cantidad_ids:'1',id_declaracion_0:SelectionsRecord.data.id_declaracion},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
					},
					failure:CM_conexionFailure,
					timeout:100000000
				});
		} else{
			Ext.MessageBox.alert('...', 'Seleccione un registro');
		} 
	}
	
	function btn_gen_arch(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('¿Esta seguro de generar los Archivos de la Ejecucion Presupuestaria?')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando archivos...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/cab_cbte/ActionGenerarArchivos.php",
					method:'POST',
					params:{cantidad_ids:'1',m_id_declaracion:SelectionsRecord.data.id_declaracion},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
					},
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
		} else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro');
		} 
	}
	
	function btn_anular_sigma(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
	
		if(NumSelect==1){
			if(confirm('¿Esta seguro de Anular la Declaración de la Ejecucion Presupuestaria?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Anulando ...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/declaracion/ActionAnularDeclaracion.php",
					method:'POST',
					params:{cantidad_ids:'1',id_declaracion_0:SelectionsRecord.data.id_declaracion},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
						ds.load({params:{
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros
						}});
					},
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
		} else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro');
		} 
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		var cmbGestion=getComponente('id_gestion');
		var cmbPeriodo=getComponente('id_periodo');
		
		var onGestionSelect=function(e){
			var id = cmbGestion.getValue();
	
			ds_periodo.baseParams={
				id_gestion:id
			}
			cmbPeriodo.modificado = true;
			cmbPeriodo.setValue('');
		};
		cmbGestion.on('select',onGestionSelect);
		cmbGestion.on('change',onGestionSelect);
	}
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout.getLayout()};
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones); 
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Valida Consistencia de la Ejecución',btn_validar_ejecucion,true,'validar_ejecucion','Validar Ejecucion');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Valida la Ejecución Acumulada',btn_validar_acumulado,true,'validar_acumulado','Validar Acumulado');
	
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Procesa todos los comprobantes del periodo y los replica en el SIGMA',btn_generar_sigma,true,'generar_sigma','Generar Ejecucion');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Valida Transferencia de la Ejecución al SIGMA',btn_validar_sigma,true,'validar_sigma','Validar SIGMA');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Permite ver los datos de los comprobantes del periodo y sus transacciones',btn_ver_datos,true,'ver_datos','Visualizar Datos');
	
	this.AdicionarBoton('../../../lib/imagenes/excel.png','Exporta los comprobantes de Gasto e Inversion en formato Excel',btn_excel_gasto_inversion,true,'excel_gasto','Gasto e Inversion');
	this.AdicionarBoton('../../../lib/imagenes/excel.png','Exporte los comprobantes de Recurso en formato Excel',btn_excel_recurso,true,'excel_recurso','Recurso');			
	
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Verifica que los datos almacenados esten completos y no tengan errores',btn_verif_arch,true,'verif_arch','Verificar Archivos');
	this.AdicionarBoton('../../../lib/imagenes/zip.png','Genera los Archivos ASCII y los comprime en un archivo .tar que puede descargarse mediante el enlace azul',btn_gen_arch,true,'gener_arch','Generar Archivos');
	this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular la Declración de la Ejecución',btn_anular_sigma,true,'anula_tran','Anular Declaración');

	//para agregar botones	
	CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	CM_getBoton('validar_ejecucion-'+idContenedor).disable();
	CM_getBoton('generar_sigma-'+idContenedor).disable();
	CM_getBoton('ver_datos-'+idContenedor).disable();
	CM_getBoton('validar_sigma-'+idContenedor).disable();
	CM_getBoton('validar_acumulado-'+idContenedor).disable();
	CM_getBoton('excel_gasto-'+idContenedor).disable();
	CM_getBoton('excel_recurso-'+idContenedor).disable();
	CM_getBoton('verif_arch-'+idContenedor).disable();
	CM_getBoton('gener_arch-'+idContenedor).disable();
	CM_getBoton('anula_tran-'+idContenedor).disable();
	
	function enable(sm,row,rec){		
		cm_EnableSelect(sm,row,rec);
		
		if(rec.data['estado'] =='Validar_ejecucion' || rec.data['estado'] =='Diferencia_conta_ppto'){
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();	
			CM_getBoton('validar_ejecucion-'+idContenedor).enable();
			CM_getBoton('generar_sigma-'+idContenedor).disable();
			CM_getBoton('ver_datos-'+idContenedor).disable();
			CM_getBoton('validar_sigma-'+idContenedor).disable();
			CM_getBoton('validar_acumulado-'+idContenedor).disable();
			CM_getBoton('excel_gasto-'+idContenedor).disable();
			CM_getBoton('excel_recurso-'+idContenedor).disable();
			CM_getBoton('verif_arch-'+idContenedor).disable();
			CM_getBoton('gener_arch-'+idContenedor).disable();
			CM_getBoton('anula_tran-'+idContenedor).disable();
		}		
		if(rec.data['estado'] =='Generar_sigma'){
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).enable();	
			CM_getBoton('validar_ejecucion-'+idContenedor).disable();
			CM_getBoton('generar_sigma-'+idContenedor).enable();
			CM_getBoton('ver_datos-'+idContenedor).disable();
			CM_getBoton('validar_sigma-'+idContenedor).disable();
			CM_getBoton('validar_acumulado-'+idContenedor).disable();
			CM_getBoton('excel_gasto-'+idContenedor).disable();
			CM_getBoton('excel_recurso-'+idContenedor).disable();
			CM_getBoton('verif_arch-'+idContenedor).disable();
			CM_getBoton('gener_arch-'+idContenedor).disable();
			CM_getBoton('anula_tran-'+idContenedor).disable();
		}
		if(rec.data['estado'] =='Validar_acumulado' || rec.data['estado'] =='Diferencia_acumulado'){
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).enable();	
			CM_getBoton('validar_ejecucion-'+idContenedor).disable();
			CM_getBoton('generar_sigma-'+idContenedor).disable();
			CM_getBoton('ver_datos-'+idContenedor).disable();
			CM_getBoton('validar_sigma-'+idContenedor).disable();
			CM_getBoton('validar_acumulado-'+idContenedor).enable();
			CM_getBoton('excel_gasto-'+idContenedor).disable();
			CM_getBoton('excel_recurso-'+idContenedor).disable();
			CM_getBoton('verif_arch-'+idContenedor).disable();
			CM_getBoton('gener_arch-'+idContenedor).disable();
			CM_getBoton('anula_tran-'+idContenedor).disable();
		}
		if(rec.data['estado'] =='Validar_sigma' || rec.data['estado'] =='Diferencia_sigma_ppto'){
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).enable();	
			CM_getBoton('validar_ejecucion-'+idContenedor).disable();
			CM_getBoton('generar_sigma-'+idContenedor).disable();
			CM_getBoton('ver_datos-'+idContenedor).enable();
			CM_getBoton('validar_sigma-'+idContenedor).enable();
			CM_getBoton('validar_acumulado-'+idContenedor).disable();
			CM_getBoton('excel_gasto-'+idContenedor).disable();
			CM_getBoton('excel_recurso-'+idContenedor).disable();
			CM_getBoton('verif_arch-'+idContenedor).disable();
			CM_getBoton('gener_arch-'+idContenedor).disable();
			CM_getBoton('anula_tran-'+idContenedor).disable();
		}
		if(rec.data['estado'] =='Generar_archivos'){
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();	
			CM_getBoton('validar_ejecucion-'+idContenedor).disable();
			CM_getBoton('generar_sigma-'+idContenedor).disable();
			CM_getBoton('ver_datos-'+idContenedor).enable();
			CM_getBoton('validar_sigma-'+idContenedor).disable();
			CM_getBoton('validar_acumulado-'+idContenedor).disable();
			CM_getBoton('excel_gasto-'+idContenedor).enable();
			CM_getBoton('excel_recurso-'+idContenedor).enable();
			CM_getBoton('verif_arch-'+idContenedor).enable();
			CM_getBoton('gener_arch-'+idContenedor).enable();
			CM_getBoton('anula_tran-'+idContenedor).enable();
		}
		if(rec.data['estado'] =='Anulado_sigma'){
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();	
			CM_getBoton('validar_ejecucion-'+idContenedor).disable();
			CM_getBoton('generar_sigma-'+idContenedor).disable();
			CM_getBoton('ver_datos-'+idContenedor).disable();
			CM_getBoton('validar_sigma-'+idContenedor).disable();
			CM_getBoton('validar_acumulado-'+idContenedor).disable();
			CM_getBoton('excel_gasto-'+idContenedor).disable();
			CM_getBoton('excel_recurso-'+idContenedor).disable();
			CM_getBoton('verif_arch-'+idContenedor).disable();
			CM_getBoton('gener_arch-'+idContenedor).disable();
			CM_getBoton('anula_tran-'+idContenedor).disable();
		}
	}
	layout.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}