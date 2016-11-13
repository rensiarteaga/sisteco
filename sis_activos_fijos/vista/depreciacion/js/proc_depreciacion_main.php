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
var elemento={pagina:new ProcesoDepreciacion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_servicio_proveedores.js
 * Propósito: 			pagina objeto principal
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		16/09/2009
 * Fecha de modificación: 29/09/2009
 * Descripción:           Cambio de combo
 */
function ProcesoDepreciacion(idContenedor,direccion,paramConfig){
	
	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
    var nombre_tipo_adq='';
    var nombre_tipo_servicio='';
    var nombre_servicio='';

    
	var datax;
   
	 var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=actif'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');

	
	
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	// txt id_depto
	vectorAtributos[0]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento de Activos Fijos',
			allowBlank:false,			
			//emptyText:'Departamento de Tesorería...',
			desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'codigo_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			typeAhead:true,
			tpl:tpl_id_depto,
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
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',		
		filtro_0:true,
		filterColValue:'CUDOC.desc_depto',
		save_as:'txt_id_depto',
		id_grupo:0		
	};	
	
	////////// txt mes_ini //////
	vectorAtributos[1] = {
		validacion: {
			name: 'mes_fin',
			fieldLabel: 'Mes finalización',
			allowBlank: false,
			typeAhead: false,
			lazyRender:true,
			forceSelection:true,
			mode: 'local',
			triggerAction: 'all',			
			//store: new Ext.data.SimpleStore({fields: ['mes', 'nombre'],data : Ext.proc_depreciacionCombo.meses}),
			store: new Ext.data.SimpleStore({fields: ['mes', 'nombre'],data : [
			                                                                   ['01', 'Enero'],
			                                                                   ['02', 'Febrero'],
			                                                                   ['03', 'Marzo'],
			                                                                   ['04', 'Abril'],
			                                                                   ['05', 'Mayo'],
			                                                                   ['06', 'Junio'],
			                                                                   ['07', 'Julio'],
			                                                                   ['08', 'Agosto'],
			                                                                   ['09', 'Septiembre'],
			                                                                   ['10', 'Octubre'],
			                                                                   ['11', 'Noviembre'],
			                                                                   ['12', 'Diciembre']
			                                                               ]}),
			valueField:'mes',
			displayField:'nombre',
			width_grid:65, // ancho de columna en el grid
			width: 120,
			minChars : 0
		},
		tipo:'ComboBox',
		save_as:'txt_mes_fin',
		id_grupo:0
	}	

	////////// txt gestion_ini//////
	vectorAtributos[2] = {
		validacion:{
			name: 'gestion_fin',
			fieldLabel: 'Año finalización',
			allowBlank: false,
			maxLength:4,
			minLength:4,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 1900,
			maxValue: 2050,
			minText: 'La fecha debe ser mayor a 1900',
			maxText: 'La fecha debe ser menor a 2050',
			nanText : 'Fecha no válida',
			minLengthText :'La fecha debe estar en formato yyyy',
			maxLengthText :'La fecha debe estar en formato yyyy',			
			vtype:"texto",
			width: 80,
			typeAhead: false,
			//editable:true,
			mode: 'local',
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['v1'],data : Ext.proc_depreciacionCombo.anos}),
			store: new Ext.data.SimpleStore({fields: ['v1','v2'],data : 
				[
				 ['2000', '2000'],
			        ['2001', '2001'], 
			        ['2002', '2002'],
			        ['2003', '2003'],  
			        ['2004', '2004'], 
			        ['2005', '2005'],
			        ['2006', '2006'],
			        ['2007', '2007'],
			        ['2008', '2008'],
			        ['2009', '2009'],                                 
					['2010', '2010'],
			        ['2011', '2011'],
			        ['2012', '2012'],
			        ['2013', '2013'],
			        ['2014', '2014'],
			        ['2015', '2015'],
			        ['2016', '2016'],
			        ['2017', '2017'],
			        ['2018', '2018'],
			        ['2019', '2019'],
			        ['2020', '2020'],
			        ['2021', '2021'],
					['2022', '2022'],
					['2023', '2023'],
					['2024', '2024'],
					['2025', '2025']
				 ]}),
			valueField:'v1',
			displayField:'v1',
			lazyRender:true,
			forceSelection:true
		},
		tipo: 'ComboBox',
		save_as:'txt_gestion_fin',
		id_grupo: 0
	}	
	
	
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
		titulo_maestro:'Depreciación'		
	};
	
	layout_Servicios_proveedores=new DocsLayoutProceso(idContenedor);
	layout_Servicios_proveedores.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_Servicios_proveedores,idContenedor);
	
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
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerTitulo()
	{
		
		var titulo = "Depreciación";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		width:'60%',
		//url:direccion+'../../../../control/_reportes/servicio/ActionPDFReporteServiciosProveedor.php',
		url:direccion+'../../../../sis_activos_fijos/control/depreciacion/ActionDepreciar.php',		
		//url:'../../control/depreciacion/ActionDepreciar.php',			
	    abrir_pestana:false, //abrir pestana no
		titulo_pestana:obtenerTitulo,		
		fileUpload:false,		
		columnas:['47%','47%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Depreciación',
		
		grupos:[
			{
				tituloGrupo:'Parámetros Generales',
				columna:0,
				id_grupo:0
			}
		]}};
		
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

	function iniciarEventosFormularios(){
			
        for (var i=0;i<vectorAtributos.length;i++){
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}		
	}
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			//alert('Entra');
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
	
    //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_Servicios_proveedores.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
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
				//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}