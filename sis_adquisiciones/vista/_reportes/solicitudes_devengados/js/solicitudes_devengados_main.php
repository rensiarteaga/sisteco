//<script>
<?php session_start(); ?>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	echo "var vista='$vista';";
	
	?>

var paramConfig={TiempoEspera:10000};

var empleado={
	id_empleado:<?php echo $_SESSION['ss_id_empleado'];?>,
	 nombre_empleado:"<?php echo $_SESSION['ss_nombre_empleado'];?>",
    paterno_empleado:"<?php echo $_SESSION["ss_paterno_empleado"];?>",
    materno_empleado:"<?php echo $_SESSION["ss_materno_empleado"];?>", 
    id_empresa:<?php echo $_SESSION['ss_id_empresa'];?>,
    id_usuario:<?php echo $_SESSION['ss_id_usuario'];?>,
    nombre_usuario:_CP.getConfig().ss_nombre_usuario,
    lugar:"<?php echo $_SESSION['ss_nombre_lugar'];?>"
    }

var elemento={pagina:new pagina_solicitudes_devengado(idContenedor,direccion,empleado,paramConfig,vista),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_solicitudes_et.js
* Propósito: 			pagina objeto principal
* Autor:				AVQ
* Fecha creación:		13/01/2012
*/
function pagina_solicitudes_devengado(idContenedor,direccion,empleado,paramConfig,vista)
{
	//alert (vista);
	var vectorAtributos=new Array;
	var data_ep;
	var componentes=new Array();
    var txt_emp=0;
	//DATA STORE's
	
	 /*var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},
			['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel']),
			baseParams:{sw_presto:1,tipo_vista:'reporte_solicitudes_uo',oc:'si'}
	});


var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/_reportes/solicitudes_et/ActionListarPrestoEP.php?origen=filtro'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_ep',totalRecords: 'TotalCount'},['id_ep','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','desc_epe' ])
	});

*/	
	
	var ds_parametro_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro_adquisicion/ActionListarParametroAdquisicion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro_adquisicion',totalRecords: 'TotalCount'}, ['id_parametro_adquisicion','estado','fecha','id_gestion_subsistema','id_subsistema','id_gestion','gestion'])});
	             
	//FUNCIONES RENDER
	
	/*function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['nombre_unidad']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
		
		
	
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
    function render_id_contratista(value, p, record){return String.format('{0}', record.data['desc_contratista'])}
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado'])}
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion'])}
	*/
	
	var resultTplParAdq = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion}</b>','<br><FONT COLOR="#B5A642">Estado: {estado}</FONT>','</div>');
	/*var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogico = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
    var resultTplContratista = new Ext.Template('<div class="search-item">','<b><i>{nombre_contratista}</i></b>','<br><FONT COLOR="#B5A642">Código: {codigo}','<br>Email: {email}','<br>Dirección: {direccion}</FONT>','</div>');
	var resultTplInstitucion = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">Página web: {pag_web}','<br>Dirección: {direccion}</FONT>','</div>');
	var resultTplEmpleado = new Ext.Template('<div class="search-item">','<b><i>{codigo_empleado}</i></b>','<br><FONT COLOR="#B5A642">Nombre: {desc_persona}</FONT>','</div>');
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');	

function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_epe']);}
		*/
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_parametro_adquisicion',
			desc:'gestion',
			store:ds_parametro_almacen,
			valueField:'id_parametro_adquisicion',
			displayField:'gestion',
			filterCol:'PARALM.gestion',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParAdq,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			grid_indice:0
		},
		tipo:'ComboBox',
		save_as:'id_parametro_adquisicion',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[1]= {
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Fecha desde',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_desde',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Fecha hasta',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_hasta',
		id_grupo:0
	};
	/*
	  vectorAtributos[3]={
			validacion:{
			name:'id_ep',
			fieldLabel:'Estructura Programática',
			allowBlank:false,			
			emptyText:'EP....',
			desc:'desc_epe', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_ep',
			displayField:'desc_epe',
			queryParam:'filterValue_0',
			//filterCol:'presup.desc_presupuesto',
			filterCol :'ep.codigo_financiador#ep.codigo_regional#ep.codigo_programa#ep.codigo_proyecto#ep.codigo_actividad#ep.nombre_financiador#ep.nombre_regional#ep.nombre_programa#ep.nombre_proyecto#ep.nombre_actividad#ep.desc_epe',
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
			renderer:render_id_presupuesto,
			disabled:false	
		},
		tipo:'ComboBox',
		//tipo:'epField',
		//filterColValue:' ',
		save_as:'id_fina_regi_prog_proy_acti',
		id_grupo:0
	};
	
	
vectorAtributos[4]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc: 'nombre_unidad', 
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.codigo#UNIORG.nombre_unidad#UNIORG.centro',
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
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		//filtro_0:true,
		//filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional',
		id_grupo:1
	};
	*/
	vectorAtributos[3]= {
		validacion: {
			name:'tipo_reporte',
			fieldLabel:'Tipo de Reporte',
			emptyText:'Tipo de Reporte',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.proc_existenciasCombo.tipo_reporte}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Bien','Bienes'],['Servicio','Servicios']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'',
		defecto:'items',
		save_as:'tipo_adq',
		//id_grupo:2
	};

	/*vectorAtributos[6]= {
		validacion: {
			name:'estado',
			emptyText:'Estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.proc_existenciasCombo.estado
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'',
		defecto:'aprobado',
		save_as:'estado',
		id_grupo:2
	};*/
	
		/*
		vectorAtributos[6]={
		validacion:{
			name              :  'estado',
			fieldLabel        :  'Estados',
			dataFields        :  ['code', 'desc'],
			data              :   Ext.proc_existenciasCombo.estado,
			valueField        :  'code',
			displayField      :  'desc',
			width             :  150,
			height            :  150,
			allowBlank        :  false
		},
		tipo:'Multiselect',
		save_as:'estado',
		id_grupo:2
	};
	
*/

	vectorAtributos[4]={
		validacion:{
			labelSeparator:'',
			name:'gestion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'gestion'
	};	
  /*  vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_fina_regi_prog_proy_acti'
	};*/
	/*vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'codigo_ep',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'codigo_ep'
	};*/
	
	/*vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'nombre_unidad',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'nombre_unidad'
	};
	if (vista =='tiempos_estados_x_solicitud_detalle_monto'){
		vectorAtributos[9]={
		validacion:{
			vtype:"texto",
			fieldLabel:'Monto Minimo',
			name:'monto_min',
			allowNegative:false,
			minValue:0,
			decimalPrecision:2,//para numeros float
			allowBlank:true,
			grid_visible:false,
			grid_editable:true
		},
		tipo:'NumberField',
		filtro_0:false,
		save_as:'monto_min'
	};
	vectorAtributos[10]={
		validacion:{
			vtype:"texto",
			fieldLabel:'Monto Max',
			name:'monto_max',
			allowNegative:false,
			minValue:1,
			decimalPrecision:2,//para numeros float
			allowBlank:true,
			grid_visible:false,
			grid_editable:true
		},
		tipo:'NumberField',
		filtro_0:false,
		save_as:'monto_max'
	};
	}
	*/
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo_maestro:'Solicitud por Unidad Organizacional'

	};
	layout=new DocsLayoutProceso(idContenedor);
	layout.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
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
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Reporte Solicitudes Estados y Tiempos Transcurridos";

		return titulo;
	}

	//datos necesarios para el filtro
	
	
	/*switch (vista)
		{
			case 'tiempos_estados_x_solicitud_detalle': 
					
		*/		var paramFunciones = {

					Formulario:{html_apply:'dlgInfo-'+idContenedor,
					height:'100%',
					url:direccion+'../../../../control/_reportes/solicitudes_devengado/ActionPDFDevengadosNoPagados.php',
					abrir_pestana:true, //abrir pestana
					titulo_pestana:obtenerTitulo,
					fileUpload:false,
					width:'100%',
					columnas:['100%'],
					minWidth:150,minHeight:200,	closable:true,titulo:'Parte Diario',
					grupos:[
					{tituloGrupo:'Fechas',columna:0,id_grupo:0}/*,
					{tituloGrupo:'Unidades Organizacionales',columna:0,id_grupo:1},
					{tituloGrupo:'Tipo de Reporte',columna:0,id_grupo:2}*/
					]}
				};
