/**
* Nombre:		  	    pagina_detalle_seguimiento_solicitud_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 11:58:28
*/
function pag_cpm_rap_se_dt(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM,maestro;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra_det/ActionListarSolicitudCompraDet_det.php?simplificado=1'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_solicitud_compra_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_solicitud_compra_det',

		//'id_item_antiguo',
		'cantidad',
		'precio_referencial_estimado',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_inicio_serv',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin_serv',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'estado_reg',
		'id_solicitud_compra',
		'desc_solicitud_compra',
		'id_servicio',
		'desc_servicio',
		'tipo_servicio','precio_referencial_moneda_seleccionada',
		'precio_total_moneda_seleccionada',
		'precio_total_referencial',
		'especificaciones_tecnicas','id_cuenta','desc_cuenta','id_partida','codigo_partida'
		]),remoteSort:true});

		//carga datos XML
		

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
			filtro_0:false,
			save_as:'id_solicitud_compra_det',
			id_grupo:0
		};
		// txt cantidad
		Atributos[1]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:75,
				grid_indice:5
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'SOLDET.cantidad'
		};

		// txt precio_referencial_estimado
		Atributos[2]={
			validacion:{
				name:'precio_referencial_estimado',
				fieldLabel:'Precio Unitario',
				grid_visible:false,
				grid_editable:false,
				width_grid:10,
				align:'right',
				grid_indice:6
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'SOLDET.precio_referencial_estimado'
		};


		Atributos[3]={
			validacion:{
				name:'tipo_servicio',
				fieldLabel:'Tipo de Servicio',
				
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				grid_indice:1
			},
			tipo: 'Field',
			form: false,
			filterColValue:'TIPSER.nombre',
			filtro_0:true
		};

		// txt fecha_inicio_serv
		Atributos[4]= {
			validacion:{
				name:'fecha_inicio_serv',
				fieldLabel:'Inicio del Servicio',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:110,
				disabled:false,
				grid_indice:8
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_inicio_serv',
			dateFormat:'m-d-Y'
		};

		Atributos[5]={
			validacion:{
				name:'abreviatura',
				fieldLabel:'Unid. Med.',
				grid_visible:true,
				width_grid:80,
				grid_indice:4
			},
			form:false,
			tipo:'Field',
			filtro_0:false
		};


		// txt fecha_fin_serv
		Atributos[6]= {
			validacion:{
				name:'fecha_fin_serv',
				fieldLabel:'Fin del Servicio',
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				renderer: formatDate,
				width_grid:110,
				grid_indice:9
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_fin_serv',
			dateFormat:'m-d-Y'
		};


		Atributos[7]={
			validacion:{
				name:'precio_referencial_moneda_seleccionada',
				fieldLabel:'Precio Unitario Mon.Sel.',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				width_grid:120,
				grid_indice:6
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};


		Atributos[8]={
			validacion:{
				name:'precio_total_moneda_seleccionada',
				fieldLabel:'Precio Total Mon.Sel.',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				align:'right',
				grid_indice:7
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};

		Atributos[9]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripcion',
				grid_visible:false,
				grid_editable:false,
				width_grid:100
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'SOLDET.descripcion'
		};



		Atributos[10]={
			validacion:{
				name:'especificaciones_tecnicas',
				fieldLabel:'Especificaciones Tecnicas',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				grid_indice:3
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'SOLDET.especificaciones_tecnicas'
		};

		Atributos[11]={
			validacion:{
				name:'desc_cuenta',
				fieldLabel:'Cuenta',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:11
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'CUENTA.desc_cuenta#CUENTA.nombre_cuenta'
		};


		Atributos[12]={
			validacion:{
				name:'codigo_partida',
				fieldLabel:'Partida',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:10
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida'
		};

		
		Atributos[13]={
			validacion:{
				name:'desc_servicio',
				fieldLabel:'Servicio',
				grid_visible:true,
				grid_editable:false,
				width_grid:130,
				grid_indice:2
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'SERVIC.codigo#SERVIC.nombre'
		};
		
		Atributos[14]={
			validacion:{
				name:'id_solicitud_compra',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			form: false,
			filtro_0:false
		};


		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		tituloM='Solicitud Detalle';
		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Solicitud Compra (Maestro)',grid_maestro:'grid-'+idContenedor};
		var layt_sol_com_serv_det = new DocsLayoutMaestro(idContenedor);
		layt_sol_com_serv_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layt_sol_com_serv_det,idContenedor);
		var getSelectionModel=this.getSelectionModel;
		//DEFINICIÓN DE LA BARRA DE MENÚ
	    var paramMenu={actualizar:{crear:true,separador:false}};//DEFINICIÓN DE FUNCIONES
		var paramFunciones={btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionAnularSolicitudCompraDet.php'}};



			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(m){
				maestro=m;
                
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:1,
						m_id_solicitud_compra:maestro.id_solicitud_compra,
						m_tipo_adq:maestro.tipo_adq,
						m_simbolo:maestro.simbolo,
						id_empresa:maestro.id_empresa
						
					}
				};
		       
				this.btnActualizar();
				Atributos[14].defecto=maestro.id_solicitud_compra;
				paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
				this.InitFunciones(paramFunciones)
			};


			function btn_caracteristica(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					//
					var data='m_id_solicitud_compra_det='+SelectionsRecord.data.id_solicitud_compra_det;
					data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
					data=data+'&m_id_detalle='+SelectionsRecord.data.desc_servicio;
                    data=data+'&m_id_item_propuesto=-1&m_id_servicio_propuesto=-1';
					
					var ParamVentana={ventana:{width:'90%',height:'70%'}};
					layt_sol_com_serv_det.loadWindows(direccion+'../../../../sis_adquisiciones/vista/caracteristica/caracteristica_det.php?'+data,'Caracteristicas Adicionales',ParamVentana);
					layt_sol_com_serv_det.getVentana().on('resize',function(){
						layt_sol_com_serv_det.getLayout().layout();
					})
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}



			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layt_sol_com_serv_det.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Caracteristicas Adicionales',btn_caracteristica,true,'caracteristica','');
			this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Detalle',this.btnEliminar,true,'anular_detalle','');
			this.iniciaFormulario();
			this.bloquearMenu();
			
			
			layt_sol_com_serv_det.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}