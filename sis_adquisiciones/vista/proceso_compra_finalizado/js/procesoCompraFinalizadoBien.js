/**
* Nombre:		  	    
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-24 10:24:54
*/
function p_proceso_compra_mul_item_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	
	var Atributos=new Array,sw_grup=true,gridG,gSm,id_SCD,ds_g,gDlg;
	var maestro;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../../control/proceso_compra_det/ActionListarProcesoCompraMulIteDet.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proceso_compra_det',
			totalRecords: 'TotalCount'},[
			'id_proceso_compra_det',
			'id_proceso_compra',
			'cantidad',
			'precio_referencial_total',
			'estado_reg',
			'id_item',
			'id_unidad_medida_base',
			'codigo_item',
			'nombre_item',
			'nombre_id3',
			'nombre_id2',
			'nombre_id1',
			'nombre_subg',
			'nombre_grupo',
			'nombre_supg',
			'nombre_unid_base',
			'precio_total_moneda_seleccionada','descripcion'
			]),remoteSort:true});
	//DATA STORE COMBOS
		/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_
	//en la posición 0 siempre esta la llave primaria
Atributos[0]={
				validacion:{
					//fieldLabel: 'Id',
					labelSeparator:'',
					name: 'id_proceso_compra_det',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_proceso_compra_det'
			};
			Atributos[1]={
				validacion:{
					labelSeparator:'',
					name: 'id_item',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_proceso_compra_det'
			};
			// txt id_item
			Atributos[2]={
				validacion:{
					name:'codigo_item',
					fieldLabel:'Codigo Item',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
                    grid_indice:1
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'ITEM.codigo'
			};
			// txt id_item
			Atributos[3]={
				validacion:{
					name:'nombre_supg',
					fieldLabel:'Super Grupo',
					grid_visible:true,
					grid_editable:false,
					width_grid:120
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'SUPGRU.nombre'
			};
			Atributos[4]={
				validacion:{
					name:'nombre_grupo',
					fieldLabel:'Grupo',
					grid_visible:true,
					grid_editable:false,
					width_grid:120
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'G.nombre'
			};
			Atributos[5]={
				validacion:{
					name:'nombre_subg',
					fieldLabel:'Sub Grupo',
					grid_visible:true,
					grid_editable:false,
					width_grid:120
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'SUB.nombre'
			};
			Atributos[6]={
				validacion:{
					name:'nombre_id1',
					fieldLabel:'ID 1',
					grid_visible:true,
					grid_editable:false,
					width_grid:120
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'ID1.nombre'
			};
			Atributos[7]={
				validacion:{
					name:'nombre_id2',
					fieldLabel:'ID 2',
					grid_visible:true,
					grid_editable:false,
					width_grid:120

				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'ID2.nombre'
			};
			Atributos[8]={
				validacion:{
					name:'nombre_id3',
					fieldLabel:'ID 3',
					grid_visible:true,
					grid_editable:false,
					width_grid:120

				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'ID3.nombre'
			};
			// txt id_item
			Atributos[9]={
				validacion:{
					name:'nombre_item',
					fieldLabel:'Item',
					grid_visible:false,
					grid_editable:false,
					width_grid:120
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'ITEM.nombre'
			};
			// txt cantidad
			Atributos[10]={
				validacion:{
					name:'cantidad',
					fieldLabel:'Cantidad',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:4,
					align:'right'
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'PROCOMDET.cantidad'
			};
			Atributos[11]={
				validacion:{
					name:'nombre_unid_base',
					fieldLabel:'Unidad Medida',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:3
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'UMB.nombre'
			};
			// txt precio_referencial_total
			Atributos[12]={
				validacion:{
					name:'precio_referencial_total',
					fieldLabel:'Precio Ref. Total Bs.',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:5,
					decimalPrecision:2,//para numeros float
					align:'right'
				},
				tipo:'Field',
				form:true,
				filtro_0:true,
				filterColValue:'PROCOMDET.precio_referencial_total'
			};
			// txt estado_reg
			Atributos[14]={
				validacion:{
					name:'estado_reg',
					fieldLabel:'Estado',
					grid_visible:true,
					grid_editable:false,
					width_grid:100
				},
				tipo:'TextField',
				form: false,
				filtro_0:true,
				filterColValue:'PROCOMDET.estado_reg'
			};
			// txt precio_total_moneda_seleccionada
			Atributos[13]={
				validacion:{
					name:'precio_total_moneda_seleccionada',
					fieldLabel:'PT. Moneda Seleccionada',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					grid_indice:5,
					decimalPrecision:2,//para numeros float
					align:'right'
				},
				tipo:'TextField',
				form: false,
				filtro_0:true,
				filterColValue:'precio_total_moneda_seleccionada'
			};
			Atributos[14]={
				validacion:{
					name:'descripcion',
					fieldLabel:'Descripcion Item',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:2
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'ITEM.descripcion'
			};
	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Compras Finalizadas (Maestro)',titulo_detalle:'Detalle de la Compra Finalizada (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_CompraFinalizadoBien = new DocsLayoutMaestro(idContenedor);
	layout_CompraFinalizadoBien.init(config);



	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_CompraFinalizadoBien,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES

	var paramFunciones={ };

		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(m){
			maestro=m;
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_proceso_compra:maestro.id_proceso_compra
				}
			};
			this.btnActualizar();
			if(maestro.id_moneda==1){
					getGrid().getColumnModel().setHidden(4,true);
				}
				else{
					getGrid().getColumnModel().setHidden(4,false);
				}
			//Atributos[5].defecto=maestro.id_ante_proyecto;
			//paramFunciones.btnEliminar.parametros='&id_ante_proyecto='+maestro.id_ante_proyecto;
			//paramFunciones.Save.parametros='&id_ante_proyecto='+maestro.id_ante_proyecto;
			//paramFunciones.ConfirmSave.parametros='&id_ante_proyecto='+maestro.id_ante_proyecto;
			//this.InitFunciones(paramFunciones)
		};



		//Para manejo de eventos
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
		}

		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_CompraFinalizadoBien.getLayout()};
		//para el manejo de hijos

		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);

		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		this.bloquearMenu();
		layout_CompraFinalizadoBien.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);


}