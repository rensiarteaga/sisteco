/**
 * Nombre:		  	    pagina_sub_tipo_activo_cuenta.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 10:18:01
 */
function pagina_sub_tipo_activo_cuenta(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sub_tipo_activo_cuenta/ActionListarSubTipoActivoCuenta.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_adq',totalRecords:'TotalCount'
		},[		
		'id_sub_tipo_activo_cuenta',
		'id_sub_tipo_activo',
		'estado_reg',
		'id_usuario_reg',
		'desc_usuario',
		'id_cuenta',
		'desc_cuenta',
		'id_auxiliar',
		'desc_auxiliar',
		'id_proceso',
		'desc_proceso',
		'id_gestion',
		'gestion',
		'id_presupuesto',
		'desc_estructura',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},'id_cuenta2','id_auxiliar2','desc_cuenta2','desc_auxiliar2','id_fina_regi_prog_proy_acti','desc_epe'

		]),remoteSort:true});

	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
			/*,
			m_id_sub_tipo_activo:maestro.id_sub_tipo_activo*/
	/*	}
	});*/
	// DEFINICIÓN DATOS DEL MAESTRO
	var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_usuario','nombre','desc_usuario'])
	});
	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta'])
	}); 
	var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar'])
	});
	var ds_proceso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/proceso/ActionListaProceso.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proceso',totalRecords:'TotalCount'},['id_proceso','descripcion','codigo'])
	});
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion'])
	});

	
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ])
	
	});
	
	var ds_cuenta2 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta'])
	}); 
	var ds_auxiliar2 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar'])
	});
	
	
	function render_id_estructura(value, p, record){return String.format('{0}', record.data['desc_estructura']);}
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	//var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');
	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
	function render_id_proceso(value, p, record){return String.format('{0}', record.data['desc_proceso']);}
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	function render_id_cuenta2(value, p, record){return String.format('{0}', record.data['desc_cuenta2']);}
	function render_id_auxiliar2(value, p, record){return String.format('{0}', record.data['desc_auxiliar2']);}
	

	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_cuenta}</FONT>','</div>'); 
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b><i>{codigo_auxiliar}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_auxiliar}</FONT>','</div>');
	var tpl_id_proceso=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>',' - ','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Estructura Programatica:  <FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br> <b><FONT COLOR="#B5A642">{desc_presupuesto}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
 
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
		

	var tpl_id_cuenta2=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_cuenta}</FONT>','</div>'); 
	var tpl_id_auxiliar2=new Ext.Template('<div class="search-item">','<b><i>{codigo_auxiliar}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_auxiliar}</FONT>','</div>');
	//DATA STORE COMBOS

	//FUNCIONES RENDER

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_categoria_adq
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_sub_tipo_activo_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_sub_tipo_activo_cuenta'
	};
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_sub_tipo_activo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_sub_tipo_activo'
	};
	
	
	
	Atributos[2]={
			validacion:{
				name:'id_gestion',
				fieldLabel:'Gestion',
				allowBlank:true,
				emptyText:'Gestion...',
				desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_gestion,
				valueField:'id_gestion',
				displayField:'gestion',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:false,
				tpl:tpl_id_gestion,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_gestion,
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'GESTIO.gestion',
			save_as:'id_gestion',
			id_grupo:0  //1
		};
	Atributos[3]={
			validacion:{
				name:'id_proceso',
				fieldLabel:'Proceso',
				allowBlank:true,
				emptyText:'Proceso...',
				desc: 'desc_proceso', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_proceso,
				valueField:'id_proceso',
				displayField:'codigo',
				queryParam: 'filterValue_0',
				filterCol:'PRO.codigo#PRO.descripcion',
				typeAhead:false,
				tpl:tpl_id_proceso,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_proceso,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'PROCES.codigo#PROCES.descripcion',
			save_as:'id_proceso',
			id_grupo:0  //1
		};
		Atributos[4]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'EP....',
			desc:'desc_estructura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_epe',
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
			renderer:render_id_estructura,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			width_grid:150,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width:'100%',
			disabled:true,
			grid_indice:2
		},
		tipo:'ComboBox',
		form:true,
		filterColValue:'ESTPRO.desc_epe',
		filtro_0:true,
		save_as:'id_presupuesto',
		id_grupo:2
	};
	
	
	
	Atributos[5]={
			validacion:{
				name:'id_cuenta',
				fieldLabel:'Cuenta',
				allowBlank:true,
				emptyText:'Cuenta...',
				desc: 'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cuenta,
				valueField:'id_cuenta',
				displayField:'nombre_cuenta',
				queryParam: 'filterValue_0',
				filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
				typeAhead:false,
				tpl:tpl_id_cuenta,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_cuenta,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:3
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			save_as:'id_cuenta',
			id_grupo:1  //1
		};
		
		
		Atributos[6]={
			validacion:{
				name:'id_auxiliar',
				fieldLabel:'Auxiliar',
				allowBlank:true,
				emptyText:'Auxiliar...',
				desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_auxiliar,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam: 'filterValue_0',
				filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				typeAhead:false,
				tpl:tpl_id_auxiliar,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_auxiliar,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:4
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			save_as:'id_auxiliar',
			id_grupo:1  //1
		};
		
		
		Atributos[7]={
			validacion:{
				name:'id_cuenta2',
				fieldLabel:'Cuenta2',
				allowBlank:true,
				emptyText:'Cuenta...',
				desc: 'desc_cuenta2', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cuenta2,
				valueField:'id_cuenta',
				displayField:'nombre_cuenta',
				queryParam: 'filterValue_0',
				filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
				typeAhead:false,
				tpl:tpl_id_cuenta2,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_cuenta2,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:5
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			save_as:'id_cuenta2',
			id_grupo:1  //1
		};
		
		
		Atributos[8]={
			validacion:{
				name:'id_auxiliar2',
				fieldLabel:'Auxiliar2',
				allowBlank:true,
				emptyText:'Auxiliar...',
				desc: 'desc_auxiliar2', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_auxiliar2,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam: 'filterValue_0',
				filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				typeAhead:false,
				tpl:tpl_id_auxiliar2,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_auxiliar2,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:6
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			save_as:'id_auxiliar2',
			id_grupo:1  //1
		};
		
	Atributos[9]={
			validacion:{
				name:'id_usuario_reg',
				fieldLabel:'Usuario',
				allowBlank:true,
				emptyText:'Usuario...',
				desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
				valueField:'id_usuario',
				displayField:'desc_usuario',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				//renderer:render_id_usuario,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false,
				grid_indice:7
			},
			tipo:'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			save_as:'id_usuario_reg'
			
		};
	// txt fecha_reg
	Atributos[10]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:105,
			disabled:true,
			grid_indice:8
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SUTIAC.fecha_reg',
		dateFormat:'m-d-Y',
		id_grupo:0  
	};
	
		// txt estado
	Atributos[11]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
		store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:false,
			maxLength:10,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			align:'right',
			width:80,
			disable:true,
			grid_indice:9
		},
		tipo: 'ComboBox',
		defecto:'activo',
		form: true,
		filtro_0:true,
		filterColValue:'SUTIAC.estado_reg',
		save_as:'estado_reg'
	};
	
		
		
		
	
	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			fieldLabel:'EP',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%'
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'id_fina_regi_prog_proy_acti',
		id_grupo:2
	};
	
	Atributos[13]={
		validacion:{
			labelSeparator:'',
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			grid_visible:false,
			grid_editable:false,
			width:'100%',
			disabled:true
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'id_unidad_organizacional',
		id_grupo:2
	};
	
	/*Atributos[10]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional', 
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional',
		id_grupo:2
	};

*/
		
	

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Sub Tipo(Maestro)',titulo_detalle:'Sub Tipo Activo Cuenta Auxiliar (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_categoria_adq = new DocsLayoutMaestro(idContenedor);
	layout_tipo_categoria_adq.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_tipo_categoria_adq,idContenedor);
//	var ClaseMadre_getComponente=this.getComponente;
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/sub_tipo_activo_cuenta/ActionEliminarSubTipoActivoCuenta.php'},
	Save:{url:direccion+'../../../control/sub_tipo_activo_cuenta/ActionGuardarSubTipoActivoCuenta.php'},
	ConfirmSave:{url:direccion+'../../../control/sub_tipo_activo_cuenta/ActionGuardarSubTipoActivoCuenta.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['47%','47%'],
			grupos:[
			{
				tituloGrupo:'Datos Sub Tipo Cuenta',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Datos Cuenta-Auxiliar',
				columna:1,
				id_grupo:1
			},{
				tituloGrupo:'Datos Presupuesto',
				columna:0,
				id_grupo:2
			}
			],
			width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'Sub Tipo Activo Cuenta'}};
	
	
	

	//-------------- Sobrecarga de funciones --------------------//
	this.btnNew = function()
	{
		get_fecha_bd();
		ClaseMadre_btnNew()
	};
	
	
	this.btnEdit = function(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas
		if(NumSelect != 0){		
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			getComponente('id_fina_regi_prog_proy_acti').setRawValue(SelectionsRecord.data.desc_epe);
			getComponente('id_unidad_organizacional').setRawValue(SelectionsRecord.data.desc_unidad_organizacional);
			ds_cuenta.baseParams={m_id_gestion:SelectionsRecord.data.id_gestion};
			ds_cuenta.modificado=true;
			ds_presupuesto.baseParams={id_gestion:SelectionsRecord.data.id_gestion};
			ds_presupuesto.modificado=true;
			
			ds_cuenta2.baseParams={m_id_gestion:SelectionsRecord.data.id_gestion};
			ds_cuenta2.modificado=true;
			getComponente('id_cuenta').enable();
			getComponente('id_cuenta2').enable();
			getComponente('id_presupuesto').enable();
			CM_btnEdit();
		}else{
			alert('Antes debe seleccionar un item');
		}
	};
	
	  function get_fecha_bd()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}
	
	function cargar_fecha_bd(resp)
	{   
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
			
			
		}
	}
	
		this.reload=function(m){
				maestro=m;

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_sub_tipo_activo:maestro.id_sub_tipo_activo
					}
				};
				this.btnActualizar();
				
				Atributos[1].defecto=maestro.id_sub_tipo_activo;
				paramFunciones.btnEliminar.parametros='&m_id_sub_tipo_activo='+maestro.id_sub_tipo_activo;
				paramFunciones.Save.parametros='&m_id_sub_tipo_activo='+maestro.id_sub_tipo_activo;
				paramFunciones.ConfirmSave.parametros='&m_id_sub_tipo_activo='+maestro.id_sub_tipo_activo;
				this.InitFunciones(paramFunciones)
			};
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for(i=0;i<Atributos.length;i++)
		{
			componentes[i]=getComponente(Atributos[i].validacion.name)
		}
		sm=getSelectionModel()
		combo_cuenta=getComponente('id_cuenta');
		combo_gestion=getComponente('id_gestion');
		combo_ep=getComponente('id_presupuesto');
		combo_auxiliar=getComponente('id_auxiliar');
		id_unidad_organizacional=getComponente('id_unidad_organizacional');
		id_fina_regi_prog_proy_acti=getComponente('id_fina_regi_prog_proy_acti');
		combo_cuenta2=getComponente('id_cuenta2');
		combo_auxiliar2=getComponente('id_auxiliar2');
		
		var onGestionSelect = function(e) {
			combo_cuenta.setValue('');
			combo_auxiliar.setValue('');
			combo_ep.setValue('');
			combo_cuenta2.setValue('');
			combo_auxiliar2.setValue('');
		    
			var id_gestion  = combo_gestion.getValue();
			
			ds_cuenta.baseParams=({"m_id_gestion":id_gestion});
			ds_cuenta2.baseParams=({"m_id_gestion":id_gestion});
			ds_presupuesto.baseParams=({"id_gestion":id_gestion});
			combo_ep.modificado=true;
			combo_cuenta.modificado=true;
			combo_cuenta.enable();
			combo_cuenta2.modificado=true;
			combo_cuenta2.enable();
			
			combo_ep.enable();
			getComponente('id_auxiliar').setValue('');
			getComponente('id_auxiliar').modificado=true;
			
			getComponente('id_auxiliar2').setValue('');
			getComponente('id_auxiliar2').modificado=true;
			combo_auxiliar.disable();
			combo_auxiliar2.disable();
			
		};
		
		var onCuentaSelect =function(e){
			combo_auxiliar.setValue('');
			var id_cuenta = combo_cuenta.getValue();
			if(id_cuenta!=undefined){
			ds_auxiliar.baseParams=({"cuenta":id_cuenta})
			combo_auxiliar.enable();
			combo_auxiliar.modificado=true;
			}
		};
		
		var onCuenta2Select =function(e){
			combo_auxiliar2.setValue('');
			var id_cuenta2 = combo_cuenta2.getValue();
			if(id_cuenta2!=undefined){
			ds_auxiliar2.baseParams=({"cuenta":id_cuenta2})
			combo_auxiliar2.enable();
			combo_auxiliar2.modificado=true;
			}
		};
		
		var onEstructuraSelect= function(e){
			var id_ep=combo_ep.getValue();
			id_fina_regi_prog_proy_acti.setValue(combo_ep.store.getById(id_ep).data.id_fina_regi_prog_proy_acti);
			id_unidad_organizacional.setValue(combo_ep.store.getById(id_ep).data.id_unidad_organizacional);
			id_unidad_organizacional.setRawValue(combo_ep.store.getById(id_ep).data.nombre_unidad);				
			id_fina_regi_prog_proy_acti.setRawValue(combo_ep.store.getById(id_ep).data.desc_epe);
		};
		
		 combo_ep.on('select',onEstructuraSelect);
		 combo_cuenta.on('select',onCuentaSelect);
		 combo_cuenta2.on('select',onCuenta2Select);
		 combo_gestion.on('select',onGestionSelect);
		
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_categoria_adq.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	//	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Estado Compra Categoria',btn_estado_compra_categoria_adq,true,'estado_compra_categoria_adq','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_tipo_categoria_adq.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}