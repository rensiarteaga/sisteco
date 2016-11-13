<?php
/**
 * Nombre:		  	    devengado_concepto_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 15:43:29
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
	?>
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
	var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var maestro={
		id_devengado:<?php if($id_devengado=='') {echo '0';} else {echo $id_devengado;}?>,
		desc_concepto_ingas:decodeURIComponent('<?php if($desc_concepto_ingas=='') {echo '0';} else {echo $desc_concepto_ingas;}?>'),
		desc_moneda:decodeURIComponent('<?php if($desc_moneda=='') {echo '0';} else {echo $desc_moneda;}?>'),
		importe_devengado:decodeURIComponent('<?php if($importe_devengado=='') {echo '0';} else {echo $importe_devengado;}?>'),
		estado_devengado:decodeURIComponent('<?php if($estado_devengado=='') {echo '0';} else {echo $estado_devengado;}?>'),
		tipo_devengado:decodeURIComponent('<?php if($tipo_devengado=='') {echo '0';} else {echo $tipo_devengado;}?>'),
		tipoFormDev:decodeURIComponent('<?php if($tipoFormDev=='') {echo '0';} else {echo $tipoFormDev;}?>')
	};
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new pagina_devengado_concepto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//sub view added

/**
* Nombre:		  	    pagina_devengado_concepto.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:43:29
*/
function pagina_devengado_concepto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado_concepto/ActionListarDevengadoConcepto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_devengado_concepto',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_devengado_concepto',
		'id_devengado',
		'id_concepto_ingas',
		'descripcion',
		'importe',
		'desc_concepto_ingas'
		]),remoteSort:true
	});


	// DEFINICIÓN DATOS DEL MAESTRO


	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}


	//Añade y dibuja Tabla del maestro si el formulario es de Pago o Finalización
	var div_grid_detalle,data_maestro;
	div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	data_maestro=[['Concepto Ingreso Gasto',maestro.desc_concepto_ingas],['Moneda',maestro.desc_moneda],['Importe Devengado',maestro.importe_devengado],['Estado Devengado',maestro.estado_devengado],['Tipo Devengado',maestro.tipo_devengado]];


	//DATA STORE COMBOS

	var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php?sw_tesoro=1'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_ingas','desc_ingas_item_serv','gestion_pres','desc_partida'])
		});
	
	//FUNCIONES RENDER
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b>Concepto: </b><FONT COLOR="#B5A642">{desc_ingas_item_serv}</FONT>','<br><b>Partida: </b><FONT COLOR="#8E2323 ">{desc_partida}</FONT>','<br><b>Gestion: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>','</div>');
	



	/////////////////////////
	// Definición de datos //
	/////////////////////////

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_devengado_concepto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			name:'id_devengado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_devengado
	};

	Atributos[2]={
			validacion:{
				name:'id_concepto_ingas',
				fieldLabel:'Concepto Gasto',
				allowBlank:false,
				emptyText:'Concepto Gasto...',
				desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_concepto_ingas,
				valueField: 'id_concepto_ingas',
				displayField: 'desc_ingas_item_serv',
				queryParam: 'filterValue_0',
				filterCol:'CONING.desc_ingas',
				typeAhead:false,
				tpl:tpl_id_concepto_ingas,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:15,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_concepto_ingas,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:300,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'desc_concepto_ingas'
		};
	
	
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:'90%',
			allowBlank:false
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'descripcion'
	};
	
	
	Atributos[4]={
		validacion:{
			name:'importe',
			fieldLabel:'Importe',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'50%',
			disabled:false,
			validator:function val_num(value){if(value<=0){return false;}else{return true;}},
			invalidText:'El valor debe ser mayor a cero'
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'DEVOTR.importe'
	};

	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var layout_devengado_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_devengado_detalle.init({titulo_maestro:'Registro de Pagos',titulo_detalle:'Otros conceptos de gasto',grid_maestro:'grid-'+idContenedor});

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_devengado_detalle,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_grid=this.getGrid;


	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES

	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));

	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/devengado_concepto/ActionEliminarDevengadoConcepto.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Save:{url:direccion+'../../../control/devengado_concepto/ActionGuardarDevengadoConcepto.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		ConfirmSave:{url:direccion+'../../../control/devengado_concepto/ActionAprobarDevengadoConcepto.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0}],width:'60%',minWidth:150,minHeight:200,	closable:true,titulo:'Otros Concepto de Gasto'}
	};

	//-------------- Sobrecarga de funciones --------------------//

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_devengado=datos.m_id_devengado;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_devengado:maestro.id_devengado
			}
		};
		this.btnActualizar();
		//Añade y dibuja Tabla del maestro si el formulario es de Pago o Finalización
		data_maestro=[['Concepto Ingreso Gasto',datos.m_desc_concepto_ingas],['Moneda',datos.m_desc_moneda],['Importe Devengado',datos.m_importe_devengado],['Estado Devengado',datos.m_estado_devengado],['Tipo Devengado',datos.m_tipo_devengado]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));

		Atributos[1].defecto=maestro.id_devengado;

		paramFunciones.btnEliminar.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.Save.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.ConfirmSave.parametros='&m_id_devengado='+maestro.id_devengado;

		//CM_getBoton('editar-'+idContenedor).disable();
		//CM_getBoton('eliminar-'+idContenedor).disable();//nuevo,guardar,actualizar

		this.InitFunciones(paramFunciones);
	};

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_devengado_detalle.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_devengado:maestro.id_devengado
		}
	});

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_devengado_detalle.getLayout().addListener('layout',this.onResize);
	//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}