<?php
/**
 * Nombre:		  	    depreciacion2_comprobante_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				
 * Fecha creación:		
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
var maestro={id_grupo_depreciacion:<?php echo $m_id_grupo_depreciacion;?>,
			 ano_fin:<?php echo $m_ano_fin;?>,
			 mes_fin:<?php echo $m_mes_fin;?>,
			 desc_depto:decodeURIComponent('<?php echo $m_desc_depto;?>'),
			 estado:decodeURIComponent('<?php echo $m_estado;?>'),
			 desc_usuario:decodeURIComponent('<?php echo $m_desc_usuario;?>'),
			 fecha_reg:decodeURIComponent('<?php echo $m_fecha_reg;?>'),
			 desc_usuario2:decodeURIComponent('<?php echo $m_desc_usuario2;?>'),
			 proyecto:decodeURIComponent('<?php echo $m_proyecto;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_depreciacion_comprobante(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre de archivo:	    depreciacion2_comprobante.js
* Propósito:				generador de la vista emergente
* Fecha de Creación:		10/01/2013
* Autor:					Elmer Velasquez
*/

function pagina_depreciacion_comprobante(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){

	var Atributos=new Array,sw=0; 
	var componentes=new Array;

	var TodasRegionales=false;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		//proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_comprobante/ActionListarRegionalesActivoFijoDepreciacion.php?m_id_grupo_depreciacion='+maestro.id_grupo_depreciacion+'&txt_mes_fin='+maestro.mes_fin+'&txt_ano_fin='+maestro.ano_fin}),
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_comprobante/ActionListaRegionalesDepreciacion.php?m_id_grupo_depreciacion='+maestro.id_grupo_depreciacion+'&txt_mes_fin='+maestro.mes_fin+'&txt_ano_fin='+maestro.ano_fin}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'codigo_regional',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiqutas (campos)
// 		'codigo_regional',
// 		'estado_registro',
// 		'ids_comprobantes',
		'id_depreciacion_cbte_regional',
		'id_grupo_depreciacion',
		'codigo_regional','id_depto','id_depto_aux','fecha_reg',
		'usuario_reg','estado_registro','ids_comprobantes','id_depreciacion_comprobante','desc_presto','desc_depto','id_presupuesto','desc_depto_aux'	
		
		]),

		remoteSort: true // metodo de ordenacion remoto
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Id Grupo Depreciacion','   '+maestro.id_grupo_depreciacion+'   '],['Departamento','   '+maestro.desc_depto]];
	

	//DATA STORE COMBOS

	/////DATA STORE COMBOS////////////
	
	//FUNCIONES RENDER
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
	function render_deposito(value, p, record){return String.format('{0}', record.data['nombre_deposito']);}


	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});

	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuestoDepto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','desc_presupuesto','tipo_pres','estado_pres','id_fuente_financiamiento','nombre_fuente_financiamiento',
																										'id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','nombre_financiador', 
																										'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad','id_parametro','gestion_pres',
																										'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																										'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])});
		

	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');

	function render_id_depto_aux(value, p, record){return String.format('{0}', record.data['desc_depto_aux']);}


	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presto']+ '</span>';}else {return record.data['desc_presto'];}}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
			'<b><i>{nombre_unidad}</i></b>',
			'<br><b>Gesti�n: </b> <FONT COLOR="#0000ff">{gestion_pres} </FONT> ',
			'<br>   Tipo Presupuesto: </b> <FONT COLOR="#B50000">{tipo_pres} </FONT> ',
			'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#0000ff">{nombre_fuente_financiamiento}</FONT>',		
			'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#0000ff">{desc_epe}</FONT></b>',
			'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
			'<br>  <FONT COLOR="#0000ff">{nombre_regional}</FONT>',
			'<br>  <FONT COLOR="#0000ff">{nombre_programa}</FONT>',
			'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
			'<br>  <FONT COLOR="#0000ff">{nombre_actividad}</FONT>',
			'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
			'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
			'</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////

	//en la posición 0 siempre esta la llave primaria

		// id_activo_fijo_empleado
	 Atributos[0] = {
				validacion:{ 
					labelSeparator:'',
					name: 'id_depreciacion_cbte_regional',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false,
					width_grid:80 
		
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'h_id_depreciacion_cbte_regional'
			};
			
			
		    Atributos[1] = {
		    		validacion:{
		    			fieldLabel: 'Regional',
		    			name: 'codigo_regional', 
		    			width_grid:120,
		    			align:'center',
		    			grid_visible:true, // se muestra en el grid
		    			grid_editable:false,
		    			width:80,
		    			disabled:true

		    		},
		    		tipo: 'TextField',
		    		form:true,
		    		save_as:'txt_cod_regional'
		    	};
	    	
			// nombre_deposito
			Atributos[2] = {
				validacion:{
					fieldLabel: 'Estado',
					name: 'estado_registro',
					width_grid:90,
					grid_visible:true, // se muestra en el grid
					grid_editable:false
		
				},
				tipo: 'TextField',
				form:false,
				filtro_0:true
			};
			Atributos[3]={
					validacion:{
						name:'id_depto',
						fieldLabel:'Departamento Contable',
						allowBlank:true,
						emptyText:'Departamento...',
						desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
						store:ds_depto,
						valueField: 'id_depto',
						displayField: 'nombre_depto',
						queryParam: 'filterValue_0',
						filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
						typeAhead:false,
						tpl:tpl_id_depto,
						forceSelection:true,
						mode:'remote',
						queryDelay:250,
						pageSize:100,
						minListWidth:'80%',
						//	onSelect:function(record){},
						grow:true,
						resizable:true,
						queryParam:'filterValue_0',
						minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
						triggerAction:'all',
						editable:true,
						renderer:render_id_depto,
						grid_visible:true,
						grid_editable:false,
						width_grid:350,
						width:260,
						disabled:false
					},
					tipo:'ComboBox',
					form: true,
					filterColValue:'dep.nombre_depto#dep.codigo_depto',
					save_as:'h_id_depto'
				};

			Atributos[4]={
					validacion:{
						name:'id_presupuesto',
						fieldLabel:'Presupuesto',
						allowBlank:false,			
						emptyText:'Presupuesto...',
						desc: 'desc_presto', //indica la columna del store principal ds del que proviane la descripcion
						store:ds_presupuesto,
						valueField: 'id_presupuesto',
						displayField: 'desc_presupuesto',
						queryParam: 'filterValue_0',
						filterCol:'PRESUP.desc_presupuesto#PRESUP.desc_epe#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
						typeAhead:false,
						tpl:tpl_id_presupuesto,
						forceSelection:false,
						mode:'remote',
						queryDelay:250,
						pageSize:100,
						minListWidth:'100%',
						grow:true,
						resizable:true,
						queryParam:'filterValue_0',
						minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
						triggerAction:'all',
						editable:true,
						renderer:render_id_presupuesto,
						grid_visible:false,
						grid_editable:false,
						width_grid:250,
						width:290,
						disabled:false		
					},
					tipo:'ComboBox',
					form: false,
					save_as:'h_id_presupuesto',
					filterColValue:'pre.sigla#pre.desc_presupuesto'
				};
			 Atributos[5] = {
						validacion:{
							fieldLabel: 'Id Comprobante',
							name: 'ids_comprobantes',
							width_grid:100,
							grid_visible:true, // se muestra en el grid
							grid_editable:false,
							grid_indice:1
				
						},
						tipo: 'TextField',
						form:false,
						filtro_0:false
					};
			 Atributos[6] = {
						validacion:{
							labelSeparator:'',
							name: 'ayuda_editar',
							inputType:'hidden'
						},
						tipo: 'Field',
						filtro_0:false,
						save_as:'txt_edit'
						
					};
				Atributos[7]={
						validacion:{
							name:'id_depto_aux',
							fieldLabel:'Departamento Contable Auxiliar',
							allowBlank:true,
							emptyText:'Departamento Contable Auxiliar...',
							desc: 'desc_depto_aux', //indica la columna del store principal ds del que proviane la descripcion
							store:ds_depto,
							valueField: 'id_depto',
							displayField: 'nombre_depto',
							queryParam: 'filterValue_0',
							filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
							typeAhead:false,
							tpl:tpl_id_depto,
							forceSelection:true,
							mode:'remote',
							queryDelay:250,
							pageSize:100,
							minListWidth:'80%',
							//	onSelect:function(record){},
							grow:true,
							resizable:true,
							queryParam:'filterValue_0',
							minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
							triggerAction:'all',
							editable:true,
							renderer:render_id_depto_aux,
							grid_visible:true,
							grid_editable:false,
							width_grid:350,
							width:260,
							disabled:false
						},
						tipo:'ComboBox',
						form: true,
						filterColValue:'dep.nombre_depto#dep.codigo_depto',
						save_as:'h_id_depto_aux'
					};
		

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros Generales',titulo_detalle:'Regionales',grid_maestro:'grid-'+idContenedor};
	var layout = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout.init(config);


	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_grid=this.getGrid;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var cm_Save = this.Save;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	
	var paramMenu={
		editar:{crear:true,separador:false},	
		actualizar:{crear:true,separador:false}
	};
		
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
		btnEliminar:{
			url:direccion+"../../../control/activo_fijo_empleado/ActionEliminaActivoFijoEmpleado.php"
		},
		Save:{
			//url:direccion+"../../../control/activo_fijo_comprobante/ActionRegistrarComprobantesContables.php",
			url: obtenerDireccion,timeout:100000000
		},
		ConfirmSave:{
			url:direccion+"../../../control/activo_fijo_comprobante/ActionGuardarDepreciacionCbteRegional.php"
		},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
			width:'30%',minWidth:'30%',
			height:300,
			minHeight:200,
			closable:true,
			columnas:[400],
			grupos:[
			{
				tituloGrupo:'Datos generales',
				columna:0,
				id_grupo:0
			}]
		}};

	//-------------- Sobrecarga de funciones --------------------//

	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));

		maestro.id_grupo_depreciacion=datos.maestro_id_grupo_depreciacion;
		maestro.desc_depto=datos.maestro_desc_depto;
		maestro.mes_fin=datos.maestro_mes_fin;
		maestro.ano_fin=datos.maestro_ano_fin;
		

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_grupo_depreciacion: maestro.id_grupo_depreciacion,
				txt_mes_fin : maestro.mes_fin,
				txt_ano_fin : maestro.ano_fin,
				maestro_codigo_regional: maestro.codigo_regional
			}
		};
		this.btnActualizar();
		data_maestro=[['Id Grupo Depreciacion','   '+maestro.id_grupo_depreciacion+'   '],['Departamento','   '+maestro.desc_depto]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.codigo_regional;
		
		this.InitFunciones(paramFunciones);
	};

	this.btnEdit=function()
	{
		var sm=getSelectionModel();
		
		if(getSelectionModel().getCount()>0)
		{
			ClaseMadre_getComponente('ayuda_editar').setValue('si');
		} 
		else
		{
			Ext.MessageBox.alert('Estado','Seleccione un Item primero.');
		}
		CM_btnEdit();
	};
	
	function btn_generar()
	{
		var sm=getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
		
			
			var id_grupo_depreciacion = maestro.id_grupo_depreciacion;
			var fecha_hasta = maestro.mes_fin+"/01/"+maestro.ano_fin;
			var codigo_regional =  SelectionsRecord.data.codigo_regional;
		
			TodasRegionales = false;
			
			if(SelectionsRecord.data.estado_registro == 'pendiente')
			{
				ClaseMadre_getComponente('ayuda_editar').setValue('no');
				cm_Save();
			}				
			else
				Ext.MessageBox.alert('Estado','La regional seleccionada ya tiene comprobantes registrados !!!');
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
			
	}
	
	function btn_respaldo()        
	{
		var sm=getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var id_grupo_depreciacion = maestro.id_grupo_depreciacion;
			var fecha_hasta = maestro.mes_fin+"/01/"+maestro.ano_fin;
			var codigo_regional =  SelectionsRecord.data.codigo_regional;
			
			var data="txt_mes_fin="+maestro.mes_fin;
			data = data + "&txt_ano_fin="+maestro.ano_fin;
			data = data + "&txt_desc_depto="+maestro.desc_depto;
			data = data + "&txt_desc_usuario="+maestro.desc_usuario;
			data = data + "&txt_fecha_reg="+maestro.fecha_reg;
			data = data + "&txt_proyecto="+maestro.proyecto;
			
			if(SelectionsRecord.data.estado_registro == 'pendiente')
				//desaparecer el boton
				//CM_getBoton('respaldo-'+idContenedor).disable(); 
				Ext.MessageBox.alert('Estado','Se debe Generar comprobantes del proceso de depreciacion antes de tener el respaldo');
			else 
			{
				if(SelectionsRecord.data.estado_registro == 'registrado')
					{
						window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionPDFRespaldoDepreciacion.php?id_grupo_depreciacion='+id_grupo_depreciacion+"&fecha_hasta="+fecha_hasta+"&codigo_regional="+codigo_regional+"&"+data);
					}
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro');
		}
	}
	
	function obtenerDireccion(){
		
		//Ext.MessageBox.alert('Estado','Se genero correctamente' );
		
		var sm=getSelectionModel();
		var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
		
		var id_grupo_dep = maestro.id_grupo_depreciacion;
		var fecha_h = maestro.mes_fin+"/01/"+maestro.ano_fin;
		
		var codigo_r = '%';
		if(!TodasRegionales)
			codigo_r =  SelectionsRecord.data.codigo_regional;
		
		var resp = direccion+"../../../control/activo_fijo_comprobante/ActionRegistrarComprobantesContables.php?id_grupo_depreciacion="+id_grupo_dep+"&fecha_hasta="+fecha_h+"&codigo_regional="+codigo_r;
		
		return resp;
	}
	
	
	
	function btn_generar_todo()
	{
		var sm=getSelectionModel();
		TodasRegionales = true;
		cm_Save();
		
		//Ext.MessageBox.alert('Estado',ds.getCount());
			
	}

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');		
	}
	
	function get_fecha_bd()
	{
				
		Ext.Ajax.request({
					url:'../../../lib/lib_control/action/ActionObtenerFechaBD.php',
					method:'POST',
					success:cargar_fecha_bd,
					failure:ClaseMadre_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				});
	}

	//Carga la fecha obtenida
	function cargar_fecha_bd(resp)
	{
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()=="")
			{
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}
	
	this.btnNew = function()
	{
		ClaseMadre_btnNew();
		get_fecha_bd();
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	var CM_getBoton=this.getBoton;
	this.AdicionarBoton("../../../lib/imagenes/bricks.png",'<b>Generar<b>',btn_generar,true,'generar','Generar');
	this.AdicionarBoton("../../../lib/imagenes/print.gif",'<b>Respaldo<b>',btn_respaldo,true,'respaldo','Respaldo'); 
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_grupo_depreciacion: maestro.id_grupo_depreciacion,
			txt_mes_fin : maestro.mes_fin,
			txt_ano_fin : maestro.ano_fin
		}
	});


	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	layout.getVentana(idContenedor).on('resize',function(){layout.getLayout().layout()})
			
	
}

