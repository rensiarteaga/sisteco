<?php
/**
 * Nombre:		  	    servicio_adicional_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2016-04-27 14:34:08
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
var paramConfig={TamanoPagina:20,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:false};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var maestro={id_asignacion_equipo:<?php echo "'$id_asignacion_equipo'";?>};

var elemento={idContenedor:idContenedor,pagina:new pagina_servicio_adicional(idContenedor,direccion,paramConfig,idContenedorPadre,maestro)};//,idContenedorPadre,maestro)};
//_CP.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
* Nombre:		  	    pagina_empleado_planilla.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2010-08-27 14:34:08
*/
function pagina_servicio_adicional(idContenedor,direccion,paramConfig,idContenedorPadre,maestro)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio_adicional/ActionListarServicioAdicional.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_servicio_adicional',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_servicio_adicional',
		'id_asignacion_equipo',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'usuario_reg',
		'importe_servicio',
		'detalle',
		'id_correspondencia','desc_correspondencia'
		]),remoteSort:true});


		// DEFINICIÓN DATOS DEL MAESTRO
		var ds_id_correspondencia = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_flujo/control/correspondencia/ActionListarCorrespondencia.php?sol=1&vista=enviado&tipo=interna'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_correspondencia',totalRecords: 'TotalCount'},['id_correspondencia','numero','desc_empleado','desc_documento','referencia'])
		});

		function render_id_correspondencia(value, p, record){return String.format('{0}', record.data['desc_correspondencia']);}
		var tpl_id_correspondencia=new Ext.Template('<div class="search-item">','<b>{desc_documento} -','{numero}</b>','<br><FONT COLOR="#B5A642">{desc_empleado}</FONT>','<br>{referencia}','</div>');
		
		//DATA STORE COMBOS

			function render_estado_reg(value)
		{
			if(value=='activo'){value='Activo'	}
			else if(value=='inactivo'){value='Inactivo'	}
			return value
		}

		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_empleado_planilla
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_servicio_adicional',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			form:false

		};


		// txt id_empleado
		Atributos[1]={
			validacion:{
				name:'id_asignacion_equipo',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_asignacion_equipo,
			form:true
		};

		Atributos[2]={
				validacion:{
					name:'detalle',
					fieldLabel:'Detalle',
					allowBlank:true,
					maxLength:500,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:195,
					width:'62%'
				},
				tipo:'TextArea',
				filtro_0:true,
				filterColValue:'SERVAD.detalle',
				save_as:'detalle'
			};
		
		Atributos[3]= {
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
				defecto:''
			};
			
			Atributos[4]= {
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
					defecto:''
				};

			Atributos[5]={
					validacion:{
						name:'importe_servicio',
						fieldLabel:'Importe Servicio(Bs)',
						allowBlank:false,
						maxLength:10,
						minLength:0,
						selectOnFocus:true,
						allowDecimals:true,
						decimalPrecision:0,//para numeros float
						allowNegative:false,
						minValue:0,
						vtype:'texto',
						align:'right',
						grid_visible:true,
						grid_editable:false,
						width_grid:130,
						width:'62%',
						disable:false
					},
					tipo: 'NumberField',
					form: true,
					filtro_0:true,
					filterColValue:'SERVAD.importe_servicio',
					
					save_as:'importe_servicio'
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
						name:'estado_reg',			
						fieldLabel:'Estado',
						allowBlank:false,
						typeAhead: true,
						loadMask: true,
						triggerAction: 'all',			
						store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
						valueField:'ID',
						displayField:'valor',
						lazyRender:true,
						
						forceSelection:true,
						grid_visible:true,
						grid_editable:false,
						width_grid:100
					},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'SERVAD.estado_reg'
		};

		// txt fecha_reg
		Atributos[8]= {
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
			filterColValue:'TOB.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''

		};


		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Detalle Servicio',grid_maestro:'grid-'+idContenedor};
		var layout_servicio_adicional=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_servicio_adicional.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_servicio_adicional,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;

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
				btnEliminar:{url:direccion+'../../../control/servicio_adicional/ActionEliminarServicioAdicional.php'},
				Save:{url:direccion+'../../../control/servicio_adicional/ActionGuardarServicioAdicional.php'},
				ConfirmSave:{url:direccion+'../../../control/servicio_adicional/ActionGuardarServicioAdicional.php'},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Roaming Internacional'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


			//funcion de reload


			this.reload=function(m){
				maestro=m; 
				Atributos[1].defecto=maestro.id_asignacion_equipo;
				
                this.InitFunciones(paramFunciones);
		
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_asignacion_equipo:maestro.id_asignacion_equipo
					}
				};

				this.btnActualizar()
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_servicio_adicional.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			/*ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_obligacion:maestro.id_obligacion
				}
			});*/

			//para agregar botones

			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			layout_servicio_adicional.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

			
			
}