/**
* Nombre:		  	    pagina_compra_rapida.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-07-01 16:50:46
*/
function pag_com_rap_bien(idContenedor,direccion,paramConfig,bandera){
	var Atributos=new Array,sw=0,simplificada='NO';
	var cmpTipoRecibo,cmpIdComprador,config,cmpPago_variable;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra/ActionListarCompraRapida.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[
		'id_solicitud_compra',
		'num_solicitud',
		'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'id_empleado_frppa_solicitante',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'descripcion_programa_programa',
		'codigo_programa_programa',
		'descripcion_proyecto_proyecto',
		'codigo_proyecto_proyecto',
		'descripcion_actividad_actividad',
		'codigo_actividad_actividad',
		'desc_empleado_tpm_frppa',
		'id_cuenta',
		'desc_cuenta',
		'id_rpa',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'descripcion_programa_programa',
		'codigo_programa_programa',
		'descripcion_proyecto_proyecto',
		'codigo_proyecto_proyecto',
		'descripcion_actividad_actividad',
		'codigo_actividad_actividad',
		'desc_rpa',
		'localidad',
		'id_moneda',
		'desc_moneda',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'tipo_adjudicacion',
		'tipo_adq',
		'observaciones',
		'nombre',
		'num_solicitud_peri',
		'gestion',
		'categoria',
		'permite_agrupar','avance','gestion_sgte','id_depto'
		]),remoteSort:true});


		var ds_id_comprador = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprador/ActionListarComprador.php'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',id:'id_comprador',totalRecords:'TotalCount'
			},[
			'id_comprador',
			'id_empleado',
			'apellido_paterno_persona',
			'apellido_materno_persona',
			'nombre_persona',
			'desc_empleado',
			{name: 'fecha_asignacion',type:'date',dateFormat:'Y-m-d'},
			'estado'
			]),remoteSort:true});






			/////////////////////////
			// Definición de datos //
			/////////////////////////

			// hidden id_solicitud_compra
			//en la posición 0 siempre esta la llave primaria

			Atributos[0]={
				validacion:{
					labelSeparator:'',
					name: 'id_solicitud_compra',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_solicitud_compra'
			};
			// txt id_fina_regi_prog_proy_acti
			Atributos[1]={
				validacion:{
					fieldLabel:'Estructura Programatica',
					allowBlank:true,
					emptyText:'Estructura Programática',
					name:'id_fina_regi_prog_proy_acti',
					minChars:1,
					triggerAction:'all',
					editable:false,
					grid_visible:true,
					grid_editable:false,
					grid_indice:13,
					width:300
				},
				form:false,
				tipo:'epField',
				save_as:'id_ep'
			};
			// txt id_empleado_frppa_solicitante
			Atributos[2]={
				validacion:{
					name:'desc_empleado_tpm_frppa',
					fieldLabel:'Solicitante',
					grid_visible:true,
					grid_editable:false,
					width_grid:200,
					grid_indice:2
				},
				tipo:'Field',
				form: false,
				filtro_0:true,
				filterColValue:'EMPLEP_2.apellido_paterno#EMPLEP_2.apellido_materno#EMPLEP_2.nombre#EMPLEP_2.codigo_empleado'
			};


			// txt localidad
			Atributos[3]={
				validacion:{
					name:'categoria',
					fieldLabel:'Modalidad de Compra',
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					grid_indice:6
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'CAT.nombre'
			};
			// txt id_moneda
			Atributos[4]={
				validacion:{
					name:'desc_moneda',
					fieldLabel:'Moneda',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					grid_indice:7
				},
				tipo:'Field',
				form: false,
				filtro_0:true,
				filterColValue:'MONEDA.nombre'
			};
			// txt id_unidad_organizacional
			Atributos[5]={
				validacion:{
					name:'desc_unidad_organizacional',
					fieldLabel:'Unidad Organizacional',
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					disable:false,
					grid_indice:3
				},
				tipo:'ComboBox',
				form: false,
				filtro_0:true,
				filterColValue:'UNIORG.nombre_unidad'
			};
			// txt id_tipo_categoria_adq
			Atributos[6]={
				validacion:{
					name:'desc_tipo_categoria_adq',
					fieldLabel:'Tipo Categoria',
					grid_editable:false,
					width_grid:120,
					grid_indice:9
				},
				tipo:'Field',
				form: false,
				filtro_0:true,
				filterColValue:'TIPCAT.nombre'
			};
			// txt tipo_adjudicacion
			Atributos[7]={
				validacion:{
					name:'tipo_adjudicacion',
					fieldLabel:'Adjudicación',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:5
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'SOLCOM.tipo_adjudicacion'
			};
			// txt tipo_adq
			Atributos[8]={
				validacion:{
					name:'tipo_adq',
					fieldLabel:'Tipo Adquisición',
					width_grid:150,
					grid_indice:4
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'TIPADQ.tipo_adq'
			};
			// txt observaciones
			Atributos[9]={
				validacion:{
					name:'observaciones',
					fieldLabel:'Observaciones Estado',
					grid_visible:true,
					grid_editable:false,
					width_grid:250,
					grid_indice:11
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'ESTPRO.observaciones'
			};
			// txt nombre
			Atributos[10]={
				validacion:{
					name:'nombre',
					fieldLabel:'Estado',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:10
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'ESTCOM.nombre'
			};

			// txt nombre
			Atributos[11]={
				validacion:{
					name:'codigo_proceso',
					fieldLabel:'Código',
					allowBlank:false,
					maxLength:20,
					minLength:0,
					selectOnFocus:true,
					grid_visible:false,
					width:'50%'
				},
				tipo: 'TextField',
				save_as:'codigo_proceso'
			};

			// txt observaciones
			Atributos[12]={
				validacion:{
					name:'observaciones_proceso',
					fieldLabel:'Observaciones',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:false,
					width:'100%'
				},
				tipo: 'TextArea'
			};

			// txt nombre
			Atributos[13]={
				validacion:{
					name:'num_solicitud_peri',
					fieldLabel:'Periódo / Nº',
					grid_visible:true,
					grid_editable:false,
					width_grid:110,
					grid_indice:1
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'SOLCOM.num_solicitud#SOLCOM.periodo'
			};

			Atributos[14]={
				validacion:{
					labelSeparator:'',
					name:'simplificada',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo:'Field',
				filtro_0:false
			};

			Atributos[15]={
				validacion:{
					name:'tipo_recibo',
					fieldLabel:'Tipo Recibo',
					allowBlank:false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',
					store: new Ext.data.SimpleStore({
						fields: ['ID','valor'],
						data : [['provisorio','Provisorio'],['pago','de Pago']]
					}),
					valueField:'ID',
					disabled:true,
					displayField:'valor',
					mode: 'local',
					grid_visible:false,
					grid_editable:false,
					value:'provisorio'

				},
				tipo: 'ComboBox',
				filtro_0:false
			};


			Atributos[16]={//22
				validacion:{
					name:'id_comprador',
					fieldLabel:'Comprador',
					allowBlank:false,
					emptyText:'Comprador...',
					//desc: 'desc_tipo_adq', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_id_comprador,
					valueField: 'id_comprador',
					displayField: 'desc_empleado',
					queryParam: 'filterValue_0',
					filterCol:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre',
					typeAhead:false,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:100,
					minListWidth:'80%',
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					grid_visible:false,
					width:'80%'
				},
				tipo:'ComboBox',
				form: true
			};
			Atributos[17]={
				validacion:{
					name:'permite_agrupar',
					fieldLabel:'Permite Agrupar',
					grid_visible:true,
					grid_editable:false,
					width_grid:110,
					grid_indice:12
				},
				tipo: 'Field',
				form: false,
				filtro_0:false,
				filterColValue:'SOLCOM.permite_agrupar'
			};


			Atributos[18]={
				validacion:{
					name:'pago_variable',
					fieldLabel:'Plande de Pago variable',
					allowBlank:true,
					typeAhead:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({
						fields:['ID', 'valor'],
						data:[['si','si'],['no','no']]
					}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:false,
					width:50
				},
				tipo:'ComboBox',
				defecto:'no',
				filtro_0:false,
				form:true
			};


			//////////////////////////////////////////////////////////////
			// ----------            FUNCIONES RENDER    ---------------//
			//////////////////////////////////////////////////////////////
			function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

			//---------- INICIAMOS LAYOUT DETALLE

			if(bandera=='Bien'){
				config={titulo_maestro:'compra_rapida',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/compra_rapida/compra_rapida_bien_det.php'};
			}
			else{

				var config={titulo_maestro:'compra_rapida',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/compra_rapida/compra_rapida_serv_det.php'};

			}



			var layout_com_rap_bien=new DocsLayoutMaestroDetalleEP(idContenedor);

			layout_com_rap_bien.init(config);




			////////////////////////
			// INICIAMOS HERENCIA //
			////////////////////////


			this.pagina=Pagina;
			//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
			this.pagina(paramConfig,Atributos,ds,layout_com_rap_bien,idContenedor);
			var getComponente=this.getComponente;
			var getSelectionModel=this.getSelectionModel;
			var ClaseMadre_conexionFailure=this.conexionFailure;
			var CM_btnEdit=this.btnEdit;
			var cm_EnableSelect=this.EnableSelect;
			var CM_ocultarComponente=this.ocultarComponente;
			var CM_mostrarComponente= this.mostrarComponente;
			var ClaseMadre_conexionFailure=this.conexionFailure;
			var ClaseMadre_btnActualizar=this.btnActualizar;

			///////////////////////////////////
			// DEFINICIÓN DE LA BARRA DE MENÚ//
			///////////////////////////////////

			var paramMenu={
				actualizar:{crear:true,separador:false}
			};

			//////////////////////////////////////////////////////////////////////////////
			//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
			//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
			//////////////////////////////////////////////////////////////////////////////

			//datos necesarios para el filtro
			var paramFunciones={
				Save:{url:direccion+'../../../control/solicitud_compra/ActionGuardarCompraRapida.php'},
				Formulario:{
					titulo:'Proceso',
					html_apply:"dlgInfo-"+idContenedor,
					width:'45%',
					height:'30%',
					minWidth:80,
					minHeight:10,
					columnas:['95%'],
					closable:true,
					grupos:[{
						tituloGrupo:'Datos Proceso',
						columna:0,
						id_grupo:0
					}
					]
				}
			}

			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

			//Para manejo de eventos
			function iniciarEventos(){
				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_com_rap_bien.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_com_rap_bien.getIdContentHijo()).pagina.bloquearMenu()
					}
				});

				cmpTipoRecibo=getComponente('tipo_recibo');
				cmpIdComprador=getComponente('id_comprador');
				cmpPago_variable=getComponente('pago_variable');
				
				

				var onTipoReciboSelect=function(e){

					if(cmpTipoRecibo.getValue()=='pago'){
						CM_ocultarComponente(cmpIdComprador);
						cmpIdComprador.disable();

					}
					else{
						CM_mostrarComponente(cmpIdComprador);
						cmpIdComprador.enable();
					}
				};
				cmpTipoRecibo.on('select',onTipoReciboSelect);

			}

			function btn_fin_pro_rap(){
				var sm=getSelectionModel(), NumSelect=sm.getCount();
				if(NumSelect!=0){
					simplificada='NO';
					Ext.Ajax.request({
						url:direccion+"../../../control/solicitud_compra/ActionVerificarDetalleProceso.php",
						success:cargar_respuesta,
						params:{'id_solicitud_compra':sm.getSelected().data.id_solicitud_compra},
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					})

				}
				else{
					Ext.MessageBox.alert('Estado','Debe seleccionar una Solicitud.')
				}
			}


			function btn_fin_pro_sim(){
				var sm=getSelectionModel(), NumSelect=sm.getCount();

				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					if(SelectionsRecord.data.avance=='si'){
						Ext.MessageBox.alert('Estado', 'Solicitudes asociadas a Cuentas Documentadas van por Proceso Regular');
					}else{
						if(parseFloat(SelectionsRecord.data.gestion_sgte)>0){
							Ext.MessageBox.alert('Estado', 'Solicitudes con detalles a pagarse en la siguiente gestion van por Proceso Regular');
						}else{
							simplificada='SI';
							ds_id_comprador.baseParams={
								id_depto:SelectionsRecord.data.id_depto
							}
							Ext.Ajax.request({
								url:direccion+"../../../control/solicitud_compra/ActionVerificarDetalleProceso.php",
								success:cargar_respuesta,
								params:{'id_solicitud_compra':sm.getSelected().data.id_solicitud_compra},
								failure:ClaseMadre_conexionFailure,
								timeout:paramConfig.TiempoEspera
							})
						}
					}

				}
				else{
					Ext.MessageBox.alert('Estado','Debe seleccionar una Solicitud.')
				}
			}

			function btn_correccion(){
				data='';
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					Ext.MessageBox.show({
						title: 'Observaciones de Corrección',
						msg: 'Ingrese observaciones para corrección:',
						width:300,
						buttons: Ext.MessageBox.OK,
						multiline: true,
						fn: getObservacionesC

					});
					data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
					data=data+'&operacion=correccion';


				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}

			function getObservacionesC(btn,text){
				if(btn!='cancel'){
					observaciones=text;

					data=data+'&observaciones='+observaciones;
					data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";

					Ext.Ajax.request({
						url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
						method:'GET',
						success:esteSuccessC,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
					});}
			}

			function esteSuccessC(resp){
				if(resp.responseXML&&resp.responseXML.documentElement){

					ClaseMadre_btnActualizar();
				}
				else{
					ClaseMadre_conexionFailure();
				}
			}


			function cargar_respuesta(resp){

				Ext.MessageBox.hide();
				if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
				{
					var root=resp.responseXML.documentElement;
					var mensaje='¿Está seguro de Iniciar el Proceso?';
					if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='existe'){
						mensaje='Esta solicitud tiene detalles en uno o mas procesos. ¿Desea continuar?'
					}
					if(confirm(mensaje)){


						getComponente('simplificada').setValue(simplificada);
						if(simplificada=='SI'){
							getComponente('codigo_proceso').disable();
							getComponente('observaciones_proceso').disable();
							CM_ocultarComponente(getComponente('codigo_proceso'));
							CM_ocultarComponente(getComponente('observaciones_proceso'));
							CM_ocultarComponente(cmpPago_variable);
							cmpPago_variable.disable();
							cmpTipoRecibo.enable();
							cmpIdComprador.enable();
							CM_mostrarComponente(cmpTipoRecibo);
							CM_mostrarComponente(cmpIdComprador);
							cmpTipoRecibo.setValue('provisorio')

						}
						else{
							getComponente('codigo_proceso').enable();
							getComponente('observaciones_proceso').enable();
							CM_mostrarComponente(getComponente('codigo_proceso'));
							CM_mostrarComponente(getComponente('observaciones_proceso'));
							CM_mostrarComponente(cmpPago_variable);
							cmpPago_variable.enable();
							cmpPago_variable.setValue('no')
							cmpTipoRecibo.disable();
							cmpIdComprador.disable();
							CM_ocultarComponente(cmpTipoRecibo);
							CM_ocultarComponente(cmpIdComprador);

						}
						CM_btnEdit()
					}


				}
			}



			this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_com_rap_bien.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_com_rap_bien.getIdContentHijo()).pagina.desbloquearMenu();
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_com_rap_bien.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);


			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/proc.png','Iniciar Proceso de Compra Regular',btn_fin_pro_rap,true,'finprorab','');
			this.AdicionarBoton('../../../lib/imagenes/procsim.png','Iniciar Compra Simplificada',btn_fin_pro_sim,true,'finprorasimb','');
			this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Corrección',btn_correccion,true,'pedir_correccion','Corrección');
			this.iniciaFormulario();

			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					tipo_adq:bandera
				}
			});

			iniciarEventos();
			layout_com_rap_bien.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}