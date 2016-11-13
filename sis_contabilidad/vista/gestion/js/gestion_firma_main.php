<?php
/**
 * Nombre:		  	    gestion_firma_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 16:05:16
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
	
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new pagina_gestion_firma(idContenedor,direccion,paramConfig)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_gestion_frma.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 16:05:16
 */
function pagina_gestion_firma(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var maestro;
	var comp_id_empleado, comp_id_cargo, comp_sw_firma, comp_mat_contador;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/gestion_firma/ActionListarGestionFirma.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_gestion_firma',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_gestion_firma',
		'id_gestion',
		'sw_firma',
		'id_empleado',
		'nombre_completo',
		'id_cargo',
		'nombre_cargo',
		'mat_contador'
	]),remoteSort:true});
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	//DATA STORE COMBOS
    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','denominacion','gestion'])
	});
	
    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?correspondencia=si'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
	
    var ds_cargo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/gestion_firma/ActionListarCargos.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_historico_asignacion',totalRecords:'TotalCount'},['id_historico_asignacion','nombre_cargo','nombre_unidad'])
	});
	
	//FUNCIONES RENDER
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{denominacion}</FONT><br>','<FONT COLOR="#B5A642">{gestion}</FONT>','</div>');

	function render_id_empleado(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');
	
	function render_id_cargo(value, p, record){return String.format('{0}', record.data['nombre_cargo']);}
	var tpl_id_cargo=new Ext.Template('<div class="search-item">','<b><i>{nombre_cargo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_unidad}</FONT>','</div>');

	function render_firma(value, p, record){
		if(value=='firma_fc'){return 'Contador General';}
		if(value=='firma_f1'){return 'Presidencia / Gerencia General';}
		if(value=='firma_f2'){return 'Gerencia Administrativa Finaciera';}
		if(value=='firma_f3'){return 'Departamento Contable';}
		if(value=='firma_f4'){return 'Departamento Finanzas';}
		if(value=='firma_ff'){return 'Responsable Presupuestos';}
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_gestion_firma
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_gestion_firma',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	Atributos[1]={
		validacion:{
			name:'id_gestion',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};
	
	Atributos[2]={
		validacion: {
			name:'sw_firma',
			fieldLabel:'Firma',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['firma_f1','Presidencia / Gerencia General'],['firma_f2','Gerencia Administrativa Finaciera'],['firma_f3','Departamento Contable'],
			                                                			['firma_f4','Departamento Finanzas'],['firma_fc','Contador General'],['firma_ff','Responsable Presupuestos']]}),
			valueField:'ID',
			displayField:'valor',
			renderer:render_firma,
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			align:'center',
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false
	};

	Atributos[3]={
		validacion:{
			name:'id_empleado',
			fieldLabel:'Fucionario',
			allowBlank:false,			
			emptyText:'Funcionario...',
			desc: 'nombre_completo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'EA.nombre_completo'
	};
	
	Atributos[4]={
		validacion:{
			name:'id_cargo',
			fieldLabel:'Cargo',
			allowBlank:false,			
			emptyText:'Cargo...',
			desc: 'nombre_cargo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cargo,
			valueField: 'id_historico_asignacion',
			displayField: 'nombre_cargo',
			queryParam: 'filterValue_0',
			filterCol:'id_historico_asignacion#nombre_cargo#nombre_unidad',
			typeAhead:false,
			tpl:tpl_id_cargo,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cargo,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'EA.nombre_cargo'
	};
	
	Atributos[5]={
		validacion:{
			name:'mat_contador',
			fieldLabel:'Matricula',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'EEF.mat_contador'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Gestión (Maestro)',titulo_detalle:'gestion_firma (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_gestion_firma = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_gestion_firma.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_gestion_firma,idContenedor);
	
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_getComponente=this.getComponente;
	var CM_saveSuccess=this.saveSuccess;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	var CM_getDialog=this.getDialog;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_enableSelect=this.EnableSelect;

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/gestion_firma/ActionEliminarGestionFirma.php'},
		Save:{url:direccion+'../../../control/gestion_firma/ActionGuardarGestionFirma.php'},
		ConfirmSave:{url:direccion+'../../../control/gestion_firma/ActionGuardarGestionFirma.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'gestion_firma'}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_gestion:maestro.id_gestion
			}
		};
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_gestion;

		paramFunciones.btnEliminar.parametros='&id_gestion='+maestro.id_gestion;
		paramFunciones.Save.parametros='&id_gestion='+maestro.id_gestion;
		paramFunciones.ConfirmSave.parametros='&id_gestion='+maestro.id_gestion;
		this.InitFunciones(paramFunciones)
	};

	this.btnEdit = function(){
		comp_id_cargo.store.baseParams={id_empleado:comp_id_empleado.getValue()};
		comp_id_cargo.modificado=true;
		
		CM_ocultarComponente(comp_mat_contador);
		comp_mat_contador.allowBlank=true;
		
		CM_btnEdit();
		
		if (comp_sw_firma.getValue() == 'firma_fc'){
			CM_mostrarComponente(comp_mat_contador);
			comp_mat_contador.allowBlank=false;
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		comp_id_empleado = CM_getComponente('id_empleado');
		comp_id_cargo = CM_getComponente('id_cargo');
		comp_sw_firma = CM_getComponente('sw_firma');
		comp_mat_contador = CM_getComponente('mat_contador');
		
		comp_id_empleado.on('select', f_empleado);
		comp_sw_firma.on('select', f_firma);
	}
	
	function f_empleado(combo, record, index ){
		comp_id_cargo.store.baseParams={id_empleado:record.data.id_empleado};
		comp_id_cargo.modificado=true;
		comp_id_cargo.setValue('');
	}
	
	function f_firma(combo, record, index ){
		CM_ocultarComponente(comp_mat_contador);
		comp_mat_contador.allowBlank=true;
		comp_mat_contador.setValue('');

		if (record.data.ID == 'firma_fc'){
			CM_mostrarComponente(comp_mat_contador);
			comp_mat_contador.allowBlank=false;
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_gestion_firma.getLayout()};
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_gestion_firma.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}