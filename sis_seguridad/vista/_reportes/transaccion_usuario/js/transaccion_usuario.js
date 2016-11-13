function TransaccionUsuario(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var componentes=new Array();
	//var ContPes=1;
	//var layout_transaccion_usuario,h_txt_gestion,h_txt_mes,ds_linea;
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
var ds_usuario=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/usuario/ActionListarUsuario.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_usuario','desc_persona'])
	});
var resultTplUsuario=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','</div>');
	
var ds_procedimiento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/procedimiento_db/ActionListarProcedimiento_db.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'codigo_procedimiento',totalRecords:'TotalCount'},['codigo_procedimiento','nombre_funcion','descripcion'])
	});
	
var resultTplProcedimiento=new Ext.Template('<div class="search-item">','<b><i>{codigo_procedimiento}</i></b><br>','<FONT COLOR="#000000"><B><I>{nombre_funcion}</I></B></FONT><br>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Usuario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Usuario...',
			name:'id_usuario',
			desc:'desc_persona',
			store:ds_usuario,
			valueField:'id_usuario',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol :'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplUsuario,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'id_usuario',
		tipo:'ComboBox'
	};
	
	vectorAtributos[1]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_ini',
		dateFormat:'m/d/Y',
		defecto:""
	};
	///////// fecha /////////
	vectorAtributos[2]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_fin',
		dateFormat:'m/d/Y',
		defecto:""
	};
	
	vectorAtributos[3]={
		validacion:{
			fieldLabel:'Procedimiento',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Procedimiento...',
			name:'codigo_procedimiento',
			desc:'codigo_procedimiento',
			store:ds_procedimiento,
			valueField:'codigo_procedimiento',
			displayField:'codigo_procedimiento',
			queryParam:'filterValue_0',
			filterCol :'PROCDB.codigo_procedimiento#PROCDB.nombre_funcion',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplProcedimiento,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'codigo_procedimiento',
		filterColValue:'PROCDB.codigo_procedimiento#PROCDB.nombre_funcion',
		tipo:'ComboBox'
	};
	
	vectorAtributos[4]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Tipo de Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','PDF'],['1',' Word'],['2','Excel']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	vectorAtributos[5]={
		validacion:{
			labelSeparator:'',
			name:'nombre_usuario',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'nombre_usuario'
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Transaccion - Usuario"};
	layout_transaccion_usuario=new DocsLayoutProceso(idContenedor);
	layout_transaccion_usuario.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_transaccion_usuario,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	//ds_proveedor.addListener('loadexception',ClaseMadre_conexionFailure);
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios()
	{			
				
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[1].on('change',evento_fecha_inicio);	//
		componentes[0].on('select',evento_usuario);
		//componentes[2].on('change',evento_fecha_fin);	//
		
			
	}
	
	
	
	function evento_fecha_inicio(combo,record,index) {
			
			var fecha_inicio_val=componentes[1].getValue();
				componentes[2].minValue=fecha_inicio_val;
				
				//componentes[3].setValue(formatDate(componentes[1].getValue()));
				
				
			
		}
	function evento_usuario(combo,record,index){
		componentes[5].setValue(record.data.desc_persona);
	}
	/*function  evento_fecha_fin(combo,record,index) {
	
		var fecha_fin_val=componentes[2].getValue();
				componentes[4].setValue(formatDate(componentes[2].getValue()));
			
		}*/
	
	
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Ordenes de Compra "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,
		            url:direccion+'../../../../../sis_seguridad/control/_reportes/transaccion_usuario/ActionPDFTransaccionesUsuario.php',
		            abrir_pestana:true,
		            titulo_pestana:obtenerTitulo,
		            fileUpload:false,columnas:[420,420],
			        grupos:[{tituloGrupo:'Datos para el reporte Transacciones por Usuarios',
			        		 columna:0,
			        		 id_grupo:0
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