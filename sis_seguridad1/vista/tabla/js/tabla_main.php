<?php
/**
 * Nombre:		  	    tabla_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-06-04 16:11:09
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
var maestro={id_metaproceso:<?php echo $m_id_metaproceso;?>,nombre:decodeURIComponent('<?php echo $m_nombre;?>'),descripcion:decodeURIComponent('<?php echo $m_descripcion;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_tabla(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_tabla.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-06-04 16:11:10
 */
function pagina_tabla(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tabla/ActionListarTabla.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tabla',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tabla',
		'nombre_metaproceso',
		'descripcion_metaproceso',
		'nombre_tabla',
		'desc_tabla',
		'nombre',
		'observaciones',
		'id_metaproceso',
		'desc_metaproceso',
		'fk_id_tabla'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_metaproceso:maestro.id_metaproceso
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Metaproceso',maestro.id_metaproceso],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    var ds_tabla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tabla/ActionListarTabla.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_tabla',totalRecords:'TotalCount'},['id_tabla','nombre','observaciones','id_metaproceso','fk_id_tabla'])
	});
	
	var ds_relacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/relacion/ActionListarRelacion.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_tabla',totalRecords:'TotalCount'},['id_relacion','nombre'])
	});

	function render_id_tabla(value, p, record){return String.format('{0}', record.data['nombre_tabla']);}
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tabla
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tabla',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_tabla'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Tabla',
			allowBlank:false,
			emptyText:'tabla...',
			desc: 'nombre_tabla', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_relacion,
			valueField: 'nombre',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'c.relname',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			grid_indice:1	
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TABCON.nombre',
		save_as:'nombre'
	};
// txt observaciones
	Atributos[2]={
		validacion:{
			name:'observaciones',
			fieldLabel:'observaciones',
			allowBlank:true,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disable:false,
			grid_indice:2		
		},
		tipo:'Field',
		filtro_0:true,
		form:true,		
		filterColValue:'TABCON.observaciones',
		save_as:'observaciones'
	};
// txt id_metaproceso
	Atributos[3]={
		validacion:{
			name:'id_metaproceso',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_metaproceso,
		save_as:'id_metaproceso'
	};
// txt fk_id_tabla
	Atributos[4]={
		validacion:{
			name:'fk_id_tabla',
			fieldLabel:'Join',
			allowBlank:true,
			emptyText:'join...',
			desc: 'nombre_tabla', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tabla,
			valueField: 'id_tabla',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TABCON.nombre',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tabla,
			grid_visible:true,
			grid_editable:true,
			width_grid:250		
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TABCON.fk_id_tabla',
		save_as:'fk_id_tabla'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Metaproceso (Maestro)',titulo_detalle:'Tabla (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_tabla = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tabla.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_tabla,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/tabla/ActionEliminarTabla.php',parametros:'&m_id_metaproceso='+maestro.id_metaproceso},
	Save:{url:direccion+'../../../control/tabla/ActionGuardarTabla.php',parametros:'&m_id_metaproceso='+maestro.id_metaproceso},
	ConfirmSave:{url:direccion+'../../../control/tabla/ActionGuardarTabla.php',parametros:'&m_id_metaproceso='+maestro.id_metaproceso},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'tabla'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_metaproceso=datos.m_id_metaproceso;
maestro.nombre=datos.m_nombre;
maestro.descripcion=datos.m_descripcion;
		ds_tabla.baseParams={m_id_metaproceso:maestro.id_metaproceso};
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_metaproceso:maestro.id_metaproceso
			}
		};
		this.btnActualizar();
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Metaproceso',maestro.id_metaproceso],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]);
		Atributos[3].defecto=maestro.id_metaproceso;

		paramFunciones.btnEliminar.parametros='&m_id_metaproceso='+maestro.id_metaproceso;
		paramFunciones.Save.parametros='&m_id_metaproceso='+maestro.id_metaproceso;
		paramFunciones.ConfirmSave.parametros='&m_id_metaproceso='+maestro.id_metaproceso;
		this.InitFunciones(paramFunciones)
	};
	function btn_campo(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_tabla='+SelectionsRecord.data.id_tabla;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_desc_metaproceso='+SelectionsRecord.data.desc_metaproceso;

			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_tabla.loadWindows(direccion+'../../../vista/campo/campo.php?'+data,'Campo',ParamVentana);
layout_tabla.getVentana().on('resize',function(){
			layout_tabla.getLayout().layout();
				})
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	}
		}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tabla.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Campo',btn_campo,true,'campo','');
	ds_tabla.baseParams={m_id_metaproceso:maestro.id_metaproceso};
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tabla.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}