//<script>


function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host   = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir  = "http://$host$uri/";
	echo "\nvar direccion =\"$dir\";";
	echo "var idContenedor ='$idContenedor';";
	?>

	
	
var paramConfig ={TiempoEspera:10000};
var configConsolidacion ={sw_vista:'<?php echo utf8_decode($sw_vista);?>'};

var elemento ={pagina:new  EjecucionPresupuesto(idContenedor,direccion,paramConfig,configConsolidacion),idContenedor:idContenedor};

ContenedorPrincipal.setPagina(elemento);

}
Ext.onReady(main,main);

function EjecucionPresupuesto(idContenedor,direccion,paramConfig,configConsolidacion){
	var vectorAtributos=new Array();
//	var  municipio;
	var parametro;
	var gestion;
	var periodo;
	var componentes=new Array();
	var id_moneda , id_parametro, tipo_pres, f_f,e_p_e,u_o;
	
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
			});
	
	var ds_tipo_pres_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});
			
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
	
	
	//render	
		function renderTipoPresupuesto(value, p, record)
		{
			if(value == 1)
			{return  "Recurso"}
			if(value == 2)
			{return "Gasto"}
			if(value == 3)
			{return "Inversión"}
			if (value=='2,3')
			{return "Gasto - Inversion"}
			if(value == 4)
			{return "PNO - Recurso"}
			if(value == 5)
			{return "PNO - Gasto"}
			if(value == 6)
			{return "PNO - Inversión"}
		}	
		
		function renderPeriodo(value, p, record)
		{
			if(value == 1) {return  "Enero"}
			if(value == 2) {return "Febrero"}
			if(value == 3) {return "Marzo"}
			if(value == 4) {return "Abril"}
			if(value == 5) {return "Mayo"}
			if(value == 6) {return "Junio"}
			if(value == 7) {return "Julio"}
			if(value == 8) {return "Agosto"}
			if(value == 9) {return "Septiembre"}
			if(value == 10){return "Octubre"}
			if(value == 11){return "noviembre"}
			if(value == 12){return "Diciembre"}
			if(value == 13){return "Gestión"}
		}
		
		function render_id_parametro(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_parametro']);}
		function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
		function render_id_tipo_pres_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
				
		
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
		
		// txt codigo
	
		 vectorAtributos[0]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Parametro...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	}; 
	
	 /*vectorAtributos[1]  = {
		validacion: {
			name:'tipo_pres',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			//emptyText:'Tipo Presupuesto...',
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
			width:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		save_as:'tipo_pres',
		id_grupo:0
	};*/  

	vectorAtributos[1]={
		validacion:{
			name:'tipo_pres',
			fieldLabel:'Tipo de Presupuesto',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_tipo_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_pres_gestion,
			valueField: 'id_tipo_pres',
			displayField: 'desc_tipo_pres',
			queryParam: 'filterValue_0',
			filterCol:'TIPREGES.desc_tipo_pres',
			typeAhead:true,
			tpl:tpl_id_tipo_pres_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_pres_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'tipo_pres'
	}; 
	vectorAtributos[2]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:'50%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
		
	vectorAtributos[3]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicial',
			allowBlank:true,
			format:'d/m/Y', 
			minValue:'01/01/2009',
			disabledDaysText:'Día no válido',
			grid_visible:true, 
			grid_editable:false, 
			renderer:formatDate,
			width_grid:100, 
			width:'100%',
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'cre.fecha_ini',
		filtro_1:true,
		save_as:'txt_fecha_ini',
		dateFormat:'m-d-Y', 
	};
	
	vectorAtributos[4]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Final',
			allowBlank:true,
			format:'d/m/Y', 
			minValue:'01/01/1900',
			//disabledDays:[0, 7],
			disabledDaysText:'Día no válido',
			grid_visible:true, 
			grid_editable:false, 
			renderer:formatDate,
			width_grid:100, 
			width:'100%',
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'cre.fecha_fin',
		filtro_1:true,
		save_as:'txt_fecha_fin',
		dateFormat:'m-d-Y', 
	};
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Consolidación Presupuesto"
	};
	layout_ejecucion=new DocsLayoutProceso(idContenedor);
	layout_ejecucion.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_ejecucion,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){
	 
		id_moneda = ClaseMadre_getComponente('id_moneda');
		id_parametro = ClaseMadre_getComponente('id_parametro');
		tipo_pres = ClaseMadre_getComponente('tipo_pres');

		fecha_ini = ClaseMadre_getComponente('fecha_ini');
		fecha_fin = ClaseMadre_getComponente('fecha_fin');	

		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		componentes[0].on('select',evento_parametro);		//parametro	
	}
	
	function evento_parametro( combo, record, index )
	{
		//Validación de fechas
		var id = componentes[0].getValue();
		if(componentes[0].store.getById(id)!=undefined){
			
			var intGestion=componentes[0].store.getById(id).data.gestion_pres;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[3].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[3].maxValue=dte_fecha_fin_valid;
			componentes[4].minValue=dte_fecha_ini_valid;
			componentes[4].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[3].setValue(dte_fecha_ini_valid);
			componentes[4].setValue(dte_fecha_fin_valid);			
		}
		
		componentes[1].store.baseParams={m_id_parametro:componentes[0].getValue(),m_incluir_dobles:'no'};
		componentes[1].modificado=true;
		componentes[1].setValue('');
	}
	


	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
