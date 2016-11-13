/**
* Nombre:				activo_fijo_comprobantes.js  	  
* Propósito: 			pagina objeto principal		
* Autor:				Elmer Velasquez	
* Fecha creación:		01/02/2013
*/
function pagina_activo_fijo_comprobantes(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var maestro;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds =  new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_comprobantes/ActionListarActivoFijoComprobante.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id:'id_activo_fijo_comprobante',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_activo_fijo_comprobante',
		'id_grupo_proceso',
		'id_comprobante',
		'id_depto_contable',
		'desc_cuenta',
		'monto',
		'depreciacion_acumulada',
		'estado',
		'tipo_comprobante','monto_actual',
		'id_tipo_activo_cuenta','id_contra_cuenta',
		'depto_contable' 
		]),
		remoteSort: true // metodo de ordenacion remoto
	});
	
	// DEFINICIÓN  DE DATOS DEL MAESTRO

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Proceso   ',maestro.id_grupo_proceso+'										'],['',''],['Descripción Proceso   ',maestro.proceso]];

	/////////////////////////
	// Definición de datos //
	/////////////////////////


	Atributos[0] = {
		validacion:{
			labelSeparator:'',
			name: 'id_activo_fijo_comprobante',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false
	};

	/////////// txt codigo//////
	Atributos[1] = {
			validacion:{
				labelSeparator:'',
				name: 'id_grupo_proceso',
				inputType:'hidden',
				grid_visible:false, // visible en el grid
				grid_editable:false,

			},
			tipo: 'Field',
			filtro_0:false
		};
	Atributos[2] = {
			validacion:{
				fieldLabel: 'Cuenta',
				name: 'desc_cuenta',
				width_grid:250,
				grid_visible:true, // visible en el grid
				grid_editable:false,
				grid_indice:2

			},
			tipo: 'TextField',
			filterColValue:'cta.nro_cuenta#cta.nombre_cuenta', 
			form:false,
			filtro_0:true,
			id_grupo:0
	
		};
	Atributos[3] = {
			validacion:{
			fieldLabel: 'Monto',
			name: 'monto',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			vtype:"texto", 
			width:200,
			grid_visible:true, // visible en el grid
			grid_editable:false, //editable en el grid,
			width_grid:115, // ancho de columna en el grid
			grid_indice:4

		},
		tipo: 'NumberField',
		filtro_0:false,
		form:false,  
		id_grupo:0
		
	};
	Atributos[4] = {
			validacion:{
				fieldLabel: 'Estado',
				name: 'estado',
				width_grid:110,
				grid_visible:true, // visible en el grid
				grid_editable:false,
				grid_indice:7

			},
			tipo: 'TextField',
			filterColValue:'tac.estado',
			form:false,
			filtro_0:true,
			id_grupo:0 
		};
	Atributos[5] = {
			validacion:{
			fieldLabel: 'Dpto. Contable',
			name: 'depto_contable',
			width_grid:250,
			grid_visible:true, // visible en el grid
			grid_editable:false,
			grid_indice:8

		},
		tipo: 'TextField',
		form:false,
		filtro_0:false,
		id_grupo:0
	};
	Atributos[6] = {
			validacion:{
				labelSeparator:'',
				fieldLabel: 'Id Comprobante',
				name: 'id_comprobante',
				width_grid:90,
				grid_visible:true, // visible en el grid
				grid_editable:false,
				grid_indice:1

			},
			tipo: 'Field',
			filterColValue:'tac.id_comprobante',
			filtro_0:true
		};
	Atributos[7] = {
			validacion:{
			fieldLabel: 'Monto DepAcum.',
			name: 'depreciacion_acumulada',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			vtype:"texto", 
			width:200,
			grid_visible:true, //visible en el grid
			grid_editable:false, //editable en el grid,
			width_grid:115, // ancho de columna en el grid
			grid_indice:5
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:false,  
		id_grupo:0
	};
	Atributos[8] = {
			validacion:{
			fieldLabel: 'Monto Actual.',
			name: 'monto_actual',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			vtype:"texto", 
			width:200,
			grid_visible:true, //visible en el grid
			grid_editable:false, //editable en el grid,
			width_grid:115, // ancho de columna en el grid
			grid_indice:6

		},
		tipo: 'NumberField',
		filtro_0:false,
		form:false,  
		id_grupo:0
	};
	
	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:"Detalle Proceso (Maestro)",
				titulo_detalle:"Cuentas Asociadas,segun TIPO-EP del AF (Detalle)",
				grid_maestro:'grid-'+idContenedor};
	var layout_generacion_cbtes = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_generacion_cbtes.init(config);



	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_generacion_cbtes,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_btnEdit=this.btnEdit;
	var CM_getComponente=this.getComponente;
	var CM_enableSelect=this.EnableSelect;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_success=this.success;
	
  
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu = {
			actualizar:{
				crear :true,
				separador:false
			}
		};
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/activo_fijo_comprobantes/ActionEliminarActivoFijoComprobante.php'},
			Formulario:{
						html_apply:'dlgInfo-'+idContenedor,height:370,width:'60%',minWidth:150,minHeight:100,closable:true,titulo:'Proceso Activos Fijos',
						columnas:['45%'],
						grupos:[{	tituloGrupo:'Presupuesto',columna:0,id_grupo:0}]	
				}
			};
	
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
		
	}

	//-------------- Sobrecarga de funciones --------------------//
	this.btnEdit=function(){
		var sm=getSelectionModel();
		if(getSelectionModel().getCount()>0){
			var SelectionsRecord=sm.getSelected();
			var dpto=SelectionsRecord.data.id_depto_contable;
			var id_param=SelectionsRecord.data.id_parametro;
			var id_grupo_proceso=SelectionsRecord.data.id_grupo_proceso;
			CM_btnEdit();
		} else{
			Ext.MessageBox.alert('Estado','Seleccione un Item primero..');
		}
	};

		this.reload=function(params)
		{
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_grupo_proceso=datos.maestro_id_grupo_proceso;
			maestro.proceso=datos.maestro_proceso;
			
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_grupo_proceso:maestro.id_grupo_proceso
				}
			};
			this.btnActualizar();
			data_maestro=[['Proceso',maestro.id_grupo_proceso+'										'],['',''],['Descripción Proceso',maestro.proceso]];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
			
			this.InitFunciones(paramFunciones);
		}
		function esteSuccess(resp){
			Ext.MessageBox.hide();
					if(resp.responseXML&&resp.responseXML.documentElement){
											
						ClaseMadre_btnActualizar();
					}  
					else{
						ClaseMadre_conexionFailure();
					}
		} 
		//funcion que detalla la asociacion de af segun TIPO y EP
		function btn_reporte_asociacion_af()
		{
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();	
				
				if(NumSelect!=0)
				{	
					var data="id_grupo_proceso=" + SelectionsRecord.data.id_grupo_proceso;	
					//window.open(direccion+'../../../control/asociacion_tipo_ep/reporte/ActionPDFDetalleAsociacionTipoEP.php?'+data);	
					window.open(direccion+'../../../control/activo_fijo_comprobantes/reporte/ActionPDFDetalleAsociacionTipoEP.php?'+data);
				}
				else
				{
					Ext.MessageBox.alert('Alerta','Debe seleccionar una registro.')
			    }
		}
		//funcion del boton q permitira generar comprobantes de alta
		function btnComprobantes()
		{ 
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();
			if(NumSelect==1)
			{
				if(SelectionsRecord.data.tipo_comprobante=='ALTA')
				{	
					if(SelectionsRecord.data.estado=='Pendiente')
					{	
						if(confirm('¿Esta Seguro de Generar los Comprobantes?'))
						{
							Ext.MessageBox.show({
								title: 'Generando Comprobantes...',
								msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando Comrpobantes...</div>",
								width:300,
								height:200,
								closable:false 
							});
							Ext.Ajax.request({
							url:direccion+"../../../control/activo_fijo_comprobantes/generacion_comprobantes/ActionGenerarComprobantesAlta.php",																									
							method:'POST',
							params:{cantidad_ids:'1',id_grupo_proceso:SelectionsRecord.data.id_grupo_proceso},
							success:esteSuccess,
							failure:ClaseMadre_conexionFailure,
							timeout:100000000});
						} 
					}
					else
					{
						Ext.MessageBox.alert('Estado','El grupo proceso ya tiene comprobantes registrados!!!');
					}
				}
				else
				{
					Ext.MessageBox.alert('ERROR', 'No puede generar comprobantes de ALTA desde un proceso de BAJA');
					  
				}
			}
			else
			{
				Ext.MessageBox.alert('Atencion', 'Antes debe seleccionar un registro.');
			}
		}
		function btnComprobantesBaja()
		{
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();
			if(NumSelect==1)
			{
				if(SelectionsRecord.data.tipo_comprobante=='BAJA')
				{
					if(SelectionsRecord.data.estado=='Pendiente')
					{
						var confirmacion='¿Esta Seguro de Generar los Comprobantes de Baja del grupo Proceso: '+SelectionsRecord.data.id_grupo_proceso+' ?'
						if(confirm(confirmacion))
						{
							Ext.MessageBox.show({
								title: 'Generando Comprobantes...',
								msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando Comrpobantes de Baja...</div>",
								width:300,
								height:200,
								closable:false
							});
							Ext.Ajax.request({
							url:direccion+"../../../control/activo_fijo_comprobantes/generacion_comprobantes/ActionGenerarComprobantesBaja.php",
							method:'POST',
							params:{cantidad_ids:'1',id_grupo_proceso:SelectionsRecord.data.id_grupo_proceso},
							success:esteSuccess,
							failure:ClaseMadre_conexionFailure,
							timeout:100000000});
						}
					}
					else
					{
						Ext.MessageBox.alert('Estado','El grupo proceso ya tiene comprobantes registrados!!!');
					}
				}
			}
			else
			{
				Ext.MessageBox.alert('Atencion', 'Antes debe seleccionar un registro.');
			}
		}
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
			}

		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_generacion_cbtes.getLayout()};
		//para el manejo de hijos
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		var CM_getBoton=this.getBoton;
		this.InitFunciones(paramFunciones);
		//para agregar botones
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Generar Comprobantes Alta',btnComprobantes,true,'genComprobantes','Generar Comprobantes Alta');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Generar Comprobantes Baja',btnComprobantesBaja,true,'genComprobantesBaja','Generar Comprobantes Baja');
		this.AdicionarBoton("../../../lib/imagenes/print.gif",'Detalle Asociacion',btn_reporte_asociacion_af,true, 'reporAsocAF','Detalle Asociacion');
		
		function enable(sm,row,rec)
		{
			CM_enableSelect(sm,row,rec);
			var aux=new String(rec.data['tipo_comprobante']);
			//window.alert(aux);
			//window.alert(aux.substring(0,4));
			if(aux.substring(0,4)=='ALTA')
			{
				
				CM_getBoton('genComprobantesBaja-'+idContenedor).hide();
				CM_getBoton('genComprobantes-'+idContenedor).setVisible(true);
			}
			else
			{
				if(aux.substring(0,4)=='BAJA')
				{
					CM_getBoton('genComprobantes-'+idContenedor).hide();
					CM_getBoton('genComprobantesBaja-'+idContenedor).setVisible(true);
				}
			}
		
		}
		
		
		
		this.iniciaFormulario();
		
		
		iniciarEventosFormularios();
		layout_generacion_cbtes.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_grupo_proceso:maestro.id_grupo_proceso
			}
		});

}