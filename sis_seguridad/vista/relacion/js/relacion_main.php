<?php
/**
 * Nombre:		  	    relacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-17 16:09:00
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_subsistema:<?php echo $m_id_subsistema;?>,nombre_corto:'<?php echo $m_nombre_corto;?>',descripcion:'<?php echo $m_descripcion;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_relacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_relacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-17 16:09:00
 */
function pagina_relacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/relacion/ActionListarRelacion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_relacion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_relacion',
		'nombre',
		'codigo',
		'titulo',
		'descripcion'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_nombre_corto:maestro.nombre_corto
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	;
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_relacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_relacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_relacion'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre Tabla',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disable:true,
			grid_indice:1		
		},
		tipo:'Field',
		filtro_0:true,
		form:true,		
		filterColValue:'c.relname',
		save_as:'nombre'
	};
// txt codigo
	Atributos[2]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo Base',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			width:'100%',
			disable:false,
			grid_indice:2		
		},
		tipo:'Field',
		save_as:'codigo'
	};
// txt titulo
	Atributos[3]={
		validacion:{
			name:'titulo',
			fieldLabel:'Titulo',
			allowBlank:true,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disable:false,
			grid_indice:3		
		},
		tipo:'Field',
		save_as:'titulo'
	};
// txt descripcion
	Atributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:'100%',
			disable:false,
			grid_indice:4		
		},
		tipo:'Field',
		save_as:'descripcion'
	};
	
	// txt id_subsistema
	Atributos[5]={
		validacion:{
			name:'id_subsistema',
			labelSeparator:'',
			inputType:'hidden',
			disabled:true
		},
		tipo:'Field',
		defecto:maestro.id_subsistema,
		save_as:'id_subsistema'
	};
	
	// txt id_subsistema
	Atributos[6]={
		validacion:{
			name:'nombre_corto',
			labelSeparator:'',
			inputType:'hidden',
			disabled:true
		},
		tipo:'Field',
		defecto:maestro.nombre_corto,
		save_as:'nombre_corto'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:' (Maestro)',titulo_detalle:'Relaciones (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_relacion = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_relacion.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_relacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	
	ConfirmSave:{url:direccion+'../../../control/relacion/ActionGuardarRelacion.php',parametros:'&m_nombre_corto='+maestro.nombre_corto}
	}
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_subsistema=datos.m_id_subsistema;
	    maestro.nombre_corto=datos.m_nombre_corto;
	    maestro.descripcion=datos.m_descripcion;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_nombre_corto:maestro.nombre_corto
			}
		};
		this.btnActualizar();
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripción',maestro.descripcion]]);
		
		
		paramFunciones.ConfirmSave.parametros='&m_nombre_corto='+maestro.nombre_corto;
		this.InitFunciones(paramFunciones)
	};
	function btnGenerador(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_tabla='+SelectionsRecord.data.nombre;
			

			var paramVentana={
							Ventana:{
								width:'60%',
					            height:'70%'
							}
						};
				layout_relacion.loadWindows(direccion+'../../desc_tabla/desc_tabla.php?'+data, "Descripción Tabla",paramVentana);
				layout_relacion.getVentana().on('resize',function(){
			    layout_relacion.getLayout().layout();
				});
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un elemento.');
		}
		
		
		
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_relacion.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Descripción campos',btnGenerador,true, 'btngen','Descripción Campos');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_relacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}