<?php 
/**
 * Nombre:		  	    parametro_cuenta_auxiliar_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		13-10-2010
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
	}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};

var elemento={idContenedor:idContenedor,pagina:new pagina_parametro_cuenta_auxiliar(idContenedor,direccion,paramConfig)};
_CP.setPagina(elemento);

}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_parametro_cuenta_auxiliar.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		13-10-2010
 */
function pagina_parametro_cuenta_auxiliar(idContenedor,direccion,paramConfig){
	var Atributos=new Array;
	var ds;
	var elementos=new Array();
	var cmpId_gestion;
	var cmpCuenta,cmpAuxiliar,cmpEp,cmpUo,cmpPresupuesto,cmpTipoColumna;
	var g_id_gestion='';
	var maestro=new Array();
	var sw=0;
	var componentes=new Array;
	var dialog;
	var form;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_cuenta_auxiliar/ActionListarParametroCuentaAuxiliar.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_parametro_cuenta_auxiliar',totalRecords:'TotalCount'
		},[		
		'id_parametro_cuenta_auxiliar',
		'id_cuenta',
		'desc_cuenta',
		'id_auxiliar',
		'desc_auxiliar',
		'id_gestion',
		'gestion',
		'id_fina_regi_prog_proy_acti',
		'id_financiador',
		'nombre_financiador',
		'id_regional',
		'nombre_regional',
		'id_programa',
		'nombre_programa',
		'id_proyecto',
		'nombre_proyecto',
		'id_actividad',
		'nombre_actividad',
		'id_unidad_organizacional',
		'nombre_unidad',
		'id_columna_tipo',
		'nombre',
		'id_orden_trabajo',
		'desc_orden_trabajo',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_reg',
		'id_presupuesto',
		'desc_presupuesto'
		]),remoteSort:true});
	//DATA STORE COMBOS   	
	
		var ds_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_contabilidad/control/cuenta/ActionListarCuenField.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','desc_cuenta','nro_cuenta','nombre_cuenta'])});
		var tpl_cuenta=new Ext.Template('<div class="search-item">','<b>{desc_cuenta}</b>','<br><FONT COLOR="#B5A642"><b>Nombre:</b> {nombre_cuenta}</FONT>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta:</b> {nro_cuenta}</FONT>','</div>');
        var ds_auxiliar=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarCuentaAuxiliar.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_auxiliar',totalRecords:'TotalCount'},['id_cuenta_auxiliar','id_auxiliar','nombre_auxiliar','codigo_auxiliar'])});
		var tpl_auxiliar=new Ext.Template('<div class="search-item">','<b>Nombre:</b> {nombre_auxiliar}','<br><FONT COLOR="#B5A642"><b>Código:</b> {codigo_auxiliar}</FONT>','</div>');	
		var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?tipo_vista=reporte_solicitudes_uo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},
			['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel']),baseParams:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,sw_presto:1}
	});
	var ds_tipo_columna=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_columna/ActionListarColumnaTipo.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_columna_tipo',totalRecords:'TotalCount'},['id_columna_tipo','nombre','tipo_dato','tipo_aporte'])});
		var tpl_id_columna_tipo=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642"><b>Tipo Dato:</b> {tipo_dato}</FONT>','<br><FONT COLOR="#B5A642"><b>Tipo Aporte:</b> {tipo_aporte}</FONT>','</div>');
      var ds_orden_trabajo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_contabilidad/control/orden_trabajo/ActionListarOrdenTrabajo.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords:'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden'])});
		var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b>{desc_orden}</b>','<br><FONT COLOR="#B5A642"><b>Motivo:</b> {motivo_orden}</FONT>','</div>');
       
    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti',
																																								'desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto',
																																								'nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																																								'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin']),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>', 
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',
		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>',  
		'</div>'); 
		//FUNCIONES RENDER
	
