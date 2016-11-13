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

/*var maestro={
	nro_orden_compra:'<?php echo $m_nro_orden_compra;?>',
	periodo:'<?php echo $m_periodo;?>',
    id_gestion:'<?php echo $m_id_gestion;?>',
    id_departamento:'<?php echo $m_id_departamento;?>', 
    id_tipo_adquisicion:'<?php echo $m_id_tipo_adquisicion;?>'
    }*/

var elemento={pagina:new pagina_orden_compra_np(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_orden_compra_np.js
* Propósito: 			pagina objeto principal
* Autor:				AMVQ
* Fecha creación:		3/06/2009
*/
function pagina_orden_compra_np(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	//var data_ep;
	var componentes=new Array();
   // var txt_emp=0;
	//DATA STORE's
	
	var ds_parametro = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_gestion',totalRecords: 'TotalCount'}, ['id_gestion','id_empres','desc_empresa','id_moneda_base','desc_moneda','gestion','estado_ges_gral'])
	});
	
	
	var ds_departamento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo'])
	});
    	
	var ds_periodo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords:'TotalCount'},['id_periodo','id_gestion','periodo','fecha_inicio','fecha_registro','fecha_final','estado_peri_gral'])
	});
	                
	//FUNCIONES RENDER
	
		
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	
   var resultTplParAdq = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion}</b>','<br><FONT COLOR="#B5A642">Estado: {estado_ges_gral}</FONT>','</div>');
   var resultTplDepto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>','</div>');
   var resultTplPeriodo = new Ext.Template('<div class="search-item">','<b>Periodo: {periodo}</b>','<br><FONT COLOR="#B5A642">Estado: {estado_peri_gral}</FONT>','</div>');
   

	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_gestion',
			desc:'gestion',
			store:ds_parametro,
			valueField:'id_gestion',
			displayField:'gestion',
			filterCol:'PARALM.gestion',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParAdq,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:200,
			grid_indice:0
		},
		tipo:'ComboBox',
		save_as:'id_gestion',
		id_grupo:0
	};
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Periodo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Periodo...',
			name:'id_periodo',
			desc:'periodo',
			store:ds_periodo,
			valueField:'id_periodo',
			displayField:'periodo',
			filterCol:'PERIOD.periodo',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplPeriodo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:200,
			grid_indice:0
			
		},
		tipo:'ComboBox',
		save_as:'id_periodo',
		id_grupo:0
	};
vectorAtributos[2]={
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
	
	vectorAtributos[3]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo de Adquisición',
			vtype:'texto',
			emptyText:'Adquisición...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['Bien'],['Servicio']]}),
			valueField:'valor',
			displayField:'valor',
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		id_grupo:1,
		save_as:'tipo_adquisicion'
	};
	

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
   
	vectorAtributos[5]={
		validacion:{
			name:'nro_orden_compra',
			desc:'nro_orden_compra',
			fieldLabel:'Nro Orden de Compra',
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width:50
		},
		tipo:'Field',
		id_grupo:1,
		save_as:'nro_orden_compra'
	};
	
	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'vista_orden_compra',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		save_as:'vista_orden_compra',
		defecto:'rep_orden_compra_np'
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
		titulo_maestro:'Parametros de Reporte Orden de Compra'

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
		var titulo = "Reporte Orden de Compra";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'100%',
		url:direccion+'../../../../control/cotizacion/reporte/ActionPDFOrdenCompra.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'50%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'nose donde sale',
		grupos:[
		{tituloGrupo:'Gestion / Departamento',columna:0,id_grupo:0},
		{tituloGrupo:'Tipo de Adquisicion / Periodo / Nro Orden Compra',columna:0,id_grupo:1}
		
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	
	function iniciarEventosFormularios(){
		cmbGestion=ClaseMadre_getComponente('id_gestion');
		gestion=ClaseMadre_getComponente('gestion');
		vista_orden_compra=ClaseMadre_getComponente('vista_orden_compra');
		vista_orden_compra.setValue('rep_orden_compra_np');
		cmbPeriodo=ClaseMadre_getComponente('id_periodo');
		ClaseMadre_getComponente('id_periodo').disable();
		
		var onGestionSelect = function(e) {
			if(parseFloat(e.value)>0){
			//if(cmbGestion.store.getById(id)!=undefined){
			cmbPeriodo.modificado=true;
			ClaseMadre_getComponente('id_periodo').enable();
				
				ds_periodo.baseParams.id_gestion=e.value;
			    cmbPeriodo.modificado=true;
			    //cmbPeriodo.disabled=false;
			    cmbPeriodo.setValue('');
			}
			
		};
		
		cmbGestion.on('select',onGestionSelect);
		cmbGestion.on('change',onGestionSelect);
		
	}
	
	
/*function InitPaginaSolicitudesUO(){
	 for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
	
    }*/
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
	//InitPaginaSolicitudesUO(); 
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
