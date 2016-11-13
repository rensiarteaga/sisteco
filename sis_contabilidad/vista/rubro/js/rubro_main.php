<?php
/**
 * Nombre:		  	    rubro_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-02 11:34:33
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
var maestro={id_reporte_eeff:<?php echo $m_id_reporte_eeff;?>,
nombre_eeff:decodeURIComponent('<?php echo $m_nombre_eeff;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_rubro(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_rubro.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-02 11:34:33
 */
function pagina_rubro(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	//  DATA STORE //
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rubro/ActionListarRubro.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_rubro',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_rubro',
		'nombre_rubro',
		'id_reporte_eeff',
		'desc_reporte_eeff',
		'fk_rubro',
		'desc_rubro',
		'sw_debe_haber',
		'sw_arbol_cuenta'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_reporte_eeff:maestro.id_reporte_eeff
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[
	//['id_reporte_eeff',maestro.id_reporte_eeff],
	['Reporte EEFF',maestro.nombre_eeff]];
	
	//DATA STORE COMBOS

    var ds_reporte_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarReporteEeff.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_reporte_eeff',totalRecords: 'TotalCount'},['id_reporte_eeff','nombre_eeff'])
	});

    var ds_rubro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rubro/ActionListarRubro.php?m_id_reporte_eeff='+maestro.id_reporte_eeff}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rubro',totalRecords: 'TotalCount'},['id_rubro','id_reporte_eeff','nombre_rubro','fk_rubro','sw_debe_haber'])
	});

	//FUNCIONES RENDER
	
		function render_id_reporte_eeff(value, p, record){return String.format('{0}', record.data['desc_reporte_eeff']);}
		var tpl_id_reporte_eeff=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_eeff}</FONT><br>','</div>');

		function render_fk_rubro(value, p, record){return String.format('{0}', record.data['desc_rubro']);}
		var tpl_fk_rubro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_rubro}</FONT><br>','</div>');

	function render_sw_debe_haber(value){
		if(value==1){value='Debe'	}
		 if (value==2){	value='Haber'}
		 if (value==3){	value='Suma Debe'}
		 if (value==4){	value='Suma Haber'}
	         	
		return value
	}
	
	function render_sw_arbol_cuenta(value){
		if(value=='si'){value='SI'	}
		if(value=='no'){value='NO'	}
	         
		return value
	}
		
		
	// Definición de datos //

	// hidden id_rubro
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_rubro',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_rubro'
	};
// txt nombre_rubro
	Atributos[1]={
		validacion:{
			name:'nombre_rubro',
			fieldLabel:'Nombre Rubro',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'RUBROO.nombre_rubro',
		save_as:'nombre_rubro'
	};
// txt id_reporte_eeff
	Atributos[2]={
		validacion:{
			name:'id_reporte_eeff',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_reporte_eeff,
		save_as:'id_reporte_eeff'
	};
// txt fk_rubro
	Atributos[3]={
			validacion:{
			name:'fk_rubro',
			fieldLabel:'Rubro Padre',
			allowBlank:true,			
			emptyText:'Rubro Padre...',
			desc: 'desc_rubro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rubro,
			valueField: 'id_rubro',
			displayField: 'nombre_rubro',
			queryParam: 'filterValue_0',
			filterCol:'RUBROO.nombre_rubro',
			typeAhead:true,
			tpl:tpl_fk_rubro,
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
			renderer:render_fk_rubro,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'RUBROO.nombre_rubro',
		save_as:'fk_rubro'
	};

	Atributos[4]={
		validacion:{
			name:'sw_debe_haber',
			fieldLabel:'Suma al Debe o Haber',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Debe'],['2','Haber'],['3','Suma Debe'],['4','Suma Haber']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_sw_debe_haber,
			grid_editable:false,
			forceSelection:true,
			width_grid:150,
			width:'50%'
			
		},
		tipo:'ComboBox',
		save_as:'sw_debe_haber'
		};
		Atributos[5]={
		validacion:{
			name:'sw_arbol_cuenta',
			fieldLabel:'Arbol Cuenta',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','SI'],['no','NO']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_sw_arbol_cuenta,
			grid_editable:false,
			forceSelection:true,
			width_grid:150,
			width:'50%'
			
		},
		tipo:'ComboBox',
		save_as:'sw_arbol_cuenta'
		};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'EEFF (Maestro)',titulo_detalle:'rubro (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_rubro = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_rubro.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_rubro,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/rubro/ActionEliminarRubro.php',parametros:'&m_id_reporte_eeff='+maestro.id_reporte_eeff},
	Save:{url:direccion+'../../../control/rubro/ActionGuardarRubro.php',parametros:'&m_id_reporte_eeff='+maestro.id_reporte_eeff},
	ConfirmSave:{url:direccion+'../../../control/rubro/ActionGuardarRubro.php',parametros:'&m_id_reporte_eeff='+maestro.id_reporte_eeff},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'rubro'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_reporte_eeff=datos.m_id_reporte_eeff;
    maestro.nombre_eeff=datos.m_nombre_eeff;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_reporte_eeff:maestro.id_reporte_eeff
			}
		};
		ds_rubro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rubro/ActionListarRubro.php?m_id_reporte_eeff='+maestro.id_reporte_eeff}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rubro',totalRecords: 'TotalCount'},['id_rubro','id_reporte_eeff','nombre_rubro','fk_rubro','sw_debe_haber'])
	});
		
		
		this.btnActualizar();
		data_maestro=[
		//['id_reporte_eeff',maestro.id_reporte_eeff],
		['Reporte EEFF',maestro.nombre_eeff]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[2].defecto=maestro.id_reporte_eeff;

		paramFunciones.btnEliminar.parametros='&m_id_reporte_eeff='+maestro.id_reporte_eeff;
		paramFunciones.Save.parametros='&m_id_reporte_eeff='+maestro.id_reporte_eeff;
		paramFunciones.ConfirmSave.parametros='&m_id_reporte_eeff='+maestro.id_reporte_eeff;
		this.InitFunciones(paramFunciones)
	};
	function btn_rubro_cuenta(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_rubro='+SelectionsRecord.data.id_rubro;
			data=data+'&m_nombre_rubro='+SelectionsRecord.data.nombre_rubro;
			data=data+'&m_nombre_eeff='+maestro.nombre_eeff;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_rubro.loadWindows(direccion+'../../../../sis_contabilidad/vista/rubro_cuenta/rubro_cuenta.php?'+data,'Rubro Cuenta',ParamVentana);

		}
	else
	{		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rubro.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Rubro Cuenta',btn_rubro_cuenta,true,'rubro_cuenta','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_rubro.getLayout().addListener('layout',this.onResize);
	layout_rubro.getVentana(idContenedor).on('resize',function(){layout_rubro.getLayout().layout()})
	
}