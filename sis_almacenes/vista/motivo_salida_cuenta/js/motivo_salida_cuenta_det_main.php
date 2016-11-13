<?php
/**
 * Nombre:		  	    motivo_salida_cuenta_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 10:10:41
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var maestro={id_motivo_salida:<?php echo $m_id_motivo_salida;?>,nombre:'<?php echo $m_nombre;?>',descripcion:'<?php echo $m_descripcion;?>'};
var elemento={idContenedor:idContenedor,pagina:new pagina_motivo_salida_cuenta_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_motivo_salida_cuenta_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 10:10:41
 */
function pagina_motivo_salida_cuenta_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,cmb_ep,txt_fecha_reg,layout_motivo_salida_cuenta,ds_cuenta;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_salida_cuenta/ActionListarMotivoSalidaCuenta_det.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_motivo_salida_cuenta',
			totalRecords:'TotalCount'
		},[
		'id_motivo_salida_cuenta',
		'descripcion',
		'id_motivo_salida',
		'desc_motivo_salida',
		'id_cuenta',
		'desc_cuenta',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
        'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_motivo_salida:maestro.id_motivo_salida
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Motivo Salida',maestro.id_motivo_salida],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	ds_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_cuenta',
			totalRecords:'TotalCount'
		},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	//FUNCIONES RENDER
	function render_id_cuenta(value,p,record){return String.format('{0}',record.data['desc_cuenta'])}
	var resultTplCuenta=new Ext.Template('<div class="search-item">','<b>{nombre_cuenta}</b>','<br><FONT COLOR="#B5A642">{nro_cuenta}</FONT>','</div>');
	// Definición de datos //
	// hidden id_motivo_salida_cuenta
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_motivo_salida_cuenta',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_motivo_salida_cuenta'
	};
// txt descripcion
	vectorAtributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'MSALCU.descripcion',
		save_as:'txt_descripcion'
	};
// txt id_motivo_salida
	vectorAtributos[2]={
		validacion:{
			name:'id_motivo_salida',
			labelSeparator:'',
			inputType:'hidden',
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_motivo_salida,
		save_as:'txt_id_motivo_salida'
	};
// txt id_cuenta
	vectorAtributos[1]={
			validacion: {
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			name:'id_cuenta',
			desc:'desc_cuenta',
			store:ds_cuenta,
			valueField:'id_cuenta',
			displayField:'nombre_cuenta',
			filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplCuenta,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:250,
			grow:true,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:true,
			grid_indice:0,
			width_grid:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CUENTA.nro_cuenta#CUENTA.descripcion',
		defecto:'',
		save_as:'txt_id_cuenta'
	};
	vectorAtributos[4]={
			validacion:{
				fieldLabel:'EP',
				allowBlank:false,
				vtype:"texto",
				emptyText:'Estructura Programática',
				name:'id_ep',
				minChars:1,
				triggerAction:'all',
				editable:false,
				grid_editable:false,
				grid_visible:true,
				grid_indice:1,
				width:350
			},
			tipo:'epField',
			save_as:'hidden_id_ep1',
			id_grupo:1
		}
		// txt fecha_reg
	vectorAtributos[5]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'MSALCU.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Motivo de Salida (Maestro)',titulo_detalle:'Cuentas - Estructura Programática (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_motivo_salida_cuenta=new DocsLayoutDetalleEP(idContenedor,idContenedorPadre);
	layout_motivo_salida_cuenta.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_motivo_salida_cuenta,idContenedor);
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
	var ClaseMadre_btnEdit=this.btnEdit;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/motivo_salida_cuenta/ActionEliminarMotivoSalidaCuenta.php',parametros:'&m_id_motivo_salida='+maestro.id_motivo_salida},
	Save:{url:direccion+'../../../control/motivo_salida_cuenta/ActionGuardarMotivoSalidaCuenta.php',parametros:'&m_id_motivo_salida='+maestro.id_motivo_salida},
	ConfirmSave:{url:direccion+'../../../control/motivo_salida_cuenta/ActionGuardarMotivoSalidaCuenta.php',parametros:'&m_id_motivo_salida='+maestro.id_motivo_salida},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,columnas:['47%','47%'],grupos:[{tituloGrupo:'almacen_ep',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:1,id_grupo:1}],width:'90%',minWidth:150,minHeight:200,closable:true,titulo:'Cuenta del Motivo de Salida'}}
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_motivo_salida=datos.m_id_motivo_salida;
		maestro.nombre=datos.m_nombre;
		maestro.descripcion=datos.m_descripcion;
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Motivo Salida',maestro.id_motivo_salida],['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]);
		vectorAtributos[2].defecto=maestro.id_motivo_salida;
		paramFunciones={
	     btnEliminar:{url:direccion+'../../../control/motivo_salida_cuenta/ActionEliminarMotivoSalidaCuenta.php',parametros:'&m_id_motivo_salida='+maestro.id_motivo_salida},
	     Save:{url:direccion+'../../../control/motivo_salida_cuenta/ActionGuardarMotivoSalidaCuenta.php',parametros:'&m_id_motivo_salida='+maestro.id_motivo_salida},
	     ConfirmSave:{url:direccion+'../../../control/motivo_salida_cuenta/ActionGuardarMotivoSalidaCuenta.php',parametros:'&m_id_motivo_salida='+maestro.id_motivo_salida},
	     Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,columnas:['47%','47%'],grupos:[{tituloGrupo:'almacen_ep',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:1,id_grupo:1}],width:'90%',minWidth:150,minHeight:200,closable:true,titulo:'Cuenta del Motivo de Salida'}
	    };
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_motivo_salida:maestro.id_motivo_salida
			}
		};
		this.btnActualizar()
	};	
//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		cmb_ep=ClaseMadre_getComponente('id_ep');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		var onEpSelect=function(e){var ep=cmb_ep.getValue();data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad']};
		cmb_ep.on('change',onEpSelect)
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_motivo_salida_cuenta.getLayout()
	};
    this.btnNew=function(){
    	CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnNew()
	};
    this.btnEdit=function(){
    	CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnEdit()
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
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_motivo_salida_cuenta.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}