<?php 
/**
 * Nombre:		  	    depreciacion2_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-07-20 14:54:38
 *
 */
session_start();
?>
//<script>
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
    echo "var id_grupo_depreciacion=$id_grupo_depreciacion;";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_depreciacion_temp(idContenedor,direccion,paramConfig,id_grupo_depreciacion),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);



function pagina_depreciacion_temp(idContenedor,direccion,paramConfig,id_grupo_depreciacion){
	var Atributos=new Array,sw=0;
	var ds;
	var sw=0;
	var maestro=new Array;

	
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depreciacion_temp/ActionListaDepreciacionTemp.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depreciacion_temp',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'codigo_temp', type: 'string'},
		'id_depreciacion_temp',
		'codigo_temp',
		'id_activo_fijo',
		'codigo_af',
		{name: 'fecha_dep', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'tipo_cambio_ini',		
		'tipo_cambio_fin',
		'vida_util_restante',
		'monto_actual',
		'depreciacion_acum',
		'depreciado',
		'observaciones',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'},
		]),

		remoteSort: true // metodo de ordenacion remoto
	});


	
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	

	/////////// hidden id_depreciacion_temp//////
	//en la posición 0 siempre tiene que estar la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_depreciacion_temp',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_depreciacion_temp'
	}
	
	/////////// txt codigo temp//////
	Atributos[1]={
		validacion:{
			name: 'codigo_temp',
			fieldLabel: 'Código',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		save_as:'txt_codigo_temp'
	}
	

	/////////// txt id_activo_fijo//////
	Atributos[2]={
		validacion:{
			name: 'id_activo_fijo',
			fieldLabel: 'Id activo fijo',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 300,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:250 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'id_activo_fijo',
		save_as:'txt_id_activo_fijo'
	}
	

	/////////// txt codigo af//////
	Atributos[3]={
		validacion:{
			name: 'codigo_af',
			fieldLabel: 'Código Activo Fijo',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 70,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:95 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'codigo_af',
		save_as:'txt_codigo_af'
	}
	

	/////////// txt fecha dep//////
	Atributos[4]={
		validacion:{
			name: 'fecha_dep',
			fieldLabel: 'Fecha Depreciación',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:105, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'fecha_dep',
		save_as:'txt_fecha_dep',
		dateFormat:'m-d-Y'
	}
	
	
	
	/////////// txt depreciado//////
	Atributos[5]={
		validacion:{
			name: 'depreciado',
			fieldLabel: 'Depreciado',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 300,

			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:60 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'depreciado',
		save_as:'txt_depreciado'
	}
	
	
	/////////// txt tipo_cambio_ini//////
	Atributos[6]={
		validacion:{
			name: 'tipo_cambio_ini',
			fieldLabel: 'Tipo cambio inicial',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 100,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'tipo_cambio_ini',
		save_as:'txt_tipo_cambio_ini'
	}
	
	
	/////////// txt tipo_cambio_fin//////
	Atributos[7]={
		validacion:{
			name: 'tipo_cambio_fin',
			fieldLabel: 'Tipo cambio final',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 100,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'tipo_cambio_fin',
		save_as:'txt_tipo_cambio_fin'
	}
	

	/////////// txt vida_util_restante//////
	Atributos[8]={
		validacion:{
			name: 'vida_util_restante',
			fieldLabel: 'Vida útil restante',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 300,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'vida_util_restante',
		save_as:'txt_vida_util_restante'
	}
	
	
	/////////// txt monto_actual//////
	Atributos[9]={
		validacion:{
			name: 'monto_actual',
			fieldLabel: 'Monto Actual',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 300,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'monto_actual',
		save_as:'txt_monto_actual'
	}
	
	
	/////////// txt depreciacion acum//////
	Atributos[10]={
		validacion:{
			name: 'depreciacion_acum',
			fieldLabel: 'Depreciación acumulada',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 300,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:125 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'depreciacion_acum',
		save_as:'txt_depreciacion_acum'
	}
	
	
	
	/////////// txt observaciones//////
	Atributos[11]={
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 300,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'observaciones',
		save_as:'txt_observaciones'
	}
	
	
	/////////// txt fecha_reg//////
	Atributos[12]={
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:85, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
	}
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Depreciación',grid_maestro:'grid-'+idContenedor};
	var layout_depreciacion_temp=new DocsLayoutMaestro(idContenedor);
	layout_depreciacion_temp.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_depreciacion_temp,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	
	//alert(this.SaveAndOther);
	var ClaseMadre_SaveAndOther = this.SaveAndOther; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor


	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		actualizar:{
			crear :true,
			separador:false
		}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {
		Formulario:{
			html_apply:"dlgInfo",
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true
		}
	}
	
	this.reload=function(params){
		
			
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_grupo_depreciacion=datos.id_grupo_depreciacion;
					
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_grupo_depreciacion:maestro.id_grupo_depreciacion
								
				}
			};			
			
			this.btnActualizar();			
						
	};


	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.getLayout=function(){return layout_depreciacion_temp.getLayout()};
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	maestro.id_grupo_depreciacion=id_grupo_depreciacion;
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_grupo_depreciacion:maestro.id_grupo_depreciacion
		}
	});
	
	
	this.iniciaFormulario();
	
	layout_depreciacion_temp.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);

}