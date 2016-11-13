function ReporteOrdenCompra(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var componentes=new Array();
	var ContPes=1;
	var layout_rep_orden_compra,h_txt_gestion,h_txt_mes,ds_linea;
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
var ds_proveedor=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','mail_proveedor','telefono1_proveedor','desc_insti_per'])
	});
var ds_departamento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo'])
	});
var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si&oc=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),
	baseParams:{m_sw_rendicion:'no',sw_inv_gasto:'si'}
	});
var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});	
	
var ds_servicio= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/servicio/ActionListarServicio_det.php?oc=si&origen=filtro&tipo_vista=reporte_servicios_proveedores'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_servicio',
			totalRecords: 'TotalCount'
		}, ['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio','desc_tipo_servicio','codigo_entero','continuo','estado','desc_tipo_adq'])
	});
	
var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_almacenes/control/item/ActionListarItem.php?oc=si'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg','mat_bajo_responsabilidad'])
	});
	
function renderServicio(value, p, record){return String.format('{0}', record.data['nombre']);}	
function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}	
var tpl_id_servicio=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{nombre}</I></B></FONT><br>','<FONT COLOR="#B5A642">{desc_tipo_servicio} <BR> {desc_tipo_adq} </FONT>','</div>');

var tpl_id_item=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{codigo} {nombre}</I></B></FONT><br>','<FONT COLOR="#B5A642">{descripcion} </FONT>','</div>');

var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Estructura Programatica:  <FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br> <b><FONT COLOR="#B5A642">{desc_presupuesto}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');	
var resultTplProv=new Ext.Template('<div class="search-item">','<b><i>{desc_insti_per}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo}</FONT>','<br><FONT COLOR="#B5A642">Email:{mail_proveedor}</FONT>','<br><FONT COLOR="#B5A642">Teléfono:{telefono1_proveedor}</FONT>','</div>');
var resultTplDepto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>','</div>');
var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');
	
vectorAtributos[0]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Tipo de Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Ordenes de Compra con EPs y UOs'],['2','Ordenes de Compra a detalle']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};

/////////// txt gerencia//////
	vectorAtributos[1]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo de Adquisición',
			vtype:'texto',
			emptyText:'Tipo de Adquisición...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['Todos'],['Bien'],['Servicio']]}),
			valueField:'valor',
			displayField:'valor',
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_adquisicion'
	};
	vectorAtributos[2]={
		validacion:{
			fieldLabel:'Departamento',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Depto...',
			name:'departamento',
			desc:'nombre_depto',
			store:ds_departamento,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol :'DEPTO.nombre_depto#DEPTO.codigo_depto',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:4,
		save_as:'departamento',
		tipo:'ComboBox'
	};
	// txt id_unidad_organizacional
	vectorAtributos[3]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc:'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',
			queryParam:'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
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
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_unidad_organizacional',
		id_grupo:4
	};
	//combo presupuesto	
     vectorAtributos[4]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Estructura Programática',
			allowBlank:false,			
			emptyText:'EP....',
			desc:'desc_epe', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_fina_regi_prog_proy_acti',
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
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200,
			disabled:false	
		},
		tipo:'ComboBox',
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_ep',
		id_grupo:4
	};
	vectorAtributos[5]={
		validacion:{
			fieldLabel:'Proveedor',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Proveedor...',
			name:'desc_insti_per',
			desc:'desc_insti_per',
			store:ds_proveedor,
			valueField:'id_proveedor',
			displayField:'desc_insti_per',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplProv,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:3,
		save_as:'proveedor',
		tipo:'ComboBox'
	};
///////// fecha_ini /////////
	vectorAtributos[6]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:3,
		tipo:'DateField',
		save_as:'fecha_ini',
		dateFormat:'m/d/Y',
		defecto:""
	};
	///////// fecha /////////
	vectorAtributos[7]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:3,
		tipo:'DateField',
		save_as:'fecha_fin',
		dateFormat:'m/d/Y',
		defecto:""
	};
	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'unidad_organizacional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'unidad_organizacional'
	};
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'nombre_departamento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'nombre_departamento'
	};
	vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			name:'nombre_proveedor',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'nombre_proveedor'
	};
	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name:'desc_ep',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_ep'
	};
	
	vectorAtributos[12]={
		validacion:{
			fieldLabel:'Servicios',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Servicios...',
			name:'id_servicio',
			desc:'nombre',
			store:ds_servicio,
			valueField:'id_servicio',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'SERVIC.nombre',
			typeAhead:false,
			forceSelection:false,
			renderer:renderServicio,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			tpl:tpl_id_servicio,
			width_grid:180
		},
		
		save_as:'id_servicio',
		tipo:'ComboBox',
		id_grupo:2
	};
	vectorAtributos[13]={
		validacion:{
			fieldLabel:'Código Item',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Item ......',
			name:'id_item',
			desc:'descripcion_item',
			store:ds_item,
			valueField: 'id_item',
			displayField: 'descripcion',
			queryParam:'filterValue_0',
			filterCol:'ite.nombre#ite.codigo',
			typeAhead:false,
			forceSelection:false,
			renderer:render_id_item,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			tpl:tpl_id_item,
			grid_indice:1
			},
		tipo:'ComboBox',
		save_as:'id_item',
		defecto:'',
		id_grupo:1
	};
	
	vectorAtributos[14]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_ini',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'rep_fecha_ini'
	};
	