//	function obtenerTitulo()
//	{
//		var lov_empleado = ClaseMadre_getComponente('des_empleado');
//		var aux = lov_empleado.lov.recuperar_valoresSelecionados();
//
//		return aux["nombre"] + " " +aux["apellido_paterno"] + " " + aux["apellido_materno"];
//	}



	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../sis_presupuesto/vista/consolidacion_presupuesto/consolidacion_presupuesto.php',
			abrir_pestana:true, //abrir pestana
		//	titulo_pestana:obtenerTitulo,
			titulo_pestana:'Ejecución Presupuestaria',
			fileUpload:false,
			columnas:[305,305],
			//submit:abrirReportes,
			grupos:[
			{
				tituloGrupo:'Asigne Datos Para Cosultar la Ejecución ',
				columna:0,
				id_grupo:0
			}
			
			],
			parametros: '',
		submit:function (){	
					var data ='&m_tipo_pres='+tipo_pres.getValue(); 
					data+='&m_id_parametro='+id_parametro.getValue(); 
					data+='&m_id_moneda='+id_moneda.getValue(); 
					data+='&m_fecha_ini='+formatDate(fecha_ini.getValue());
					data+='&m_fecha_fin='+formatDate(fecha_fin.getValue()); 
					//data+='&m_periodo='+periodo.getValue(); 
		 			
					var mensaje="";
					 
					if(tipo_pres.getValue()==""){mensaje+=" El campo tipo Presupuesto esta vacio";};
					if(id_parametro.getValue()==""){mensaje+=" El campo Gestión esta vacio";};
					if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
					if(fecha_ini.getValue()==""){mensaje+=" El campo Fecha Inicial esta vacio";};
					if(fecha_fin.getValue()==""){mensaje+=" El campo Fecha Final  esta vacio";};
					//if(periodo.getValue()==""){mensaje+=" El campo Periodo esta vacio";};
					
					if(mensaje=="")
					{
						for(var i=0;i<id_moneda.store.data.length;i++){
					 	if(id_moneda.store.getAt(i).data['id_moneda']==id_moneda.getValue()) 
						{
						data+='&m_desc_moneda='+id_moneda.store.getAt(i).data['nombre']; 	
						};
					}
					for(var i=0;i<id_parametro.store.data.length;i++){
					 	if(id_parametro.store.getAt(i).data['id_parametro']==id_parametro.getValue()) 
						{
						data+='&m_gestion_pres='+id_parametro.store.getAt(i).data['gestion_pres']; 	
						data+='&m_desc_estado_gral='+id_parametro.store.getAt(i).data['desc_estado_gral']; 	
						};
					}
					
					data +='&m_desc_pres='+renderTipoPresupuesto(tipo_pres.getValue(), '', '');
					data +='&m_sw_vista='+configConsolidacion.sw_vista;
		 				
	 				var ParamVentana={Ventana:{width:'100%',height:'90%'}}
					layout_ejecucion.loadWindows(direccion+'../../../../sis_presupuesto/vista/ejecucion_presupuesto/ejecucion_presupuesto.php?'+data,'Detalle de Partida Gasto',ParamVentana);
			//dialog.hide();	
		}
		else{alert(mensaje);}
		}
	}}

	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}

