//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var elemento={pagina:new ReporteMovimientos(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    movimientos_main.js
 * Proposito: 			pagina objeto principal
 * Autor:				UNKNOW
 * Fecha creacion:		03082015
 */
function ReporteMovimientos(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
	var datax,combo_tipo_mov;

	ds_almacen = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../control/almacen/ActionListarAlmacen.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'

		}, ['id_almacen','nombre_lugar','nombre_depto','codigo','nombre','direccion'])	});

	ds_tipo_mov = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../control/tipo_movimiento/ActionListarTipoMovimiento.php?filtro_reporte=si'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'

		}, ['id_tipo_movimiento','tipo','id_documento','requiere_aprobacion','documento','codigo_documento'])	});

	function render_id_tipo_movimiento(value, p, record)
	{
		return String.format('{0}', record.data['desc_almacen']);
	}
	
	var tplTipoMovimiento = new Ext.Template('<div class="search-item">','<b><font face ="univers" size ="2" style="text-transform: uppercase;">{documento}</font></b></br>','<font color="#BDB76B"><b>Código:&nbsp&nbsp</b>{codigo_documento}</br>','<b>Tipo:&nbsp&nbsp</b>{tipo}</br>','<b>Aprobaci�n:&nbsp&nbsp</b>{requiere_aprobacion}</font>','</div>');

	var tpl_almacen=new Ext.Template('<div class="search-item">','<b><font face ="univers" size ="2" style="text-transform: uppercase;">{nombre}</font></b></br>','<b><font color="#BDB76B">{codigo} - ','{direccion}</FONT></b>','</div>');


	var tpl_empleado=new Ext.Template('<div class="search-item">','<b><font face ="univers" size ="2" style="text-transform: uppercase;">{desc_persona}</font></b></br>','<font color="#BDB76B"><b>Unidad:&nbsp&nbsp</b>{nombre_unidad_presupuesta}</font></br>','<b><font color="#BDB76B">Cargo:&nbsp&nbsp</b>','{nombre_cargo}</font></br>','<font color="#BDB76B"><b>Documento:&nbsp&nbsp</b>{doc_id}</font>','</div>');

	 ds_empleado = new Ext.data.Store({
			// asigna url de donde se cargaran los datos
			proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?oc=si'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_empleado',
				totalRecords: 'TotalCount'

			}, ['id_empleado',
			    'id_persona',
			    'apellido_paterno',
			    'apellido_materno',
			    'nombre',
			    'desc_persona','nombre_cargo','doc_id','nombre_unidad_presupuesta',
			    'ci',
			    'email'
			    ])
		});

	
	vectorAtributos[0] = {
		validacion:{
			fieldLabel: 'Almacen',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Almacen...',
			name: 'id_almacen',     //indica la columna del store principal "ds" del que proviene el id
			desc: 'nombre', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_almacen,
// 			onSelect: function(record)
// 			{
// 				componentes[9].setValue(record.data.id_activo_fijo); 
// 				componentes[17].setValue(record.data.descripcion); 
// 				componentes[18].setValue(record.data.codigo);
// 				componentes[19].setValue(record.data.descripcion_larga);
// 				componentes[20].setValue(record.data.monto_compra);
// 				componentes[21].setValue(record.data.vida_util_original);
// 				componentes[22].setValue(record.data.fecha_ini_dep);					
// 				componentes[9].collapse(); 
// 			},
			valueField: 'id_almacen',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			tpl: tpl_almacen,
			minChars : 2, ///caracteres mï¿½nimos requeridos para iniciar la bï¿½squeda
			width : 320,
			triggerAction: 'all',				 
			editable: true
		},
		id_grupo:0,
		save_as:'h_id_almacen',
		tipo: 'ComboBox'

	};
	
	vectorAtributos[1] = {
			validacion:{
				fieldLabel: 'Tipo Movimiento',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Tipo Movimiento...',
				name: 'id_tipo_movimiento',     //indica la columna del store principal "ds" del que proviene el id
				desc: 'documento', //indica la columna del store principal "ds" del que proviene la descripcion
				store: ds_tipo_mov,
				valueField: 'id_tipo_movimiento',
				displayField: 'documento',
				queryParam: 'filterValue_0',
				onSelect: function(record)
	 			{
					componentes[1].setValue(record.data.id_tipo_movimiento);
	 				componentes[4].setValue(record.data.tipo);
	 				componentes[1].collapse();

	 				if(record.data.tipo == 'solicitud')
	 				{
	 					CM_mostrarGrupo('Solicitante');	
	 					SiBlancosGrupo(1);
	 					
		 			}
	 				else
	 				{
	 					CM_ocultarGrupo('Solicitante');	
	 					SiBlancosGrupo(1);
		 			}
	 				
	 			},
				filterCol:'',
				typeAhead: false,
				forceSelection : true,
				tpl: tplTipoMovimiento,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 0, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction: 'all',	
				width : 320,			 
				editable: true
			},
			id_grupo:0,
			save_as:'h_id_tipo_movimiento',
			tipo: 'ComboBox'

		};
	vectorAtributos[2]	= 
		{
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Desde',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width : 125,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m/d/Y',
		defecto:'',
		save_as:'txt_fecha_desde'
	};
	 

	////////// txt fecha_fin//////
	vectorAtributos[3]={
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Hasta',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText:  'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width : 125,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m/d/Y',
		defecto:'',
		save_as:'txt_fecha_hasta'
	};
	vectorAtributos[4]={
		validacion : {
			labelSeparator : '',
			name : 'tipo_movimiento',
			inputType : 'hidden',
			grid_visible : false,
			grid_editable : false
		},
		tipo : 'Field',
		filtro_0 : false,
		save_as : 'h_tipo_movimiento'
	};
	vectorAtributos[5] = {
    		validacion:{
    			fieldLabel: 'Empleado',
    			allowBlank: false,
    			vtype:"texto",
    			emptyText:'Empleado...',
    			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
    			desc: 'empleado', //indica la columna del store principal "ds" del que proviane la descripcion
    			store:ds_empleado,
    			valueField: 'id_empleado',
    			displayField: 'desc_persona',
    			queryParam: 'filterValue_0',
    			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
    			typeAhead: false,
    			forceSelection : true,
    			mode: 'remote',
    			queryDelay: 50,
    			pageSize: 10,
    			minListWidth : 300,
    			width:320,
    			tpl: tpl_empleado,
    			resizable: true,
    			queryParam: 'filterValue_0',
    			minChars : 0, ///caracteres m�nimos requeridos para iniciar la busqueda
    			triggerAction: 'all',
    			grid_editable : false,
    			grid_visible:true, // se muestra en el grid
    			grid_editable:false, //es editable en el grid,
    			width_grid:150
    			
    		},
    		id_grupo:1,
    		tipo: 'ComboBox',
    		save_as:'h_id_empleado'
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
		titulo_maestro:'Reporte Depreciaciones'		
	};
	
	layout_reporte_depreciacion=new DocsLayoutProceso(idContenedor);
	layout_reporte_depreciacion.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_reporte_depreciacion,idContenedor);
	
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
	var ClaseMadre_submit = this.submit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	
	
	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerTitulo()
	{
		
		var titulo = "Rep. Tipo de Movimientos";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/tipo_movimientos/ActionPDFTipoMovimientos.php',
							
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:false,  //rensi
		width:'80%',
		columnas:[480],
		//columnas:['47%','47%'],
		minWidth:800,
		minHeight:400,	
		closable:true,
		titulo:'Reporte Tipos de Movimientos',
		
		grupos:[
				{tituloGrupo:'Detalle Movimiento',columna:0,id_grupo:0},
				{tituloGrupo:'Solicitante',columna:0,id_grupo:1},
			]
		}	
	};
				
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

	
	function iniciarEventosFormularios()
	{		
		CM_ocultarGrupo('Solicitante');		
	}	

	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(vectorAtributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
		
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(vectorAtributos[i].id_grupo==grupo)
				componentes[i].allowBlank=vectorAtributos[i].validacion.allowBlank;
		}
	}
		
	function InitPaginaSolicitudes()
	{
		 for(i=0;i<vectorAtributos.length;i++){
				componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
			}
	}
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	
	//-------------- FIN DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
				
	this.InitFunciones(paramFunciones);
	//para agregar botones
				
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaSolicitudes();

	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}