function Diferencias(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	
	var g_id_declaracion;
	var g_id_partida;
	var g_id_gestion;
	var g_periodo;
	var g_gestion;
	var g_estado;
	var g_tipo_dif;
	var g_partida_desc;
	var g_declara_desc;
	var g_id_dato;
	var g_tipo_dato;
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_declaracion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_sigma/control/declaracion/ActionListarDeclaracion.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_declaracion',totalRecords:'TotalCount'},[	'id_declaracion', 'desc_periodo', 'gestion', 'estado', 'id_gestion'])
    }); 
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    }); 
	
	//FUNCIONES RENDER
	var tpl_id_declaracion=new Ext.Template('<div class="search-item">','<b><FONT COLOR="#000000">{id_declaracion}</FONT></b><br>',
            '<FONT COLOR="#B5A642">Periodo: {gestion} - {desc_periodo}</FONT><br>',
            '<FONT COLOR="#B5A642">Estado: {estado}</FONT>','</div>');
	
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><FONT COLOR="#000000">{codigo_partida} - {nombre_partida}</FONT></b><br>',
            '<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>',
            '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>','</div>');

	vectorAtributos[0]={
			validacion:{
				name: 'tipo_dif',
				fieldLabel:'Consultar',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Diferencias de Ejecución'],['2','Diferencias por Partida'],['3','Resumen Recurso-Percibido'],['4','Consulta por ID']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				width:250		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			defecto:'no',
			save_as:'tipo_dif'
		};
	
	vectorAtributos[1]={
			validacion:{
	 			name:'id_declaracion',
				fieldLabel:'Declaracion ',
				allowBlank:false,			
				emptyText:'Declaracion... ',
				desc: 'id_declaracion', 		
				store:ds_declaracion,
				valueField: 'id_declaracion',
				displayField: 'id_declaracion',
				queryParam: 'filterValue_0',
				filterCol:'DECLAR.id_declaracion#DECLAR.estado',
				typeAhead:false,
				triggerAction:'all',
				tpl:tpl_id_partida,
				forceSelection:true,
				mode:'remote',
				queryDelay:300,
				pageSize:20,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				minChars:1,
				editable:true,
				tpl:tpl_id_declaracion,
	 			grid_visible:true,
	 			grid_editable:true,
				width_grid:200,
				lazyRender:true,
	      		width:250,
				disabled:false		
			}, 
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'DECLAR.id_declaracion#DECLAR.estado',
			save_as:'id_declaracion'
		};
	
	vectorAtributos[2]={
		validacion:{
			name:'mes',
			fieldLabel:'Periodo',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
 			grid_editable:true,
			width:250,
			disabled:true					
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false				
	};
	
	vectorAtributos[3]={
		validacion:{
 			name:'id_partida',
			fieldLabel:'Partida ',
			allowBlank:true,			
			emptyText:'Partida... ',
			desc: 'desc_partida', 		
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_partida,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:20,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			tpl:tpl_id_partida,
 			grid_visible:true,
 			grid_editable:true,
			width_grid:200,
			lazyRender:true,
      		width:250,
			disabled:false	
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};	
	
	vectorAtributos[4]={
		validacion:{
			name: 'tipo_dato',
			fieldLabel:'ID a Consultar',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Comprobante'],['2','Cuenta Documentada'],['3','Devengado'],['4','Solicitud de Compra'],['5','Rendición Cta.Documentada'],['6','Planilla']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			width:250		
		},
		tipo: 'ComboBox',
		filtro_0:true,
		id_grupo:0,
		defecto:'no',
		save_as:'tipo_dato'
	};
	
	vectorAtributos[5]={
		validacion:{
			name:'id_dato',
			fieldLabel:'Identificador',
			allowBlank:true,
			maxLength:12,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			grid_visible:true,
 			grid_editable:true,
			minValue:1,
			maxValue:1000000,
			width:100		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		save_as:'id_dato'
	};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Diferencias"
	};
	layout_lib_may_ban = new DocsLayoutProceso(idContenedor);
	layout_lib_may_ban.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_lib_may_ban, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente = this.ocultarComponente;
	var CM_mostrarComponente = this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		cmp_partida = ClaseMadre_getComponente('id_partida');
		cmp_tdato = ClaseMadre_getComponente('tipo_dato');
		cmp_dato = ClaseMadre_getComponente('id_dato');
		
		for ( var i = 0; i < vectorAtributos.length; i++) {
			componentes[i] = ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		CM_ocultarComponente(cmp_partida);
		CM_ocultarComponente(cmp_tdato);
		CM_ocultarComponente(cmp_dato);
		
		componentes[1].store.baseParams={sw_diferencia:'si'};
		
		componentes[0].on('select', evento_diferencia);
		componentes[1].on('select', evento_declaracion); 
		componentes[3].on('select', evento_partida); 
	}

	function evento_diferencia(combo, record, index) {
		g_tipo_dif=record.data.id;
		componentes[1].store.baseParams={sw_diferencia:'si'};
		componentes[1].setValue('');
		componentes[2].setValue('');
		componentes[3].setValue('');
		componentes[4].setValue('');
		componentes[5].setValue('');
		
		CM_ocultarComponente(cmp_partida);
		CM_ocultarComponente(cmp_tdato);
		CM_ocultarComponente(cmp_dato);
		
		if(record.data.id == '1'){
			g_id_partida=0;
			g_partida_desc="";
		}
		if(record.data.id == '2'){
			CM_mostrarComponente(cmp_partida);
		}	
		if(record.data.id == '3'){
			componentes[1].store.baseParams={sw_diferencia:'no'};
			g_id_partida=0;
		}
		if(record.data.id == '4'){
			componentes[1].store.baseParams={sw_diferencia:'no'};
			CM_mostrarComponente(cmp_partida);
			CM_mostrarComponente(cmp_tdato);
			CM_mostrarComponente(cmp_dato);
		}
		ds_declaracion.load({params:{
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}});
	}
	
	function evento_declaracion(combo, record, index) {
		g_id_declaracion=record.data.id_declaracion;
		g_id_gestion=record.data.id_gestion;
		g_periodo=record.data.desc_periodo;
		g_gestion=record.data.gestion;
		g_estado=record.data.estado;
		g_declara_desc=g_id_declaracion + " / " + g_gestion + "-" + g_periodo + " / " + g_estado;
		
		componentes[2].setValue(g_gestion + " - " + g_periodo + " / " + g_estado);
		componentes[3].setValue('');
		componentes[3].store.baseParams={sw_traspaso:'si',m_id_presupuesto:'%',m_id_tipo_pres:'2,3',m_id_gestion:g_id_gestion};
		
		ds_partida.load({params:{
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}});
	}
	
	function evento_partida(combo, record, index) {
		g_id_partida=record.data.id_partida;
		g_partida_desc=record.data.codigo_partida + " - " + record.data.nombre_partida
	}

	// ------ sobrecargo la clase madre obtenerTitulo para las pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "Diferencias Presupuestarias" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :75,
			url :direccion + '../../../../../sis_sigma/control/diferencias/ActionPDFDiferencias.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 420, 420 ],
			grupos : [ {
				tituloGrupo :'Datos para el Reporte',
				columna :0,
				id_grupo :0
			} ],
			submit:function (){
				g_tipo_dato = "0";
				g_id_dato = 0;
				if(g_tipo_dif == "4"){
					g_id_dato = componentes[5].getValue();
					g_tipo_dato = componentes[4].getValue();
				}
				
				var data='&id_declaracion='+g_id_declaracion;
				data+='&tipo_dif='+g_tipo_dif;
				data+='&estado='+g_estado;
				data+='&id_partida='+g_id_partida;
				data+='&id_dato='+g_id_dato;
				data+='&tipo_dato='+g_tipo_dato;
				
				if(g_tipo_dif == "1"){
					window.open(direccion+'../../../../sis_sigma/control/diferencias/ActionPDFDiferencias.php?'+data)
				}
				if(g_tipo_dif == "2"){
					if(g_estado != "Validar_acumulado"){
						window.open(direccion+'../../../../sis_sigma/control/diferencias/ActionPDFDiferenciasPartida.php?'+data)
					}
				}
				if(g_tipo_dif == "3"){
					window.open(direccion+'../../../../sis_sigma/control/diferencias/ActionPDFConsultas.php?'+data)
				}
				if(g_tipo_dif == "4"){
					window.open(direccion+'../../../../sis_sigma/control/diferencias/ActionPDFConsultas.php?'+data)
				}
			}
		}
	};

	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}