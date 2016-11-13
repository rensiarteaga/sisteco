<?php 
/**
 * Nombre:		  	    firma_autorizada_transf_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-12-13 10:11:00
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
	var elemento={pagina:new pagina_firma_autorizada_transf(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_firma_autorizada_transf_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-12-13 10:11:00
*/
function pagina_firma_autorizada_transf(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var data_ep_ingreso,cmb_ep_ingreso,combo_motivo_ingreso,combo_motivo_ingreso_cuenta,cmb_ep_salida,combo_motivo_salida,combo_motivo_salida_cuenta;
	var data_ep_salida;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/firma_autorizada_transf/ActionListarFirmaAutorizadaTransf.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_firma_autorizada_transf',
			totalRecords:'TotalCount'
		}, [
		'id_firma_autorizada_transf',
		'estado_registro',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'id_empleado',
		'desc_empleado',
		'desc_persona',
		'id_motivo_ingreso',
		'desc_motivo_ingreso',
		'id_motivo_ingreso_cuenta',
		'desc_motivo_ingreso_cuenta',
		'id_motivo_salida',
		'desc_motivo_salida',
		'id_motivo_salida_cuenta',
		'desc_motivo_salida_cuenta',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'id_financiador_sal',
		'id_regional_sal',
		'id_programa_sal',
		'id_proyecto_sal',
		'id_actividad_sal',
		'codigo_financiador_sal',
		'codigo_regional_sal',
		'codigo_programa_sal',
		'codigo_proyecto_sal',
		'codigo_actividad_sal'
		]),remoteSort:true});
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
		var ds_empleado=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleadoUsuarioEP.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado',
			totalRecords:'TotalCount'
		},['id_empleado','id_persona','codigo_empleado','desc_persona'])
		});
		var ds_motivo_ingreso=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_ingreso/ActionListarMotivoIngresoEP.php?tipo=Transferencia&id_financiador=-&id_regional=-&id_programa=-&id_proyecto=-&id_actividad=-'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_motivo_ingreso',
			totalRecords:'TotalCount'
		},['id_motivo_ingreso','nombre','descripcion','fecha_reg'])
		});
		var ds_motivo_ingreso_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_ingreso_cuenta/ActionListarMotivoIngresoCuenta.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_motivo_ingreso_cuenta',
			totalRecords:'TotalCount'
		},['id_motivo_ingreso_cuenta','desc_cuenta','descripcion','fecha_reg','codigo_ep'])
		});
		var ds_motivo_salida=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_salida/ActionListarMotivoSalidaEP.php?tipo=Transferencia&id_financiador=-&id_regional=-&id_programa=-&id_proyecto=-&id_actividad=-'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_motivo_salida',
			totalRecords:'TotalCount'
		},['id_motivo_salida','nombre','descripcion','fecha_reg'])
		});
		var ds_motivo_salida_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_salida_cuenta/ActionListarMotivoSalidaCuenta.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_motivo_salida_cuenta',
			totalRecords:'TotalCount'
		},['id_motivo_salida_cuenta','desc_cuenta','descripcion','fecha_reg','codigo_ep'])
		});
		//FUNCIONES RENDER
		function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_persona']);}
		function render_id_motivo_ingreso(value, p, record){return String.format('{0}', record.data['desc_motivo_ingreso']);}
		function render_id_motivo_ingreso_cuenta(value, p, record){return String.format('{0}', record.data['desc_motivo_ingreso_cuenta']);}
		function render_id_motivo_salida(value, p, record){return String.format('{0}', record.data['desc_motivo_salida']);}
		function render_id_motivo_salida_cuenta(value, p, record){return String.format('{0}', record.data['desc_motivo_salida_cuenta']);}
		//Template combo
		var resultTplMotivoIngreso = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
		var resultTplMotivoIngresoCuenta = new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{desc_cuenta}','<br>{codigo_ep}</FONT>','</div>');
		var resultTplMotivoSalida = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
		var resultTplMotivoSalidaCuenta = new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{desc_cuenta}','<br>{codigo_ep}</FONT>','</div>');
		var resultTplEmpleado = new Ext.Template('<div class="search-item">','<b><i>{codigo_empleado}</i></b>','<br><FONT COLOR="#B5A642">{desc_persona}</FONT>','</div>');
		// Definición de datos //
		vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name:'id_firma_autorizada_transf',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_firma_autorizada_transf'
		};
		// txt EP Ingreso
		vectorAtributos[1]={
			validacion:{
				fieldLabel:'EP',
				allowBlank:false,
				vtype:"texto",
				emptyText:'Estructura Programática',
				name:'id_ep_ingreso',     //indica la columna del store principal "ds" del que proviane el id
				minChars:1,
				triggerAction:'all',
				editable:false,
				grid_visible:false,
				grid_editable:false,
				grid_indice:14,
				width:200
			},
			lf:'Financiador Ingreso',
			lr:'Regional Ingreso',
			lp:'Programa Ingreso',
			lpr:'Proyecto Ingreso',
			la:'Actividad Ingreso',
			tipo: 'epField',
			save_as:'hidden_id_ep_ingreso',
			id_grupo:0
		};
		filterCols_motivo_ingreso=new Array();
		filterValues_motivo_ingreso=new Array();
		// txt id_motivo_ingreso
		vectorAtributos[2]={
			validacion:{
				fieldLabel:'Motivo ingreso',
				allowBlank:true,
				emptyText:'Motivo Ingreso ...',
				name:'id_motivo_ingreso',     //indica la columna del store principal ds del que proviane el id
				desc:'desc_motivo_ingreso', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_motivo_ingreso,
				valueField:'id_motivo_ingreso',
				displayField:'descripcion',
				queryParam:'filterValue_0',
				filterCol:'MOTING.descripcion',
				tpl:resultTplMotivoIngreso,
				filterCols:filterCols_motivo_ingreso,
				filterValues:filterValues_motivo_ingreso,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				width:200,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_motivo_ingreso,
				grid_visible:true,
				grid_editable:false,
				grid_indice:1,
				width_grid:120 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:false,
			filterColValue:'MOTING.descripcion',
			defecto:'',
			save_as:'txt_id_motivo_ingreso',
			id_grupo:0
		};
		filterCols_motivo_ingreso_cuenta=new Array();
		filterValues_motivo_ingreso_cuenta=new Array();
		filterCols_motivo_ingreso_cuenta[0]='MOTING.id_motivo_ingreso';
		filterValues_motivo_ingreso_cuenta[0]='-';
		// txt id_motivo_ingreso_cuenta
		vectorAtributos[3]={
			validacion:{
				name:'id_motivo_ingreso_cuenta',
				fieldLabel:'Motivo Ingreso Cuenta',
				allowBlank:false,
				emptyText:'Cuenta...',
				desc:'desc_motivo_ingreso_cuenta', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_motivo_ingreso_cuenta,
				valueField:'id_motivo_ingreso_cuenta',
				displayField:'descripcion',
				queryParam:'filterValue_0',
				filterCol:'MINGCU.descripcion',
				tpl:resultTplMotivoIngresoCuenta,
				filterCols:filterCols_motivo_ingreso_cuenta,
				filterValues:filterValues_motivo_ingreso_cuenta,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_motivo_ingreso_cuenta,
				grid_visible:true,
				grid_editable:true,
				grid_indice:2,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'MOINCU.descripcion',
			defecto: '',
			save_as:'txt_id_motivo_ingreso_cuenta',
			id_grupo:0
		};
		vectorAtributos[4]={
			validacion:{
				fieldLabel:'EP',
				allowBlank:false,
				vtype:"texto",
				emptyText:'Estructura Programática',
				name:'id_ep_salida',     //indica la columna del store principal "ds" del que proviane el id
				minChars:1,
				triggerAction:'all',
				editable:false,
				grid_visible:false,
				grid_editable:false,
				grid_visible:false,
				grid_indice:14,
				width:200
			},
			lf:'Financiador Salida',
			lr:'Regional Salida',
			lp:'Programa Salida',
			lpr:'Proyecto Salida',
			la:'Actividad Salida',
			f:'id_financiador_sal',
			r:'id_regional_sal',
			p:'id_programa_sal',
			pr:'id_proyecto_sal',
			a:'id_actividad_sal',
			nf:'nombre_financiador_dest',
			nr:'nombre_regional_dest',
			np:'nombre_programa_dest',
			npr:'nombre_proyecto_dest',
			na:'nombre_actividad_dest',
			cf:'codigo_financiador_sal',
			cr:'codigo_regional_sal',
			cp:'codigo_programa_sal',
			cpr:'codigo_proyecto_sal',
			ca:'codigo_actividad_sal',
			tipo: 'epField',
			save_as:'hidden_id_ep_salida',
			id_grupo:1
		};
		filterCols_motivo_salida=new Array();
		filterValues_motivo_salida=new Array();
		// txt id_motivo_salida
		vectorAtributos[5]={
			validacion: {
				fieldLabel:'Motivo Salida',
				allowBlank:true,
				emptyText:'Motivo Salida ...',
				name:'id_motivo_salida',     //indica la columna del store principal ds del que proviane el id
				desc:'desc_motivo_salida', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_motivo_salida,
				valueField:'id_motivo_salida',
				displayField:'descripcion',
				queryParam:'filterValue_0',
				filterCol:'MOTSAL.descripcion',
				tpl:resultTplMotivoSalida,
				filterCols:filterCols_motivo_salida,
				filterValues:filterValues_motivo_salida,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				width:200,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_motivo_salida,
				grid_visible:true,
				grid_editable:false,
				grid_indice:3,
				width_grid:120 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:false,
			filterColValue:'MOTSAL.descripcion',
			defecto:'',
			save_as:'txt_id_motivo_salida',
			id_grupo:1
		};
		filterCols_motivo_salida_cuenta=new Array();
		filterValues_motivo_salida_cuenta=new Array();
		filterCols_motivo_salida_cuenta[0]='MOTSAL.id_motivo_salida';
		filterValues_motivo_salida_cuenta[0]='-';
		// txt id_motivo_salida_cuenta
		vectorAtributos[6] = {
			validacion: {
				name:'id_motivo_salida_cuenta',
				fieldLabel:'Motivo Salida Cuenta',
				allowBlank:false,
				emptyText:'Cuenta Salida...',
				desc:'desc_motivo_salida_cuenta', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_motivo_salida_cuenta,
				valueField:'id_motivo_salida_cuenta',
				displayField:'descripcion',
				queryParam:'filterValue_0',
				filterCol:'MSALCU.descripcion',
				tpl:resultTplMotivoSalidaCuenta,
				filterCols:filterCols_motivo_salida_cuenta,
				filterValues:filterValues_motivo_salida_cuenta,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_motivo_salida_cuenta,
				grid_visible:true,
				grid_editable:true,
				grid_indice:4,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'MSALCU.descripcion',
			defecto:'',
			save_as:'txt_id_motivo_salida_cuenta',
			id_grupo:1
		};
		// txt id_empleado
		vectorAtributos[7]={
			validacion:{
				name:'id_empleado',
				fieldLabel:'Empleado',
				allowBlank:true,
				emptyText:'Empleado...',
				name:'id_empleado',     //indica la columna del store principal ds del que proviane el id
				desc:'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_empleado,
				valueField:'id_empleado',
				displayField:'desc_persona',
				queryParam:'filterValue_0',
				filterCol:'EMPLEA.id_persona#EMPLEA.codigo_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				tpl:resultTplEmpleado,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_empleado,
				grid_visible:true,
				grid_editable:true,
				width_grid:250 // ancho de columna en el grid
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'EMPLEA.codigo_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			defecto:'',
			save_as:'txt_id_empleado',
			id_grupo:2
		};
		// txt fecha_registro
		vectorAtributos[8]={
			validacion:{
				name:'fecha_registro',
				fieldLabel:'Fecha registro',
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
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'FATRAN.fecha_registro',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_registro',

		};
		// txt estado_registro
		vectorAtributos[9]={
			validacion:{
				name:'estado_registro',
				fieldLabel:'Estado registro',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.firma_autorizada_transf_combo.estado_registro}),
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],
				                                        					['inactivo','inactivo']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:true,
				width_grid:60 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:false,
			filtro_1:true,
			filterColValue:'FATRAN.estado_registro',
			defecto:'activo',
			save_as:'txt_estado_registro',
		};
		// ----------            FUNCIONES RENDER    ---------------//
		function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
		//---------         INICIAMOS LAYOUT MAESTRO     -----------//
		var config={
			titulo_maestro:'Firma Autorizada Transferencia',
			grid_maestro:'grid-'+idContenedor
		};
		layout_firma_autorizada_transf=new DocsLayoutMaestro(idContenedor);
		layout_firma_autorizada_transf.init(config);
		/// HEREDAMOS DE LA CLASE MADRE
		this.pagina=Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_firma_autorizada_transf,idContenedor);
		//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_ocultarTodosComponente=this.ocultarTodosComponente;
		var CM_ocultarComponente=this.ocultarComponente;
		var ClaseMadre_getGrid=this.getGrid;
		var ClaseMadre_getFormulario=this.getFormulario;
		var ClaseMadre_getDialog=this.getDialog;
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_btnEdit=this.btnEdit;
		var ClaseMadre_onResize=this.onResize;
		var ClaseMadre_SaveAndOther=this.SaveAndOther;
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/firma_autorizada_transf/ActionEliminarFirmaAutorizadaTransf.php'},
			Save:{url:direccion+'../../../control/firma_autorizada_transf/ActionGuardarFirmaAutorizadaTransf.php'},
			ConfirmSave:{url:direccion+'../../../control/firma_autorizada_transf/ActionGuardarFirmaAutorizadaTransf.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,
			height:'80%',
			width:'55%',
			columnas:['96%'],
			grupos:[
			{tituloGrupo:'Ingreso',columna:0,id_grupo:0},
			{tituloGrupo:'Salida',columna:0,id_grupo:1},
			{tituloGrupo:'Empleado que Ordena',columna:0,id_grupo:2}
			],
			minWidth:150,
			minHeight:200,
			closable:true,titulo:'Firma Autorizada Transferencia'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			this.btnNew=function()
			{	//dialog.resizeTo(450,380);
				CM_mostrarComponente(componentes[1]);
				CM_mostrarComponente(componentes[2]);
				CM_mostrarComponente(componentes[3]);
				CM_mostrarComponente(componentes[4]);
				CM_mostrarComponente(componentes[5]);
				CM_mostrarComponente(componentes[6]);
				CM_mostrarComponente(componentes[7]);
				CM_ocultarComponente(componentes[8]);
				CM_ocultarComponente(componentes[9]);
				ClaseMadre_btnNew();
				get_fecha_bd();
			};
			this.btnEdit=function()
			{
				CM_mostrarComponente(componentes[1]);
				CM_mostrarComponente(componentes[2]);
				CM_mostrarComponente(componentes[3]);
				CM_mostrarComponente(componentes[4]);
				CM_mostrarComponente(componentes[5]);
				CM_mostrarComponente(componentes[6]);
				CM_mostrarComponente(componentes[7]);
				CM_ocultarComponente(componentes[8]);
				CM_ocultarComponente(componentes[9]);
				ClaseMadre_btnEdit();
			}
			function get_fecha_bd(){
				Ext.Ajax.request({
					url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
					method:'GET',
					success:cargar_fecha_bd,
					failure:ClaseMadre_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			};
			function cargar_fecha_bd(resp){
				Ext.MessageBox.hide();
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if(componentes[8].getValue()=="")
					{

						componentes[8].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					}
				}
			};
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				cmb_ep_ingreso=ClaseMadre_getComponente('id_ep_ingreso');
				combo_motivo_ingreso = ClaseMadre_getComponente('id_motivo_ingreso');
				combo_motivo_ingreso_cuenta = ClaseMadre_getComponente('id_motivo_ingreso_cuenta');
				cmb_ep_salida=ClaseMadre_getComponente('id_ep_salida');
				combo_motivo_salida = ClaseMadre_getComponente('id_motivo_salida');
				combo_motivo_salida_cuenta = ClaseMadre_getComponente('id_motivo_salida_cuenta');
				var onMotivoIngresoSelect=function(e){
					var id=combo_motivo_ingreso.getValue();
					if(id=="") id='-';
					combo_motivo_ingreso_cuenta.filterValues[0]=id;
					combo_motivo_ingreso_cuenta.modificado=true;
					combo_motivo_ingreso_cuenta.setValue('');
					combo_motivo_ingreso.modificado=true;
				};
				var onMotivoSalidaSelect=function(e) {
					var id=combo_motivo_salida.getValue();
					if(id=="") id='-';
					combo_motivo_salida_cuenta.filterValues[0]=id;
					combo_motivo_salida_cuenta.modificado=true;
					combo_motivo_salida_cuenta.setValue('');
					combo_motivo_salida.modificado=true;
				};
				var onEpIngresoSelect=function(e){
					var ep=cmb_ep_ingreso.getValue();
					data_ep_ingreso='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
					//Actualiza los datastore de los combos para filtrar por EP
					actualizar_ds_combosIngreso();
					combo_motivo_ingreso.setValue('');
					combo_motivo_ingreso_cuenta.setValue('');
					combo_motivo_ingreso.modificado=true;
					combo_motivo_ingreso_cuenta.modificado=true;
					combo_motivo_ingreso_cuenta.filterValues[0]='-';
				};
				function actualizar_ds_combosIngreso(){
					var datos=Ext.urlDecode(decodeURIComponent(data_ep_ingreso));
					Ext.apply(combo_motivo_ingreso.store.baseParams,datos)
					Ext.apply(combo_motivo_ingreso_cuenta.baseParams,datos)
				};
				var onEpSalidaSelect=function(e){
					var ep=cmb_ep_salida.getValue();
					data_ep_salida='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
					//Actualiza los datastore de los combos para filtrar por EP
					actualizar_ds_combosSalida();
					combo_motivo_salida.setValue('');
					combo_motivo_salida_cuenta.setValue('');
					combo_motivo_salida.modificado=true;
					combo_motivo_salida_cuenta.modificado=true;
					combo_motivo_salida_cuenta.filterValues[0]='-'
				};
				function actualizar_ds_combosSalida(){
					var datos=Ext.urlDecode(decodeURIComponent(data_ep_salida));
					Ext.apply(combo_motivo_salida.store.baseParams,datos)
					Ext.apply(combo_motivo_salida_cuenta.baseParams,datos)
				}
				cmb_ep_salida.on('change',onEpSalidaSelect);
				combo_motivo_ingreso.on('select',onMotivoIngresoSelect);
				combo_motivo_ingreso.on('change',onMotivoIngresoSelect);
				cmb_ep_ingreso.on('change',onEpIngresoSelect);
				combo_motivo_salida.on('select',onMotivoSalidaSelect);
				combo_motivo_salida.on('change',onMotivoSalidaSelect);
				for(i=0;i<vectorAtributos.length;i++){
					componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
				}
				sm=getSelectionModel()
			};
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_firma_autorizada_transf.getLayout();};
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
			this.InitFunciones(paramFunciones);
			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_firma_autorizada_transf.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}