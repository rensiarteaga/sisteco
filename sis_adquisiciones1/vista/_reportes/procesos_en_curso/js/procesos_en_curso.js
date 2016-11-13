/**
* Nombre de archivo:	    compro
* Propósito:				Contenedor HTML de los objetos de la vista
* Fecha de Creación:		11/02/2011
* Autor:					Ana Maria villegas Quispe
*/
function pagina_procesos_en_curso(idContenedor,direccion,empleado,paramConfig)
{
	var vectorAtributos=new Array;
	var data_ep;
	var componentes=new Array();
    var txt_emp=0;
	//DATA STORE's
	
	
    var ds_parametro_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro_adquisicion/ActionListarParametroAdquisicion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_gestion',totalRecords: 'TotalCount'}, ['id_parametro_adquisicion','estado','fecha','id_gestion_subsistema','id_subsistema','id_gestion','gestion'])});

/*   var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla','desc_presupuesto'])
	});*/
    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti',
																																									'id_unidad_organizacional','desc_unidad_organizacional','id_fuente_financiamiento','denominacion','id_parametro',
																																									'desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador',
																																									'nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional',
																																									'codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla',
																																									'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																																									'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])
});	
	 var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_presupuesto/control/partida/ActionListarPartida.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
			});	
	
	
	//render
	
		function renderTipoPresupuesto(value, p, record)
		{						
			if(value == 1)
			{return "Recurso"}
			if(value == 2)
			{return "Gasto"}
			if(value == 3)
			{return "Inversión"}
			if(value=='2,3')
			{return "Gasto - Inversión"}
			if(value == 4)
			{return "PNO - Recurso"}
			if(value == 5)
			{return "PNO - Gasto"}
			if(value == 6)
			{return "PNO - Inversión"}
			
			return '';
		}	
	                
	//FUNCIONES RENDER
		function render_id_partida(value,cell,record,row,colum,store)
		{		if(store.getAt(row).data['sw_transaccional'] == 1){
				return  '<span style="color:green;"><pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre></span>'
	 			}	
				if(store.getAt(row).data['sw_transaccional'] == 2){return String.format('{0}','<pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre>')}
		};
		
		var tpl_id_partida=new Ext.Template('<div class="search-item">','<b>{nombre_partida}</b><br><FONT COLOR="#B50000">{codigo_partida} - {nombre_partida}</FONT>','</div>');

	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	
	var resultTplParAdq = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion}</b>','<br><FONT COLOR="#B5A642">Estado: {estado}</FONT>','</div>');
	/*var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{desc_unidad_organizacional}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{denominacion}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{codigo_financiador}-{codigo_regional}-{codigo_programa}-{codigo_proyecto}-{codigo_actividad}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_actividad}</FONT>',		
		'</div>');
		*/
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>',
			'<br><b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
			'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
			'<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
			'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
			'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>',
			'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
			'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>',  
			'</div>');																									


	
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_parametro_adquisicion',
			desc:'gestion',
			store:ds_parametro_almacen,
			valueField:'id_gestion',
			displayField:'gestion',
			filterCol:'GESTIO.gestion',
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
		save_as:'id_gestion',
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
		dateFormat:'m/d/Y',
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
		dateFormat:'m/d/Y',
		save_as:'txt_fecha_hasta',
		id_grupo:0
	};
	vectorAtributos[3]={
		validacion:{
			labelSeparator:'',
			name:'gestion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'gestion',
		id_grupo:0
	};	
	
	vectorAtributos[4]  = {
		validacion: {
			name:'tipo_pres',			
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			//emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.tipo_pres // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:250			
		},
		tipo:'ComboBox',
		filtro_0:true,
		save_as:'tipo_pres',
		id_grupo:1
	};  

	/*vectorAtributos[5]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupue...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',			
			typeAhead:false,			
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, //caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			//renderer:renderTipoPresupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:250,
			disabled:true,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,		
		filterColValue:'UNIORG.nombre_unidad#FUNFIN.denominacion#FINANC.nombre_financiador#REGION.nombre_regional#PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad',
		save_as:'id_presupuesto',
		id_grupo:1
	};
	*/
	vectorAtributos[5]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupue...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.id_presupuesto#PROGRA.codigo#PROYEC.codigo#ACTIVI.codigo#FUNFIN.codigo_fuente#ORGFIN.codigo',				
			typeAhead:false,			
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, //caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:250,
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,		
		filterColValue:'UNIORG.nombre_unidad#FUNFIN.denominacion#FINANC.nombre_financiador#REGION.nombre_regional#PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad#PRESUP.id_presupuesto#ORGFIN.codigo',
		save_as:'id_presupuesto',
		id_grupo:1
	};
	
	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'desc_presupuesto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_presupuesto'
	};
	
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'financiador',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'financiador'
	};
	
	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'regional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'regional'
	};
	
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'programa',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'programa'
	};
	
	vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			name:'proyecto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'proyecto'
	};
	
	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name:'actividad',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'actividad'
	};
	vectorAtributos[12]={
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
	vectorAtributos[13]={
		validacion:{
			labelSeparator:'',
			name:'fuente_financiamiento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'fuente_financiamiento'
	};
	vectorAtributos[14]={
			validacion:{
			name:'id_partida',
			fieldLabel:'Partida',
			allowBlank:false,			
			emptyText:'Partida...',
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'nombre_partida',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.nombre_partida#PARTID.codigo_partida',
			typeAhead:true,
			tpl:tpl_id_partida,
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
			renderer:render_id_partida,
			grid_visible:true,
			grid_editable:false,
			width_grid:370,
			width:'100%',
			grid_indice:2,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_partida',
		save_as:'id_partida',
		id_grupo:1
	};
	vectorAtributos[15]= {
		validacion: {
			name:'tipo_reporte',
			fieldLabel:'Tipo de Adquisición',
			emptyText:'Tipo de Reporte',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.proc_existenciasCombo.tipo_reporte
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
		defecto:'items',
		save_as:'tipo_adq',
		id_grupo:2
	};
	vectorAtributos[16]={
		validacion:{
			labelSeparator:'',
			name:'tipo_presto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'tipo_presto'
	};
	vectorAtributos[17]={
		validacion:{
			name:'tipo_impresion',
			fieldLabel:'Tipo de Impresión',
			vtype:'texto',
			emptyText:'Elija el Tipo de Impresion...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','PDF'],['1','Word'],['2','Excel']]}),
		
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:2,
		//defecto:'PDF',
		save_as:'tipo_impresion'
	};
	
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
		var titulo = "Solicitud por Unidad Organizacional";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'100%',
		url:direccion+'../../../../control/_reportes/procesos_en_curso/ActionPDFProcesosEnCurso.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'100%',
		columnas:['100%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Parte Diario',
		grupos:[
		{tituloGrupo:'Fechas',columna:0,id_grupo:0},
		{tituloGrupo:'Presupuesto',columna:0,id_grupo:1},
		{tituloGrupo:'Tipo de Reporte',columna:0,id_grupo:2}
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	
	function iniciarEventosFormularios(){
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
				
		componentes[0].on('select',evento_parametro);		//parametro		
		componentes[4].on('select',evento_tipo_presupuesto);	//tipo_pres	
		componentes[5].on('select',evento_presupuesto);	//evento presupuesto
		}
		
		
		 cmbGestion=ClaseMadre_getComponente('id_parametro_adquisicion');
		 gestion=ClaseMadre_getComponente('gestion');
		 dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		 dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');
		
		
	
	function evento_parametro( combo, record, index )
	{
		//Validación de fechas
		var id = componentes[0].getValue();
		if(componentes[0].store.getById(id)!=undefined){
			
			var intGestion=componentes[0].store.getById(id).data.gestion;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[1].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[1].maxValue=dte_fecha_fin_valid;
			componentes[2].minValue=dte_fecha_ini_valid;
			componentes[2].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[1].setValue(dte_fecha_ini_valid);
			componentes[2].setValue(dte_fecha_fin_valid);
			
		}
		componentes[5].store.baseParams={vista:'rep_procesos_en_curso',m_id_gestion:componentes[0].getValue(),m_id_tipo_pres:componentes[4].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[5].modificado=true;
			
		componentes[5].setValue('');
		componentes[3].setValue(record.data.gestion);
		//componentes[]=record.data.gestion_pres;
		//alert(componentes[4].getValue());
		if(componentes[4].getValue()!=undefined && componentes[4].getValue()!=''){
			componentes[5].setDisabled(false);
		}
		
	}
	//alert (componentes[0].getValue());
	function evento_tipo_presupuesto( combo, record, index )
	{		
		//componentes[9].setValue(renderTipoPresupuesto(componentes[1].getValue()), '', '');
		componentes[5].store.baseParams={vista:'rep_procesos_en_curso',m_id_gestion:componentes[0].getValue(),m_id_tipo_pres:componentes[4].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[5].modificado=true;
		componentes[5].setValue('');
		if(componentes[0].getValue()!=undefined && componentes[0].getValue()!=''){
			componentes[5].setDisabled(false);
		}	
       componentes[16].setValue(renderTipoPresupuesto(componentes[4].getValue()));		
	}
	/*function evento_partida( combo, record, index )
	{		
		
       //componentes[15].setValue(renderTipoPresupuesto(componentes[4].getValue()));		
	}*/
	function evento_presupuesto( combo, record, index )
	{
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		componentes[6].setValue(record.data.desc_presupuesto);
		componentes[7].setValue(record.data.nombre_regional);
	 	componentes[8].setValue(record.data.nombre_financiador);
	 	componentes[9].setValue(record.data.nombre_programa);
	 	componentes[10].setValue(record.data.nombre_proyecto);
	 	componentes[11].setValue(record.data.nombre_actividad);
	 	componentes[12].setValue(record.data.desc_unidad_organizacional);
	 		componentes[14].setValue('');
	 	componentes[14].store.baseParams={vista:'rep_procesos_en_curso',id_gestion:componentes[0].getValue(),rep_procur_id_presupuesto:componentes[5].getValue(),oc:'si'};  
		componentes[14].modificado=true;
	
		/*if(componentes[0].getValue()!=undefined && componentes[0].getValue()!='' && componentes[0].getValue()!=undefined && componentes[5].getValue){
			componentes[14].setDisabled(false);
		}	*/
	 	
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
