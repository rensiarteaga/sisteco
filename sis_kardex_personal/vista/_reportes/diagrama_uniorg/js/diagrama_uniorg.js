function DiagramaUniorg(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var componentes=new Array();
	//var ContPes=1;
	//var layout_diagrama_uniorg,h_txt_gestion,h_txt_mes,ds_linea;
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
var ds_usuario=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?tipo_vista=vista_diagrama&oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords:'TotalCount'},['id_unidad_organizacional','nombre_unidad'])
	});
var resultTplUsuario=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','</div>');
/*	
var ds_procedimiento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/procedimiento_db/ActionListarProcedimiento_db.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'codigo_procedimiento',totalRecords:'TotalCount'},['codigo_procedimiento','nombre_funcion','descripcion'])
	});
	
var resultTplProcedimiento=new Ext.Template('<div class="search-item">','<b><i>{codigo_procedimiento}</i></b><br>','<FONT COLOR="#000000"><B><I>{nombre_funcion}</I></B></FONT><br>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
*/	
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gerencias',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gerencia...',
			name:'id_unidad_organizacional',
			desc:'nombre_unidad',
			store:ds_usuario,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',
			queryParam:'filterValue_0',
			//filterCol :'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
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
			editable:true,
			width:200
		},
		id_grupo:0,
		save_as:'id_unidad_organizacional',
		tipo:'ComboBox'
	};
	
	vectorAtributos[1]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Tipo de Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','Pliego '],['1','Varias Hojas']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	
	
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Datos de Consulta"};
	layout_diagrama_uniorg=new DocsLayoutProceso(idContenedor);
	layout_diagrama_uniorg.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_diagrama_uniorg,idContenedor);
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
		
	}
	
	
	
	/*function evento_fecha_inicio(combo,record,index) {
			
			var fecha_inicio_val=componentes[1].getValue();
				componentes[2].minValue=fecha_inicio_val;
				
				//componentes[3].setValue(formatDate(componentes[1].getValue()));
				
				
		
		}
	function evento_usuario(combo,record,index){
		componentes[5].setValue(record.data.desc_persona);
	}*/
	/*function  evento_fecha_fin(combo,record,index) {
	
		var fecha_fin_val=componentes[2].getValue();
				componentes[4].setValue(formatDate(componentes[2].getValue()));
			
		}*/
	
	
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Datos de consulta "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,
		            url:direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacionalDiagrama.php',
		            abrir_pestana:true,
		            titulo_pestana:obtenerTitulo,
		            fileUpload:false,columnas:[420,420],
			        grupos:[{tituloGrupo:'Datos para el reporte Diagrama Unidad Organizacional',
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