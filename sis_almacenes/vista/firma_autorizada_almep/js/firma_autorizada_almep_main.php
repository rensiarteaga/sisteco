<?php
/**
 * Nombre:		  	    firma_autorizada_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-23 18:53:21
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
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var maestro={id_almacen_ep:<?php echo $m_id_almacen_ep;?>,descripcion:'<?php echo $m_descripcion;?>',observaciones:'<?php echo $m_observaciones;?>',id_financiador:<?php echo $m_id_financiador;?>,id_regional:<?php echo $m_id_regional;?>,id_programa:<?php echo $m_id_programa;?>,id_proyecto:<?php echo $m_id_proyecto;?>,id_actividad:<?php echo $m_id_actividad;?>};
	var elemento={idContenedor:idContenedor,pagina:new pagina_firma_autorizada_almep(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento)
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_firma_autorizada_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-23 18:53:21
*/
function pagina_firma_autorizada_almep(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_firma_autorizada_almep,combo_movimiento,combo_ingreso,combo_salida,txt_estado_reg,txt_fecha_reg,combo_empleado,tipo_movimiento;
	var elementos=new Array();
	var sw=0;

	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/firma_autorizada/ActionListarFirmaAutorizada_almep.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_firma_autorizada',
			totalRecords:'TotalCount'
		},[
		'id_firma_autorizada',
		'descripcion',
		'prioridad',
		'estado_reg',
		'observaciones',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_empleado_frppa',
		'desc_empleado_tpm_frppa',
		'id_motivo_salida',
		'desc_motivo_salida',
		'desc_motivo_ingreso',
		'id_motivo_ingreso',
		'id_almacen_ep',
		'desc_almacen_ep',
		'nombre_completo'
		]),remoteSort:true});
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_ep:maestro.id_almacen_ep
			}
		});
		// DEFINICIÓN DATOS DEL MAESTRO
		var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
		function italic(value){return '<i>'+value+'</i>'}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Almacen EP',maestro.id_almacen_ep],['Descripcion',maestro.descripcion],['Observaciones',maestro.observaciones]]}),cm:cmMaestro});
		gridMaestro.render();
		//DATA STORE COMBOS
		var data_ep='hidden_ep_id_financiador='+maestro.id_financiador+'&hidden_ep_id_regional='+maestro.id_regional+'&hidden_ep_id_programa='+maestro.id_programa+'&hidden_ep_id_proyecto='+maestro.id_proyecto+'&hidden_ep_id_actividad='+maestro.id_actividad;
		var datos=Ext.urlDecode(decodeURIComponent(data_ep));
		var ds_empleado_tpm_frppa=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoUsuarioTpmFrppa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_frppa',totalRecords:'TotalCount'},['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti','desc_nombrecompleto','ci','email']),
			baseParams:datos
		});
		var ds_id_motivo_ingreso=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_ingreso/ActionListarMotivoIngreso.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_motivo_ingreso',totalRecords:'TotalCount'},['id_motivo_ingreso','nombre','descripcion'])
		});
		var ds_id_motivo_salida=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_salida/ActionListarMotivoSalida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_motivo_salida',totalRecords:'TotalCount'},['id_motivo_salida','nombre','descripcion'])
		});
		//FUNCIONES RENDER
		function render_id_empleado_frppa(value,p,record){return String.format('{0}',record.data['nombre_completo'])}
		function render_id_almacen_ep(value,p,record){return String.format('{0}',record.data['desc_almacen_ep'])}
		function render_id_motivo_ingreso(value,p,record){return String.format('{0}',record.data['desc_motivo_ingreso'])}
		function render_id_motivo_salida(value,p,record){return String.format('{0}',record.data['desc_motivo_salida'])}
		var resultTplAlmEP=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{observaciones}</FONT>','</div>');
		var resultTplEmpTpm=new Ext.Template('<div class="search-item">','<b><i>{desc_nombrecompleto}</i></b>','<br><FONT COLOR="#B5A642">Documento:{ci}</FONT>','<br><FONT COLOR="#B5A642">Email:{email}</FONT>','</div>');
		var resultTplMotSal=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
		var resultTplMotIng=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
		// Definición de datos //
		// hidden id_firma_autorizada
		vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name:'id_firma_autorizada',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_firma_autorizada'
		};
		// txt id_empleado_frppa
		vectorAtributos[1]={
			validacion:{
				name:'id_empleado_frppa',
				fieldLabel:'Funcionario',
				allowBlank:false,
				emptyText:'Funcionario...',
				desc:'nombre_completo',
				store:ds_empleado_tpm_frppa,
				valueField:'id_empleado_frppa',
				displayField:'desc_nombrecompleto',
				filterCol:'PER.nombre#PER.apellido_paterno#PER.apellido_materno#PER.doc_id#PER.email1',
				typeAhead:true,
				forceSelection:true,
				tpl:resultTplEmpTpm,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:250,
				grow:true,
				width:'90%',
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_empleado_frppa,
				grid_visible:true,
				grid_editable:false,
				width_grid:210
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'PER.nombre#PER.apellido_paterno#PER.apellido_materno#PER.doc_id#PER.email1',
			defecto: '',
			save_as:'txt_id_empleado_frppa'
		};
		// txt estado_reg
		vectorAtributos[2]={
			validacion:{
				name:'movimiento',
				fieldLabel:'Tipo de Movimiento',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.firma_autorizada_combo.movimiento}),
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Ingreso','Ingreso'],['Salida','Salida']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:true,
				width_grid:90
			},
			tipo:'ComboBox',
			filtro_0:false,
			defecto:'Ingreso',
			save_as:'txt_movimiento'
		};
		// txt id_motivo_salida
		vectorAtributos[3]={
			validacion:{
				name:'id_motivo_salida',
				fieldLabel:'Motivo de Salida',
				allowBlank:true,
				emptyText:'Motivo de Salida...',
				desc:'desc_motivo_salida',
				store:ds_id_motivo_salida,
				valueField:'id_motivo_salida',
				displayField:'nombre',
				queryParam:'filterValue_0',
				filterCol:'MOTSAL.nombre#MOTSAL.descripcion',
				typeAhead:true,
				forceSelection:true,
				tpl:resultTplMotSal,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:200,
				grow:true,
				width:'90%',
				resizable:true,
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_motivo_salida,
				grid_visible:true,
				grid_editable:false,
				width_grid:120
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'MOTSAL.nombre#MOTSAL.descripcion',
			defecto:'',
			save_as:'txt_id_motivo_salida'
		};
		// txt id_motivo_ingreso
		vectorAtributos[4]={
			validacion:{
				name:'id_motivo_ingreso',
				fieldLabel:'Motivo de Ingreso',
				allowBlank:true,
				emptyText:'Motivo de Ingreso...',
				desc:'desc_motivo_ingreso',
				store:ds_id_motivo_ingreso,
				valueField:'id_motivo_ingreso',
				displayField:'nombre',
				queryParam:'filterValue_0',
				filterCol:'MOTING.nombre#MOTING.descripcion',
				typeAhead:true,
				forceSelection:true,
				tpl:resultTplMotIng,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:200,
				grow:true,
				width:'90%',
				resizable:true,
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_motivo_ingreso,
				grid_visible:true,
				grid_editable:false,
				width_grid:120
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'MOTING.nombre#MOTING.descripcion',
			defecto: '',
			save_as:'txt_id_motivo_ingreso'
		};
		// txt prioridad
		vectorAtributos[5]={
			validacion:{
				name:'prioridad',
				fieldLabel:'Prioridad',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:60
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'FIRAUT.prioridad',
			save_as:'txt_prioridad'
		};
		// txt descripcion
		vectorAtributos[6]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:180,
				width:'90%'
			},
			tipo:'TextArea',
			filtro_0:true,
			filterColValue:'FIRAUT.descripcion',
			save_as:'txt_descripcion'
		};
		// txt observaciones
		vectorAtributos[7]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:180,
				width:'90%'
			},
			tipo:'TextArea',
			filtro_0:true,
			filterColValue:'FIRAUT.observaciones',
			save_as:'txt_observaciones'
		};
		// txt estado_reg
		vectorAtributos[8]={
			validacion:{
				name:'estado_reg',
				fieldLabel:'Estado registro',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.firma_autorizada_combo.estado_reg}),
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:90
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'FIRAUT.estado_reg',
			defecto:'activo',
			save_as:'txt_estado_reg'
		};
		// txt fecha_reg
		vectorAtributos[9]={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				allowBlank:true,
				format:'d/m/Y',
				minValue:'01/01/1900',
				disabledDaysText:'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'FIRAUT.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg'
		};
		// txt id_almacen_ep
		vectorAtributos[10]={
			validacion:{
				name:'id_almacen_ep',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_almacen_ep,
			save_as:'txt_id_almacen_ep'
		};
		//----------- FUNCIONES RENDER
		function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Almacén - Estructura Programática (Maestro)',titulo_detalle:'Firmas Autorizadas (Detalle)',grid_maestro:'grid-'+idContenedor};
		layout_firma_autorizada_almep=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_firma_autorizada_almep.init(config);
		//---------- INICIAMOS HERENCIA
		this.pagina=Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_firma_autorizada_almep,idContenedor);
		var getSelectionModel=this.getSelectionModel;
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
		var ClaseMadre_btnEliminar=this.btnEliminar;
		
		//-------- DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
		//--------- DEFINICIÓN DE FUNCIONES
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/firma_autorizada/ActionEliminarFirmaAutorizadaAlmEP.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
			Save:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizadaAlmEP.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
			ConfirmSave:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizadaAlmEP.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'50%',width:'50%',minWidth:150,minHeight:200,closable:true,titulo:'Firma Autorizada'}
		};
		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_almacen_ep=datos.m_id_almacen_ep
			maestro.descripcion=datos.m_descripcion;
			maestro.observaciones=datos.m_observaciones;
			maestro.id_financiador=datos.m_id_financiador;
			maestro.id_regional=datos.m_id_regional;
			maestro.id_programa=datos.m_id_programa;
			maestro.id_proyecto=datos.m_id_proyecto;
			maestro.id_actividad=datos.m_id_actividad;
			gridMaestro.getDataSource().removeAll();
			gridMaestro.getDataSource().loadData([['Id Almacen EP',maestro.id_almacen_ep],['Descripcion',maestro.descripcion],['Observaciones',maestro.observaciones]]);
			vectorAtributos[10].defecto=maestro.id_almacen_ep;
			data_ep='hidden_ep_id_financiador='+maestro.id_financiador+'&hidden_ep_id_regional='+maestro.id_regional+'&hidden_ep_id_programa='+maestro.id_programa+'&hidden_ep_id_proyecto='+maestro.id_proyecto+'&hidden_ep_id_actividad='+maestro.id_actividad;
			datos=Ext.urlDecode(decodeURIComponent(data_ep));			
			Ext.apply(combo_empleado.store.baseParams,datos);
			var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/firma_autorizada/ActionEliminarFirmaAutorizadaAlmEP.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
				Save:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizadaAlmEP.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
				ConfirmSave:{url:direccion+'../../../control/firma_autorizada/ActionGuardarFirmaAutorizadaAlmEP.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'50%',width:'50%',minWidth:150,minHeight:200,closable:true,titulo:'Firma Autorizada'}
			};
			this.InitFunciones(paramFunciones)
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_almacen_ep:maestro.id_almacen_ep
				}
				
			};
			this.btnActualizar()
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		function iniciarEventosFormularios(){
			combo_movimiento=ClaseMadre_getComponente('movimiento');
			combo_ingreso=ClaseMadre_getComponente('id_motivo_ingreso');
			combo_salida=ClaseMadre_getComponente('id_motivo_salida');
			txt_estado_reg=ClaseMadre_getComponente('estado_reg');
			txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
			combo_empleado=ClaseMadre_getComponente('id_empleado_frppa');
			var onMovimientoSelect=function(e){
				var movimiento=combo_movimiento.getValue();
				if(movimiento=='Salida'){
					CM_ocultarComponente(combo_ingreso);
					CM_mostrarComponente(combo_salida);
					combo_salida.setValue('');
					combo_ingreso.setValue('')
				}
				else{
					CM_ocultarComponente(combo_salida);
					CM_mostrarComponente(combo_ingreso);
					combo_salida.setValue('');
					combo_ingreso.setValue('')
				}
			};
			combo_movimiento.on('select',onMovimientoSelect);
			combo_movimiento.on('change',onMovimientoSelect)
		}
		this.btnNew=function(){
			CM_ocultarComponente(txt_fecha_reg);
			CM_ocultarComponente(txt_estado_reg);
			CM_ocultarComponente(combo_salida);
			CM_mostrarComponente(combo_movimiento);
			CM_mostrarComponente(combo_ingreso);
			combo_empleado.enable();
			combo_movimiento.enable();
			combo_salida.enable();
			combo_ingreso.enable();
			ClaseMadre_btnNew()
		};
		this.btnEdit=function(){
			tipo_movimiento=combo_salida.getValue();
			CM_ocultarComponente(txt_fecha_reg);
			CM_ocultarComponente(txt_estado_reg);
			CM_ocultarComponente(combo_movimiento);
			combo_empleado.disable();
			if(tipo_movimiento==''){
				CM_ocultarComponente(combo_salida);
				CM_mostrarComponente(combo_ingreso);
				combo_ingreso.disable()
			}
			else{
				CM_ocultarComponente(combo_ingreso);
				CM_mostrarComponente(combo_salida);
				combo_salida.disable()
			}
			ClaseMadre_btnEdit()
		};
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_firma_autorizada_almep.getLayout()
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
		this.Init();
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_firma_autorizada_almep.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}