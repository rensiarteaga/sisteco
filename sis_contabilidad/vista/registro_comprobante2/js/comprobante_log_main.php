<?php
/**
 * Nombre:		  	    comprobante_log_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		28/04/2010
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
		id_comprobante:<?php if($id_comprobante=='') {echo '0';} else {echo $id_comprobante;}?>
	};
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new pagina_comprobante_log(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_comprobante_log.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		28/04/2010
*/
function pagina_comprobante_log(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var var_id_comprobante;
	//var maestro=pmaestro;

	/////////////////
	//  DATA STORE //
	/////////////////
	// DEFINICIÓN DATOS DEL MAESTRO
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarComprobanteLog.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_comprobante_log',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_comprobante_log',
			'id_comprobante',
			'id_parametro',
			'desc_parametro',
			'nro_cbte',
			'momento_cbte',
			{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
			'concepto_cbte',
			'glosa_cbte',
			'acreedor',
			'aprobacion',
			'conformidad',
			'pedido',
			'id_periodo_subsis',
			'desc_periodo',
			'id_usuario',
			'desc_usuario', 
			'id_subsistema',
			'desc_subsistema',
			'id_cbte_clase',
			'desc_clase',
			'id_moneda',
			'desc_moneda',
			'id_gestion',
			'nombre_depto',
			'id_depto',
			'titulo_cbte',
			{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
			{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},
			'id_moneda_cbte',
			'tipo_cambio',
			'nombre_moneda_cbte',
			'prioridad_moneda_cbte',
			'estado_cbte'
		]),remoteSort:true
	});
	
	//DATA STORE COMBOS
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	//FUNCIONES RENDER
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']+' - '+record.data['desc_periodo']);}
	function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
	function render_id_cbte_clase(value, p, record){return String.format('{0}', record.data['desc_clase']);}
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda_cbte']);}
	function render_id_tipo_cambioOCV(value, p, record){
		rf = ds_tipo_cambioOCV.getById(value);	 
		if(rf!=null){record.data['id_tipo_cambio'] =rf.data['id_tipo_cambio'];record.data['desc_tc'] =rf.data['tipo_cambio'];}
		return String.format('{0}',record.data['desc_tc'])
	}
	
	function render_momento(value, p, record){
		if(value==0){return 'Contable';}
		if(value==1){return 'Devengado';}
		if(value==4){return 'Pagado o Percibido';}
		if(value==5){return 'Reversión Devengado';}
		if(value==6){return 'Reversión Pagado o Percibido';	}
		if(value==7){return 'Ajustar Devengado';	}
		if(value==8){return 'Ajustar Pagado o Percibido';	}
	}

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_devengado_detalle
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante_log',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		form:false,
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			fieldLabel:'Identificador',
			name: 'id_comprobante',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:1
		},
		tipo:'Field',
		form:true,
		filtro_0:true,
		filterColValue:'COMPRO.id_comprobante'
	};
	// txt id_parametro
	Atributos[2]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:3
		},
		tipo:'Field',
		form: false
	};
	
	Atributos[3]={
		validacion:{
			name:'id_periodo_subsis',
			fieldLabel:'Periodo Subsistema',
			renderer:render_id_periodo_subsistema,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:4		
		},
		tipo:'Field',
		form: false
	};

	// txt fecha_cbte
	Atributos[4]= {
		validacion:{
			name:'fecha_cbte',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85	
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'COMPRO.fecha_cbte',
		dateFormat:'m-d-Y'
	};
	
	// txt nro_cbte
	Atributos[5]={
		validacion:{
			name: 'nro_cbte',
			fieldLabel:'Número',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:2
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'COMPRO.nro_cbte'
	};
	
	// txt id_subsistema
	Atributos[6]={
		validacion:{
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			renderer:render_id_subsistema,
			grid_visible:false,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		form:false,
		filtro_0:true,
		filterColValue:'SUBSIS.codigo'
	};

 // txt id_documento_nro
	Atributos[7]={
			validacion:{
			name:'id_cbte_clase',
			fieldLabel:'Comprobante de',
			renderer:render_id_cbte_clase,
			grid_visible:true,
			grid_editable:false,
			width_grid:150	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'CBCLAS.desc_clase'
	};
	
	Atributos[8]={
		validacion:{
			name:'momento_cbte',
			fieldLabel:'Momento',
			grid_visible:true,
			grid_editable:false,
			renderer:render_momento,
			width_grid:200
		},
		tipo:'Field',
		form:false
	};

	//txt acreedor
	Atributos[9]={
		validacion:{
			name:'acreedor',
			fieldLabel:'Acreedor',
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'COMPRO.acreedor'
	};
	
	//txt aprobacion
	Atributos[10]={
		validacion:{
			name:'aprobacion',  
			fieldLabel:'Aprobación',
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo: 'Field',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'COMPRO.aprobacion',
		save_as:'aprobacion'
	};
// txt conformidad
	Atributos[11]={
		validacion:{
			name:'conformidad', 
			fieldLabel:'Conformidad',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'COMPRO.conformidad'
	};
	
	// txt pedido
	Atributos[12]={
		validacion:{
			name:'pedido',	
			fieldLabel:'Pedido',
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'COMPRO.pedido'
	};
	
	// txt concepto_cbte
	Atributos[13]={
		validacion:{
			name:'concepto_cbte',
			fieldLabel:'Concepto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'COMPRO.concepto_cbte'
	};
	
	// txt glosa_cbte
	Atributos[14]={
		validacion:{
			name:'glosa_cbte',
			fieldLabel:'Observación',
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'COMPRO.glosa_cbte'
	};

	//id_depto
	Atributos[15]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento Contable',
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			grid_indice:4
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'dep.nombre_depto'
	};
		
	Atributos[16]={
		validacion:{
			name:'desc_usuario',
			fieldLabel:'Usuario',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo: 'Field'
	};	
	
	Atributos[17]={
		validacion:{
			name:'id_moneda_cbte',
			fieldLabel:'Moneda',
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150		
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'monedacbte.nombre'
	};
	Atributos[18]={
		validacion:{
			name:'id_tipo_cambio',
			fieldLabel:'T/C Origen',
			renderer:render_id_tipo_cambioOCV,
			grid_visible:false,
			grid_editable:true,
			width_grid:150		
		},
		tipo:'Field',
		form: false,
		filtro_0:false	
	};
	
	Atributos[19]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Tipo Cambio',
			grid_visible:true,
			grid_editable:false,
			//renderer:render_moneda_16,
			width_grid:100	
		},
		tipo: 'Field',
		form: false,
		filtro_0:false
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:' (Maestro)',titulo_detalle:'Tran-Log',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/registro_comprobante2/comprobante_logdet.php?idSub='+decodeURI('Transacción Log')+'&'};
	var layout = new DocsLayoutMaestroDeatalle(idContenedor );
	layout.init(config);
	//var layout = new DocsLayoutDetalle(idContenedor);
	//layout.init({titulo_maestro:'Registro de Pagos',titulo_detalle:'Prorrateo del Gasto',grid_maestro:'grid-'+idContenedor});

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);

	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit =this.btnEdit;
	var ClaseMadre_Eliminar =this.btnEliminar;

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
	
	//DEFINICIÓN DE FUNCIONES
	/*var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/devengado_detalle/ActionEliminarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Save:{url:direccion+'../../../control/devengado_detalle/ActionGuardarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		ConfirmSave:{url:direccion+'../../../control/devengado_detalle/ActionAprobarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0}],width:'60%',minWidth:150,minHeight:200,	closable:true,titulo:'Devengado Detalle'}
	};*/
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../../sis_contabilidad/control/actualizacion/ActionEliminarActualizacion.php'},
		Save:{url:direccion+'../../../../sis_contabilidad/control/actualizacion/ActionGuardarActualizacion.php'},
		ConfirmSave:{url:direccion+'../../../../sis_contabilidad/control/actualizacion/ActionGuardarActualizacion.php' },
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Registro de actualizaciones',	
		grupos:[{
				tituloGrupo:'Datos de Actualización',
				columna:0,
				id_grupo:0}]
	}};

	//-------------- Sobrecarga de funciones --------------------//	
	this.reload=function(params){
		maestro=Ext.urlDecode(decodeURIComponent(params));
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_comprobante:maestro.id_comprobante
			}
		};

		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		ClaseMadre_btnActualizar();
		getComponente('id_comprobante').setValue(maestro.id_comprobante);
	};

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		var_id_comprobante=ClaseMadre_getComponente('id_comprobante');
	}
	
	this.EnableSelect=function(sm,row,rec){
		
		_CP.getPagina(layout.getIdContentHijo()).pagina.reload(rec.data);
		//cm_EnableSelect(sm,row,rec);
	}
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	this.getLayout=function(){return layout.getLayout()};
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_comprobante:maestro.id_comprobante
		}
	});
}