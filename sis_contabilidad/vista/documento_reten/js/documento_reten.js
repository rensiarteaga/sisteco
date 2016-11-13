function documento_reten(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var txt_id_moneda;
	var id_parametro,id_periodo_subsistema,desc_periodo,desc_usuario,desc_depto,cmb_depto,intGestion,cmb_gestion,cmb_periodo,cmb_usuario,chkComprobante,id_gestion,cmb_tipo_reporte,id_usuario,chkGestion,id_periodo,chkTotales;
	var desc_gestion,sw_retencion;
		
	//DATA STORE
	var	ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro',totalRecords: 'TotalCount'}, ['id_parametro','id_gestion','desc_gestion','estado_gestion','gestion_conta'])});
    
	var ds_periodo_subsis = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoGestionSubsis.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'}, ['id_periodo_subsistema','id_periodo','desc_periodo','estado_periodo','periodo']),baseParams:{sw_reporte:'libro_compra'}});

    var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
    });
   
    var ds_usuario=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto_usuario/ActionListarDepartamentoUsuario.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_depto_usuario','id_depto','desc_depto','id_usuario','desc_usuario','apellido_paterno_persona','apellido_materno_persona','nombre_persona','estado','doc_id'])
    });
   
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?todos=no'}),
	reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B50000">{nombre_depto}</FONT>','</div>');				
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<FONT COLOR="#B50000"><b> - </b>{simbolo}</FONT>','</div>');
    var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>Gestion</i></b>','<br><FONT COLOR="#B5A642">{desc_gestion}</FONT>','</div>');
    var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#B50000">{desc_usuario}</FONT>','</div>');

    vectorAtributos[0]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento', 
			vtype:'texto',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:50,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:300,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		save_as:'id_depto'
	};
		
	var filterCols_parametro=new Array();
	var filterValues_parametro=new Array();
	filterCols_parametro[0]='estado_gestion';
	filterValues_parametro[0]='2';
	vectorAtributos[1]= {
		validacion: {
			name: 'gestion',
			fieldLabel:'Gestión',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'gestion',
			store:ds_gestion,
			valueField: 'id_parametro',
			displayField: 'desc_gestion',
			queryParam: 'filterValue_0',
			filterCols:filterCols_parametro,
			filterValues:filterValues_parametro,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:200,
			pageSize:20,
			minListWidth:200,
			grow:true,
			width:200,
			minChars:1,
			triggerAction:'all',
			editable:true
		},
		tipo:'ComboBox',
		save_as:'id_parametro'
	};

	var filterCols_periodo=new Array();
	var filterValues_periodo=new Array();
	filterCols_periodo[0]='PERIOD.id_gestion';
	filterValues_periodo[0]='x';
	filterCols_periodo[2]='PERSIS.id_subsistema';
	filterValues_periodo[2]='12';
	vectorAtributos[2]= {
		validacion: {
			name: 'id_periodo_subsis',
			fieldLabel:'Periodo',
			allowBlank:false,
			emptyText:'Periodo...',
			desc: 'desc_periodo',
			store:ds_periodo_subsis,
			valueField: 'id_periodo_subsistema',
			displayField: 'desc_periodo',
			filterCols:filterCols_periodo,
			filterValues:filterValues_periodo,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:200,
			pageSize:20,
			minListWidth:200,
			grow:true,
			width:200,
			minChars:1,
			triggerAction:'all',
			editable:true
		},
		tipo:'ComboBox',
		save_as:'id_periodo_subsis'
	};
	
	 vectorAtributos[3]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
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
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	 
	var filterCols_usuario=new Array();
	var filterValues_usuario=new Array();
	filterCols_usuario[0]='DEPTO.id_depto';
	filterValues_periodo[0]='x';
	vectorAtributos[4]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Responsable',
			allowBlank:false,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.id_depto',
			filterCols:filterCols_usuario,
			filterValues:filterValues_usuario,
			typeAhead:false,
			tpl:tpl_id_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:50,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:300,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.id_depto',
		save_as:'id_usuario'
	};
	
	vectorAtributos[5]={
		validacion:{
			name:'sw_retencion',
			fieldLabel:'Retención',
			vtype:'texto',
			emptyText:'Elija la retención...',
			allowBlank:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[[3,'Bienes'],[4,'Servicios'],[5,'RC-IVA'],[6,'Recibos S/R']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'sw_retencion',
		defecto:'3'
	};
	
	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'por_comprobante',
			fieldLabel:'Por Cbte.:',
			allowBlank:true,
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Checkbox',
		filtro_0:false,
		save_as:'por_comprobante'
	};
	
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'toda_gestion',
			fieldLabel:'Toda la Gestión:',
			allowBlank:true,
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Checkbox',
		filtro_0:false,
		save_as:'toda_gestion'
	};
	
	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'sw_totales',
			fieldLabel:'Totales:',
			allowBlank:true,
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Checkbox',
		filtro_0:false,
		save_as:'sw_totales'
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf','PDF'],['xls','Excel'],['rtf',' Word']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Retenciones"
	};
	var layout_documento_reten=new DocsLayoutProceso(idContenedor);
	layout_documento_reten.init(config);
	
	//---------         INICIAMOS HERENCIA           -----------//
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,documento_reten,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		txt_id_depto = ClaseMadre_getComponente('id_depto');
		cmb_depto = ClaseMadre_getComponente('id_depto');
		cmb_gestion = ClaseMadre_getComponente('gestion');
		cmb_periodo = ClaseMadre_getComponente('id_periodo_subsis');
		txt_id_moneda = ClaseMadre_getComponente('id_moneda');
		cmb_usuario = ClaseMadre_getComponente('id_usuario');
		sw_retencion = ClaseMadre_getComponente('sw_retencion');
		chkComprobante=ClaseMadre_getComponente('por_comprobante');
		chkGestion=ClaseMadre_getComponente('toda_gestion');
		cmb_tipo_reporte=ClaseMadre_getComponente('tipo_reporte');
		chkTotales=ClaseMadre_getComponente('sw_totales');
		
		var onGestionSelect = function(e) {
			var id = cmb_gestion.getValue();
			if(cmb_gestion.store.getById(id)!=undefined){
				id_gestion=cmb_gestion.store.getById(id).data.id_gestion;
				
				intGestion=cmb_gestion.store.getById(id).data.desc_gestion;
				
				cmb_periodo.filterValues[0]=id_gestion;
				cmb_periodo.modificado = true;
				cmb_periodo.setValue('');
			}
		};
		
		function set_desc_moneda(combo,record, index){txt_desc_moneda=record.data.nombre}
		
		var onDeptoSelect =function(e){
			var id_depto=txt_id_depto.getValue();
			if(txt_id_depto.store.getById(id_depto)!=undefined){
				cmb_usuario.filterValues[0]=id_depto;
				cmb_usuario.modificado = true;
				cmb_usuario.setValue('');
				txt_codigo_depto=txt_id_depto.store.getById(id_depto).data.codigo_depto;
			}	
		}
		
		function set_desc_usuario(combo,record, index){
			desc_usuario=record.data.nombre_persona+' '+record.data.apellido_paterno_persona+' '+record.data.apellido_materno_persona;
			id_usuario=record.data.id_usuario;
			doc_id=record.data.doc_id
		}
		
		function set_desc_depto(combo,record, index){
			desc_depto=record.data.nombre_depto;
		}
		
		function set_periodo(combo,record, index){
			id_periodo=record.data.id_periodo_subsistema;
		    desc_periodo=record.data.desc_periodo;
		}

		txt_id_moneda.on('select',set_desc_moneda);
		txt_id_depto.on('select',onDeptoSelect);
		cmb_gestion.on('select',onGestionSelect);
		cmb_gestion.on('change',onGestionSelect);
		cmb_periodo.on('select',set_periodo);
		cmb_usuario.on('select',set_desc_usuario);
		cmb_depto.on('select',set_desc_depto);	
	}
	
    //----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Detalle Facturación',
			fileUpload:false,
			columnas:[405,305],
			grupos:[{
				tituloGrupo:'libro de retenciones',
				columna:0,
				id_grupo:0
			}],
			parametros: '',
			submit:function (){	
		        var data ='&id_depto='+txt_id_depto.getValue(); 		
				var mensaje="";
				if(txt_id_moneda.getValue()==""){mensaje+=" Debe elegir una moneda";};
				if(txt_id_depto.getValue()==""){mensaje+=" Debe elegir departamento contable";};

				if(mensaje==""){
					data +='&id_gestion='+id_gestion;
					data +='&id_periodo='+id_periodo;
					data +='&id_moneda='+txt_id_moneda.getValue();
					data +='&id_usuario='+id_usuario;
					data +='&codigo_depto='+txt_codigo_depto;
					data +='&desc_depto='+desc_depto;
					data +='&desc_gestion='+intGestion;
					data +='&desc_periodo='+desc_periodo;
					data +='&desc_moneda='+txt_desc_moneda;
					data +='&desc_usuario='+desc_usuario;
					data +='&doc_id='+doc_id;
					data +='&sw_retencion='+sw_retencion.getValue();
					data +='&por_comprobante='+chkComprobante.getValue();
					data +='&toda_gestion='+chkGestion.getValue();
					data +='&tipo_reporte='+cmb_tipo_reporte.getValue();
					data +='&sw_totales='+chkTotales.getValue();
					
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_documento_reten.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento_reten/documento_reten_det.php?'+data,'Detalle Retenciones',ParamVentana);
				}
				else{
					alert(mensaje);
				}
			}
		}
	}
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}