function render_id_cuenta(value,p,record){return String.format('{0}',record.data['desc_cuenta'])}
function render_id_auxiliar(value,p,record){return String.format('{0}',record.data['desc_auxiliar'])}
function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['nombre_unidad']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
function render_id_columna_tipo(value, p, record){return String.format('{0}', record.data['nombre']);}	
function render_id_orden_trabajo(value, p, record){return String.format('{0}', record.data['desc_orden_trabajo']);}	
function render_financiador(value,p,record){return String.format('{0}',record.data['nombre_financiador'])}	
function render_regional(value,p,record){return String.format('{0}',record.data['nombre_regional'])}	
function render_programa(value,p,record){return String.format('{0}',record.data['nombre_programa'])}	
function render_proyecto(value,p,record){return String.format('{0}',record.data['nombre_proyecto'])}	
function render_actividad(value,p,record){return String.format('{0}',record.data['nombre_actividad'])}	
function render_estado_reg(value)
	{
		if(value=='activo'){value='Activo'	}
		else if(value=='inactivo'){value='Inactivo'	}
		return value
	}
Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_parametro_cuenta_auxiliar',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};
Atributos[1]={
		validacion:{
			fieldLabel:'Cuenta',
		    allowBlank:false,
		    vtype:'texto',
		    emptyText:'Cuenta...',
		    name:'id_cuenta',
		    desc:'desc_cuenta',
		    store:ds_cuenta,
		    valueField:'id_cuenta',
		    displayField:'desc_cuenta',
		    queryParam:'filterValue_0',
		    filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
		    typeAhead:true,
		    forceSelection:true,
		    renderer:render_id_cuenta,
		    tpl:tpl_cuenta,
		    mode:'remote',
		    queryDelay:50,
		    pageSize:10,
		    minListWidth:230,
		    width:250,
		    resizable:true,
		    minChars:0,
		    triggerAction:'all',
		    editable:true,
		    grid_visible:true,
		    grid_editable:false,
		    width_grid:230
		},
		tipo:'ComboBox',
	    filtro_0:true,
	    filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta'
	};
	    var filterCols_id_auxiliar=new Array();
	    var filterValues_id_auxiliar=new Array();
	    filterCols_id_auxiliar[0]='CUEAUX.id_cuenta';
	    filterValues_id_auxiliar[0]='%';
	Atributos[2]={
		validacion:{
			fieldLabel:'Auxiliar',
					allowBlank:false,
		            vtype:'texto',
					emptyText:'Auxiliar ...',
					name:'id_auxiliar',
					desc:'desc_auxiliar',
					store:ds_auxiliar,
					valueField:'id_auxiliar',
					displayField:'nombre_auxiliar',
					queryParam:'filterValue_0',
					filterCols:filterCols_id_auxiliar,
			        filterValues:filterValues_id_auxiliar,
					filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
					typeAhead:true,
					forceSelection:true,
					renderer:render_id_auxiliar,
					mode:'remote',
					queryDelay:50,
					pageSize:10,
					minListWidth:250,
					width:250,
					tpl:tpl_auxiliar,
					resizable:true,
					minChars:0,
					triggerAction:'all',
					editable:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:200
				},
				tipo:'ComboBox',
				filtro_0:true,
				filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar'
	};
	Atributos[3]={
		validacion:{
			labelSeparator:'',
			name:'id_gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
		
	};
	Atributos[4]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:'100%'	
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'PRESUP.desc_presupuesto'
	};
	Atributos[5]={
		validacion:{
			name:'id_columna_tipo',
			fieldLabel:'Tipo Columna',
			allowBlank:false,			
			emptyText:'Tipo Columna...',
			desc:'nombre', 
			store:ds_tipo_columna,
			valueField:'id_columna_tipo',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'COLTIP.nombre',
			typeAhead:true,
			tpl:tpl_id_columna_tipo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_columna_tipo,
			grid_visible:true,
			width:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'COLTIP.nombre'
		
	};
	Atributos[6]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[7]={
		validacion:{
			labelSeparator:'',
			name:'Financiador',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			renderer:render_financiador
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[8]={
		validacion:{
			labelSeparator:'',
			name:'Regional',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			renderer:render_regional
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name:'Programa',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			renderer:render_programa
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name:'Proyecto',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			renderer:render_proyecto
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[11]={
		validacion:{
			labelSeparator:'',
			name:'Actividad',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			renderer:render_actividad
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[12]={
		validacion:{
			name:'id_orden_trabajo',
			fieldLabel:'Orden de Trabajo',
			allowBlank:true,			
			emptyText:'Orden Trabajo...',
			desc:'desc_orden_trabajo', 
			store:ds_orden_trabajo,
			valueField:'id_orden_trabajo',
			displayField:'desc_orden',
			queryParam:'filterValue_0',
			filterCol:'ORDTRA.desc_orden',
			typeAhead:true,
			tpl:tpl_id_orden_trabajo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_orden_trabajo,
			width:200,
			grid_visible:true,
			grid_editable:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ORDTRA.desc_orden'
	};
	Atributos[13]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100,
			disabled:true		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PARCUAUX.fecha_reg',
		dateFormat:'m/d/Y'
	};
	Atributos[14]={
		validacion:{
			labelSeparator:'',
			name:'estado_reg',
			inputType:'hidden',
			grid_visible:true, 
			renderer:render_estado_reg,
			grid_editable:false
		},
		tipo:'Field',
		defecto:'activo',
		filtro_0:false
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	/*var config={
		titulo_maestro:'Empleado Cuenta',
		grid_maestro:'grid-'+idContenedor
	};*/
	var config={titulo_maestro:'Parametro Cuenta',grid_maestro:'grid-'+idContenedor};
	var layout_parametro_cuenta_auxiliar=new DocsLayoutMaestro(idContenedor);
	layout_parametro_cuenta_auxiliar.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_parametro_cuenta_auxiliar,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_btnEdit=this.btnEdit;
	
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro_cuenta_auxiliar/ActionEliminarParametroCuentaAuxiliar.php'},
		Save:{url:direccion+'../../../control/parametro_cuenta_auxiliar/ActionGuardarParametroCuentaAuxiliar.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro_cuenta_auxiliar/ActionGuardarParametroCuentaAuxiliar.php'},
		Formulario:
		    {html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Parametro'		    
		    }};
	
	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	    CM_getBoton('nuevo-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
	    CM_getBoton('editar-'+idContenedor).disable();
		cmpId_gestion=getComponente('id_gestion');
	    cmpCuenta=getComponente('id_cuenta');
	    cmpTipoColumna=getComponente('id_columna_tipo');
	    cmpAuxiliar=getComponente('id_auxiliar');
	    cmpFRPPA=getComponente('id_fina_regi_prog_proy_acti');
	    cmpOT=getComponente('id_orden_trabajo');
	    cmpPresupuesto=getComponente('id_presupuesto');
	    var onCuentaSelect=function(e){
			var id=cmpCuenta.getValue()
			cmpAuxiliar.filterValues[0]=id;
			cmpAuxiliar.modificado=true;
			cmpAuxiliar.enable();
			cmpAuxiliar.allowBlank=false;
			cmpAuxiliar.setValue('');
		};
		cmpCuenta.on('select',onCuentaSelect);
		cmpCuenta.on('change',onCuentaSelect)
		
		
	
	}

	
	this.btnNew=function(){
		CM_btnNew();
		cmpId_gestion.setValue(gestion.getValue());
	}
	
	/*this.btnEdit=function(){
		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.tiene_quincena=='si'){
				CM_mostrarComponente(getComponente('porcen_quincena'));
			}else{
				CM_ocultarComponente(getComponente('porcen_quincena'));
			}
			
			if(SelectionsRecord.data.socio_cooperativa=='si'){
				CM_mostrarComponente(getComponente('monto_fijo'));
				CM_mostrarComponente(getComponente('porcen_fijo_cooperativa'));
			}else{
				CM_ocultarComponente(getComponente('monto_fijo'));
				CM_ocultarComponente(getComponente('porcen_fijo_cooperativa'));
			}
			
			if(SelectionsRecord.data.tipo_contrato=='planta'){
				CM_ocultarComponente(getComponente('fecha_fin'));
				getComponente('fecha_fin').allowBlank=true;
				getComponente('fecha_fin').reset();
			}else{
				CM_mostrarComponente(getComponente('fecha_fin'));
				getComponente('fecha_fin').allowBlank=false;
			}
			CM_btnEdit();
		}else{
			alert('Es necesario seleccionar un item');
		}
	};*/
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_parametro_cuenta_auxiliar.getLayout()
	};
	//para el manejo de hijos
		this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
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
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	var CM_getBoton=this.getBoton;
	
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{estado:'abierto'}});
	   var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
var gestion =new Ext.form.ComboBox({
			store:ds_gestion,
			displayField:'gestion',
			typeAhead: true,
			mode:'remote',
			triggerAction: 'all',
			emptyText:'gestion...',
			selectOnFocus:true,
			width:100,
			valueField:'id_gestion',
			tpl:tpl_gestion
		});
  gestion.on('select',function (combo, record, index){g_id_gestion=gestion.getValue();
  ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:g_id_gestion
		}
	});	
	CM_getBoton('nuevo-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();
	    CM_getBoton('editar-'+idContenedor).enable();
  cmpId_gestion.setValue(g_id_gestion);
  cmpCuenta.store.baseParams={m_id_gestion:g_id_gestion};
  cmpTipoColumna.store.baseParams={m_id_gestion_parametro:g_id_gestion, estado:'activo'};
  cmpCuenta.modificado=true;
  cmpTipoColumna.modificado=true;
  cmpPresupuesto.store.baseParams={m_sw_rendicion:'si',sw_inv_gasto:'si',id_gestion:g_id_gestion};
  cmpPresupuesto.modificado=true;
  });
  this.AdicionarBotonCombo(gestion,'gestion');
	layout_parametro_cuenta_auxiliar.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}