<?php
/**
 * Nombre:		  	    asignacion_equipo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		28-04-2016
 *
 */
session_start ();?>
//<script>
function main(){
 	<?php
		// obtenemos la ruta absoluta
		$host = $_SERVER ['HTTP_HOST'];
		$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
		echo "var idContenedor='$idContenedor';";
		
		?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_empleado:<?php echo $id_empleado;?>};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={pagina:new pagina_asignacion_equipo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);


}
Ext.onReady(main,main);
/**
* Nombre:		  	    pagina_asignacion_equipo.js
* Propósito: 			pagina objeto principal
* Autor:				Mercedes Zambrana Meneses
* Fecha creación:		28-04-2016
*/
function pagina_asignacion_equipo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){ 
	var Atributos=new Array,sw=0, g_pago, m_bandera;
	var filterCols_asignacion_equipo=new Array();
	    				filterValues_asignacion_equipo=new Array();
	var mi_array=new Array;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asignacion_equipo/ActionListarAsignacionEquipo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_asignacion_equipo',totalRecords:'TotalCount'
		},[
		'id_asignacion_equipo',
		'id_equipo',
		'id_plan_llamada',
		'id_empleado',
		'id_correspondencia',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'usuario_reg',
		'nro_asignacion',
		'desc_plan_llamada',		
		'nombre_completo','desc_correspondencia','desc_equipo',
		'id_componente','desc_componente','id_linea','desc_linea','tipo_asignacion'
		]),remoteSort:true});

		var ds_id_equipo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_telefonico/control/equipos/ActionListarEquipo.php?sin_asignar=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_equipo',totalRecords: 'TotalCount'},
		['id_equipo','modelo','marca','observaciones'])
		});
		
		var ds_id_plan_llamada = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_telefonico/control/plan_llamada/ActionListarPlanLlamada.php?estado=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_plan_llamada',totalRecords: 'TotalCount'},
			['id_plan_llamada','nombre','monto_llamada', 'monto_datos','tarifa_win'])
			});
		
		var ds_id_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/empleado/ActionListarEmpleado.php'}),
				reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','apellido_paterno','apellido_materno','nombre','codigo_empleado'])
		    });

		var ds_id_correspondencia = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_flujo/control/correspondencia/ActionListarCorrespondencia.php?sol=1&vista=enviado&tipo=interna'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_correspondencia',totalRecords: 'TotalCount'},['id_correspondencia','numero','desc_empleado','desc_documento','referencia'])
			});

	/*	var ds_id_componente = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_telefonico/control/componente/ActionListarComponente.php?sin_asignar=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_componente',totalRecords: 'TotalCount'},['id_componente','imei','sim_card','estado_reg','fecha_ini'])
			});*/

		var ds_id_linea = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_telefonico/control/linea/ActionListarLinea_det.php?m_id_tipo_llamada=2&sin_asignar=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_linea',totalRecords: 'TotalCount'},['id_linea','numero_telefono','empresa','sim_card'])
			});
	  	//FUNCIONES RENDER

		function render_id_equipo(value, p, record){return String.format('{0}', record.data['desc_equipo']);}
		var tpl_id_equipo=new Ext.Template('<div class="search-item">','<b>Marca:</b> {marca} ','<br><FONT COLOR="#B5A642"><b>Modelo:</b> {modelo}</FONT>','<br><b>Accesorios:</b> {observaciones}','</div>');

		function render_id_plan_llamada(value, p, record){return String.format('{0}', record.data['desc_plan_llamada']);}
		var tpl_id_plan_llamada=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">Monto Datos:{monto_datos}</FONT>','<br>Monto Llamada:{monto_llamada}','</div>');
		
	    function render_id_empleado(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','{nombre_completo}','</div>');
		
		function render_id_correspondencia(value, p, record){return String.format('{0}', record.data['desc_correspondencia']);}
		var tpl_id_correspondencia=new Ext.Template('<div class="search-item">','<b>{desc_documento} -','{numero}</b>','<br><FONT COLOR="#B5A642">{desc_empleado}</FONT>','<br>{referencia}','</div>');

		/*function render_id_componente(value, p, record){return String.format('{0}', record.data['desc_componente']);}
		var tpl_id_componente=new Ext.Template('<div class="search-item">','<b>{imei}</b>','<br><FONT COLOR="#B5A642">{sim_card}</FONT>','</div>');
		*/
		function render_id_linea(value, p, record){return String.format('{0}', record.data['desc_linea']);}
		var tpl_id_linea=new Ext.Template('<div class="search-item">','<b>{numero_telefono}</b>','<br><FONT COLOR="#B5A642">{empresa}</FONT>','<br><b>Sim Card:</b> {sim_card}','</div>');
		
			/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_columna_tipo
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_asignacion_equipo',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

		// txt id_empleado
		Atributos[1]={
			validacion:{
				name:'id_empleado',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_empleado
		};


		Atributos[2]={//35
				validacion:{
					name:'nro_asignacion',
					fieldLabel:'Numeración',
					allowBlank:true,
					maxLength:30,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					align:'right',
					width:'40%',
					disabled:false
				},
				tipo: 'TextField',
				form:false,
				filtro_0:true,
				filtro_1:true,
				filterColValue:'ASIGEQ.nro_asignacion',
				save_as:'nro_asignacion'
				
			};
		
		Atributos[3]={
			validacion:{
				name:'id_equipo',
				fieldLabel:'Equipo',
				allowBlank:false,
				//emptyText:'Presupuesto...',
				desc: 'desc_equipo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_id_equipo,
				valueField: 'id_equipo',
				displayField: 'marca',
				queryParam: 'filterValue_0',
				filterCol:'EQUIPO.modelo#EQUIPO.marca',
				typeAhead:false,
				tpl:tpl_id_equipo,
				forceSelection:true,
				mode:'remote',
				queryDelay:180,
				pageSize:10,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_equipo,
				confTrigguer:{
					url:direccion+'../../../../sis_telefonico/vista/equipo/equipo.php',
				    paramTri:'prueba:XXX',		
				    title:'Equipo',
				    param:{width:800,height:800},
				    idContenedor:idContenedor,
				   // clase_vista:'pagina_persona'
				},	
				grid_visible:true,
				grid_editable:false,
				width_grid:200,
				
				width:'100%'
			},
			tipo:'ComboTrigger',
			form: true,
			filtro_0:true,
			filterColValue:'EQUIPO.nombre'
			
		};


		Atributos[4]={
				validacion:{
					name:'id_linea',
					fieldLabel:'Linea',
					allowBlank:false,
					//emptyText:'Presupuesto...',
					desc: 'desc_linea', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_id_linea,
					valueField: 'id_linea',
					displayField: 'numero_telefono',
					queryParam: 'filterValue_0',
					filterCol:'LINEA.numero_telefono',
					typeAhead:false,
					tpl:tpl_id_linea,
					forceSelection:true,
					mode:'remote',
					queryDelay:135,
					pageSize:10,
					minListWidth:150,
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_linea,
					confTrigguer:{
						url:direccion+'../../../../sis_telefonico/vista/linea/linea_det.php',
					    paramTri:'prueba:XXX',		
					    title:'Linea',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
					},	
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					
					width:'100%'
				},
				tipo:'ComboTrigger',
				form: true,
				filtro_0:true,
				filterColValue:'LINEA.numero_telefono'
				
			};

		/*Atributos[5]={
				validacion:{
					name:'id_componente',
					fieldLabel:'Chip',
					allowBlank:false,
					//emptyText:'Presupuesto...',
					desc: 'desc_componente', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_id_componente,
					valueField: 'id_componente',
					displayField: 'imei',
					queryParam: 'filterValue_0',
					filterCol:'COMPON.imei#COMPON.sim_card',
					typeAhead:false,
					tpl:tpl_id_componente,
					forceSelection:true,
					mode:'remote',
					queryDelay:160,
					pageSize:10,
					minListWidth:180,
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_componente,
					confTrigguer:{
						url:direccion+'../../../../sis_telefonico/vista/chip/componente.php',
					    paramTri:'prueba:XXX',		
					    title:'Componente',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
					},	
					grid_visible:true,
					grid_editable:false,
					width_grid:180,
					
					width:'100%'
				},
				tipo:'ComboTrigger',
				form: true,
				filtro_0:true,
				filterColValue:'COMPON.imei'
				
			};*/
		
		Atributos[5]={
				validacion:{
				name:'id_plan_llamada',
				fieldLabel:'Plan Llamada',
				allowBlank:true,			
				emptyText:'Plan Llamada...',
				desc: 'desc_plan_llamada', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_id_plan_llamada,
				valueField: 'id_plan_llamada',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'PLALLAM.nombre#PLALLAM.monto_llamada#PLALLAM.monto_datos',
				typeAhead:true,
				tpl:tpl_id_plan_llamada,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_plan_llamada,
				grid_visible:true,
				grid_editable:false,
				width_grid:160,
				width:230,
				
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'PLALLAM.nombre#PLALLAM.monto_datos#PLALLAM.monto_llamada',
			save_as:'id_plan_llamada'
		};


		Atributos[6]={
				validacion:{
					name:'id_correspondencia',
					fieldLabel:'Correspondencia',
					allowBlank:true,
					store:ds_id_correspondencia,	
					//maestroValField:'correspondencia_asociada',
					valueField: 'id_correspondencia',
					displayField: 'desc_correspondencia',				
					queryParam: 'filterValue_0',
					filterCol:'CORRE.numero#EMPLE.nombre_completo#CORRE.referencia#DOCUME.documento',
					typeAhead:false,
					tpl:tpl_id_correspondencia,				
					defValor:function(val,record){					
						var text = record['numero']+' -> '+record['referencia'];
						return text;				
					},							
					mode:'remote',
					queryDelay:250,
					pageSize:100,
					minListWidth:'100%',
					grow:true,
					resizable:true,
					grid_visible:true,
					grid_editable:false,
					renderer:render_id_correspondencia,
					queryParam:'filterValue_0',
					minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction:'all',
				    width:'85%',
				    width_grid:150
				},
				tipo:'ComboMultiple2',
				form: true,
				filtro_0:false
		};

		Atributos[7]= {
				validacion: {
					name:'tipo_asignacion',			
					fieldLabel:'Tipo Asignacion',
					allowBlank:false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['personal','personal'],['comodin','comodin']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					
					forceSelection:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:110
					
				},
				tipo:'ComboBox',
				filtro_0:false,
				
				filterColValue:'ASIGEQ.tipo_asignacion',
				save_as:'tipo_asignacion'
			};

		Atributos[8]= {
				validacion:{
					name:'fecha_ini',
					fieldLabel:'Fecha Inicio',
					allowBlank:true,
					format: 'd/m/Y', //formato para validacion
					minValue: '01/01/1900',
					disabledDaysText: 'Día no válido',
					grid_visible:true,
					grid_editable:false,
					renderer: formatDate,
					width_grid:100,
					disabled:false
				},
				form:true,
				tipo:'DateField',
				filtro_0:true,
				filterColValue:'ASIGEQ.fecha_ini',
				dateFormat:'m-d-Y',
				defecto:'',
				save_as:'fecha_ini'
			};
			
			Atributos[9]= {
					validacion:{
						name:'fecha_fin',
						fieldLabel:'Fecha Fin',
						allowBlank:true,
						format: 'd/m/Y', //formato para validacion
						minValue: '01/01/1900',
						disabledDaysText: 'Día no válido',
						grid_visible:true,
						grid_editable:false,
						renderer: formatDate,
						width_grid:100,
						disabled:false
					},
					form:true,
					tipo:'DateField',
					filtro_0:true,
					filterColValue:'ASIGEQ.fecha_fin',
					dateFormat:'m-d-Y',
					defecto:'',
					save_as:'fecha_fin'
				};

		
		Atributos[10]= {
				validacion: {
					name:'estado_reg',			
					fieldLabel:'Estado',
					allowBlank:false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:100
				},
				tipo:'ComboBox',
				filtro_0:false,
				
				filterColValue:'ASIGEQ.estado_reg',
				save_as:'estado_reg'
			};

		// txt fecha_reg
		Atributos[11]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'ASIGEQ.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''

		};
		
		

		
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'asignacion_equipo',
		grid_maestro:'grid-'+idContenedor,
		urlHijo:'../../../sis_telefonico/vista/servicio_adicional/servicio_adicional.php'};
		var layout_asignacion_equipo=new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
		layout_asignacion_equipo.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_asignacion_equipo,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var cm_EnableSelect=this.EnableSelect;
		var CM_btnNew=this.btnNew;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var CM_btnEdit=this.btnEdit;
		var dialog= this.getDialog;
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
			btnEliminar:{url:direccion+'../../../control/asignacion_equipo/ActionEliminarAsignacionEquipo.php'},
			Save:{url:direccion+'../../../control/asignacion_equipo/ActionGuardarAsignacionEquipo.php'},
			ConfirmSave:{url:direccion+'../../../control/asignacion_equipo/ActionGuardarAsignacionEquipo.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'asignacion_equipo'
			/*grupos:
			[{tituloGrupo:'Datos Fijos',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Editables',columna:0,id_grupo:1}
			]*/
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


			//funcion de reload

			this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_asignacion_equipo.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_asignacion_equipo.getIdContentHijo()).pagina.desbloquearMenu();
				enable(sm, row, rec);
			}


			this.reload=function(params){


				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_empleado=datos.id_empleado;


				Atributos[1].defecto=maestro.id_empleado;
				/*
				paramFunciones={
				btnEliminar:{url:direccion+'../../../control/planilla_presupuesto/ActionEliminarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				Save:{url:direccion+'../../../control/planilla_presupuesto/ActionGuardarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				ConfirmSave:{url:direccion+'../../../control/planilla_presupuesto/ActionGuardarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Presupuesto'}};

				*/



				this.InitFunciones(paramFunciones);

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_empleado:maestro.id_empleado
					}
				};

				this.btnActualizar()
			}

			this.btnNew=function(){  
				dialog().resizeTo(450,270);
				
				CM_ocultarComponente(getComponente('fecha_fin'));
				
				/*	
				getComponente('id_cuenta').allowBlank=true;
				getComponente('id_auxiliar').allowBlank=true;
				getComponente('id_cuenta_bancaria').allowBlank=true;
				if(maestro.id_planilla==0){ //pago de asignacion_equipoes con desembolso unico por gestion
					
					ds_id_tipo_asignacion_equipo.baseParams={
						pago_unico:'simple'
					}
					ds_id_tipo_asignacion_equipo.modificado=true;
					CM_mostrarComponente(getComponente('id_gestion'));
					getComponente('id_gestion').allowBlank=false;
					
				}else{
					CM_ocultarComponente(getComponente('id_gestion'));
					getComponente('id_gestion').allowBlank=true;
					getComponente('id_gestion').reset();
				}
				CM_ocultarComponente(getComponente('obs_pago'));
				CM_ocultarComponente(getComponente('id_institucion_acreedor'));
				CM_ocultarComponente(getComponente('id_persona'));
				CM_ocultarComponente(getComponente('id_lugar'));*/
				CM_btnNew();
			}

			
			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					
					CM_mostrarComponente(getComponente('fecha_fin'));
					
					CM_btnEdit();
				}else{
					alert('Antes debe seleccionar un item');
				}
			}
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				txt_fecha_fin=getComponente('fecha_fin');
				/*cmb_cta_bancaria=getComponente('id_cuenta_bancaria');
				cmb_institucion=getComponente('id_institucion_acreedor');
				cmb_persona=getComponente('id_persona');
				
				
				//para iniciar eventos en el formulario
				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_asignacion_equipo.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_asignacion_equipo.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
				
				
				
				var FechaPago=function(e){
					cmb_cta_bancaria.setValue('');
					ds_cuenta_bancaria.modificado=true;
					g_pago=parseFloat(e.value.substring(6,10));
					
					
					ds_cuenta_bancaria.baseParams={
						gestion:g_pago,
						tipo_vista:'tkp_asignacion_equipo'
					}
					ds_cuenta_bancaria.modificado=true;
				}
				
				txt_fecha_pago.on('change',FechaPago);
				
				
				var onInstitucion=function(e){
					if (e.value!=null && e.value!=undefined){
						getComponente('id_persona').reset();
					}
				}
				cmb_institucion.on('change',onInstitucion);
				
				
				var onPersona=function(e){
					if (e.value!=null && e.value!=undefined){
						getComponente('id_institucion_acreedor').reset();
					}
				}
				cmb_persona.on('change',onPersona);*/
			}
			
				
	/*	function btn_solicitar_pago(){
				
				var sm=getSelectionModel();
				
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelectP=sm.getCount();
				var mm=sm.getSelections();
				var m;
				
				//[i].data[parametrosDatos[0].validacion.name];
				
				if(NumSelectP!=0){
					CM_mostrarComponente(getComponente('id_institucion_acreedor'));
					CM_mostrarComponente(getComponente('id_persona'));
					
					m_bandera='no';
					mi_array=new Array();
					for(m=0;m<NumSelectP;m++){
						
						mi_array[m]=mm[m].data['id_asignacion_equipo'];
						if(mm[m].data['id_cuenta']=='' || mm[m].data['id_cuenta']==undefined || mm[m].data['id_cuenta']==null){
							m_bandera='si';
						}
					}
					if(m_bandera=='no'){
							var SelectionsRecord=sm.getSelected(); //alert(SelectionsRecord.data.id_tipo_asignacion_equipo);
							getComponente('accion_obli').setValue('pago');
							getComponente('id_tipo_asignacion_equipo').setValue(SelectionsRecord.data.id_tipo_asignacion_equipo);
							getComponente('id_asignacion_equipo').setValue(SelectionsRecord.data.id_asignacion_equipo);
							getComponente('observaciones').setValue(SelectionsRecord.data.observaciones);
							
							CM_ocultarGrupo('Datos Fijos');
							CM_mostrarGrupo('Datos Editables');
							CM_ocultarComponente(getComponente('id_cuenta'));
							CM_ocultarComponente(getComponente('id_gestion'));
							getComponente('id_gestion').allowBlank=true;
							getComponente('id_cuenta_bancaria').allowBlank=false;
							
							CM_ocultarComponente(getComponente('id_auxiliar'));
							CM_mostrarComponente(getComponente('obs_pago')); //20jun11 - pago unico asignacion_equipo
							//CM_mostrarComponente(getComponente('id_institucion_acreedor')); // 20jun11
							//CM_mostrarComponente(getComponente('id_persona')); // 20jun11
							CM_mostrarComponente(getComponente('id_lugar')); // 20jun11
							
							getComponente('mi_array').setValue(mi_array);
							getComponente('cantidad_asignacion_equipoes').setValue(NumSelectP);
							CM_btnEdit();
							sm.clearSelections();
							NumSelectP=0;
							ds.rejectChanges();
						
							
					}else{
						alert('Es necesario registrar Cuenta/auxiliar para la asignacion_equipo que no cuente con ella');
					}
				}else{
					alert('Antes debe seleccionar un item');
				}
		}*/

		function btn_reporte(){
			var sm=getSelectionModel();
			
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelectA=sm.getCount();
			if(NumSelectA!=0){
			        var seleccionados =sm.getSelected();
			
					var data='id_asignacion_equipo='+seleccionados.data.id_asignacion_equipo;
					window.open(direccion+'../../../control/asignacion_equipo/ActionPDFFormularioAsignacion.php?'+data)
			}
				
			}
		
		/*	var nombre='';
		function btn_archivo_pago(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					var data=data+'&id_subsistema=5';
					var data=data+'&id_cuenta_bancaria='+SelectionsRecord.data.id_cuenta_bancaria;
					var data=data+'&codigo='+SelectionsRecord.data.codigo;
					if(SelectionsRecord.data.codigo=='AGUIN' || SelectionsRecord.data.codigo=='AGUIN2'){
						var data=data+'&nombre=pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}else{
					    var data=data+'&nombre=pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}
					
					if(SelectionsRecord.data.codigo=='AGUIN' || SelectionsRecord.data.codigo=='AGUIN2'){
						nombre='pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}else{
						nombre='pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}
					
					
						Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarRPrincipal.php?"+data,
						success:successGenerar,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					
			}
			}*/
			
			/*function btn_sol_pago_obl(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_asignacion_equipo='+SelectionsRecord.data.id_asignacion_equipo;
					
					window.open(direccion+'../../../control/asignacion_equipo/ActionPDFSolicitudPagoasignacion_equipo.php?'+data)
				
						
			}else {
				alert ("Elija la obligación");
			}
					
					
			}*/
			
		/*function successGenerar(resp){ 
			
		  window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/planta/'+nombre);
	*/
		
			
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_asignacion_equipo.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			
 			var CM_getBoton=this.getBoton;
			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/print.gif','Formulario de Asignacion',btn_reporte,true,'reporte','Form. Asignación');
	
			
			
			
			function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){
					/*if(record.estado_reg!='borrador'){
						CM_getBoton('solicitar_pago-'+idContenedor).disable();
					}else {
						CM_getBoton('solicitar_pago-'+idContenedor).enable();
					}
					
					if(record.codigo=='SUELLIQ' || record.codigo=='QUINCENA' || record.codigo=='AGUIN' || record.codigo=='ANTICIPADO' || record.codigo=='AGUIN2' || record.codigo=='REFRIGERIO'){// aguin adicionado 19dic11
						CM_getBoton('archivo_pago-'+idContenedor).enable();
					}else{
						CM_getBoton('archivo_pago-'+idContenedor).disable();
					}*/
					
				}
			}
			/*if(maestro.id_planilla>0){
				this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte de asignacion_equipoes',btn_reporte_asignacion_equipoes,true,'ver_reporte_asignacion_equipoes','Reporte asignacion_equipoes');
			
			
				this.AdicionarBoton('../../../lib/imagenes/copy.png','Archivo Pago',btn_archivo_pago,true,'archivo_pago','Archivo de Pago TXT');
				
				this.AdicionarBoton('../../../lib/imagenes/print.gif','Solicitud Pago Obligación',btn_sol_pago_obl,true,'archivo_pago','Solicitud Pago Obligación');
			} */
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			
			
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_empleado:maestro.id_empleado
				}
			});
			layout_asignacion_equipo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			/*if(maestro.id_planilla==0){
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
			}else{*/
			_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
			//}
}

