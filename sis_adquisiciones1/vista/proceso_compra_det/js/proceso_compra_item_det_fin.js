/**
* Nombre:		  	    pagina_proceso_compra_mul_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-20 17:42:43
*/
function p_proceso_compra_mul_item_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw_grup=true,gridG,gSm,id_SCD,ds_g,gDlg;

	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompraFin.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proceso_compra_det',
			totalRecords: 'TotalCount'},[
			'id_cotizacion',
			'nombre',
			'proveedor',
			'impuestos',
			'num_factura',
			{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},
			'cantidad_sol',
			'cant_total',
			'id_moneda',
			'simbolo',
			'estado_vigente','id_proceso_compra_det'
			
			]),remoteSort:true});

			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_proceso_compra:maestro.id_proceso_compra
				}
			});



			// DEFINICIÓN DATOS DEL MAESTRO
			var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
			Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
			

			/////////////////////////
			// Definición de datos //
			/////////////////////////

			// hidden id_proceso_compra_det
			//en la posición 0 siempre esta la llave primaria

			Atributos[0]={
				validacion:{
					//fieldLabel: 'Id',
					labelSeparator:'',
					name: 'id_cotizacion',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_cotizacion'
			};
			Atributos[1]={
				validacion:{

					labelSeparator:'',
					name: 'nombre',
					fieldLabel:'Pedido',
					inputType:'hidden',
					grid_visible:true,
					grid_editable:false
				},
				tipo: 'TextField',
				filtro_0:true,
				form:false,
				filterColValue:'item.descripcion#servic.nombre'
				
			};

			// txt id_item
			Atributos[2]={
				validacion:{
					name:'proveedor',
					fieldLabel:'Proveedor',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
                    grid_indice:1
				},
				tipo:'TextField',
				form:false,
				filtro_0:true,
				filterColValue:'instit.nombre#person.nombre#person.apellido_paterno#person.apellido_materno'
			};

			// txt id_item
			Atributos[3]={
				validacion:{
					name:'impuestos',
					fieldLabel:'Tipo de Documento',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					renderer:impuesto
				},
				tipo:'Field',
				form:false,
				filtro_0:false,
				filterColValue:'impuestos'
			};

			Atributos[4]={
				validacion:{
					name:'num_factura',
					fieldLabel:'Nº Factura/Recibo',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,

				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'num_factura'
			};
			Atributos[5]= {
			validacion:{
				name:'fecha_factura',
				fieldLabel:'Fecha Factura',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:false,
			dateFormat:'m-d-Y',
			save_as:'fecha_factura'
		};
			Atributos[6]={
				validacion:{
					name:'cantidad_sol',
					fieldLabel:'Cantidad solicitada',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,

				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'cantidad_solicitada'
			};
			Atributos[7]={
				validacion:{
					name:'cant_total',
					fieldLabel:'Precio Total Compra',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,

				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'cant_total'
			};
			Atributos[8]={
				validacion:{
					name:'id_moneda',
					fieldLabel:'',
					grid_visible:false,
					grid_editable:false,
					width_grid:120,

				},
				tipo:'Field',
				form:false,
				filtro_0:false,
				filterColValue:'id_moneda'
			};
			// txt id_item
			Atributos[9]={
				validacion:{
					name:'simbolo',
					fieldLabel:'Moneda',
					grid_visible:true,
					grid_editable:false,
					width_grid:120

				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'simbolo'
			};
			// txt cantidad
		/*	Atributos[10]={
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
					align:'right'

				},
				tipo:'Field',
				form:true,
				filtro_0:true,
				filterColValue:'PROCOMDET.precio_referencial_total'
			};
*/
			// txt estado_reg
			Atributos[10]={
				validacion:{
					name:'estado_vigente',
					fieldLabel:'Estado',
					grid_visible:true,
					grid_editable:false,
					width_grid:100
				},
				tipo:'TextField',
				form: false,
				filtro_0:true,
				filterColValue:'estado_vigente'
			};


			// txt precio_total_moneda_seleccionada
			/*Atributos[13]={
				validacion:{
					name:'precio_total_moneda_seleccionada',
					fieldLabel:'PT. Moneda Seleccionada',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					grid_indice:5,
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
			};*/
			
			//----------- FUNCIONES RENDER

			function formatDate(value){return value?value.dateFormat('d/m/Y'):''};


			function impuesto(val){
				if(val==1){
					return 'Factura c/IVA';
				}
				if(val==2){
					return 'Factura s/IVA';
				}
				if(val==3){
					return 'Recibo sin Retencion';
				}
				if(val==4){
					return 'Recibo con retencion Bien';
				}else{
					return 'Recibo con retencion Servicio';
				}
				
			}

			//---------- INICIAMOS LAYOUT DETALLE
			var config={titulo_maestro:'Iniciar Procedimiento de Compra Múltiple (Maestro)',titulo_detalle:'Procedimiento Detalle (Detalle)',grid_maestro:'grid-'+idContenedor};
			var layout_proceso_compra_mul_det_fin = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
			layout_proceso_compra_mul_det_fin.init(config);



			//---------- INICIAMOS HERENCIA
			this.pagina = Pagina;
			this.pagina(paramConfig,Atributos,ds,layout_proceso_compra_mul_det_fin,idContenedor);
			var getComponente=this.getComponente;
			var getSelectionModel=this.getSelectionModel;
			var getGrid=this.getGrid;
			var xhtmlMaestro=this.htmlMaestro;
			//DEFINICIÓN DE LA BARRA DE MENÚ
			cargar_maestro();
			
			
			var paramMenu={actualizar:{crear:true,separador:false}};
			//DEFINICIÓN DE FUNCIONES


			var paramFunciones={
				//				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso_compra_mul_det'}
			};

			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_proceso_compra=datos.m_id_proceso_compra;
				maestro.desc_tipo_categoria_adq=datos.m_desc_tipo_categoria_adq;
				maestro.codigo_proceso=datos.m_codigo_proceso;
				maestro.desc_moneda=datos.m_desc_moneda;
				maestro.id_tipo_adq=datos.m_id_tipo_adq;
				maestro.desc_tipo_adq=datos.m_desc_tipo_adq;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_proceso_compra:maestro.id_proceso_compra
					}
				};
				this.btnActualizar();
				cargar_maestro()
			};

			function cargar_maestro(){
				Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,xhtmlMaestro([['id_proceso_compra',maestro.id_proceso_compra],['Código de Proceso',maestro.codigo_proceso],['Moneda',maestro.desc_moneda],['Tipo Adquisición',maestro.desc_tipo_adq]]));
			}



			function btn_caracteristica(){
				var sm=getSelectionModel(),NumSelect=sm.getCount();
				if(NumSelect!=0){
					var record=sm.getSelected();
					if(sw_grup){
						InitDetalleGrupo(record.data.id_proceso_compra_det,record.data.id_item)
					}
					else{
						//mostra ventana de grupos
						reloadDetalleGrupo(record.data.id_proceso_compra_det,record.data.id_item)
					}
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}
			//ventana del detaalle grup


			function InitDetalleGrupo(id_proceso_compra_det,id_item){

				//crear ventana para para manejar grupos
				//var Win=Ext.DomHelper.append(document.body,{tag:'div',id:"gDlg-"+idContenedor,html:"<div id=gcenter-"+idContenedor+" ><div id=grid_g-"+idContenedor+"></div></div>"},true);
				//var Win=Ext.DomHelper.append(document.body,{tag:'div',id:"gsDlg-"+idContenedor,html:"<div id=grid_gs-"+idContenedor+"></div>"},true);

				//				var Win=Ext.DomHelper.append(document.body,{tag:'div',id:"gsDlg-"+idContenedor,html:"<div id=grid_gs-"+idContenedor+"></div>"},true);

				var Win=Ext.DomHelper.append(document.body,{tag:'div',id:"gsDlg-"+idContenedor},true);
				var dGrid=Ext.DomHelper.append("gsDlg-"+idContenedor,{tag:'div',id:"grid_gs-"+idContenedor},true);

				gDlg = new Ext.LayoutDialog(Win,{
					title:'Solicitudes Agrupadas',
					modal: true,
					autoTabs: true,
					resizable:true,
					width: 400,
					height: 200,
					shadow: false,
					fixedCenter:true,
					constraIntoviewport: true,
					closable: true,
					center:{split:false,titlebar:false,autoScroll:true,fitToFrame:true}
				});
				gDlg.addKeyListener(27,function(){gDlg.hide()});//ESC

				function formatSol(value,p,record){return "<div><a href=\"javascript:pProItemMul.openWindows('../../../vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det="+record.data.id_solicitud_compra_det+"')\">[ "+record.data.periodo+"/"+record.data.num_solicitud+ " , " +record.data.periodo+"  ]</a></div>"}
				function formatAdj(value,p,record){return "<div><a href=\"javascript:pProItemMul.openWinCot('../../../vista/cotizacion/cotizacion_min.php?m_id_cotizacion_det="+record.data.id_cotizacion_det+"')\">"+record.data.cantidad_adjudicada+"</a></div>"}


				//function formatSolicitud(value,p,record){return "<div><input type="button" value="Enviar"  onclick='javascript:pProItemMul.openCaracteristica("+record[id_solicitud_compra_det]+")'/></div>")
				//var datos=Ext.urlDecode(decodeURIComponent(params));

				ds_g = new Ext.data.Store({
					proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/grupo_sp_det/ActionListarGrupoSpDet.php'}),
					// aqui se define la estructura del XML
					reader: new Ext.data.XmlReader({record:'ROWS',id:'id_grupo_sp_det',totalRecords:'TotalCount'},[
					'id_grupo_sp_det',
					'id_solicitud_compra_det',
					'cantidad_adjudicada',
					'cantidad_sol',
					'num_solicitud_sis',
					'num_solicitud',
					'periodo'

					]),remoteSort:false});

					ds_g.load({params:{start:0,limit:25,id_proceso_compra:maestro.id_proceso_compra,id_proceso_compra_det:id_proceso_compra_det,id_item:id_item}});
					var cmG = new Ext.grid.ColumnModel([{header:"Solicitud (Num Solicitud, Num Solicitud Sis)",width:250,dataIndex:'num_solicitud',renderer:formatSol},{header:"Catidad Solicitada",width:120,dataIndex:'cantidad_sol'},{header:"Cantidad Adjudicada",width:120,dataIndex:'cantidad_adjudicada',renderer:formatAdj}]);
					gSm=new Ext.grid.RowSelectionModel({singleSelect:true});
					var glayout=gDlg.getLayout();
					//gridG=new Ext.grid.Grid("grid_g-"+idContenedor,{ds:ds_g,cm:cmG,selModel:gSm});
					//gridG=new Ext.grid.Grid("grid_gs-"+idContenedor,{ds:ds_g,cm:cmG,selModel:gSm,autoHeight:false});
					gDlg.getLayout().layout();
					gDlg.getLayout().getRegion('center').getEl()
					gridG=new Ext.grid.Grid(dGrid,{ds:ds_g,cm:cmG,selModel:gSm,autoHeight:false});
					var g_panel=new Ext.GridPanel(gridG,{fitToFrame:true,closable:false});

					gDlg.show();
					glayout.add('center',g_panel);
					gridG.render();
					// add a paging toolbar to the grid's footer
					var gPaging=new Ext.PagingToolbar(gridG.getView().getFooterPanel(true),ds_g, {
						displayInfo:true,
						displayMsg:'Solicitudes {0} - {1} de {2}',
						emptyMsg:"No hay Solicitudes"
					});
					sw_grup=false

			}

			function reloadDetalleGrupo(id_proceso_compra_det,id_item){

				gSm.clearSelections();
				gDlg.show();
				ds_g.reload({params:{
					start:0,
					limit:100,
					id_proceso_compra:maestro.id_proceso_compra,
					id_item:id_item,
					id_proceso_compra_det:id_proceso_compra_det

				}});
				gridG.autoSize()
				gridG.getView().layout()
	}


			this.openWindows = function(dir){
				var ParamVentana={ventana:{width:'90%',height:'90%'}};
				layout_proceso_compra_mul_det_fin.loadWindows(direccion+dir,'Caracteristicas Adicionales',ParamVentana)
			}

			this.openWinCot = function(dir){
				var ParamVentana={ventana:{width:'90%',height:'90%'}};
				layout_proceso_compra_mul_det_fin.loadWindows(direccion+dir,'Datos Cotizacion',ParamVentana)
			}




			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				if(maestro.id_moneda==1){

					getGrid().getColumnModel().setHidden(4,true);
				}
				else{
					getGrid().getColumnModel().setHidden(4,false);
				}
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_proceso_compra_mul_det_fin.getLayout()};
			//para el manejo de hijos



			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Características Detalle',btn_caracteristica,true,'caracteristica','');

			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_proceso_compra_mul_det_fin.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)



}