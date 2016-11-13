/**
* Nombre:		  	    pagina_proceso_compra_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pag_proc_bien_mul(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0,cmpIdComprador;
	var cmpCodigo_proceso,cmpId_moneda,cmpObservaciones,cmpTipoRecibo,cmpDesc_tipo_adq,cmpIdParametroAdq,cmpNorma;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompraMul.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_proceso_compra',totalRecords:'TotalCount'
		},[
		'id_proceso_compra',
		'observaciones',
		'codigo_proceso',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_vigente',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_categoria_adq',
		'desc_categoria_adq',
		'id_moneda',
		'desc_moneda',
		'num_cotizacion',
		'num_proceso',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_cotizacion_sis',
		'num_proceso_sis',
		{name: 'fecha_proc',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_adq',
		'tipo_adq',
		'id_tipo_adq',
		'id_parametro_adquisicion',
		'id_periodo',
		'norma',
		'id_depto'

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



			var ds_gestion_paradq= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_adquisicion/ActionListarGestionParametroAdq.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_adquisicion',totalRecords: 'TotalCount'},['id_parametro_adquisicion','gestion','id_gestion'])
			});
			
			function render_id_gestion_paradq(value, p, record){return String.format('{0}', record.data['gestion'])}
            var tpl_gestionParadq = new Ext.Template('<div class="search-item">','<b>{gestion}</b>','</div>');


			//FUNCIONES RENDER

			/////////////////////////
			// Definición de datos //
			/////////////////////////

			// hidden id_proceso_compra
			//en la posición 0 siempre esta la llave primaria

			Atributos[0]={
				validacion:{
					labelSeparator:'',
					name: 'id_proceso_compra',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false
			};


			// txt codigo_proceso
			Atributos[1]={
				validacion:{
					name:'codigo_proceso',
					fieldLabel:'Código de Proceso',
					allowBlank:false,
					maxLength:20,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					grid_indice:1,
					width_grid:100,
					width:'100%'
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'PROCOM.codigo_proceso'
			};

			Atributos[2]={
				validacion:{
					name:'num_proceso',
					fieldLabel:'Nº Proceso',
					grid_visible:true,
					grid_indice:2,
					grid_editable:false,
					width_grid:100
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'PROCOM.num_proceso'
			};
			// txt num_cotizacion
			Atributos[3]={
				validacion:{
					name:'num_cotizacion',
					fieldLabel:'Nº Cotización',
					grid_visible:true,
					grid_indice:3,
					grid_editable:false,
					width_grid:100
				},
				tipo:'Field',
				form:false,
				filtro_0:true,
				filterColValue:'PROCOM.num_cotizacion'
			};

			// txt observaciones
			Atributos[4]={
				validacion:{
					name:'observaciones',
					fieldLabel:'Observaciones',
					allowBlank:true,
					maxLength:300,
					vtype:'texto',
					grid_visible:true,
					grid_editable:true,
					width_grid:100,
					width:'100%'
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'PROCOM.observaciones'
			};

			// txt fecha_reg
			Atributos[5]= {
				validacion:{
					name:'fecha_reg',
					fieldLabel:'Fecha registro',
					allowBlank:true,
					format: 'd/m/Y', //formato para validacion
					grid_visible:true,
					grid_editable:false,
					renderer: formatDate,
					width_grid:85
				},
				form:false,
				tipo:'DateField',
				filtro_0:true,
				filterColValue:'PROCOM.fecha_reg',
				dateFormat:'m-d-Y'
			};

			/*/ txt gestion
			Atributos[6]={
				validacion:{
					name:'gestion',
					fieldLabel:'Gestion',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					width:'100%'
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'PROCOM.gestion'
			};*/
			
		Atributos[6]={
			validacion:{
					name:'id_parametro_adquisicion',
					fieldLabel:'Gestion',
					allowBlank:false,
					emptyText:'Gestion...',
					desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_gestion_paradq,
					renderer:render_id_gestion_paradq,
					valueField: 'id_parametro_adquisicion',
					displayField: 'gestion',
					queryParam: 'filterValue_0',
					filterCol:'GESTIO.gestion',
					typeAhead:true,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					queryParam:'filterValue_0',
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					grid_visible:true,
					grid_editable:false,
					width_grid:90,
					width:'100%'
				},
				tipo:'ComboBox',
				form: true,
				filtro_0:true,
				filterColValue:'PROCOM.gestion'
			};
			
			
			
			
			
			// txt estado_vigente
			Atributos[7]={
				validacion:{
					name:'estado_vigente',
					fieldLabel:'Estado Vigente',
					grid_visible:true,
					grid_editable:false,
					width_grid:100
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'PROCOM.estado_vigente'
			};


			// txt siguiente_estado
			Atributos[8]={
				validacion:{
					name:'siguiente_estado',
					fieldLabel:'Siguiente Estado',
					grid_visible:true,
					grid_editable:false,
					width_grid:100
				},
				tipo: 'Field',
				form: false,
				filtro_0:true,
				filterColValue:'PROCOM.siguiente_estado'
			};

			// txt fecha_reg
			Atributos[9]={
				validacion:{
					name:'fecha_proc',
					fieldLabel:'Fecha Proceso',
					format: 'd/m/Y', //formato para validacion
					grid_visible:true,
					grid_editable:false,
					renderer: formatDate,
					width_grid:85,
					disabled:false
				},
				form:true,
				tipo:'DateField',
				filtro_0:true,
				filterColValue:'PROCOM.fecha_proc',
				dateFormat:'m-d-Y'
			};

			Atributos[10]={//28
				validacion:{
					name:'id_tipo_adq',
					labelSeparator:'',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo:'Field',
				filtro_0:false
			};

			Atributos[11]={
				validacion:{
					name:'desc_tipo_adq',
					fieldLabel:'Tipo Adquisicion',
					allowBlank:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					width:'45%',
					grid_indice:4
				},
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'TIPADQ.nombre'
			};
			
			Atributos[12]={
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

			Atributos[13]={//22
				validacion:{
					name:'id_comprador',
					fieldLabel:'Comprador',
					allowBlank:false,
					emptyText:'Comprador...',
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
			
			Atributos[14]={
			validacion:{
				fieldLabel:'Norma',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data : [['SABS','SABS'],['EPNE','EPNE']] 
				}),
				valueField:'ID',
				displayField:'valor',
				mode: 'local',
				name: 'norma',
				grid_indice:6,
				grid_visible:true,
				grid_editable:false,
				value:'SABS'
			},
			tipo: 'ComboBox',
			filtro_0:false
		};



			//////////////////////////////////////////////////////////////
			// ----------            FUNCIONES RENDER    ---------------//
			//////////////////////////////////////////////////////////////
			function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

			//---------- INICIAMOS LAYOUT DETALLE
			var config={titulo_maestro:'proceso_compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_item_det.php'};
			var layout_pro_bien_mul=new DocsLayoutMaestroDeatalle(idContenedor);
			layout_pro_bien_mul.init(config);
			
			
			////////////////////////
			// INICIAMOS HERENCIA //
			////////////////////////


			this.pagina=Pagina;
			//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
			this.pagina(paramConfig,Atributos,ds,layout_pro_bien_mul,idContenedor);
			var getComponente=this.getComponente;
			var getSelectionModel=this.getSelectionModel;
			var Cm_conexionFailure=this.conexionFailure;
			var cmbtnActualizar=this.btnActualizar;
			var CM_btnNew=this.btnNew;
			var CM_btnEdit=this.btnEdit;
			var getDialog=this.getDialog;
			var ocultarFormulario=this.ocultarFormulario;
			var getFormulario=this.getFormulario;
			var mostrarFormulario=this.mostrarFormulario;
			var enableSelect=this.EnableSelect;


			///////////////////////////////////
			// DEFINICIÓN DE LA BARRA DE MENÚ//
			///////////////////////////////////

			var paramMenu={
				guardar:{crear:true,separador:false},
				nuevo:{crear:true,separador:true},
				editar:{crear:true,separador:false},
				eliminar:{crear:true,separador:false},
				actualizar:{crear:true,separador:false}
			};


			//////////////////////////////////////////////////////////////////////////////
			//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
			//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
			//////////////////////////////////////////////////////////////////////////////

			//datos necesarios para el filtro
			var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/proceso_compra/ActionEliminarProcesoCompraMul.php'},
				Save:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraMul.php'},
				ConfirmSave:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraMul.php'},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso_compra'}};
				//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//



				function btn_solicitud_proceso_compra(){
					var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
					if(NumSelect!=0){
						var SelectionsRecord=sm.getSelected();
						var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
						data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
						data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
						data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
						data=data+'&m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq;
						data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
						data=data+'&m_gestion='+SelectionsRecord.data.gestion;
						data=data+'&m_id_gestion='+SelectionsRecord.data.id_gestion;
						
						
						data=data+'&m_id_parametro_adquisicion='+SelectionsRecord.data.id_parametro_adquisicion;
						
					
						
						data=data+'&m_desc_tipo_adq='+encodeURIComponent(SelectionsRecord.data.desc_tipo_adq);
						data=data+'&m_id_depto='+SelectionsRecord.data.id_depto;
						data=data+'&m_norma='+SelectionsRecord.data.norma;

						var ParamVentana={Ventana:{width:'90%',height:'90%'},title:"Solicitudes de Bienes"}
						layout_pro_bien_mul.loadWindows(direccion+'../../../../sis_adquisiciones/vista/solicitud_proceso_compra/solicitud_proceso_bien.php?'+data,'Solicitudes de Compra',ParamVentana);
						layout_pro_bien_mul.getVentana().on('resize',function(){
							layout_pro_bien_mul.getLayout().layout();
						})
					}
					else
					{
						Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
					}
				}



				this.btnNew=function(){
					preparaNewEdit();
					getComponente('fecha_proc').enable();
					mostrarComponente(getComponente('fecha_proc'));
					CM_btnNew();
					get_bienes();
					cmpIdParametroAdq.enable()
				};

				this.btnEdit=function(){
					preparaNewEdit();
					getComponente('fecha_proc').disable();
					mostrarComponente(getComponente('fecha_proc'));
					CM_btnEdit()
					

				};

				function preparaNewEdit(){

					getDialog().buttons[3].hide();
					getDialog().buttons[4].hide();
					getDialog().buttons[0].show();
					getDialog().buttons[1].show();
					getDialog().buttons[2].show();
					cmpCodigo_proceso.enable();
					cmpNorma.enable();
					//cmpId_moneda.enable();
					cmpObservaciones.enable();
					cmpIdParametroAdq.disable();
					cmpDesc_tipo_adq.disable();
					mostrarComponente(cmpCodigo_proceso);
					mostrarComponente(cmpIdParametroAdq);
					mostrarComponente(cmpNorma);
					//mostrarComponente(cmpId_moneda);
					mostrarComponente(cmpObservaciones);
					mostrarComponente(cmpDesc_tipo_adq);
					cmpIdComprador.disable();
					ocultarComponente(cmpIdComprador);
					cmpTipoRecibo.disable();
					ocultarComponente(cmpTipoRecibo);
					
				}




				function btn_fin_pro(){
					var sm=getSelectionModel(), NumSelect=sm.getCount();
					if(NumSelect!=0){
						if(confirm("¿Está seguro de Iniciar el Proceso Regular?")){
							Ext.Ajax.request({
								url:direccion+"../../../control/proceso_compra/ActionIniciarProcesoCompra.php",
								success:cmbtnActualizar,
								params:{'id_proceso_compra':sm.getSelected().data.id_proceso_compra},
								failure:Cm_conexionFailure,
								timeout:paramConfig.TiempoEspera
							})
						}
					}
					else{
						Ext.MessageBox.alert('Estado','Debe seleccionar un Prcoeso.')
					}
				}




				function btn_fin_pro_sim(){

					var sm=getSelectionModel(), NumSelect=sm.getCount();
					if(NumSelect!=0){

						getDialog().buttons[3].show();
						getDialog().buttons[4].show();
						getDialog().buttons[0].hide();
						getDialog().buttons[1].hide();
						getDialog().buttons[2].hide();

						cmpCodigo_proceso.disable();
						cmpNorma.disable();
						//cmpId_moneda.disable();
						cmpObservaciones.disable();
						cmpDesc_tipo_adq.disable();
						cmpIdParametroAdq.disable();

						ocultarComponente(cmpCodigo_proceso);
						ocultarComponente(cmpNorma);
						//ocultarComponente(cmpId_moneda);
						ocultarComponente(cmpObservaciones);
						ocultarComponente(cmpDesc_tipo_adq);
						ocultarComponente(cmpIdParametroAdq);
						ocultarComponente(getComponente('fecha_proc'));
						

						cmpIdComprador.enable();
						mostrarComponente(cmpIdComprador);
						
						cmpTipoRecibo.enable();
						mostrarComponente(cmpTipoRecibo);
						cmpTipoRecibo.setValue('provisorio')
						
						getFormulario().reset();
						mostrarFormulario()
					}

				}


				function get_bienes(){
					Ext.Ajax.request({
						url:direccion+"../../../control/tipo_adq/ActionListarTipoAdq.php?tipo_adq=bien",
						method:'GET',
						success:cargar_tipo,
						failure:Cm_conexionFailure,
						timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
					});
				}

				function cargar_tipo(resp){
					if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
						var root = resp.responseXML.documentElement;
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
							getComponente('desc_tipo_adq').setValue(root.getElementsByTagName('nombre')[0].firstChild.nodeValue);
							getComponente('id_tipo_adq').setValue(root.getElementsByTagName('id_tipo_adq')[0].firstChild.nodeValue);
						}
					}
				}





				
				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_pro_bien_mul.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_pro_bien_mul.getIdContentHijo()).pagina.bloquearMenu()
					}
				});


				this.EnableSelect=function(sm,row,rec){
					enable(sm,row,rec)
					
					_CP.getPagina(layout_pro_bien_mul.getIdContentHijo()).pagina.reload(rec.data);
					_CP.getPagina(layout_pro_bien_mul.getIdContentHijo()).pagina.desbloquearMenu();
				};


				//para que los hijos puedan ajustarse al tamaño
				this.getLayout=function(){return layout_pro_bien_mul.getLayout()};
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones

				//para agregar botones
				this.AdicionarBoton('../../../lib/imagenes/detalle.png','Solicitudes de Compra',btn_solicitud_proceso_compra,true,'solprocomb','');
		
				this.AdicionarBoton('../../../lib/imagenes/proc.png','Iniciar Proceso de Compra Regular',btn_fin_pro,true,'finprob','');
				this.AdicionarBoton('../../../lib/imagenes/procsim.png','Iniciar Compra Simplificada de Bienes',btn_fin_pro_sim,true,'finprosimb','');
				var CM_getBoton=this.getBoton;

				this.iniciaFormulario();
				//Para manejo de eventos
				function iniciarEventosFormularios(){
					
					
					//para iniciar eventos en el formulario
					cmpCodigo_proceso=getComponente('codigo_proceso');
					cmpNorma=getComponente('norma');
					//cmpId_moneda=getComponente('id_moneda');
					cmpObservaciones=getComponente('observaciones');
					cmpDesc_tipo_adq=getComponente('desc_tipo_adq');
					cmpId_tipo_adq=getComponente('id_tipo_adq');
					cmpIdComprador=getComponente('id_comprador');
					cmpIdParametroAdq=getComponente('id_parametro_adquisicion');


					cmpTipoRecibo=getComponente('tipo_recibo');
					
					
					var onTipoReciboSelect=function(e){

						if(cmpTipoRecibo.getValue()=='pago'){
							ocultarComponente(cmpIdComprador);
							cmpIdComprador.disable();

						}
						else{
							mostrarComponente(cmpIdComprador);
							cmpIdComprador.enable();

						}

					};

					cmpTipoRecibo.on('select',onTipoReciboSelect);
					
					/*27/04/10: FER-MOD-AD-07*/
					var onFechaProc=function(e){ 
						if(e.getValue()!=null&&e.getValue()!=undefined)
						{   var mFecha='31/12/'+e.getRawValue();
							getComponente('fecha_proc').setValue(mFecha);
							getComponente('fecha_proc').maxValue=getComponente('fecha_proc').getValue();
							var miGestion=new Date();
							miGestion=miGestion.getFullYear();
							
							if(parseFloat(e.getRawValue())<parseFloat(miGestion)){
								getComponente('fecha_proc').setValue(getComponente('fecha_proc').getValue());
							}else{
								getComponente('fecha_proc').setValue(new Date());
							}
						}
					}
					
					cmpIdParametroAdq.on('select',onFechaProc);
					cmpIdParametroAdq.on('change',onFechaProc);
					
					
					cmpIdComprador.disable();
					ocultarComponente(cmpIdComprador);
					
					cmpTipoRecibo.disable();
					ocultarComponente(cmpTipoRecibo)
					

					getDialog().addButton('Iniciar',function(){

						var sm=getSelectionModel(), NumSelect=sm.getCount();
						if(NumSelect!=0){

							if(getFormulario().isValid()){

								if(confirm("¿Está seguro de Iniciar el Proceso Simplificado?")){
									Ext.Ajax.request({
										url:direccion+"../../../control/proceso_compra/ActionIniciarProcesoCompraSimplificado.php",
										success:findefProc,
										params:{'id_proceso_compra':sm.getSelected().data.id_proceso_compra,'id_comprador':cmpIdComprador.getValue(),'tipo_recibo':cmpTipoRecibo.getValue()},
										failure:Cm_conexionFailure,
										timeout:paramConfig.TiempoEspera
									})
								}

							}


						}
						else{
							Ext.MessageBox.alert('Estado','Debe seleccionar un Prcoeso.')
						}

					});
					getDialog().addButton('Cancelar',ocultarFormulario);

					getDialog().buttons[3].hide();
					getDialog().buttons[4].hide();



					CM_getBoton('finprob-'+idContenedor).disable();
					CM_getBoton('finprosimb-'+idContenedor).disable();

					getSelectionModel().on('rowdeselect',function(){

						CM_getBoton('finprob-'+idContenedor).disable();
						CM_getBoton('finprosimb-'+idContenedor).disable();

					});

				}

				function findefProc(){
					getDialog().hide();
					cmbtnActualizar()
				}



				function  enable(sel,row,selected){
					var record=selected.data;

					if(selected&&record!=-1){

						CM_getBoton('finprob-'+idContenedor).enable();
						CM_getBoton('finprosimb-'+idContenedor).enable();
					}
					enableSelect(sel,row,selected);
				}

				iniciarEventosFormularios();


				//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						tipo_adq:'Bien'
					}
				});
				layout_pro_bien_mul.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}