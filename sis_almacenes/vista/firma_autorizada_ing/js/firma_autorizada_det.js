/**
 * Nombre:		  	    pagina_firma_autorizada_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-17 15:50:00
 */
function pagina_firma_autorizada_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,ds_empleado_tpm_frppa,ds_almacen;
	var elementos=new Array();
	var combo_almacen,combo_empleado,cmb_ep,data_ep,txt_estado_reg,txt_fecha_reg,txt_id_motivo_salida;
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/firma_autorizada/ActionListarFirmaAutorizada_ing_det.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_firma_autorizada',
			totalRecords:'TotalCount'
		},[
		'id_firma_autorizada',
		'descripcion',
		'prioridad',
		'estado_reg',
		'observaciones',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_empleado_frppa',
		'desc_empleado_tpm_frppa',
		'id_motivo_salida',
		'desc_motivo_salida',
		'desc_motivo_ingreso',
		'id_motivo_ingreso',
		'id_almacen_ep',
		'desc_almacen_ep',
		'nombre_completo',
		'desc_almacen',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'id_almacen'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_motivo_ingreso:maestro.id_motivo_ingreso
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
  	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['Id Motivo Ingreso',maestro.id_motivo_ingreso],['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
    ds_empleado_tpm_frppa=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoUsuarioTpmFrppaEP.php'}),
			reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_frppa',
			totalRecords:'TotalCount'
		}, ['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti','desc_nombrecompleto','ci','email'])
	});
	ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen/ActionListarAlmacenEP.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_almacen',
			totalRecords:'TotalCount'
		},['id_almacen','nombre','descripcion'])
		});
	//FUNCIONES RENDER
		function render_id_empleado_frppa(value, p, record){return String.format('{0}', record.data['nombre_completo'])}
		function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen'])}
	// Template combo
	var resultTplAlmacen=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplEmpTpm=new Ext.Template('<div class="search-item">','<b><i>{desc_nombrecompleto}</i></b>','<br><FONT COLOR="#B5A642">Documento:{ci}</FONT>','<br><FONT COLOR="#B5A642">Email:{email}</FONT>','</div>');
	// Definición de datos //
	// hidden id_firma_autorizada
	vectorAtributos[0]={
		validacion:{
		   labelSeparator:'',
			name:'id_firma_autorizada',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_firma_autorizada'
	};
//txt ep
  vectorAtributos[1]={
			validacion:{
				fieldLabel:'EP',
				allowBlank:false,
				vtype:"texto",
				emptyText:'Estructura Programática',
				name:'id_ep', 
				minChars:1,
				triggerAction:'all',
				
				grid_editable:false,
				grid_visible:true,
				grid_indice:14,
				width:320
			},
			tipo:'epField',
			save_as:'hidden_id_ep1'
		};
        var filterCols_almacen=new Array();
		var filterValues_almacen=new Array();
//txt almacen
	vectorAtributos[2]={
		validacion:{
				name:'id_almacen',
				fieldLabel:'Almacén Físico',
				allowBlank:true,
				emptyText:'Almacén Físico...',
				desc:'desc_almacen', 
				store:ds_almacen,
				valueField:'id_almacen',
				displayField:'nombre',
				queryParam:'filterValue_0',
				filterCol:'ALMACE.nombre#ALMACE.descripcion',
				filterCols:filterCols_almacen,
				filterValues:filterValues_almacen,
				typeAhead:true,
				forceSelection:false,
				tpl:resultTplAlmacen,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:450,
				grow:true,
				width:300,
				resizable:true,
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_almacen,
				grid_visible:true,
				grid_editable:false,
				grid_indice:1,
				width_grid:100 
			},
			tipo:'ComboBox',
			filtro_0:false,
			filterColValue:'ALMACE.nombre',
			defecto:'',
			save_as:'txt_id_almacen'
		};
// txt id_empleado_frppa
 var filterCols_empleado_frppa=new Array();
 var filterValues_empleado_frppa=new Array();
	vectorAtributos[3]={
			validacion:{
			name:'id_empleado_frppa',
			fieldLabel:'Funcionario',
			allowBlank:false,			
			emptyText:'Funcionario...',
			desc:'nombre_completo',
			store:ds_empleado_tpm_frppa,
			valueField:'id_empleado_frppa',
			displayField:'desc_nombrecompleto',
			queryParam:'filterValue_0',
			filterCol:'PER.nombre#PER.apellido_paterno#PER.apellido_materno#PER.doc_id#PER.email1',
			filterCols:filterCols_empleado_frppa,
			filterValues:filterValues_empleado_frppa,
			typeAhead:true,
			forceSelection:true,
			tpl:resultTplEmpTpm,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_frppa,
			grid_visible:true,
			grid_editable:false,
			grid_indice:0,
			width_grid:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PER.nombre#PER.apellido_paterno#PER.apellido_materno#PER.doc_id#PER.email1',
		defecto:'',
		save_as:'txt_id_empleado_frppa'
	};
// txt prioridad
	vectorAtributos[4]={
		validacion:{
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:60
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'FIRAUT.prioridad',
		save_as:'txt_prioridad'
	};
// txt descripcion
	vectorAtributos[5]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'FIRAUT.descripcion',
		save_as:'txt_descripcion'
	};
// txt observaciones
	vectorAtributos[6]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'FIRAUT.observaciones',
		save_as:'txt_observaciones'
	};
// txt estado_reg
	vectorAtributos[7]={
			validacion:{
			name:'estado_reg',
			fieldLabel:'Estado registro',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.firma_autorizada_combo.estado_reg}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:95 
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'FIRAUT.estado_reg',
		defecto:'activo',
		save_as:'txt_estado_reg'
	};
// txt fecha_reg
	vectorAtributos[8]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:90,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'FIRAUT.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
// txt id_motivo_salida
	vectorAtributos[9]={
			validacion:{
			name:'id_motivo_salida',
			fieldLabel:'Motivo Salida',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
			},
		tipo:'TextField',
		filtro_0:false,
		defecto:'',
		save_as:'txt_id_motivo_salida'
	};
// txt id_motivo_ingreso
	vectorAtributos[10]={
		validacion:{
			name:'id_motivo_ingreso',
			labelSeparator:'',
			inputType:'hidden',
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_motivo_ingreso,
		save_as:'txt_id_motivo_ingreso'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Motivo Ingreso (Maestro)',titulo_detalle:'Funcionarios para Autorización(Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_firma_autorizada=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_firma_autorizada.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_firma_autorizada,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
    var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/firma_autorizada/ActionEliminarFirmaAutorizada.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	Save:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizada.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	ConfirmSave:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizada.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:390,width:500,minWidth:150,minHeight:200,closable:true,titulo: 'Funcionarios para Autorización'}};
  	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_motivo_ingreso=datos.m_id_motivo_ingreso;
		maestro.nombre=datos.m_nombre;
		maestro.descripcion=datos.m_descripcion;
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Motivo Ingreso',maestro.id_motivo_ingreso],['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]);
		vectorAtributos[10].defecto=maestro.id_motivo_ingreso;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/firma_autorizada/ActionEliminarFirmaAutorizada.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	    Save:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizada.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	    ConfirmSave:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizada.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	    Formulario:{html_apply:'dlgInfo-'+idContenedor,height:390,width:500,minWidth:150,minHeight:200,closable:true,titulo: 'Funcionarios para Autorización'}
	    };
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_motivo_ingreso:maestro.id_motivo_ingreso
			}
		};
		this.btnActualizar();
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
	   combo_almacen=ClaseMadre_getComponente('id_almacen');
	   combo_empleado=ClaseMadre_getComponente('id_empleado_frppa');
       cmb_ep=ClaseMadre_getComponente('id_ep');
       txt_estado_reg=ClaseMadre_getComponente('estado_reg');
       txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
       txt_id_motivo_salida=ClaseMadre_getComponente('id_motivo_salida');
       var onEpSelect=function(e){
		   var ep=cmb_ep.getValue();
		   data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
		   actualizar_ds_combos();
		   combo_almacen.setValue('');
		   combo_empleado.setValue('');
		   combo_almacen.modificado=true;
		   combo_empleado.modificado=true
			};
		  cmb_ep.on('change',onEpSelect)
	}
	function actualizar_ds_combos(){
		var datos=Ext.urlDecode(decodeURIComponent(data_ep)); 	
		Ext.apply(combo_almacen.store.baseParams,datos);
		Ext.apply(combo_empleado.store.baseParams,datos)
		}
 	this.btnNew=function(){
		CM_ocultarComponente(txt_estado_reg);
		CM_ocultarComponente(txt_fecha_reg);
		CM_ocultarComponente(txt_id_motivo_salida);
		cmb_ep.enable();
		combo_almacen.enable();
		combo_empleado.enable();
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(txt_estado_reg);
		CM_ocultarComponente(txt_fecha_reg);
		CM_ocultarComponente(txt_id_motivo_salida);
		ClaseMadre_btnEdit()
	};
	this.getLayout=function(){
		return layout_firma_autorizada.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_firma_autorizada.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}