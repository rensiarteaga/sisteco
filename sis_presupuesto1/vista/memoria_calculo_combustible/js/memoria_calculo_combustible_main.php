<?php 
/**
 * Nombre:		  	    descargo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-17 10:39:24
 *
 */
session_start();
?>
//<script>
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};

var maestro={
		id_partida_presupuesto:<?php echo utf8_decode($id_partida_presupuesto);?>,	
		id_presupuesto:'<?php echo utf8_decode($id_presupuesto);?>',
		id_parametro:'<?php echo utf8_decode($id_parametro);?>',
		nombre_financiador:'<?php echo utf8_decode($nombre_financiador);?>',
		nombre_regional:'<?php echo utf8_decode($nombre_regional);?>',
		nombre_programa:'<?php echo utf8_decode($nombre_programa);?>',
		nombre_proyecto:'<?php echo utf8_decode($nombre_proyecto);?>',
		nombre_actividad:'<?php echo utf8_decode($nombre_actividad);?>',
		desc_unidad_organizacional:'<?php echo utf8_decode($desc_unidad_organizacional);?>',
		tipo_pres:'<?php echo utf8_decode($tipo_pres);?>',
		desc_moneda:'<?php echo utf8_decode($desc_moneda);?>',
		id_moneda:'<?php echo utf8_decode($id_moneda);?>',
		tipo_memoria:'<?php echo utf8_decode($tipo_memoria);?>',
		id_partida:'<?php echo utf8_decode($id_partida);?>',
	    desc_partida:'<?php echo utf8_decode($desc_partida);?>', 	
		tipo_vista:'<?php echo utf8_decode($tipo_vista);?>' 					
	};
	
idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';

