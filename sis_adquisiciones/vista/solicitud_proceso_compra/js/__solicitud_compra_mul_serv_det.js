/**
* Nombre:		  	    pagina_solicitud_compra_det_det.js
* Prop�sito: 			pagina objeto principal
* Autor:				Rensi Arteaga Copari
* Fecha creaci�n:		2008-05-16 09:53:33
*/
function p_sco_mul_serv_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0,cmp_incluido,sw_grup=true,gridG,gSm,sw_check=false,value_check=false,id_SCD,ds_g,maestro;
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
		'monto_aprobado',
		'tipo_servicio',
		'id_proceso_compra',
		'codigo_proceso',
		'id_proceso_compra_det',
		'id_grupo_sp_det',
		'servicio',
		'id_unidad_medida_base_serv',
		'nombre_unid_base_serv',
		{name:'incluido',type:'boolean'}

		]),remoteSort:true});


		/////////////////////////
		// Definici�n de datos //
		/////////////////////////

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
				grid_editable:true
			},
			tipo:'Checkbox',
			form:true,
			filtro_0:false
		};


		Atributos[2]={
			validacion:{
				name:'tipo_servicio',
				fieldLabel:'Tipo Servicio',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%'
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false
		};

		Atributos[3]={
			validacion:{
				name:'servicio',
				fieldLabel:'Servicio',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%'
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false
		};

		// txt descripcion
		Atributos[4]={
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



		// txt fecha_inicio_serv
		Atributos[5]= {
			validacion:{
				name:'fecha_inicio_serv',
				fieldLabel:'Inicio Servicio',
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				renderer: formatDate,
				width_grid:85
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_inicio_serv',
			dateFormat:'m-d-Y'
		};




		// txt fecha_fin_serv
		Atributos[6]= {
			validacion:{
				name:'fecha_fin_serv',
				fieldLabel:'Fin Servicio',
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				renderer: formatDate,
				width_grid:85
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_fin_serv',
			dateFormat:'m-d-Y'
		};



		Atributos[7]={
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
		
		Atributos[8]={
			validacion:{
				name:'nombre_unid_base_serv',
				fieldLabel:'Unidad Med.',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'UMBS.nombre'
		};


		// txt precio_referencial_estimado
		Atributos[9]={
			validacion:{
				name:'precio_referencial_estimado',
				fieldLabel:'Precio Referencial',
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
		Atributos[10]={
			validacion:{
				name:'monto_aprobado',
				fieldLabel:'Monto Aprobado',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:false
		};
		// txt partida_presupuestaria
		Atributos[11]={
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
		Atributos[12]={
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
		Atributos[13]={
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
		Atributos[14]= {
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
		var lay_sol_com_serv_det = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		lay_sol_com_serv_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,lay_sol_com_serv_det,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var getGrid=this.getGrid;
		var conexionFailure=this.conexionFailure;
		var getComponenteGrid=this.getComponenteGrid;
		var btnActualizar=this.btnActualizar;
		var EnableSelect=this.EnableSelect;
		var xhtmlMaestro=this.htmlMaestro;
		//DEFINICI�N DE LA BARRA DE MEN�
		var paramMenu={actualizar:{crear:true,separador:false}};

		//DEFINICI�N DE FUNCIONES

		var paramFunciones={};

		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(m){

			maestro=m;
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_solicitud_compra:maestro.id_solicitud_compra
				}
			};

			render_incluido=function (value, p, record){
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
			};
			var mycm =this.getColumnModel();
			mycm.setRenderer(this.getColumnNum('incluido'),render_incluido);
			this.btnActualizar();

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
			getGrid().addListener('beforeedit',antesEdit);
			cmp_incluido.on('check',onCheck)
		}

		function antesEdit(e){
			if(e.record.data['id_proceso_compra']!=maestro.id_proceso_compra && e.record.data['incluido']){
				return false
			}
		}



		function onCheck(x,check){

			value_check=getSelectionModel().getSelected().data.incluido;


			if(value_check!=check){


				if(check){
					//marca
					var record=getSelectionModel().getSelected();
					Ext.Ajax.request({
						url:direccion+"../../../control/proceso_compra_det/ActionVerificarInsertarProcesoCompraMulDet.php",
						params:{id_solicitud_compra_det:record.data.id_solicitud_compra_det,id_proceso_compra:maestro.id_proceso_compra,id_solicitud_compra:maestro.id_solicitud_compra},
						argument:{id_solicitud_compra_det:record.data.id_solicitud_compra_det,id_item:record.data.id_item,id_servicio:record.data.id_servicio},
						success:terminado,
						failure:MyConexionFailure,
						timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
					});
				}
				else{
					//desmarca

					var record=getSelectionModel().getSelected();
					Ext.Ajax.request({
						url:direccion+"../../../control/proceso_compra_det/ActionEliminarProcesoCompraMulDet.php",
						params:{id_solicitud_compra_det:record.data.id_solicitud_compra_det,id_proceso_compra:maestro.id_proceso_compra,id_solicitud_compra:maestro.id_solicitud_compra},
						success:terminado,
						failure:MyConexionFailure,
						timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
					});



				}

				record.commit()


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
					id_solicitud_compra_det:id_SCD,
					id_proceso_compra:maestro.id_proceso_compra,
					id_solicitud_compra:maestro.id_solicitud_compra,
					agrupar:grup,
					id_proceso_compra_det:id_proceso_compra_det
				},
				success:terminado,
				failure:conexionFailure,
				timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

		function siGrup(){if(gSm.getSelected()){agrupar('SI',gSm.getSelected().data.id_proceso_compra_det)}}
		function noGrup(){agrupar('NO')}




		function InitDetalleGrupo(id_item,id_servicio){

			//crear ventana para para manejar grupos
			var Win=Ext.DomHelper.append(document.body,{tag:'div',id:"gseDlg-"+idContenedor},true);
			var dGrid=Ext.DomHelper.append("gseDlg-"+idContenedor,{tag:'div',id:"grid_gse-"+idContenedor},true);
			gDlg = new Ext.LayoutDialog(Win,{
				fittoframe:true,
				modal: true,
				autoTabs: true,
				resizable:true,
				width: 400,
				height: 200,
				shadow: false,
				fixedCenter:true,
				constraIntoviewport: true,
				closable: true,
				center:{split:false,titlebar:false,autoScroll:true}
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
				'grupo',
				'solicitantes']),remoteSort:false});

				ds_g.load(
				{
					params:{
						start:0,
						limit:100,
						id_proceso_compra:maestro.id_proceso_compra,
						id_servicio:id_servicio,
						id_item:id_item,
						funcion:'pSolServMul'

					}
				});
				var cmG = new Ext.grid.ColumnModel([{header:"Grupo",width:50,dataIndex:'numero'},{header:"(N� Sol Gral, N� Sol RP)",dataIndex:'grupo',renderer:formatURL},{header:"Solicitante",width: 350,dataIndex:'solicitantes'}]);
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
				sw_grup=false;

		}

		function reloadDetalleGrupo(id_item,id_servicio){

			gSm.clearSelections();
			gDlg.show();
			ds_g.reload({params:{
				start:0,
				limit:100,
				id_proceso_compra:maestro.id_proceso_compra,
				id_servicio:id_servicio,
				id_item:id_item,
				funcion:'pSolServMul'

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
					gDlg.buttons[1].show();

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
		}





		this.openWindows = function(dir){lay_sol_com_serv_det.loadWindows(direccion+dir,'Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})};



		//para que los hijos puedan ajustarse al tama�o
		this.getLayout=function(){return lay_sol_com_serv_det.getLayout()};
		//para el manejo de hijos

		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Detalle Agrupaci�n',btn_caracteristica,true,'grup','');
		this.iniciaFormulario();
		iniciarEventosFormularios();
		this.bloquearMenu();
		lay_sol_com_serv_det.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}