/*
				break;
			 case 'tiempos_estados_x_solicitud':
			 
			 			
				var paramFunciones = {

				Formulario:{html_apply:'dlgInfo-'+idContenedor,
				height:'100%',
				url:direccion+'../../../../control/_reportes/solicitudes_et/ActionPDFSolicitudTiemposEstados.php',
				abrir_pestana:true, //abrir pestana
				titulo_pestana:obtenerTitulo,
				fileUpload:false,
				width:'100%',
				columnas:['100%'],
				minWidth:150,minHeight:200,	closable:true,titulo:'Parte Diario',
				grupos:[
				{tituloGrupo:'Fechas',columna:0,id_grupo:0},
				{tituloGrupo:'Unidades Organizacionales',columna:0,id_grupo:1},
				{tituloGrupo:'Tipo de Reporte',columna:0,id_grupo:2}
				]}
				};
			 break;
			  case 'tiempos_estados_x_solicitud_detalle_monto':
			 
			 			
				var paramFunciones = {

				Formulario:{html_apply:'dlgInfo-'+idContenedor,
				height:'100%',
				url:direccion+'../../../../control/_reportes/solicitudes_et/ActionPDFSolicitudTiemposEstadosMontos.php',
				abrir_pestana:true, //abrir pestana
				titulo_pestana:obtenerTitulo,
				fileUpload:false,
				width:'100%',
				columnas:['100%'],
				minWidth:150,minHeight:200,	closable:true,titulo:'Parte Diario',
				grupos:[
				{tituloGrupo:'Fechas',columna:0,id_grupo:0},
				{tituloGrupo:'Unidades Organizacionales',columna:0,id_grupo:1},
				{tituloGrupo:'Tipo de Reporte',columna:0,id_grupo:2}
				]}
				};
			 break;
	
	} 
	*/

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	
	function iniciarEventosFormularios(){
		cmbEp=ClaseMadre_getComponente('id_ep');
		
		cmbGestion=ClaseMadre_getComponente('id_parametro_adquisicion');
		
		//cmb_epI=getComponente('id_ep');
		dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');
	/*	txt_id_financiador=ClaseMadre_getComponente('id_financiador');
		txt_id_regional=ClaseMadre_getComponente('id_regional');
		txt_id_programa=ClaseMadre_getComponente('id_programa');
		txt_id_proyecto=ClaseMadre_getComponente('id_proyecto');
		txt_id_actividad=ClaseMadre_getComponente('id_actividad');
	*/	//nombre_unidad=ClaseMadre_getComponente('nombre_unidad');
		//codigo_ep=ClaseMadre_getComponente('codigo_ep');
		gestion=ClaseMadre_getComponente('gestion');
		//combo_uo=ClaseMadre_getComponente('id_unidad_organizacional');
       /*id_fina_regi_prog_proy_acti=ClaseMadre_getComponente('id_fina_regi_prog_proy_acti');
                cmbEp.ep.setBaseParams({"id_empleado":empleado.id_empleado});
				cmbEp.ep.modificado=true;
				cmbEp.modificado=true;
     */
		/*var onEpSelect = function(e){
			
			var ep=cmbEp.getValue();
			
			//data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			/*alert(ep);
			if (ep!='%'){
			*/
			/*ds_unidad_organizacional.baseParams.id_fina_regi_prog_proy_acti=ep;
			combo_uo.modificado=true;
		//}
			
			//id_fina_regi_prog_proy_acti.setValue(ep['id_fina_regi_prog_proy_acti']);
			
			//codigo_ep.setValue((ep['codigo_financiador']+'-'+ep['codigo_regional']+'-'+ep['codigo_programa']+'-'+ep['codigo_proyecto']+'-'+ep['codigo_actividad']));
			
		};*/

		var onGestionSelect = function(e) {
			var id = cmbGestion.getValue();
			if(cmbGestion.store.getById(id)!=undefined){
				intGestion=cmbGestion.store.getById(id).data.gestion;
			
				dte_fecha_ini_valid = '01/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = '12/31/'+intGestion+' 00:00:00';
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);
				
				//Aplica la validación en la fecha
				dteFechaDesde.minValue=dte_fecha_ini_valid;
				dteFechaDesde.maxValue=dte_fecha_fin_valid;
				dteFechaHasta.minValue=dte_fecha_ini_valid;
				dteFechaHasta.maxValue=dte_fecha_fin_valid;
				
				//Define un valor por defecto
				dteFechaDesde.setValue(dte_fecha_ini_valid);
				dteFechaHasta.setValue(dte_fecha_fin_valid);
				gestion.setValue(cmbGestion.store.getById(id).data.gestion);
			}
		};
		
		
			/*var onUnidadOrganizacionalSelect = function(e) {
			var id = combo_uo.getValue();
			if(combo_uo.store.getById(id)!=undefined){
				nombre_unidad.setValue(combo_uo.store.getById(id).data.nombre_unidad);
			}
		};
		*/
	    cmbGestion.on('select',onGestionSelect);
		/*cmbEp.on('change',onEpSelect);
		cmbEp.on('select',onEpSelect);
		*/
		
		/*combo_uo.on('select',onUnidadOrganizacionalSelect)*/
	}
	
	
function InitPaginaSolicitudesUO(){
	 for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
	
    }
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
  
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaSolicitudesUO(); 
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
