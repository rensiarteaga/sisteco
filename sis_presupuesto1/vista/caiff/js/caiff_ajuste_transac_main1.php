<?php
/**
 * Nombre:		  	    caif_ajuste_transac_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:42
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	    echo "var idSub='$idSub';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
//var maestro={id_comprobante:<?php echo $id_comprobante;?>};

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new pagina_caif_ajuste_transac(idContenedor,direccion,paramConfig,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);

//var elemento={idContenedor:idContenedor,pagina:new pagina_caif_ajuste_transac(idContenedor,direccion,paramConfig,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
//ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_caif_ajuste_transac.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:43
 */
function pagina_caif_ajuste_transac(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array;
	var ds;
	var elementos=new Array();  
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var Trasaccion = Ext.data.Record.create([		
		                                 		'id_transaccion',
		                                 		'id_comprobante','desc_comprobante',
		                                 		'id_partida_cuenta','desc_partida_cuenta',
		                                 		'id_cuenta', 'desc_cuenta',
		                                 		'id_partida','desc_partida',
		                                 	 	'id_auxiliar','desc_auxiliar',
		                                 		'id_orden_trabajo','desc_orden_trabajo',
		                                 		'id_oec','nombre_oec',
		                                 		'concepto_tran',
		                                 		'id_moneda','desc_moneda',
		                                 		'importe_debe','importe_haber',
		                                 		'importe_gasto','importe_recurso',
		                                 		'id_presupuesto','desc_presupuesto',
		                                 		'tipo_pres',
		                                 		'sw_aux',
		                                 		'sw_oec',
		                                 		'sw_deha',
		                                 		'id_moneda',
		                                 		'id_nombre',
		                                 		'sw_rega',
		                                 		'disponibilidad'
		                                 		]); 
		                                  
		                                 	//---DATA STORE
		                                 	var ds = new Ext.data.Store({
		                                 		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarGestionarRegistroTransacion.php'}),
		                                 		reader: new Ext.data.XmlReader({
		                                 		record: 'ROWS',id:'id_transaccion',totalRecords:'TotalCount'
		                                 		},Trasaccion),remoteSort:true});
	

	//carga datos XML
		                                 /*	function render_id_comprobante(value, p, record){return String.format('{0}', record.data['desc_comprobante']);}
		                                	function render_id_orden_trabajo(value, p, record){return String.format('{0}',record.data['desc_orden_trabajo'])}
		                                	function render_id_auxiliar(value, p, record){return String.format('{0}',record.data['desc_auxiliar'])}
		                                	function render_id_oec(value, p, record){return String.format('{0}', record.data['nombre_oec']);}
		                                	function render_id_moneda(value, p, record){return String.format('{0}',record.data['desc_moneda'])}
		                                	function render_moneda_16(value,cell,record,row,colum,store){
		                                	 	if(record.data['disponibilidad'] == 1){
		                                		return  '<span style="color:blue;">' +var_importe_haber.formatMoneda(value)+'</span>'}	
		                                		if(record.data['disponibilidad'] == 0){return '<span style="color:red;">' +var_importe_haber.formatMoneda(value)+'</span>'}
		                                 	}
		                                   function render_moneda_17(value,cell,record,row,colum,store){
		                                	 	if(record.data['disponibilidad'] == 1){
		                                		return  '<span style="color:blue;">' +var_importe_haber.formatMoneda(value)+'</span>'}	
		                                		if(record.data['disponibilidad'] == 0){return '<span style="color:red;">' +var_importe_haber.formatMoneda(value)+'</span>'}
		                                 	}
		                                	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		                                	function render_id_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
	
	*/// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Cbte',maestro.id_siet_cbte]]}),cm:cmMaestro});
	gridMaestro.render();
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	Atributos[0]={
			validacion:{labelSeparator:'',
				name: 'id_transaccion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			id_grupo:0,
			save_as:'id_transaccion'
		};
		
		/*Atributos[1]={
			validacion:{
				name:'id_comprobante',
				fieldLabel:'Comprobante',
				allowBlank:false,emptyText:'Comprobante...',
				desc: 'desc_comprobante',store:ds_comprobante,
				valueField: 'id_comprobante',
				displayField: '',
				queryParam: 'filterValue_0',
				filterCol:'id_comprobante',
				typeAhead:false,
				tpl:tpl_id_comprobante,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_comprobante,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			id_grupo:0,		
			filterColValue:'id_comprobante',
			save_as:'id_comprobante'
		};*/
		// txt id_presupuesto
		Atributos[1]={
			validacion:{
				name:'id_presupuesto',
				fieldLabel:'Presupuesto',
				allowBlank:false,			
				emptyText:'Presupuesto...',
				desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_presupuesto,
				valueField: 'id_presupuesto',
				displayField: 'desc_presupuesto',
				queryParam: 'filterValue_0',
				filterCol:'PRESUP.desc_presupuesto#PRESUP.desc_epe#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
				typeAhead:false,
				//tpl:tpl_id_presupuesto,
				forceSelection:false,
				//mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_presupuesto,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:250,
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'desc_presupuesto'
			 
		};
		
	/*	Atributos[2]={
			validacion:{
				fieldLabel:'Partida - Cuenta',
				allowBlank:false,
				emptyText:'Partida Cuenta...',
				name:'id_partida_cuenta',
				desc:'desc_partida_cuenta',
				//store:ds_partida_cuenta,
				valueField:'id_partida_cuenta',
				displayField:'partida_cuenta',
				queryParam:'filterValue_0',
				filterCol:'nro_cuenta#nombre_cuenta#codigo_partida#nombre_partida#partida_cuenta',
				//tpl:tpl_id_partida_cuenta,
				typeAhead:false,
				forceSelection:false,
				//mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:400,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_id_partida_cuenta,
				grid_visible:true,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
		    id_grupo:2,
			form: true,
	 		filterColValue:'desc_partida_cuenta',
	  		save_as:'id_partida_cuenta'
		};

		// txt id_auxiliar
		Atributos[3]={
			validacion:{
				name:'id_auxiliar',
				fieldLabel:'Auxiliar',
				allowBlank:true,			
				emptyText:'Auxiliar...',
				desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_auxiliar,
				valueField: 'id_auxiliar',
				displayField: 'nombre_auxiliar',
				queryParam: 'filterValue_0',
				filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				typeAhead:false,
				//tpl:tpl_id_auxiliar,
				forceSelection:false,
				//mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_auxiliar,
				grid_visible:true,
				grid_editable:false,
				width_grid:200,
				width:'100%',
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			id_grupo:2,
			filterColValue:'desc_auxiliar',
			save_as:'id_auxiliar'
		};

	
		
	 	Atributos[4]= {
			validacion:{
				name:'concepto_tran',
				fieldLabel:'Glosa Transacción',
				allowBlank:true,
				maxLength:250,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:250,
				width:250
			},
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			id_grupo:4,
			filterColValue:'concepto_tran',
			save_as:'concepto_tran'
		};

		// txt total_general
		Atributos[5]={
			validacion:{
				name:'importe_debe',
				fieldLabel:'Importe Debe',
				allowBlank:true,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				allowMil:true,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				renderer:render_moneda_16,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			id_grupo:5,
			//defecto:'45,123,489.15',
			filtro_0:true,
			filterColValue:'importe_debe',
			save_as:'importe_debe'
		};
		
		Atributos[6]={
			validacion:{
				name:'importe_haber',
				fieldLabel:'Importe Haber',
				allowBlank:true,
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
				renderer:render_moneda_17,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			filtro_0:true,
			id_grupo:5,
			filterColValue:'importe_haber',
			save_as:'importe_haber'
		};
		
		Atributos[7]={
			validacion:{
				name:'importe_gasto',
				fieldLabel:'Importe gasto',
				allowBlank:true,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				renderer:render_moneda_17,
				grid_editable:false,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			filtro_0:true,
			id_grupo:5,
			filterColValue:'importe_gasto',
			save_as:'importe_gasto'
		};
		
		Atributos[8]={
			validacion:{
				name:'importe_recurso',
				fieldLabel:'Importe Recurso',
				allowBlank:true,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				renderer:render_moneda_17,
				grid_editable:false,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			filtro_0:true,
			id_grupo:5,
			filterColValue:'importe_recurso',
			save_as:'importe_recurso'
		};
		
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};
*/
	//---------- INICIAMOS LAYOUT DETALLE
	/* var config = {
	 			titulo_maestro:'Partidas',
	 			grid_maestro:'grid-'+idContenedor
	 		};

		var layout_caif_ajuste_transac = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_caif_ajuste_transac.init(config);
		*/
	var config={
		titulo_maestro:'Cbte (Maestro)',
		titulo_detalle:'Partidas(Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_caif_ajuste_transac = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_caif_ajuste_transac.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_caif_ajuste_transac,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//datos necesarios para el filtro
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
			Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
			ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte'+maestro.id_siet_cbte},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Partidas',
		
			grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}]
		}
	};
	/*this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_siet_cbte=datos.m_id_siet_cbte;
		maestro.id_siet_declara=datos.m_id_siet_declara;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_cbte:maestro.id_siet_cbte,
				m_id_siet_declara:maestro.id_siet_declara
				
			}
		};
		iniciarEventosFormularios();
	Atributos[1].defecto=maestro.id_siet_cbte;
	this.InitFunciones(paramFunciones)
	};*/
	/*this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_siet_cbte=datos.m_id_siet_cbte;
		maestro.id_siet_declara=datos.m_id_siet_declara;
	
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_cbte:maestro.id_siet_cbte,
				m_id_siet_declara:maestro.id_siet_declara
			}
		});
		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Cbte',maestro.id_siet_cbte]]);
		vectorAtributos[1].defecto=maestro.id_siet_cbte;
		var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
				Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
				ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte'+maestro.id_siet_cbte},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Partidas',
				
				grupos:[{
							tituloGrupo:'Datos',
							columna:0,
							id_grupo:1
						}]
				
				}};
		this.InitFunciones(paramFunciones)
	};
	*/
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	
		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	for(i=0;i<Atributos.length;i++)
		{
			
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
			
		}
		sm=getSelectionModel();
	}


	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_caif_ajuste_transac.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_caif_ajuste_transac.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}