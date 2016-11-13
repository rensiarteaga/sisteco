/**
* Nombre:		  	    pagina_solicitud_compra_det_det.js
* Propósito: 			pagina objeto principal
* Autor:				Rensi Arteaga Copari
* Fecha creación:		2008-05-16 09:53:33
*/
function p_sco_mul_item_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0,cmp_incluido,sw_grup=true,gridG,gSm,sw_check=false,value_check=false,id_SCD,ds_g,gDlg;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra_det/ActionListarSolicitudCompraDetGrup.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_solicitud_compra_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_solicitud_compra_det',
		'id_item_antiguo',
		'cantidad',
		'precio_referencial_estimado',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_inicio_serv',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin_serv',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'partida_presupuestaria',
		'estado_reg',
		'pac_verificado',
		'id_solicitud_compra',
		'id_servicio',
		'id_item',
		'codigo_item',
		'nombre_item',
		'monto_aprobado',
		'mat_bajo_responsabilidad',
		'supergrupo',
		'grupo',
		'subgrupo',
		'id1',
		'id2',
		'id3',
		'tipo_servicio',
		'nombre_unid_base',
		'id_proceso_compra',
		'codigo_proceso',
		'id_proceso_compra_det',
		'id_grupo_sp_det',
		{name:'incluido',type:'boolean'}

		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra,
				m_tipo_adq:maestro.tipo_adq
			}
		});

		// DEFINICIÓN DATOS DEL MAESTRO
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");


		//FUNCIONES RENDER


		function render_id_solicitud_compra(value, p, record){return String.format('{0}', record.data['desc_solicitud_compra']);}
		var tpl_id_solicitud_compra=new Ext.Template('<div class="search-item">','<b><i>{localidad}</i></b>','<br><FONT COLOR="#B5A642">{num_solicitud}</FONT>','</div>');


		function render_incluido(value, p, record){
			var  inc;
			if(record.data['incluido']){
				if(record.data['id_proceso_compra']==maestro.id_proceso_compra){
					inc='Si'
				}
				else{
					inc='<span style="color:red;">Otro</span>'
				}
			}else
			{
				inc='No'
			}
			return inc
		}


		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_solicitud_compra_det
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_solicitud_compra_det',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};


		Atributos[1]={
			validacion:{
				name:'incluido',
				fieldLabel:'Incluir',
				grid_visible:true,
				grid_editable:true,
				renderer:render_incluido
			},
			tipo:'Checkbox',
			form:true,
			filtro_0:false
		};


		Atributos[2]={
			validacion:{
				name:'codigo_item',
				fieldLabel:'Codigo',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'ITEM.codigo'
		};
		Atributos[3]={
			validacion:{
				name:'supergrupo',
				fieldLabel:'Supergrupo',
				grid_visible:true,
				grid_editable:false
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};

		Atributos[4]={
			validacion:{
				name:'grupo',
				fieldLabel:'Grupo',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false,
			id_grupo:4
		};

		Atributos[5]={
			validacion:{
				name:'subgrupo',
				fieldLabel:'Subgrupo',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};

		Atributos[6]={
			validacion:{
				name:'id1',
				fieldLabel:'ID1',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};

		Atributos[7]={
			validacion:{
				name:'id2',
				fieldLabel:'ID2',
				grid_visible:true,
				grid_editable:false
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};

		Atributos[8]={
			validacion:{
				name:'id3',
				fieldLabel:'ID3',
				grid_visible:true,
				grid_editable:false
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};

		Atributos[9]={
			validacion:{
				name:'nombre_item',
				fieldLabel:'Item',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};

		// txt descripcion
		Atributos[10]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripcion',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'SOLDET.descripcion'
		};

		// txt cantidad
		Atributos[11]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'SOLDET.cantidad'
		};


		Atributos[12]={
			validacion:{
				name:'nombre_unid_base',
				fieldLabel:'Unidad Medida',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};

		// txt precio_referencial_estimado
		Atributos[13]={
			validacion:{
				name:'precio_referencial_estimado',
				fieldLabel:'Precio Referencial ('+ maestro.simbolo +')',
				grid_visible:true,
				grid_editable:false,
				width_grid:180
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'SOLDET.precio_referencial_estimado'

		};

		// txt monto_aprobado
		Atributos[14]={
			validacion:{
				name:'monto_aprobado',
				fieldLabel:'Monto Aprobado ('+ maestro.simbolo +')',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};
		// txt partida_presupuestaria
		Atributos[15]={
			validacion:{
				name:'partida_presupuestaria',
				fieldLabel:'Partida Presupuestaria',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false,
			filterColValue:'SOLDET.partida_presupuestaria'
		};

		// txt pac_verificado
		Atributos[16]={
			validacion: {
				name:'pac_verificado',
				fieldLabel:'PAC Verificado',
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false,
			filterColValue:'SOLDET.pac_verificado'
		};
		// txt estado_reg
		Atributos[17]={
			validacion:{
				name:'estado_reg',
				fieldLabel:'estado',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'SOLDET.estado_reg'
		};

		// txt fecha_reg
		Atributos[18]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_reg',
			dateFormat:'m-d-Y'
		};



		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Solicitud Compra (Maestro)',titulo_detalle:'Detalle de Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
		var layout_solicitud_compra_mult_item_det = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_solicitud_compra_mult_item_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_solicitud_compra_mult_item_det,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var getGrid=this.getGrid;
		var conexionFailure=this.conexionFailure;
		var getComponenteGrid=this.getComponenteGrid;
		var btnActualizar=this.btnActualizar;
		var EnableSelect=this.EnableSelect;
		var xhtmlMaestro=this.htmlMaestro;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={};
		function cargar_maestro(){

			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,xhtmlMaestro([['Num Sol.',maestro.num_solicitud],['Num Sol Sis.',maestro.num_solicitud_sis],['Solicitante',maestro.solicitante],['Fecha Sol.',formatDate(new Date(maestro.fecha_sol))]]))}
			cargar_maestro();

			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){

				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_solicitud_proceso_compra=datos.m_id_solicitud_proceso_compra;
				maestro.id_proceso_compra=datos.m_id_proceso_compra;
				maestro.id_solicitud_compra=datos.m_id_solicitud_compra;
				maestro.id_tipo_adq=datos.m_id_tipo_adq;
				maestro.id_moneda=datos.m_id_moneda;
				maestro.tipo_adq=datos.m_tipo_adq;
				maestro.simbolo=datos.m_simbolo;
				maestro.num_solicitud=datos.m_num_solicitud;
				maestro.num_solicitud_sis=datos.m_num_solicitud_sis;
				maestro.solicitante=datos.m_solicitante
				maestro.fecha_sol=datos.m_fecha_sol

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_solicitud_compra:maestro.id_solicitud_compra
					}
				};
				this.btnActualizar();
				cargar_maestro();
			};


			function btn_caracteristica(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var record=sm.getSelected();

					if(sw_grup){
						InitDetalleGrupo(record.data.id_item,record.data.id_servicio);
					}
					else{
						//mostra ventana de grupos
						reloadDetalleGrupo(record.data.id_item,record.data.id_servicio);

					}
					gDlg.buttons[0].hide();
					gDlg.buttons[1].hide();


				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				cmp_incluido=getComponenteGrid('incluido');
				//revisa si el det esta incluido en otro proceso y lo dehabilita
				getGrid().addListener('beforeedit',antesEdit);
				cmp_incluido.on('check',onCheck)
				
			}

			function antesEdit(e){
				if(e.record.data['id_proceso_compra']!=maestro.id_proceso_compra && e.record.data['incluido']){
					return false
				}
			}


			function onCheck(x,check){
				var record=getSelectionModel().getSelected();
				value_check=record.data.incluido;
				//alert("prueba xxx")

				if(value_check!=check){
					record.commit()
					if(check){
							

						//marca
						
						//
						
						Ext.Ajax.request({
							url:direccion+"../../../control/proceso_compra_det/ActionVerificarInsertarProcesoCompraMulDet.php",
							params:{id_solicitud_compra_det:record.data.id_solicitud_compra_det,id_proceso_compra:maestro.id_proceso_compra,id_solicitud_compra:maestro.id_solicitud_compra},
							argument:{record:record,id_solicitud_compra_det:record.data.id_solicitud_compra_det,id_item:record.data.id_item,id_servicio:record.data.id_servicio},
							success:terminado,
							failure:MyConexionFailure,
							timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
						})
					}
					else{
						//desmarca

						//var record=getSelectionModel().getSelected();
						Ext.Ajax.request({
							url:direccion+"../../../control/proceso_compra_det/ActionEliminarProcesoCompraMulDet.php",
							params:{id_solicitud_compra_det:record.data.id_solicitud_compra_det,id_proceso_compra:maestro.id_proceso_compra,id_solicitud_compra:maestro.id_solicitud_compra},
							argument:{record:record},
							success:terminado,
							failure:MyConexionFailure,
							timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
						})
					}					
				}				
			}

			function MyConexionFailure(resp1,resp2,resp3,resp4){
				getGrid().stopEditing();
				getSelectionModel().clearSelections();
				conexionFailure(resp1,resp2,resp3,resp4);
				Actualizar()
			}

			function Actualizar(){
				ds.load(ds.lastOptions);//actualizar
				ds.rejectChanges()//vacia el vector de records modificados
			}


			function agrupar(grup,id_proceso_compra_det){
				
			
				var record=getSelectionModel().getSelected(); //es el primer registro selecionado
				/*-----loading----*/
				Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/proceso_compra_det/ActionVerificarInsertarProcesoCompraMulDet.php",
					params:{
						record:record,
						id_solicitud_compra_det:id_SCD,
						id_proceso_compra:maestro.id_proceso_compra,
						id_solicitud_compra:maestro.id_solicitud_compra,
						agrupar:grup,
						id_proceso_compra_det:id_proceso_compra_det
					},
					success:terminado,
					failure:conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				})
			}

			function siGrup(){if(gSm.getSelected()){agrupar('SI',gSm.getSelected().data.id_proceso_compra_det)}}
			function noGrup(){agrupar('NO')}

			
		


			function InitDetalleGrupo(id_item,id_servicio){
				
				//crear ventana para para manejar grupos
				var Win=Ext.DomHelper.append(document.body,{tag:'div',id:"gDlg-"+idContenedor},true);
				var dGrid=Ext.DomHelper.append("gDlg-"+idContenedor,{tag:'div',id:"grid_g-"+idContenedor},true);
				gDlg = new Ext.LayoutDialog(Win,{
					modal: true,
					width: 400,
					height: 200,
					fixedCenter:true,
					closable: true,
					center:{title:'Grupos',titlebar:false,autoScroll:true}
				});
				//gDlg.addKeyListener(27,function(){gDlg.hide()});//ESC
				gDlg.addButton('Agrupar',siGrup,gDlg);
				gDlg.addButton('Continuar sin Agrupar',noGrup,gDlg);


				function formatURL(value,p,record){return "<div>"+decodeURIComponent(record.data['grupo'])+"</div>"}

				//var datos=Ext.urlDecode(decodeURIComponent(params));

				ds_g = new Ext.data.Store({
					proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/grupo_sp_det/ActionListarGrupoProcDet.php'}),
					// aqui se define la estructura del XML
					reader: new Ext.data.XmlReader({record:'ROWS',id:'numero',totalRecords:'TotalCount'},[
					'numero',
					'id_proceso_compra_det',
					'id_proceso_compra',
					'grupo']),remoteSort:false});

					ds_g.load(
					{
						params:{
							start:0,
							limit:100,
							id_proceso_compra:maestro.id_proceso_compra,
							id_servicio:id_servicio,
							id_item:id_item,
							funcion:'pSolItemMul'

						}
					});
					var cmG = new Ext.grid.ColumnModel([{header:"Grupo",width:50,dataIndex:'numero'},{header:"N° Sol Gral, N° Sol RP)",dataIndex:'grupo',renderer:formatURL}]);
					gSm=new Ext.grid.RowSelectionModel({singleSelect:true});
					var glayout=gDlg.getLayout();
					gridG=new Ext.grid.Grid(dGrid,{ds:ds_g,cm:cmG,selModel:gSm});
					var g_panel=new Ext.GridPanel(gridG,{fitToFrame:true,closable:false});
					glayout.add('center',g_panel);
					gDlg.show();

					gridG.render();
					// add a paging toolbar to the grid's footer
					var gPaging=new Ext.PagingToolbar(gridG.getView().getFooterPanel(true),ds_g, {
						pageSize: 25,
						displayInfo:true,
						displayMsg:'Grupos {0} - {1} de {2}',
						emptyMsg:"No hay Grupos"
					});


					gDlg.on('hide',function(){Actualizar()});
					sw_grup=false
			}
			

			//para recargar la ventana de agrupciones
			function reloadDetalleGrupo(id_item,id_servicio){
				
				gSm.clearSelections();
				gDlg.show();
				ds_g.reload({params:{
					start:0,
					limit:100,
					id_proceso_compra:maestro.id_proceso_compra,
					id_servicio:id_servicio,
					id_item:id_item,
					funcion:'pSolItemMul'

				}})



			}

			function terminado(resp){
				getGrid().stopEditing()
				getSelectionModel().clearSelections();
				var regreso = Ext.util.JSON.decode(resp.responseText)
				Ext.MessageBox.hide();//ocultamos el loading
				if(regreso.success){
					if(regreso.agrupar=='SI'){
						id_SCD=resp.argument.id_solicitud_compra_det;
						if(sw_grup){
							InitDetalleGrupo(resp.argument.id_item,resp.argument.id_servicio)
						}
						else{
							//mostra ventana de grupos
							reloadDetalleGrupo(resp.argument.id_item,resp.argument.id_servicio)

						}
						gDlg.buttons[0].show();
						gDlg.buttons[1].show()
					}
					else{
						if(!sw_grup){
							if(gDlg.isVisible()){
								gDlg.hide()
							}
							else{
								Actualizar()
							}
						}else{
							Actualizar()
						}
					}	
				}
				//resp.argument.record.commit()
			}





			this.openWindows=function(dir){layout_solicitud_compra_mult_item_det.loadWindows(direccion+dir,'Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})}
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_solicitud_compra_mult_item_det.getLayout()};
			//para el manejo de hijos
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Detalle Agrupación',btn_caracteristica,true,'grup','');
			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_solicitud_compra_mult_item_det.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}