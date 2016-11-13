<?php 
/**
 * Nombre:		  	  param_ctas_activos_dist_main.php 
 * Propósito: 			
 * Autor:				
 * Fecha creación:		
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
		id_grupo_proceso:<?php echo $maestro_id_grupo_proceso;?>};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_pametrizacion_ctas_af_dist(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:				param_ctas_activos_dist.js  	  
* Propósito: 			pagina objeto principal		
* Autor:				Elmer Velasquez	
* Fecha creación:		01/02/2013
*/
function pagina_pametrizacion_ctas_af_dist(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes= new Array(); 
	//var maestro;
	/////////////////
	//  DATA STORE // 
	/////////////////
	var ds =  new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_generacion_cbtes/activos_fijos_distribucion/ActionListarActivoFijoDistGrupoProceso.php'}),
		
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id:'id_activo_fijo',
			totalRecords: 'TotalCount'
		}, [ 
		// define el mapeo de XML a las etiquetas (campos)
		'id_activo_fijo',
		'descripcion_activo_fijo',
		'id_tipo_activo2',
		'tipo_activo',
		'id_sub_tipo_activo',
		'subtipo_activo',
		'programa','codigo_programa',
		'tension'
		]),
		remoteSort: true // metodo de ordenacion remoto
	});
	
	var ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_activo/ActionListaTipoActivoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'	
		}, ['id_tipo_activo','descripcion'])
	
	});
	
	// DEFINICIÓN  DE DATOS DEL MAESTRO

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['   Proceso',maestro.id_grupo_proceso]];

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////


	Atributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_activo_fijo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false
	};
	Atributos[1]={
			validacion:{
				name: 'id_activo_fijo',
				fieldLabel: 'Id Activo Fijo',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 60,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:60, // ancho de columna en el gris
				grid_indice:1
			},
			form:false,
			tipo: 'Field',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,

		};
	Atributos[2]={
			validacion:{
				name: 'descripcion_activo_fijo',
				fieldLabel: 'Descripcion',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 150,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:380, // ancho de columna en el gris
				grid_indice:2
			},
			form:false,
			tipo: 'Field',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,

		};
	/*Atributos[3]={
			validacion:{
				name: 'tipo_activo',
				fieldLabel: 'Tipo Activo',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 350,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				grid_indice:3,
				width_grid:300 // ancho de columna en el grid
			},
			form:true,
			tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,
			

		};*/
	Atributos[3]={
		validacion:{
		fieldLabel: 'Tipo Activo',
		allowBlank: false,
		vtype:"texto",
		emptyText:'Tipo Activo...',
		name: 'tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
		desc: 'tipo_activo',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
		store:ds_tipo,
		valueField: 'id_tipo_activo',
		displayField: 'descripcion',
		queryParam: 'filterValue_0',
		filterCol:'tipo.descripcion',
		typeAhead: false,
		forceSelection : true,
		mode: 'remote',
		queryDelay: 50,
		pageSize: 10,
		minListWidth : 300,
		resizable: true,
		queryParam: 'filterValue_0',
		minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
		triggerAction: 'all',
		grid_visible:true, // se muestra en el grid
		grid_editable:false, //es editable en el grid,
		width_grid:200, // ancho de columna en el gris
		width:200,
		grid_indice:3
	},
	tipo: 'ComboBox',
	id_grupo:0
	};
	Atributos[4]={
			validacion:{
				name: 'subtipo_activo',
				fieldLabel: 'Sub-Tipo Activo',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 350,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				grid_indice:4,
				width_grid:300 // ancho de columna en el gris
			},
			form:true,
			tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,
		};
	
	Atributos[5]={
			validacion:{
				name: 'programa',
				fieldLabel: 'Programa',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 350,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				grid_indice:5,
				width_grid:200 // ancho de columna en el gris
			},
			form:false,
			tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,
			

		};
	Atributos[6] = {
			validacion: {
				name:'tension',
				fieldLabel: 'Tension',
				allowBlank:false,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'tension...',
				store:new Ext.data.SimpleStore({fields:['cod_tension','desc_tension'],
												data:[
												      ['Alta','ALTA'],
												      ['Media', 'MEDIA'],
												      ['Baja', 'BAJA']
												       ]
												 }),
				valueField:'cod_tension',
				displayField:'desc_tension',
				lazyRender:true,
				forceSelection:false,
				width_grid:100,
				triggerAction:'all',
				width:250,
				grid_visible:true,			
				disabled:false
				
			},
			form:true,
			id_grupo:0,
			tipo:'ComboBox',
			filtro_0:true,
			save_as:'id_tension',
			defecto:' '
	
		};
	Atributos[7] = {
			validacion:{
				labelSeparator:'',
				name: 'id_tipo_activo',
				inputType:'hidden'
			},
			tipo: 'Field',
			filtro_0:false
			//save_as:'hidden_subtipo_activo'
		};
	Atributos[8] = {
			validacion:{
				labelSeparator:'',
				name: 'id_sub_tipo_activo',
				inputType:'hidden'
			},
			tipo: 'Field',
			filtro_0:false
			//save_as:'hidden_subtipo_activo'
		};
	Atributos[9] = {
			validacion:{
				labelSeparator:'',
				name: 'codigo_programa',
				inputType:'hidden'
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_programa'
		};
	Atributos[10] = {
			validacion: {
				name:'tension_conductores',
				fieldLabel: 'Tension Conductores',
				allowBlank:false,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'tension...',
				store:new Ext.data.SimpleStore({	fields:['cod_tension_conductores','desc_tension'],
													data:[
													      ['AltaBienAereo','Alta - Bienes en Produccion Aereo'],
													      ['AltaBienSub', 'Alta - Bienes en Produccion Subterraneo'],
													      ['MediaBienAereo', 'Media - Bienes en Produccion Aereo'],
													      ['MediaBienSub', 'Media - Bienes en Produccion Subterraneo'],
													      ['BajaBienAereo', 'Baja - Bienes en Produccion Aereo'],
													      ['BajaBienSubt', 'Baja - Bienes en Produccion Subterraneo']
													     ]
											    }),
				valueField:'cod_tension_conductores',
				displayField:'desc_tension',
				lazyRender:true,
				forceSelection:false,
				width_grid:100,
				triggerAction:'all',
				width:250,
				grid_visible:false,			
				disabled:true
				
			},
			form:true,
			id_grupo:0,
			tipo:'ComboBox',
			filtro_0:true,
			save_as:'id_tension2',
			defecto:' '
		};
	Atributos[11] = {
			validacion: {
				name:'tension_estructuras',
				fieldLabel: 'Tension Estructuras',
				allowBlank:false,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'tension...',
				store:new Ext.data.SimpleStore({	fields:['cod_tension_estructuras','desc_tension'],
													data:[
													      ['AltaBien','Alta - Bienes en Produccion'],
													      ['AltaProp', 'Alta - Propiedad General'],
													      ['MediaBien', 'Media - Bienes en Produccion'],
													      ['MediaProp', 'Media - Propiedad General'],
													      ['BajaBien', 'Baja - Bienes en Produccion'],
													      ['BajaProp', 'Baja - Propiedad General']
													     ]
											    }),
				valueField:'cod_tension_estructuras',
				displayField:'desc_tension',
				lazyRender:true,
				forceSelection:false,
				width_grid:100,
				triggerAction:'all',
				width:250,
				grid_visible:false,			
				disabled:true
				
			},
			form:true,
			id_grupo:0,
			tipo:'ComboBox',
			filtro_0:true,
			save_as:'id_tension3',
			defecto:' '
		};

	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:"Detalle Proceso (Maestro)",
				titulo_detalle:"Activos Fijos Distribucion (Detalle)",
				grid_maestro:'grid-'+idContenedor};
	var layout_generacion_cbtes = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_generacion_cbtes.init(config);



	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_generacion_cbtes,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_getDialog=this.getDialog;
	

	
  
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu = {
			actualizar:{
				crear :true,
				separador:false
			},
		editar:{crear:true,separador:false}
		
		};
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
			Save:{url:direccion+'../../../control/activo_fijo/ActionSaveActivoFijo.php'},
			ConfirmSave:{url:direccion+'../../../control/activo_fijo/ActionSaveActivoFijo.php'},
			Formulario:{
						html_apply:'dlgInfo-'+idContenedor,height:370,width:'60%',minWidth:150,minHeight:100,closable:true,titulo:'Proceso Activos Fijos',
						columnas:['45%'],
						grupos:[{	tituloGrupo:'Parametrizacion de Cuentas',columna:0,id_grupo:0}]	
				}
			};
	
	

		//-------------- Sobrecarga de funciones --------------------//


		this.reload=function(params)
		{
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_grupo_proceso=datos.maestro_id_grupo_proceso;
			maestro.proceso=datos.maestro_proceso;
			
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_grupo_proceso:maestro.id_grupo_proceso
				}
			};
			this.btnActualizar();
			data_maestro=[['Proceso ',maestro.id_grupo_proceso],];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
			this.InitFunciones(paramFunciones);
		}
	
	
	
		
		
		function iniciarEventosFormularios()
		{
			//para iniciar eventos en el formulario
			for(var i=0;i<Atributos.length;i++)
			{
				componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
			}
			
			combo_tension=getComponente('tension');
			combo_tension_conductores=getComponente('tension_conductores');
			combo_tension_estructuras=getComponente('tension_estructuras');
		}

		
		this.btnEdit=function()
		{
			combo_tension_estructuras.setValue('');
			combo_tension.setValue('');
			combo_tension_conductores.setValue('');  
			
			var sm=getSelectionModel();
			if(getSelectionModel().getCount()>0)
			{
				var SelectionsRecord=sm.getSelected();
				var tipo_activo=SelectionsRecord.data.id_tipo_activo2;
				if(tipo_activo=='31')
				{
					CM_ocultarComponente(combo_tension_estructuras);
					combo_tension_estructuras.setValue('');
					combo_tension_estructuras.disable();
					
					CM_ocultarComponente(combo_tension);
					combo_tension.setValue('');
					combo_tension.disable();
					
					CM_mostrarComponente(combo_tension_conductores);
					combo_tension_conductores.enable();
					combo_tension_conductores.setValue('');
					combo_tension_conductores.modificado=true;
					
				}
				else
				{
					if(tipo_activo=='2' ||tipo_activo=='3')
					{
						CM_mostrarComponente(combo_tension_estructuras);
						combo_tension_estructuras.enable();
						combo_tension_estructuras.setValue('');
						combo_tension_estructuras.modificado=true;
						
						CM_ocultarComponente(combo_tension);
						combo_tension.setValue('');
						combo_tension.disable();
						
						CM_ocultarComponente(combo_tension_conductores);
						combo_tension_conductores.setValue('');
						combo_tension_conductores.disable();
						
					}
					else
					{
						CM_mostrarComponente(combo_tension);
						combo_tension.enable();
						combo_tension.setValue('');
						combo_tension.modificado=true;
						
						CM_ocultarComponente(combo_tension_conductores);
						combo_tension_conductores.setValue('');
						combo_tension_conductores.disable();
						
						CM_ocultarComponente(combo_tension_estructuras);
						combo_tension_estructuras.setValue('');
						combo_tension_estructuras.disable();	
					}
				}
			} 
			else
			{
				Ext.MessageBox.alert('Estado','Seleccione un Item primero..');
			}
			/*CM_ocultarComponente(combo_tension);
		  	combo_tension.enable();
		  	
		  	CM_ocultarComponente(combo_tension_estructuras);
		  	combo_tension_estructuras.enable();
		  	
		  	CM_ocultarComponente(combo_tension_conductores);
		  	combo_tension_conductores.enable();*/
			ClaseMadre_btnEdit()
		};

		
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_generacion_cbtes.getLayout()};
		//para el manejo de hijos
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		var CM_getBoton=this.getBoton;
		this.InitFunciones(paramFunciones);

		this.iniciaFormulario();
		
		
		iniciarEventosFormularios();
		layout_generacion_cbtes.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_grupo_proceso:maestro.id_grupo_proceso
			}
		});

}