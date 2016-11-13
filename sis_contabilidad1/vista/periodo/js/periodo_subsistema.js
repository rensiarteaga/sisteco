/**
 * Nombre:		  	    pagina_periodo_subsistema.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 16:05:15
 */
function pagina_periodo_subsistema(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var maestro;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_periodo_subsistema',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_periodo_subsistema',
		'id_periodo',
		'desc_periodo',
		'estado_periodo',
		'nombre_largo'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	//DATA STORE COMBOS
    var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','denominacion','gestion','periodo'])
	});

	//FUNCIONES RENDER
	function render_id_periodo(value, p, record){return String.format('{0}', record.data['desc_periodo']);}
	var tpl_id_periodo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{denominacion}</FONT><br>','<FONT COLOR="#B5A642">{gestion}</FONT><br>','<FONT COLOR="#B5A642">{periodo}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_periodo_subsistema
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_periodo_subsistema',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	//txt id_periodo
	Atributos[1]={
		validacion:{
			name:'id_periodo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};
	
	// txt estado_periodo
	Atributos[2]={
			validacion: {
			name:'estado_periodo',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['abierto','abierto'],['cerrado','cerrado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:100,
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSIS.estado_periodo',
		defecto:'abierto'
	};
	
	// txt nombre_largo
	Atributos[3]={
		validacion:{
			name:'nombre_largo',
			fieldLabel:'Sistema',
			width_grid:300,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'SUBSIS.nombre_largo',
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Periodo (Maestro)',titulo_detalle:'periodo_subsistema (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_periodo_subsistema = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_periodo_subsistema.init(config);
	
	//---------- INICIAMOS HERENCIA
	var ClaseMadre_conexionFailure=this.conexionFailure
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_periodo_subsistema,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var Cm_btnActualizar=this.btnActualizar;
	
	function btn_doc_cbte_usuario(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0&&SelectionsRecord.data.id_transaccion!=0){ 
			var SelectionsRecord=sm.getSelected();
	    	data='m_id_periodo='+SelectionsRecord.data.id_periodo;
	    	data+='&m_id_periodo_subsistema='+SelectionsRecord.data.id_periodo_subsistema;
			data+='&m_nombre_largo='+SelectionsRecord.data.nombre_largo;
			data+='&m_desc_periodo='+SelectionsRecord.data.desc_periodo;		
			//data+='&m_fecha_inicio='+SelectionsRecord.data.fecha_inicio;
			//data+='&m_fecha_final='+SelectionsRecord.data.fecha_final; alert(data);
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_periodo_subsistema.loadWindows(direccion+'../../../../sis_contabilidad/vista/doc_cbte_usuario/doc_cbte_usuario.php?'+data,'DocumentoComprobanteUsuario',ParamVentana);			
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item ya registrado');
		}
	};
	
	function btn_abrir(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			Ext.MessageBox.confirm("Atención","Esta seguro de abrir periodo?",function(btn){
				if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Abriendo periodo...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> abriendo periodo...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/periodo_subsistema/ActionAbrirCerrarPeriodoSubsistema.php",
					success:mostrar_respuesta,
					params:{accion:'abrir',id_periodo_subsistema:datas_edit.id_periodo_subsistema},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
				} 
			});
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un periodo.');
		}
	}
	
	function btn_abrir(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			Ext.MessageBox.confirm("Atención","Esta seguro de abrir periodo?",function(btn){
				if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Abriendo periodo...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> abriendo periodo...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/periodo_subsistema/ActionAbrirCerrarPeriodoSubsistema.php",
					success:mostrar_respuesta,
					params:{accion:'abrir',id_periodo_subsistema:datas_edit.id_periodo_subsistema},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
				} 
			});
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un periodo.');
		}
	}
		
	function btn_cerrar(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			
			Ext.MessageBox.confirm("Atención","Esta seguro de abrir periodo?",function(btn){
				if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Cerrando periodo...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cerrando periodo...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/periodo_subsistema/ActionAbrirCerrarPeriodoSubsistema.php",
					success:mostrar_respuesta,
					params:{accion:'cerrar',id_periodo_subsistema:datas_edit.id_periodo_subsistema},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
				} 
			});
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un periodo.');
		}
	}
	
	function mostrar_respuesta(resp){
		Ext.MessageBox.hide();
		ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_periodo:maestro.id_periodo
				}
		}
		Cm_btnActualizar();
	}	
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false},editar:{crear:true,separador:false}};
	
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/periodo_subsistema/ActionEliminarPeriodoSubsistema.php'},
	Save:{url:direccion+'../../../control/periodo_subsistema/ActionGuardarPeriodoSubsistema.php'},
	ConfirmSave:{url:direccion+'../../../control/periodo_subsistema/ActionGuardarPeriodoSubsistema.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'periodo_subsistema'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_periodo:maestro.id_periodo
			}
		};
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_periodo;

		paramFunciones.btnEliminar.parametros='&id_periodo='+maestro.id_periodo;
		paramFunciones.Save.parametros='&id_periodo='+maestro.id_periodo;
		paramFunciones.ConfirmSave.parametros='&id_periodo='+maestro.id_periodo;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_periodo_subsistema.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Permisos a Usuario',btn_doc_cbte_usuario,true,'Permisos Usuario','Permisos Usuarios');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Abrir Periodo - Subsistema',btn_abrir,true,'Abrir','Abrir');
 	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Cerrar Periodo - Subsistema',btn_cerrar,true,'Cerrar','Cerrar');
 	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_periodo_subsistema.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}