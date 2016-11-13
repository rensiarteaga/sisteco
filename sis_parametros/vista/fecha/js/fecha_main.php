<?php
session_start();
?>
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

	var fa;
	<?php
		if($_SESSION["ss_filtro_avanzado"]!='')
		{
			echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
		}
	?>	
var paramConfig={	TamanoPagina:30,
					TiempoEspera:100000000,
					CantFiltros:1,
					FiltroEstructura:false,
					FiltroAvanzado:fa
};

var elemento={pagina:new PaginaFecha(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function PaginaFecha(idContenedor,direccion,paramConfig)
{
	var sm;
	var grid;
	var dialog;
	var formulario;
	var componentes=new Array();
	
	var vectorAtributos=new Array();
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/fecha/ActionListarFecha.php'}),

		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_fecha',
			totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name:'desc_fecha', type:'string'},
		'id_fecha',
		{name:'fecha', type:'date', dateFormat:'Y-m-d'},
		'tipo_fecha',
		'desc_fecha',
		'id_lugar',
		'nombre',
		'dia_literal'
		]),

		remoteSort:true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declarado en el Data Store
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});

	/////////////////////////
	//   PARÁMETROS        //
	// Definición de datos //
	/////////////////////////

	/////DATA STORE COMBOS////////////
	var ds_param=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_param',
			totalRecords:'TotalCount'
		}, ['id_param','ciudad'])
	});

	var ds_lugar= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_lugar',totalRecords: 'TotalCount'},['id_lugar','nombre','ubicacion','codigo']),baseParams:{feriado:1}
	});
	
	function render_lugar(value, p, record){return String.format('{0}', record.data['nombre']);}
	var tpl_lugar=new Ext.Template('<div class="search-item">','<FONT COLOR="#B50000">{nombre}</FONT><br>','</div>');
	
	////////////////FUNCIONES RENDER ////////////
	function renderParam(value, p, record){return String.format('{0}', record.data['ciudad'])}

	function renderTipo(value, p, record){
		if(value==1)
		{return  "Feriado Nacional"}
		if(value==4)
		{return  "Feriado Departamental"}
		if(value==2)
		{return "Dia de Paro"}
		if(value==3)
		{return "Otros"}
	}

	vectorAtributos[0]={
		validacion:{				
			name:'id_fecha',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false 
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_fecha'
	};	

	vectorAtributos[1]={
		validacion:{				
			name:'dia_literal',
			fieldLabel:'Día ',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false 
		},
		tipo:'Field',
		form:false,
		filtro_0:false
	};	
	
	/////////// txt fecha//////		
	vectorAtributos[2]={
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:false,
			format:'d/m/Y', 
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true, 
			grid_editable:false, 
			renderer:formatDate,
			align:'center',
			width_grid:150,
			width:100
		},
		tipo:'DateField',
		filtro_0:true,
		save_as:'txt_fecha',
		dateFormat:'m-d-Y' 
	};	

	/////////// combo estado//////
	vectorAtributos[3]={
		validacion:{
			name:'tipo_fecha',
			fieldLabel:'Tipo Fecha',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({
				fields:['ID', 'valor'],
				data:[
				        [1, 'Feriado Nacional'],
						[4, 'Feriado Departamental'],
				        [2, 'Dia de Paro'],
				        [3, 'Otros']
				    ]
			}),
			valueField:'ID',
			displayField:'valor',
			align:'center',
			renderer:renderTipo,
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:150, 
			width:200
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'tipo_fecha',
		defecto:1,
		save_as:'txt_tipo_fecha'
	};
	
	/////////// txt desc_fecha//////
	vectorAtributos[4]={
		validacion:{
			name:'desc_fecha',
			fieldLabel:'Descripción Fecha',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grow:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:300, 
			width:300
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'desc_fecha',
		save_as:'txt_desc_fecha'
	};
	
	vectorAtributos[5]={
		validacion:{
			name:'id_lugar',
			fieldLabel:'Lugar',
			allowBlank:false,
			emptyText:'Lugar...',
			desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_lugar,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			tpl:tpl_lugar,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_lugar,
			renderer:render_lugar,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'LUG.nombre',
		save_as:'hidden_id_lugar'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y'):''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Fechas",
		grid_maestro:"grid-"+idContenedor
	};
	var layout_fecha=new DocsLayoutMaestro(idContenedor);
	layout_fecha.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_fecha,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;	
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;

	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////


	parametrosFiltro="&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones={
		btnEliminar:{
			url:direccion+"../../../control/fecha/ActionEliminarFecha.php"
		},
		Save:{
			url:direccion+"../../../control/fecha/ActionGuardarFecha.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/fecha/ActionGuardarFecha.php"
		},
		Formulario:{
			titulo:'Registro de Fechas',
			html_apply:"dlgInfo-"+idContenedor,
			width:500,
			height:300,
			minWidth:250,
			minHeight:200,
			columnas:['95%'],
			closable:true
		}
	};

	//sobrecarga
	this.btnNew=function(){
		ClaseMadre_btnNew()
	};

	this.SaveAndOther=function(){
		ClaseMadre_SaveAndOther()
	};

	function InitPaginaFecha(){
		for(var i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}		
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_fecha.getLayout();
	};

	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	this.iniciaFormulario();
	InitPaginaFecha();

	layout_fecha.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}