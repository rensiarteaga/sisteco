<?php
/**
 * Nombre:		  	    empleado_extension_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-17 15:14:54
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
var paramConfig={TamanoPagina:10,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_gerencia:<?php echo $m_id_gerencia;?>,nombre_gerencia:'<?php echo $m_nombre_gerencia;?>',descripcion:'<?php echo $m_descripcion;?>'};
var elemento={idContenedor:idContenedor,pagina:new pagina_empleado_extension_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_empleado_extension_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-17 15:14:54
 */
function pagina_empleado_extension_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_empleado_extension,combo_empleado,ds_empleado;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado_extension/ActionListarEmpleadoExtension_det.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_extension',
			totalRecords:'TotalCount'
		},[
		'id_empleado_extension',
		'codigo_telefonico',
		'id_empleado',
		'id_persona',
		'desc_empleado',
		'desc_gerencia',
		'id_gerencia',
		'estado'
		]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gerencia:maestro.id_gerencia
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['Id Gerencia',maestro.id_gerencia],['Nombre Gerencia',maestro.nombre_gerencia],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
    ds_empleado=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado/ActionListarEmpleadoGerencia.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
	});
	//FUNCIONES RENDER
	function render_id_empleado(value,p,record){return String.format('{0}',record.data['desc_empleado'])}
	var resultTplEmp=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">Documento:{doc_id}</FONT>','<br><FONT COLOR="#B5A642">Email:{email1}</FONT>','</div>');
	// hidden id_empleado_extension
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_extension',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_empleado_extension'
	};
// txt codigo_telefonico
	vectorAtributos[2]={
		validacion:{
			name:'codigo_telefonico',
			fieldLabel:'Código Telefónico',
			allowBlank:true,
			maxLength:2,
			minLength:2,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width:60,
			width_grid:120
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'EMPEXT.codigo_telefonico',
		save_as:'txt_codigo_telefonico'
	};
// txt id_empleado
	vectorAtributos[1]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:false,			
			emptyText:'Funcionario...',
			desc:'desc_empleado',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			forceSelection:true,
			tpl:resultTplEmp,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width:200,
			width_grid:230
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		defecto: '',
		save_as:'txt_id_empleado'
	};
// txt id_gerencia
	vectorAtributos[3]={
		validacion:{
			name:'id_gerencia',
			labelSeparator:'',
			inputType:'hidden',
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_gerencia,
		save_as:'txt_id_gerencia'
	};	
	/////////// txt estado //////
    vectorAtributos[4]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			vtype:'texto',
			emptyText:'Estado...',
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor','nombre'],data:[['1','Activo'],['2','Inactivo']]}),
			valueField:'valor',
			displayField:'nombre',
			grid_visible:true,
			grid_editable:true,
			forceSelection:true,
			renderer:formatEstado,
			width:100,
			width_grid:100
		},
		tipo:'ComboBox',
		save_as:'txt_estado'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	function formatEstado(value){
		if(value==1){
			value='Activo'
		}
		else{
			value='Inactivo'
		}
		return value
	}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Gerencia (Maestro)',titulo_detalle:'Funcionarios (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_empleado_extension=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_empleado_extension.init(config);	
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado_extension,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};	
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/empleado_extension/ActionEliminarEmpleadoExtension.php',parametros:'&m_id_gerencia='+maestro.id_gerencia},
	Save:{url:direccion+'../../../control/empleado_extension/ActionGuardarEmpleadoExtension.php',parametros:'&m_id_gerencia='+maestro.id_gerencia},
	ConfirmSave:{url:direccion+'../../../control/empleado_extension/ActionGuardarEmpleadoExtension.php',parametros:'&m_id_gerencia='+maestro.id_gerencia},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:220,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Funcionario'}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_gerencia=datos.m_id_gerencia;
		maestro.nombre_gerencia=datos.m_nombre_gerencia;
		maestro.descripcion=datos.m_descripcion;
	    gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Gerencia',maestro.id_gerencia],['Nombre Gerencia',maestro.nombre_gerencia],['Descripcion',maestro.descripcion]]);
		vectorAtributos[3].defecto=maestro.id_gerencia;
		paramFunciones={
			btnEliminar:{url:direccion+'../../../control/empleado_extension/ActionEliminarEmpleadoExtension.php',parametros:'&m_id_gerencia='+maestro.id_gerencia},
			Save:{url:direccion+'../../../control/empleado_extension/ActionGuardarEmpleadoExtension.php',parametros:'&m_id_gerencia='+maestro.id_gerencia},
			ConfirmSave:{url:direccion+'../../../control/empleado_extension/ActionGuardarEmpleadoExtension.php',parametros:'&m_id_gerencia='+maestro.id_gerencia},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:220,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Funcionario'}
		};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_gerencia:maestro.id_gerencia
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
	combo_empleado=ClaseMadre_getComponente('id_empleado');
	combo_estado=ClaseMadre_getComponente('estado');
	}
	this.btnNew=function(){
	ds_empleado.reload();
	CM_ocultarComponente(combo_estado);
	combo_empleado.enable();
	combo_estado.setValue('1');
	ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
	ds_empleado.reload();
	CM_mostrarComponente(combo_estado);
	combo_empleado.disable();
	ClaseMadre_btnEdit()
	};
	this.SaveAndOther=function(){
	ds_empleado.reload();
	ClaseMadre_SaveAndOther()
	};
	this.getLayout=function(){
		return layout_empleado_extension.getLayout()
	};
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
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_empleado_extension.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}
