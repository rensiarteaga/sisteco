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
var elemento={pagina:new pagina_servicio_proveedores(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_servicio_proveedores.js
 * Propósito: 			pagina objeto principal
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		16/09/2009
 */
function pagina_servicio_proveedores(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
    var nombre_tipo_adq='';
    var nombre_tipo_servicio='';
    var nombre_servicio='';

	var datax;
   
	 var ds_tipo_adq= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/tipo_adq/ActionListarTipoAdq.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_adq',
			totalRecords: 'TotalCount'
		}, ['id_tipo_adq','nombre','observaciones','tipo_adq','descripcion','fecha_reg','codigo','estado'])
	});
	
	var ds_tipo_servicio= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/tipo_servicio/ActionListarTipoServicio.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_servicio',
			totalRecords: 'TotalCount'
		}, ['id_tipo_servicio','nombre','descripcion','fecha_reg','id_tipo_adq','desc_tipo_adq'])
	});
	
	
	var ds_servicio= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/servicio/ActionListarServicio_det.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_servicio',
			totalRecords: 'TotalCount'
		}, ['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio','desc_tipo_servicio','codigo_entero','continuo','estado'])
	});
	

	
	function renderTipoAdq(value, p, record){return String.format('{0}', record.data['nombre']);}
	function renderTipoServicio(value, p, record){return String.format('{0}', record.data['nombre']);}
	function renderServicio(value, p, record){return String.format('{0}', record.data['nombre']);}	

	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			name:'sw_servicio_clasificacion',
			fieldLabel:'Consulta',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','Servicio'],['1','Clasificación']]}),
			onSelect: function(record){ClaseMadre_getComponente('sw_servicio_clasificacion').setValue(record.data.id);
			                           ClaseMadre_getComponente('sw_servicio_clasificacion').collapse();
			           if (record.data.id==0){
				CM_mostrarGrupo('Servicios');
				//CM_mostrarGrupo('Clasificación Item');
				CM_ocultarGrupo('Clasificación Servicios');
				SiBlancosGrupo(1);
				NoBlancosGrupo(2);
				
			}else{
				CM_mostrarGrupo('Clasificación Servicios');
					//CM_mostrarGrupo('Item');
				CM_ocultarGrupo('Servicios');
				SiBlancosGrupo(2);
				NoBlancosGrupo(1);
			}},		
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:50,
			width:'50%'
			
		},
		tipo:'ComboBox',
		save_as:'sw_servicio_clasificacion',
		id_grupo:0
		};
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Tipo Adquisición',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Tipo Adquisicion...',
			name:'id_tipo_adq',
			desc:'nombre',
			store:ds_tipo_adq,
			valueField:'id_tipo_adq',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:renderTipoAdq,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		
		save_as:'id_tipo_adq',
		tipo:'ComboBox',
		id_grupo:1
	};
	//vectorAtributos[0] = param_id_supergrupo;
	filterCols_tipo_servicio=new Array();
	filterValues_tipo_servicio=new Array();
	filterCols_tipo_servicio[0]='TIPADQ.id_tipo_adq';
	filterValues_tipo_servicio[0]='%';
	

	vectorAtributos[2]={
		validacion:{
			fieldLabel:'Tipo Servicio',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Tipo Servicio...',
			name:'id_tipo_servicio',
			desc:'nombre',
			store:ds_tipo_servicio,
			valueField:'id_tipo_servicio',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'TIPSER.nombre',
			filterCols:filterCols_tipo_servicio,
			filterValues:filterValues_tipo_servicio,
			typeAhead:true,
			forceSelection:true,
			renderer:renderTipoServicio,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		
		save_as:'id_tipo_servicio',
		tipo:'ComboBox',
		id_grupo:1
	};

	vectorAtributos[3]={
		validacion:{
			fieldLabel:'Servicios',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Servicios...',
			name:'id_servicio',
			desc:'nombre',
			store:ds_servicio,
			valueField:'id_servicio',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'SERVIC.nombre',
			/*filterCols:filterCols_servicio,
			filterValues:filterValues_servicio,*/
			typeAhead:true,
			forceSelection:true,
			renderer:renderServicio,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		
		save_as:'id_servicio',
		tipo:'ComboBox',
		id_grupo:2
	};
  vectorAtributos[4]={
		validacion:{
			labelSeparator:'',
			name:'tipo_adq',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'tipo_adq'
	};	
	
	vectorAtributos[5]={
		validacion:{
			labelSeparator:'',
			name:'tipo_servicio',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'tipo_servicio'
	};	
	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'servicio',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'servicio'
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
		titulo_maestro:'Servicios Proveedores'
		
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
		
		var titulo = "Clasificación Servicio";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		
		url:direccion+'../../../../control/_reportes/servicio/ActionPDFReporteServiciosProveedor.php',
					
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:true,
		width:'60%',
		columnas:['47%','47%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Reporte Servicios Proveedores',
		
		grupos:[
			{
				tituloGrupo:'Criterio de Selección',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Clasificación Servicios',
				columna:0,
				id_grupo:1
			},{
				tituloGrupo:'Servicios',
				columna:1,
				id_grupo:2
			}
		]}};
		
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

		function iniciarEventosFormularios(){
			
        for (var i=0;i<vectorAtributos.length;i++){
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}	
		CM_ocultarGrupo('Clasificación Servicios');
		CM_ocultarGrupo('Servicios');		
		//para iniciar eventos en el formulario
		combo_tipo_adq= ClaseMadre_getComponente('id_tipo_adq');
		combo_tipo_servicio= ClaseMadre_getComponente('id_tipo_servicio');
		combo_servicio_clasificacion=ClaseMadre_getComponente('sw_servicio_clasificacion');
		cmp_tipo_servicio=ClaseMadre_getComponente('tipo_servicio');
		cmp_tipo_adq=ClaseMadre_getComponente('tipo_adq');
		//cmp_servicio=ClaseMadre_getComponente('servicio');
		//combo_servicio= ClaseMadre_getComponente('id_servicio'); 
	    combo_tipo_adq.disable();
		ds_tipo_adq.load({callback:funComboTipoAdq});
		//ds_tipo_adq.each(funComboTipoAdq);
		
		function funComboTipoAdq(e){
			//var id = combo_tipo_adq.getValue()
			for (i=0;i<e.length;i++){
				//alert(e[i].data.id_tipo_adq);
				if (e[i].data.nombre='Servicios Generales'){
					combo_tipo_adq.setValue(e[i].data.id_tipo_adq);
					combo_tipo_servicio.filterValues[0] =  e[i].data.id_tipo_adq;
			        combo_tipo_servicio.modificado = true;
			        cmp_tipo_adq.setValue(e[i].data.nombre);
				}
			}
		//	alert(e[1].data.nombre);
			
			/*if (combo_tipo_adq.store.getById(id).data.nombre!='Servicios Generales'){
				combo_tipo_adq.setValue(id);
			   //combo_tipo_alert('Solo está autorizado Servicios Generales');	
			 }*/
		}
/*		var onTipoAdqSelect = function(e) {
			var id = combo_tipo_adq.getValue()
			
			combo_tipo_servicio.filterValues[0] =  id;
			combo_tipo_servicio.modificado = true;
						
			var  params1 = new Array();
			params1['id_tipo_servicio'] = '%';
			params1['nombre'] = 'Todos los Servicios';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_tipo_servicio.store.add(aux1)
			combo_tipo_servicio.setValue('%');
			 if (combo_tipo_adq.store.getById(id).data.nombre!='Servicios Generales'){
			   alert('Solo está autorizado Servicios Generales');	
			 }
			 
			///////
		 //  nombre_tipo_adq=combo_tipo_adq.store.getById(id).data.nombre;
		   cmp_tipo_adq.setValue(combo_tipo_adq.store.getById(id).data.nombre);
		   //alert(nombre_tipo_adq);
		   
		};
*/		  var onTipoServicioSelect = function(e) {
			  var id = combo_tipo_servicio.getValue()

			  cmp_tipo_servicio.setValue(combo_tipo_servicio.store.getById(id).data.nombre);
			
		};
		
	/*	var onServicioSelect = function(e) {
			  var id = combo_servicio.getValue()
			
			  cmp_servicio.setValue(combo_servicio.store.getById(id).data.nombre);
			  
		  
		   
		};*/
		function clasificacion(){
		    datax = "id_tipo_adq=" + combo_tipo_adq.getValue()+'&id_tipo_servicio='+combo_tipo_servicio.getValue()+'&id_servicio='+combo_servicio.getValue()+'&txt_sw_servicio_clasificacion='+combo_servicio_clasificacion.getValue()+'&nombre_tipo_adq='+nombre_tipo_adq+'&nombre_tipo_servicio='+nombre_tipo_servicio+'&nombre_servicio='+nombre_servicio;
		            
			
		 }
		
		
		
		
		//combo_tipo_adq.on('select',onTipoAdqSelect);
		//combo_tipo_adq.on('change',onTipoAdqSelect);
		combo_tipo_servicio.on('select',onTipoServicioSelect);
		//combo_servicio.on('select',onServicioSelect);
		
				
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