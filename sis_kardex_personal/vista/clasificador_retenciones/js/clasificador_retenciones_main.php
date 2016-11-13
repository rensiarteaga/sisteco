<?php 
/**
 * Nombre:		  	    factores_kardex_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
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
var elemento={pagina:new pagina_clasificador_retenciones(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_clasificador_retenciones_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2014-10-18 09:06:57
 */
function pagina_clasificador_retenciones(idContenedor,direccion,paramConfig){
	var Atributos=new Array;
	var sw=0
	
	
		
	var	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/clasificador_retenciones/ActionListarClasificadorRetenciones.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_clasificador_retenciones',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_clasificador_retenciones',
		'id_persona',
		'desc_persona',
		'id_institucion',
		'desc_institucion',
		'id_tipo_columna',
		'desc_tipo_columna',
		'codigo',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'usuario_reg','nombre'
		]),remoteSort:true});
		
	
	
		
	//carga datos XML

	
	
	
	var ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_institucion',
				totalRecords: 'TotalCount'
			}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
		});
	
	  var ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_persona',totalRecords: 'TotalCount'},['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','foto_persona','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','direccion','nro_registro','desc_per'])
	});
	  
	  
	  var ds_tipo_columna = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_columna/ActionListarColumnaTipo.php?estado=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_columna_tipo',totalRecords: 'TotalCount'},['id_columna_tipo','id_parametro_kardex','id_partida','nombre','valor','tipo_dato','id_moneda','tipo_aporte','estado_reg','fecha_reg','cotizable','descripcion','descontar','observacion','incremento','formula','codigo'])
	});
	  
	  function render_id_persona(value, p, record){return String.format('{0}', record.data['desc_persona']);}
		var tpl_id_persona=new Ext.Template('<div class="search-item">','{nombre} ','{apellido_paterno} ','{apellido_materno}','</div>');
		
		function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
		
	
		function render_id_columna_tipo(value, p, record){return String.format('{0}', record.data['desc_tipo_columna']);}
		var tpl_id_columna_tipo=new Ext.Template('<div class="search-item">','<b>{nombre}</b><br>','<FONT COLOR="#B5A642">Definición: {tipo_dato}</FONT><br>','<FONT COLOR="#B5A642">Fórmula: {formula}</FONT><br>','<FONT COLOR="#B5A642">Constante:{valor}</FONT><br>','<FONT COLOR="#B5A642"><b>--Identificador: {id_parametro_kardex}--</b></FONT>','</div>');

	function render_estado_reg(value){
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
    
		
	
	
	Atributos[0]=
			{
				validacion:{
					labelSeparator:'',
					name:'id_clasificador_retenciones',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_clasificador_retenciones'
			};
			
		
	Atributos[1]= {
				validacion: {
						name:'id_institucion_acreedor',
						fieldLabel:'Inst. Acreedor',
						allowBlank:true,
						emptyText:'Institucion...',
						desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
						store:ds_institucion,
						valueField: 'id_institucion',
						displayField: 'nombre',
						queryParam: 'filterValue_0',
						filterCol:'INSTIT.nombre#INSTIT.casilla',
						forceSelection:false,
						mode:'remote',
						queryDelay:200,
						pageSize:150,
						minListWidth:'100%',
						grow:true,
						resizable:true,
						queryParam:'filterValue_0',
						minChars:3, ///caracteres minimos requeridos para iniciar la busqueda
						triggerAction:'all',
						editable:true,
						renderer:render_id_institucion,
						grid_visible:false,
						grid_editable:false,
						width_grid:150, // ancho de columna en el gris
						width:200,
						grid_indice:1,
						confTrigguer:{
							url:direccion+'../../../../sis_parametros/vista/institucion/institucion.php',
						    paramTri:'prueba:XXX',		
						    title:'Personas',
						    param:{width:800,height:800},
						    idContenedor:idContenedor,
						   // clase_vista:'pagina_persona'
						}	
			
					},
					tipo:'ComboTrigger',
					form:false,
					
					filtro_0:false,
					//filtro_1:true,
					filterColValue:'INSTIT.nombre#INSTIT2.nombre'
				};
		
		
		
	/*	Atributos[2]={
				validacion:{
				name:'id_persona',
				fieldLabel:'Pers. Acreedor',
				allowBlank:true,			
				emptyText:'Persona...',
				desc: 'desc_person', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_persona,
				valueField: 'id_persona',
				displayField: 'desc_persona',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				typeAhead:false,
				tpl:tpl_id_persona,
				forceSelection:false,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_persona,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:200,
				disabled:false,
				grid_indice:2,
				confTrigguer:{
						url:direccion+'../../../../sis_seguridad/vista/persona/persona.php',
					    paramTri:'prueba:XXX',		
					    title:'Personas',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
					}		
			},
			tipo:'ComboTrigger',
			form: true,
			filtro_0:false,
			//filtro_1:true,
			filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre'
			
			
		};*/
	
	Atributos[2]={
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre',
				allowBlank:true,
				
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				grid_indice:1,
				disabled:false		
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'claret.nombre'
			
		};

			
		Atributos[3]={
				validacion:{
				name:'id_columna_tipo',
				fieldLabel:'Tipo Columna',
				allowBlank:true,			
				emptyText:'Tipo Columna...',
				desc: 'desc_tipo_columna', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo_columna,
				valueField: 'id_columna_tipo',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'COLTIP.id_columna_tipo#COLTIP.nombre#COLTIP.codigo',
				typeAhead:true,
				tpl:tpl_id_columna_tipo,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_columna_tipo,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:2		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
		
			filterColValue:'COLTIP.id_columna_tipo#COLTIP.nombre#COLTIP.codigo'
		};
	
		Atributos[5]= {
				validacion: {
					name:'estado_reg',			
					fieldLabel:'Estado',
					allowBlank:true,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					renderer:render_estado_reg,
					forceSelection:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:90
					
				},
				tipo:'ComboBox',
				filtro_0:true,		
				filterColValue:'claret.estado_reg'		
			};
			
			
			Atributos[4]={
				validacion:{
					name:'codigo',
					fieldLabel:'Codigo',
					allowBlank:false,
					
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					width:'100%',
					disabled:false		
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'claret.codigo'
				
			};
	
			
			
			Atributos[6]= {
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
			
			
			Atributos[7]={
					validacion:{
						name:'usuario_reg',
						fieldLabel:'Usr Registro',
						allowBlank:true,
						
						minLength:0,
						selectOnFocus:true,
						vtype:'texto',
						grid_visible:true,
						grid_editable:false,
						width_grid:150,
						width:'100%',
						disabled:false		
					},
					tipo: 'Field',
					form: true,
					filtro_0:true,
					filterColValue:'claret.usuario_reg'
					
				};
			
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	
	var config={titulo_maestro:'Factores Kardex',grid_maestro:'grid-'+idContenedor};
	var layout_clasificador_retenciones=new DocsLayoutMaestro(idContenedor);
	layout_clasificador_retenciones.init(config);
	
	
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_clasificador_retenciones,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var cm_EnableSelect=this.EnableSelect;
	
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/clasificador_retenciones/ActionEliminarClasificadorRetenciones.php'},
		Save:{url:direccion+'../../../control/clasificador_retenciones/ActionGuardarClasificadorRetenciones.php'},
		ConfirmSave:{url:direccion+'../../../control/clasificador_retenciones/ActionGuardarClasificadorRetenciones.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		
		titulo:'Clasificador Retenciones'}
	};	
	
	
		
	
	
	
	
/*	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec);
		
		_CP.getPagina(layout_clasificador_retenciones.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_clasificador_retenciones.getIdContentHijo()).pagina.desbloquearMenu();	
		
	}*/
	
	this.btnNew=function()
	{	CM_ocultarComponente(ClaseMadre_getComponente('estado_reg'));
		CM_ocultarComponente(ClaseMadre_getComponente('usuario_reg'));
		
		ClaseMadre_btnNew()
	};
	
	this.btnEdit=function()
	{
		CM_mostrarComponente(ClaseMadre_getComponente('estado_reg'));
		ClaseMadre_btnEdit()
	};
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_clasificador_retenciones.getLayout()
	};
	
	//para el manejo de hijos
	/*this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};*/
	
//	this.getElementos=function(){return elementos};
//	this.setPagina=function(elemento){elementos.push(elemento)};
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
//	var CM_getBoton=this.getBoton;
	
	
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	this.iniciaFormulario();
	//iniciarEventosFormularios();
	layout_clasificador_retenciones.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}