vectorAtributos[15]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_fin',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'rep_fecha_fin'
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Ordenes de Compra"};
	layout_rep_orden_compra=new DocsLayoutProceso(idContenedor);
	layout_rep_orden_compra.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_rep_orden_compra,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	ds_proveedor.addListener('loadexception',ClaseMadre_conexionFailure);
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios()
	{			
				
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		CM_ocultarGrupo('Servicios');
		CM_ocultarGrupo('Items');
				
		componentes[2].on('select',evento_departamento);	//tipo_pres	
		componentes[3].on('select',evento_uo);		//presupuesto
		componentes[4].on('select',evento_estructura);		//estructura		
		componentes[5].on('select',evento_proveedor);		//proveedor
		componentes[1].on('select',evento_tipo_adq);	//
		componentes[0].on('select',evento_tipo_reporte);	//
		componentes[6].on('change',evento_fecha_inicio);	//
		componentes[7].on('change',evento_fecha_fin);	//
		
		
		
		
	}
	
	
	function evento_fecha_inicio(combo,record,index) {
			var fecha_inicio_val=componentes[6].getValue();
				componentes[7].minValue=fecha_inicio_val;
				
				componentes[14].setValue(formatDate(componentes[6].getValue()));
				
				
			
		}
	function  evento_fecha_fin(combo,record,index) {
			 var fecha_fin_val=componentes[7].getValue();
				componentes[15].setValue(formatDate(componentes[7].getValue()));
			
		}
	
	
	
	function evento_tipo_adq(combo,record,index){
		if (componentes[0].getValue()=='2'){
			if(componentes[1].getValue()=='Bien'){
				//ocultar grupo de servicios
				CM_ocultarGrupo('Servicios');
				//Mostrar grupo de items
				CM_mostrarGrupo('Items');
				componentes[12].allowBlank=true;
				componentes[12].reset();//
				
			} else{
				//ocultar grupo items
				componentes[13].allowBlank=true;
				componentes[13].reset();
				CM_ocultarGrupo('Items');
				//Mostrar grupo de servicios
				CM_mostrarGrupo('Servicios');
				
			}
			if (componentes[1].getValue()=='Todos'){
				CM_ocultarGrupo('Servicios');
				CM_ocultarGrupo('Items');
				componentes[12].allowBlank=true;
				componentes[13].allowBlank=true;
				componentes[12].reset();
				componentes[13].reset();
			}
			
		}
		else{
			CM_ocultarGrupo('Servicios');
			CM_ocultarGrupo('Items');
			componentes[12].allowBlank=true;
			componentes[13].allowBlank=true;
			componentes[12].reset();
			componentes[13].reset();
								
		}
	}
	
	function evento_tipo_reporte(combo,record,index){ componentes[5].reset();
		if(componentes[0].getValue()!='2'){
			CM_ocultarGrupo('Servicios');
			CM_ocultarGrupo('Items');
			componentes[12].allowBlank=true;
			componentes[13].allowBlank=true;
			componentes[12].reset();
			componentes[13].reset();
			
		}else{
			componentes[1].reset();
			
		}
		
	}
	
	
	function evento_departamento( combo, record, index )
	{
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		componentes[9].setValue(record.data.codigo_depto+'-'+record.data.nombre_depto);
		
	}
	function evento_uo( combo, record, index )
	{
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		componentes[8].setValue(record.data.nombre_unidad);
		
	}
	function evento_estructura( combo, record, index )
	{
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		
		componentes[11].setValue(record.data.desc_epe);
		
	}
	
	function evento_proveedor( combo, record, index )
	{
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		
		componentes[10].setValue(record.data.desc_insti_per);
		
	}
	
	
	
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Ordenes de Compra "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,
		            url:direccion+'../../../../../sis_adquisiciones/control/_reportes/orden_compra/ActionPDFOrdenCompraDetallado.php',
		            abrir_pestana:true,
		            titulo_pestana:obtenerTitulo,
		            fileUpload:false,columnas:[420,420],
			        grupos:[{tituloGrupo:'Datos de Orden de Compra',
			        		 columna:0,
			        		 id_grupo:0
			        		},
			        		{tituloGrupo:'Items',
			        		 columna:0,
			        		 id_grupo:1
			        		},
			        		{tituloGrupo:'Servicios',
			        		 columna:0,
			        		 id_grupo:2
			        		},
			        		{tituloGrupo:'Fechas, Proveedor',
			        		 columna:0,
			        		 id_grupo:3
			        		},
			        		{tituloGrupo:'Ubicación',
			        		 columna:1,
			        		 id_grupo:4
			        		}
			        		],
			        parametros:''}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}