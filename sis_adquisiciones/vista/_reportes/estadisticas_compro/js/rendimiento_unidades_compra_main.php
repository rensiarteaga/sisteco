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
	
	?>

var paramConfig={TiempoEspera:10000};



var elemento={pagina:new pagina_rendimiento_unidades_compra(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_orden_compra_np.js
* Propósito: 			pagina objeto principal
* Autor:				
* Fecha creación:		
*/
function pagina_rendimiento_unidades_compra(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	//var data_ep;
	var componentes=new Array();
   // var txt_emp=0;
	//DATA STORE's
	
	var ds_departamento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=compro&oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo'])
	});
		
	//FUNCIONES RENDER
	
		
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	
	var resultTplDepto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>','</div>');
    
  
vectorAtributos[0]={
		validacion:{
			fieldLabel:'Departamento',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Depto...',
			name:'departamento',
			desc:'nombre_depto',
			store:ds_departamento,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol :'DEPTO.nombre_depto#DEPTO.codigo_depto',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			width:200,
			editable:true
		},
		id_grupo:0,
		save_as:'departamento',
		tipo:'ComboBox'
	};
	vectorAtributos[1]={
		validacion:{
			labelSeparator:'',
			name:'desc_depto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_depto'
	};
	
	vectorAtributos[2]={
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
	vectorAtributos[3]={
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
	


	vectorAtributos[4]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_ini',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'rep_fecha_ini'
	};

	vectorAtributos[5]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_fin',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'rep_fecha_fin'
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
		titulo_maestro:'Reporte Rendimiento de Unidades de Compra'

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
		var titulo = "Reporte Rendimiento de Unidades de Compra";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'100%',
		url:direccion+'../../../../control/_reportes/estadisticas_compro/ActionPDFRendimientoUnidadCompra.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'50%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'nose donde sale',
		grupos:[
		{
			tituloGrupo:'Departamento',
			columna:0,
			id_grupo:0
		}
		
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	
	function iniciarEventosFormularios(){
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		combo_fecha_inicio=ClaseMadre_getComponente('fecha_ini');
		combo_fecha_fin=ClaseMadre_getComponente('fecha_fin');	
		combo_rep_fecha_ini=ClaseMadre_getComponente('rep_fecha_ini');
		combo_rep_fecha_fin=ClaseMadre_getComponente('rep_fecha_fin');
		
		componentes[0].on('select',evento_departamento);		//departamento
				

		
		//Validación por la fecha.
		var onFecha_inicioSelect = function(e) {
			var fecha_inicio_val=combo_fecha_inicio.getValue();
				combo_fecha_fin.minValue=fecha_inicio_val;
				combo_rep_fecha_ini.setValue(formatDate(combo_fecha_inicio.getValue()));
				
		};
		var onFecha_finSelect = function(e) {
			var fecha_fin_val=combo_fecha_fin.getValue();
				combo_rep_fecha_fin.setValue(formatDate(combo_fecha_fin.getValue()));
			
		};
		
		combo_fecha_inicio.on('select',onFecha_inicioSelect);
		combo_fecha_inicio.on('change',onFecha_inicioSelect);
		combo_fecha_fin.on('change',onFecha_finSelect);
	
	}
	
	
	function evento_departamento( combo, record, index )
		{		
			componentes[1].setValue(record.data.codigo_depto+'-'+record.data.nombre_depto);
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
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