//var elemento={pagina:new pagina_agrupador_rendicion_viaticos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
var elemento={pagina:new pagina_memoria_calculo_combustible(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
//var elemento={idContenedor:idContenedor,pagina:new pagina_agrupador_rendicion_viaticos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_memoria_calculo_inversion.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-09 09:11:12
*/
//modificar  el onSelect de solicitante para que cuando elija id_tipo_categoria filtre despues los RPAs en base a la categoria que eligió y seguir modificando en la BD para que guarde!!
function pagina_memoria_calculo_combustible(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var data='';
	var monedas_for=new Ext.form.MonedaField(
	{
		name:'mes_01',
		fieldLabel:'Enero',
		allowBlank:false,
		align:'right',
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:false,
		minValue:0}
		);
		//---DATA STORE
		var ds=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/memoria_calculo/ActionListarMemoriaCalculo.php'}),
			reader:new Ext.data.XmlReader({
				record:'ROWS',id:'id_memoria_calculo',totalRecords:'TotalCount'
			},[
			'id_memoria_calculo',
			'id_concepto_ingas',
			'desc_concepto_ingas',
			'justificacion',
			'id_partida_presupuesto',
			'desc_partida_presupuesto',
			'tipo_detalle',
			'id_moneda',
			'des_moneda',
			'costo_estimado',
			'tipo_cambio',
			'total',
			'id_moneda2',
			'desc_moneda2'
			]),remoteSort:true});
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_partida_presupuesto:maestro.id_partida_presupuesto,
					tipo_memoria:maestro.tipo_memoria,
					id_moneda:maestro.id_moneda
				}
			});
			//DATA STORE COMBOS
			function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
			function italic(value){return '<i>'+value+'</i>';}
			var ds_concepto_ingas = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/concepto_ingas/ActionListarConceptoIngas.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords:'TotalCount'}, ['id_concepto_ingas','desc_ingas','id_partida','desc_partida','id_item','desc_item','id_servicio','desc_servicio','desc_ingas_item_serv']),
			baseParams:{m_id_partida : maestro.id_partida}
			});
			var ds_partida_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_presupuesto/ActionListarPartidaPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_presupuesto',totalRecords: 'TotalCount'},['id_partida_presupuesto','codigo_formulario','fecha_elaboracion','id_partida','id_presupuesto'])
			});
			var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{prioridad:1}
			});

			var ds_moneda2 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
			});
			//FUNCIONES RENDER
			function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
			var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</i></b>','</div>');
			function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
			var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');
			function render_id_moneda(value,p,record){return String.format('{0}', record.data['des_moneda'])}
			var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
			function render_id_moneda2(value, p, record){return String.format('{0}', record.data['desc_moneda2']);}
			var tpl_id_moneda2=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
			/////////////////////////
			// Definición de datos //
			/////////////////////////
			function render_tipo_memoria(value)
			{
				if(value==1){return 'Recursos'};
				if(value==2){return 'Gastos'};
				if(value==3){return 'Inversiones'};
				if(value==4){return 'Pasajes'};
				if(value==5){return 'Viajes'};
				if(value==6){return 'RRHH'};
				if(value==7){return 'Servicios'};
				if(value==8){return 'Otros Gastos'};
				if(value==9){return 'Combustibles'};
			}
			function render_moneda(value)
			{
				if(value == 1){return "Bolivianos"}
				if(value == 2){return "Dólares Americanos"}
				if(value == 3){return "Unidad de Fomento a la Vivienda"}
				if(value == 4){return "Otros"}
			}
			function renderSeparadorDeMil(value,cell,record,row,colum,store)
			{
				return monedas_for.formatMoneda(value)
			}
			// hidden id_memoria_calculo
			//en la posición 0 siempre esta la llave primaria
			Atributos[0]={
				validacion:{
					labelSeparator:'',
					name:'id_memoria_calculo',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_memoria_calculo'
			};
			// txt id_concepto_ingas
			Atributos[1]={
				validacion:{
					name:'id_concepto_ingas',
					fieldLabel:'Concepto',
					allowBlank:false,
					emptyText:'Concepto...',
					desc:'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
					desc:'desc_ingas_item_serv',
					store:ds_concepto_ingas,
					valueField:'id_concepto_ingas',
					displayField:'desc_ingas_item_serv',
					queryParam:'filterValue_0',
					filterCol:'desc_ingas_item_serv',
					typeAhead:true,
					tpl:tpl_id_concepto_ingas,
					forceSelection:true,
					mode:'remote',
					queryDelay:300,
					pageSize:10,
					minListWidth:300,
					grow:true,
					resizable:true,
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_concepto_ingas,
					grid_visible:true,
					grid_editable:false,
					width_grid:250,
					width:300,
					disabled:false
				},
				tipo:'ComboBox',
				id_grupo:0,
				filtro_0:true,
				filterColValue:'desc_ingas_item_serv',
				save_as:'id_concepto_ingas'
			};
			// txt total
			Atributos[2]={
				validacion:{
					name:'total',
					fieldLabel:'Total Presupuestado',
					allowBlank:true,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					decimalPrecision:0,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:true,
					grid_editable:false,
					renderer: renderSeparadorDeMil,
					width_grid:140,
					width:'100%',
					disabled:false
				},
				tipo:'NumberField',
				form:false,
				filtro_0:false,
				id_grupo:1,
				save_as:'total'
			};
			// txt justificacion
			Atributos[3]={
				validacion:{
					name:'justificacion',
					fieldLabel:'Justificación',
					allowBlank:false,
					maxLength:400,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:250,
					width:'100%',
					disabled:false
				},
				tipo:'TextArea',
				id_grupo:0,
				filtro_0:true,
				filterColValue:'MEMCAL.justificacion',
				save_as:'justificacion'
			};
			// txt id_partida_presupuesto
			Atributos[4]={
				validacion:{
					name:'id_partida_presupuesto',
					labelSeparator:'',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false,
					disabled:true
				},
				tipo:'Field',
				filtro_0:false,
				id_grupo:0,
				defecto:maestro.id_partida_presupuesto,
				save_as:'id_partida_presupuesto'
			};
			// txt tipo_detalle
			Atributos[5]={
				validacion:{
					name:'tipo_detalle',
					fieldLabel:'Tipo Memoria',
					allowBlank:true,
					maxLength:50,
					align:'left',
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					allowNegative:false,
					minValue:0,
					renderer:render_tipo_memoria,
					grid_visible:false,
					grid_editable:false,
					width_grid:130,
					width:'50%',
					disabled:true
				},
				tipo:'NumberField',
				filtro_0:true,
				id_grupo:1,
				filterColValue:'MEMCAL.tipo_detalle',
				defecto:maestro.tipo_memoria,
				save_as:'tipo_detalle'
			};
			// txt costo_estimado
			Atributos[6]={
				validacion:{
					name:'costo_estimado',
					fieldLabel:'Costo Estimado',
					allowBlank:true,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:true,
					decimalPrecision:2,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:false,
					grid_editable:false,
					width_grid:150,
					width:'50%',
					disabled:false
				},
				tipo:'NumberField',
				defecto:0,
				id_grupo:0,
				form:false
			};
			// txt tipo_cambio
			Atributos[7]={
				validacion:{
					name:'tipo_cambio',
					fieldLabel:'Tipo de Cambio',
					allowBlank:true,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:true,
					decimalPrecision:6,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:false,
					grid_editable:false,
					width_grid:150,
					width:'100%',
					disabled:false
				},
				tipo:'NumberField',
				id_grupo:0,
				form:false
			};
			// txt id_moneda
			Atributos[8]={
				validacion:{
					name:'id_moneda',
					fieldLabel:'Moneda a Presupuestar',
					allowBlank:false,
					emptyText:'Moneda...',
					desc:'des_moneda', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_moneda,
					valueField:'id_moneda',
					displayField:'nombre',
					queryParam:'filterValue_0',
					filterCol:'MONEDA.nombre',
					typeAhead:true,
					tpl:tpl_id_moneda,
					forceSelection:true,
					mode:'remote',
					queryDelay:200,
					pageSize:100,
					minListWidth:200,
					grow:true,
					resizable:true,
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_moneda,
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					width:200,
					disable:false
				},
				tipo:'ComboBox',
				filtro_0:true,
				id_grupo:0,
				filterColValue:'MONEDA.nombre',
				save_as:'id_moneda'
			};
			// txt id_moneda
			Atributos[9]={
				validacion:{
					name:'id_moneda2',
					fieldLabel:'Moneda',
					allowBlank:true,
					emptyText:'Moneda...',
					desc:'desc_moneda2', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_moneda2,
					valueField:'id_moneda2',
					displayField:'nombre',
					queryParam:'filterValue_0',
					filterCol:'MONEDA.nombre',
					typeAhead:true,
					tpl:tpl_id_moneda2,
					forceSelection:true,
					mode:'remote',
					queryDelay:200,
					pageSize:10,
					minListWidth:200,
					grow:true,
					resizable:true,
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_moneda2,
					grid_visible:false,
					grid_editable:false,
					width_grid:120,
					width:200,
					disabled:false
				},
				tipo:'ComboBox',
				form:false,
				filtro_0:true,
				filterColValue:'MONEDA.nombre',
				save_as:'id_moneda2'
			};
			// ----------            FUNCIONES RENDER    ---------------//
			function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
			//---------- INICIAMOS LAYOUT DETALLE
			var config={titulo_maestro:'Memoria de Calculo',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_presupuesto/vista/memoria_combustible/memoria_combustible.php'};
			var layout_memoria_calculo_combustible=new DocsLayoutMaestroDeatalle(idContenedor);
			layout_memoria_calculo_combustible.init(config);

			// INICIAMOS HERENCIA //
			this.pagina=Pagina;
			//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
			this.pagina(paramConfig,Atributos,ds,layout_memoria_calculo_combustible,idContenedor);

			var getSelectionModel=this.getSelectionModel;
			var CM_btnEdit=this.btnEdit;
			var CM_ocultarGrupo=this.ocultarGrupo;
			var CM_mostrarGrupo=this.mostrarGrupo;
			var CM_getComponente=this.getComponente;
			var CM_ocultarComponente=this.ocultarComponente;
			var CM_getFormulario=this.getFormulario;
			var CM_mostrarComponente= this.mostrarComponente;
			var Cm_conexionFailure=this.conexionFailure;
			var Cm_btnActualizar=this.btnActualizar;
			var getGrid=this.getGrid;
			var getDialog= this.getDialog;
			var cm_EnableSelect=this.EnableSelect;
			var ClaseMadre_save=this.Save;
			// DEFINICIÓN DE LA BARRA DE MENÚ//
			var paramMenu={
				nuevo:{crear:true,separador:true},
				editar:{crear:true,separador:false},
				eliminar:{crear:true,separador:false},
				actualizar:{crear:true,separador:false}
			};
			//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
			//datos necesarios para el filtro
			var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/memoria_calculo/ActionEliminarMemoriaCalculo.php',parametros:'&m_id_partida_presupuesto='+maestro.id_partida_presupuesto},
				Save:{url:direccion+'../../../control/memoria_calculo/ActionGuardarMemoriaCalculo.php',parametros:'&m_id_partida_presupuesto='+maestro.id_partida_presupuesto},
				ConfirmSave:{url:direccion+'../../../control/memoria_calculo/ActionGuardarMemoriaCalculo.php',parametros:'&m_id_partida_presupuesto='+maestro.id_partida_presupuesto},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Memoria de Cálculo',
				grupos:[{tituloGrupo:'Datos Memoria Cálculo',columna:0,id_grupo:0},{tituloGrupo:'Filtrar',columna:0,id_grupo:1}]
				}};
				//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.reload=function(params){
					var datos=Ext.urlDecode(decodeURIComponent(unescape(params)));
					maestro.id_partida_presupuesto=datos.m_id_partida_presupuesto;
					maestro.id_presupuesto=datos.m_id_presupuesto;
					maestro.id_parametro=datos.m_id_parametro;
					maestro.nombre_financiador=datos.m_nombre_financiador;
					maestro.nombre_regional=datos.m_nombre_regional;
					maestro.nombre_programa=datos.m_nombre_programa;
					maestro.nombre_proyecto=datos.m_nombre_proyecto;
					maestro.nombre_actividad=datos.m_nombre_actividad;
					maestro.id_partida=datos.m_id_partida;
					maestro.desc_partida=datos.m_desc_partida;
					maestro.desc_moneda=datos.m_desc_moneda;
					maestro.tipo_pres=datos.m_tipo_pres;
					maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional;
					maestro.id_moneda=datos.m_id_moneda;
					maestro.tipo_memoria=datos.m_tipo_memoria;
					maestro.tipo_vista=datos.m_tipo_vista;
					//bloquear botones y limpiar hijo
					_CP.getPagina(layout_memoria_calculo_combustible.getIdContentHijo()).pagina.limpiarStore();
					_CP.getPagina(layout_memoria_calculo_combustible.getIdContentHijo()).pagina.bloquearMenu()
					//
					ds.lastOptions={
						params:{
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							id_partida_presupuesto:maestro.id_partida_presupuesto,
							tipo_memoria:maestro.tipo_memoria,
							id_moneda:maestro.id_moneda
						}
					};
					prueba.setValue(maestro.id_moneda);
					this.btnActualizar();
					Atributos[1].validacion.store.baseParams={m_id_partida:maestro.id_partida};
					Atributos[8].defecto=maestro.id_moneda;
					Atributos[4].defecto=maestro.id_partida_presupuesto;
					Atributos[5].defecto=maestro.tipo_memoria;
					this.InitFunciones(paramFunciones)
					if(maestro.tipo_vista==2)
					{
						CM_getBoton('nuevo-'+idContenedor).disable();
						CM_getBoton('editar-'+idContenedor).disable();
						CM_getBoton('eliminar-'+idContenedor).disable();
					}
					else
					{
						CM_getBoton('nuevo-'+idContenedor).enable();
						CM_getBoton('editar-'+idContenedor).enable();
						CM_getBoton('eliminar-'+idContenedor).enable();
					}
					paramFunciones.btnEliminar.parametros='&m_id_partida_presupuesto='+maestro.id_partida_presupuesto;
					paramFunciones.Save.parametros='&m_id_partida_presupuesto='+maestro.id_partida_presupuesto;
					paramFunciones.ConfirmSave.parametros='&m_id_partida_presupuesto='+maestro.id_partida_presupuesto
				};
				this.btnEdit=function(){
					CM_ocultarGrupo('Filtrar');
					CM_btnEdit()
				};
				function InitPaginaMemoriaCalculoCombustible(){
					grid=getGrid();
					dialog=getDialog();
					sm=getSelectionModel();
					formulario=CM_getFormulario();
					for(var i=0; i<Atributos.length; i++){
						componentes[i]=CM_getComponente(Atributos[i].validacion.name)
					}
				}
				var prueba=new Ext.form.ComboBox({
					store:ds_moneda2,
					displayField:'nombre',
					typeAhead: true,
					mode:'local',
					triggerAction:'all',
					emptyText:'Seleccionar moneda...',
					selectOnFocus:true,
					width:135,
					valueField:'id_moneda',
					editable:false,
					tpl:tpl_id_moneda
				});
				ds_moneda.load({
					params:{
						start:0,
						limit:1000000
					}
				}
				);
				prueba.on('select',
				function(){
					ds.lastOptions={
						params:{
							start:0,
							limit:paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							id_partida_presupuesto:maestro.id_partida_presupuesto,
							tipo_memoria:maestro.tipo_memoria,
							id_moneda:prueba.getValue()
						}
					};
					Cm_btnActualizar()
				});
				//Para manejo de eventos
            function salta(){
		             ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	           }
				function iniciarEventosFormularios(){
					//evento de deselecion de una linea de grid
					getSelectionModel().on('rowdeselect',function(){
						if(_CP.getPagina(layout_memoria_calculo_combustible.getIdContentHijo()).pagina.limpiarStore()){
							_CP.getPagina(layout_memoria_calculo_combustible.getIdContentHijo()).pagina.bloquearMenu()
						}
					})
				}
				this.EnableSelect=function(sm,row,rec){
					var record=rec.data;
					_CP.getPagina(layout_memoria_calculo_combustible.getIdContentHijo()).pagina.reload(rec.data);
					
					if(maestro.tipo_vista==2)
					{
						_CP.getPagina(layout_memoria_calculo_combustible.getIdContentHijo()).pagina.bloquearMenu();
					}
					else
					{
						_CP.getPagina(layout_memoria_calculo_combustible.getIdContentHijo()).pagina.desbloquearMenu();
					}

					cm_EnableSelect(sm,row,rec)
				};
				//para que los hijos puedan ajustarse al tamaño

				this.getLayout=function(){return layout_memoria_calculo_combustible.getLayout()};
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//codigo para bloquear los botones de modificacion dependiendo del estado del presupuesto
				var CM_getBoton=this.getBoton;	
				if(maestro.tipo_vista==2)
				{
					CM_getBoton('nuevo-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
				}
				else
				{
					CM_getBoton('nuevo-'+idContenedor).enable();
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
				}					
			    //Fin codigo de bloqueo de botones
				
				var CM_getBoton=this.getBoton;
				this.InitFunciones(paramFunciones);
				this.iniciaFormulario();
				//carga datos XML
				this.AdicionarBotonCombo(prueba,'prueba');
				InitPaginaMemoriaCalculoCombustible();
				iniciarEventosFormularios();
				//Para actualizar los datos del padre al cerrar el hijo
	            layout_memoria_calculo_combustible.getVentana().addListener('beforehide',salta);
				CM_ocultarGrupo('Filtrar');
				layout_memoria_calculo_combustible.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}