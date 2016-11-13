/**
* Nombre:		  	    pagina_proceso_compra_mul_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-20 17:42:43
*/
function pagina_proceso_compra_mul_serv_det(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw_grup=true,gridG,gSm,id_SCD,ds_g,gDlg;
	
	var maestro;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra_det/ActionListarProcesoCompraMulSerDet.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proceso_compra_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_proceso_compra_det',
		'id_proceso_compra',
		'cantidad',
		'precio_referencial_total',
		'estado_reg',
		'id_servicio',
		'nombre_servicio',
		'nombre_tipo_servicio',
		'precio_total_moneda_seleccionada'
		]),remoteSort:true});

		
		
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_proceso_compra_det
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
				name: 'id_servico',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

		// txt id_item
		Atributos[2]={
			validacion:{
				name:'nombre_tipo_servicio',
				fieldLabel:'Tipo Servicio',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,

			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'TIPSER.nombre'
		};

		// txt id_item
		Atributos[3]={
			validacion:{
				name:'nombre_servicio',
				fieldLabel:'Servicio',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,

			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'SERVI.nombre'
		};
		// txt cantidad
		Atributos[4]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				align:'right'
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOMDET.cantidad'
		};

		// txt precio_referencial_total
		Atributos[5]={
			validacion:{
				name:'precio_referencial_total',
				fieldLabel:'Precio Ref. Total Bs.',
				grid_visible:true,
				grid_editable:false,
				decimalPrecision:2,//para numeros float
				width_grid:100,
				align:'right'

			},
			tipo:'Field',
			form:true,
			filtro_0:true,
			filterColValue:'PROCOMDET.precio_referencial_total'
		};

		// txt precio_total_moneda_seleccionada
			Atributos[6]={
				validacion:{
					name:'precio_total_moneda_seleccionada',
					fieldLabel:'PT. Moneda Seleccionada',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					decimalPrecision:2,//para numeros float
					align:'right'
				},
				tipo:'TextField',
				form: false,
				filtro_0:true,
				filterColValue:'precio_total_moneda_seleccionada'
			};
		// txt estado_reg
		Atributos[7]={
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

		

		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Iniciar Procedimiento de Compra Múltiple (Maestro)',titulo_detalle:'Procedimiento Detalle (Detalle)',grid_maestro:'grid-'+idContenedor};
		var layout_proceso_compra_mul_serv_det = new DocsLayoutMaestro(idContenedor);
		layout_proceso_compra_mul_serv_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_proceso_compra_mul_serv_det,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var getGrid=this.getGrid;
		
		
		
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso_compra_mul_det'}};

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
				this.InitFunciones(paramFunciones);
				//para iniciar eventos en el formulario
				if(maestro.id_moneda==1){
					getGrid().getColumnModel().setHidden(4,true);
				}
				else{
					getGrid().getColumnModel().setHidden(4,false);
				}
			};
			
			
			
			function btn_caracteristica(){
				var sm=getSelectionModel(),NumSelect=sm.getCount();
				if(NumSelect!=0){
					var record=sm.getSelected();
					if(sw_grup){
						InitDetalleGrupo(record.data.id_proceso_compra_det,record.data.id_servicio)
					}
					else{
						//mostra ventana de grupos
						reloadDetalleGrupo(record.data.id_proceso_compra_det,record.data.id_servicio)
					}
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}
			//ventana del detaalle grup


			function InitDetalleGrupo(id_proceso_compra_det,id_servicio){
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

				function formatSol(value,p,record){return "<div><a href=\"javascript:pProServMul.openWindows('../../../vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det="+record.data.id_solicitud_compra_det+"')\">[ "+record.data.periodo+" / "+record.data.num_solicitud+" , "+record.data.periodo+" ]</a></div>"}
				function formatAdj(value,p,record){return "<div><a href=\"javascript:pProServMul.openWinCot('../../../vista/cotizacion/cotizacion_min.php?m_id_cotizacion_det="+record.data.id_cotizacion_det+"')\">"+record.data.cantidad_adjudicada+"</a></div>"}

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

					ds_g.load({params:{start:0,limit:25,id_proceso_compra:maestro.id_proceso_compra,id_proceso_compra_det:id_proceso_compra_det,id_servicio:id_servicio}});
					var cmG = new Ext.grid.ColumnModel([{header:"Solicitud (Num Solicitud, Num Solicitud Sis)",width:250,dataIndex:'num_solicitud',renderer:formatSol},{header:"Catidad Solicitada",width:120,dataIndex:'cantidad_sol'},{header:"Cantidad Adjudicada",width:120,dataIndex:'cantidad_adjudicada',renderer:formatAdj}]);
					gSm=new Ext.grid.RowSelectionModel({singleSelect:true});
					var glayout=gDlg.getLayout();
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

			function reloadDetalleGrupo(id_proceso_compra_det,id_servicio){

				gSm.clearSelections();
				gDlg.show();
				ds_g.reload({params:{
					start:0,
					limit:100,
					id_proceso_compra:maestro.id_proceso_compra,
					id_servicio:id_servicio,
					id_proceso_compra_det:id_proceso_compra_det

				}});
				gridG.autoSize()
				gridG.getView().layout()



			}


			this.openWindows = function(dir){
				var ParamVentana={ventana:{width:'90%',height:'90%'}};
				layout_proceso_compra_mul_serv_det.loadWindows(direccion+dir,'Caracteristicas Adicionales',ParamVentana)
			}

			this.openWinCot = function(dir){
				var ParamVentana={ventana:{width:'90%',height:'90%'}};
				layout_proceso_compra_mul_serv_det.loadWindows(direccion+dir,'Datos Cotizacion',ParamVentana)
			}



			//Para manejo de eventos
			function iniciarEventosFormularios(){
				
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_proceso_compra_mul_serv_det.getLayout()};
			//para el manejo de hijos
			
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Características Detalle',btn_caracteristica,true,'caracteristica','');
			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			layout_proceso_compra_mul_serv_det.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)

}