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

var elemento ={pagina:new  ConsolidacionPresupuesto(idContenedor,direccion,paramConfig,configConsolidacion),idContenedor:idContenedor};

ContenedorPrincipal.setPagina(elemento);

}
Ext.onReady(main,main);

function ConsolidacionPresupuesto(idContenedor,direccion,paramConfig,configConsolidacion){
	var vectorAtributos=new Array();
//	var  municipio;
	var parametro;
	var gestion;
	var periodo;
	var id_moneda , id_parametro, tipo_pres, f_f,e_p_e,u_o;
	// Definición de todos los tipos de datos que se maneja
	// hidden id_tipo_activo
	//en la posición 0 siempre tiene que estar la llave primaria
	//DATA STORE
 var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
			,baseParams:{sw_vista:configConsolidacion.sw_vista}});
	
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
		}
		
				function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
				function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}

				var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
				var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
				// txt codigo
// txt tipo_pres  
	 vectorAtributos[0]  = {
		validacion: {
			name:'tipo_pres',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			emptyText:'Tipo Presupuesto...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data : [
				        
				        ['1', 'Recurso'],
				        ['2', 'Gasto'],
				        ['3', 'Inversión']
				        ] // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150,
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		
		save_as:'tipo_pres',
		id_grupo: 0
	};  
		 vectorAtributos[1]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Parametro...',
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

		 vectorAtributos[2]={
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
		/* vectorAtributos[3]  = {
		validacion: {
			name:'f_f',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Fuente Financiamiento',
			vtype:'texto',
			emptyText:'Fuente Financiamiento...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.combo// from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoCombo,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		defecto: '1',
		save_as:'fuente_financiamiento',
		id_grupo: 0
	};
	
	vectorAtributos[4]  = {
		validacion: {
			name:'e_p_e',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Estructura Programatica',
			vtype:'texto',
			emptyText:'Estructura Programatica...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.combo// from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoCombo,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		defecto: '1',
		save_as:'epe',
		id_grupo: 0
	};
		vectorAtributos[5]  = {
		validacion: {
			name:'u_o',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Unidad Organizacional',
			vtype:'texto',
			emptyText:'Unidad Organizacional...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.combo// from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoCombo,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		defecto: '1',
		save_as:'uo',
		id_grupo: 0
	};*/

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Consolidación Presupuesto"
	};
	layout_consolidacion=new DocsLayoutProceso(idContenedor);
	layout_consolidacion.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_consolidacion,idContenedor);

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
		
		/*f_f = ClaseMadre_getComponente('f_f');
		e_p_e = ClaseMadre_getComponente('e_p_e');	
		u_o = ClaseMadre_getComponente('u_o');*/
		
	/*	function combof_fOnSelect(){
			var id= f_f.getValue();
			if (id==2)
			{	alert ("Que hacemos Telma con estas Seleciones");
			}
		}
		function comboe_p_eOnSelect(){
			var id= e_p_e.getValue();
			if (id==2)
			{	alert ("Que hacemos Telma con estas Seleciones");
			}
		}
		function combou_oOnSelect(){
			var id= u_o.getValue();
			if (id==2)
			{	alert ("Que hacemos Telma con estas Seleciones");
			}
		}
		
		f_f.on('select',combof_fOnSelect);
		f_f.on('change',combof_fOnSelect);
		e_p_e.on('select',comboe_p_eOnSelect);
		e_p_e.on('change',comboe_p_eOnSelect);
		u_o.on('select',combou_oOnSelect);
		u_o.on('change',combou_oOnSelect);*/
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
			titulo_pestana:'Detalle Facturación',
			fileUpload:false,
			columnas:[305,305],
			//submit:abrirReportes,
			grupos:[
			{
				tituloGrupo:'Asigne Datos para la Consolidación ',
				columna:0,
				id_grupo:0
			}
			
			],
			parametros: '',
		submit:function (){	
					var data ='&m_tipo_pres='+tipo_pres.getValue(); 
					data+='&m_id_parametro='+id_parametro.getValue(); 
					data+='&m_id_moneda='+id_moneda.getValue(); 
					 var mensaje="";
					if(tipo_pres.getValue()==""){mensaje+=" El campo tipo Presupuesto esta vacio";};
					if(id_parametro.getValue()==""){mensaje+=" El campo Gestión esta vacio";};
					if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
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
		 
	 		var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			//layout_consolidacion.loadWindows(direccion+'../../../../sis_presupuesto/vista/detalle_partida_formulacion/detalle_partida_formulacion.php?'+data,'Detalle de Partida Gasto',ParamVentana);
		 layout_consolidacion.loadWindows(direccion+'../../../../sis_presupuesto/vista/consolidacion_presupuesto/consolidacion_presupuesto.php?'+data,'Detalle de Partida Gasto',ParamVentana);
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

