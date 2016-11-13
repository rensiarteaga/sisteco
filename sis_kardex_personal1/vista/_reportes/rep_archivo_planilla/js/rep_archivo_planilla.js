function RepArchivoPlanilla(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var componentes=new Array();
	var armin_id_planilla, armin_codigo;
	//var ContPes=1;
	//var layout_diagrama_uniorg,h_txt_gestion,h_txt_mes,ds_linea;
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
	});
	
	
	
	var ds_planilla=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/planilla/ActionListarPlanilla.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_planilla',totalRecords:'TotalCount'},['id_planilla','desc_tipo_planilla','resumen_periodo','numero','observaciones'])
	});
	
		
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tplPlanilla=new Ext.Template('<div class="search-item">','<b><i>{numero}</i></b><br>{observaciones}<br><b>{resumen_periodo}</b>','</div>');
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b>{gestion}</b><br>','</div>');

	
	vectorAtributos[0]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'id_gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion,
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
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		id_grupo:0
	};
	
	
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Planillas',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Planillas...',
			name:'id_planilla',
			desc:'numero',
			store:ds_planilla,
			valueField:'id_planilla',
			displayField:'numero',
			queryParam:'filterValue_0',
			//filterCol :'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:tplPlanilla,
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
		save_as:'id_planilla',
		tipo:'ComboBox'
	};
	
	
	
	vectorAtributos[2]={
		validacion:{
			name:'codigo',
			fieldLabel:'Reporte',
			vtype:'texto',
			emptyText:'Elija el Archivo a generar...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['EMP','EMP - Detalle Datos Funcionario'],['ACR','ACR - Detalle Datos Acreedor'],
			                                                            ['ING','ING - Detalle Ingresos x Funcionario'],['DES','DES - Detalle Dctos x Funcionario'],
			                                                            ['RDE','RDE - Detalle Relacion Dctos x Funcionario'],['INC','INC - Detalle Incremento x Funcionario'],
			                                                            ['C3C','C3C - Cabecera Form. C-31'],['RLA','RLA - Detalle Rel. Laboral Funcionario'],['CAR','CAR - Detalle Cargo del Funcionario'],['CUA','CUA - Detalle Unidad Organizacional']
]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'codigo'
	};
	
	

	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Datos de Consulta"};
	layout_rep_archivo=new DocsLayoutProceso(idContenedor);
	layout_rep_archivo.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_rep_archivo,idContenedor);
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
		
		cmb_gestion=ClaseMadre_getComponente('id_gestion');
		cmb_planilla=ClaseMadre_getComponente('id_planilla');
		cmb_codigo=ClaseMadre_getComponente('codigo');
		
		var onGestion=function(e){
			ds_planilla.baseParams={
					id_gestion:e.value
			}
			ds_planilla.modificado=true;
			
		}
		
		
		cmb_gestion.on ('select',onGestion);
		cmb_gestion.on ('change',onGestion);
		
		
		var onPlanilla=function(e){
			
			armin_id_planilla=e.value;
			
		}
		
		cmb_planilla.on('select',onPlanilla);
		cmb_planilla.on('change',onPlanilla);
		
		
		var onCodigo=function(e){
		//	alert(e.value+'---'+e);
			armin_codigo=e.value;
		//alert(armin_codigo);	
		}
		cmb_codigo.on('select',onCodigo);
		cmb_codigo.on('change',onCodigo);
	}
	
	
	
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Datos de consulta "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,
			   url:direccion+"../../../../../sis_kardex_personal/control/planilla/ActionGenerarArchivoMin.php",
			   success: successGenerar,
		            abrir_pestana:false,
		            titulo_pestana:obtenerTitulo,
		            failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera,
		            fileUpload:false,columnas:[420,420],
			        grupos:[{tituloGrupo:'Datos para el reporte de Funcionarios',
			        		 columna:0,
			        		 id_grupo:0
			        		}
			        		],
			        parametros:{id_planilla:armin_id_planilla, codigo:armin_codigo}
			        	}
	};
	
	
	function successGenerar(resp){ 
		Ext.MessageBox.hide();
		//alert(ClaseMadre_getComponente('id_planilla').getValue()+'_'+ClaseMadre_getComponente('codigo').getValue()+'.txt'+'-----'+armin_id_planilla+'..'+armin_codigo);
		 // window.open(direccion+'../../../../../sis_kardex_personal/control/planilla/archivos/ministerio/'+ClaseMadre_getComponente('id_planilla').getValue()+'_'+ClaseMadre_getComponente('codigo').getValue()+'.txt');
		  window.open(direccion+'../../../../../sis_kardex_personal/control/planilla/archivos/ministerio/'+armin_id_planilla+'_'+armin_codigo+'.txt');
		  
		  
	}
	
	   
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}