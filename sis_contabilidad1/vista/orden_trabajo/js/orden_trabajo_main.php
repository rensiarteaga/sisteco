<?php 
/**
 * Nombre:		  	    orden_trabajo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-08-27 09:14:44
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
var usuario={id_usuario:<?php echo $_SESSION['ss_id_usuario'];?>}

var elemento={pagina:new pagina_orden_trabajo(idContenedor,direccion,usuario,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_orden_trabajo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-08-27 09:14:44
 */
function pagina_orden_trabajo(idContenedor,direccion,usuario,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/orden_trabajo/ActionListarOrdenTrabajo.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_orden_trabajo',totalRecords:'TotalCount'
		},[		
		'id_orden_trabajo',
		'desc_orden',
		'motivo_orden',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},
		'estado_orden',
		'id_usuario',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'desc_usuario',
		{name: 'fecha_activa',type:'date',dateFormat:'Y-m-d'},'id_depto','desc_depto'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			sw_nulo:'si'
		}
	});
	
	//DATA STORE COMBOS
    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['PERSON.apellido_paterno','PERSON.apellido_materno','PERSON.nombre'])
	});

	//FUNCIONES RENDER
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{PERSON.apellido_paterno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON.apellido_materno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON.nombre}</FONT>','</div>');
	
	function render_orden_trabajo(value){
		if(value==0){value='Registrado'}
		if(value==1){value='Activado'}
		if(value==2){value='Finalizado'}
		return value
	}

	var ds_departamento_conta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},
		['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}
	});
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b>{nombre_depto}</b>','<br><FONT COLOR="#0000ff"><b>Codigo: </b>{codigo_depto}</FONT>','<br><FONT COLOR="#0000ff"><b>Subsistema: </b>{nombre_corto}</FONT>','</div>');
	function render_id_depto_conta(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	
	// Definición de datos //
	//en la posición 0 siempre esta la llave primaria
	// hidden id_orden_trabajo
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_orden_trabajo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_orden_trabajo'
	};
// txt desc_orden
	Atributos[1]={
		validacion:{
			name:'desc_orden',
			fieldLabel:'Nombre OT',
			allowBlank:false,
			maxLength:100,
			minLength:1,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'ORDTRA.desc_orden',
		save_as:'desc_orden'
	};
// txt motivo_orden
	Atributos[2]={
		validacion:{
			name:'motivo_orden',
			fieldLabel:'Motivo',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:0,
		filtro_0:false,
		filterColValue:'ORDTRA.motivo_orden',
		save_as:'motivo_orden'
	};
// txt fecha_inicio
	Atributos[3]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:3		
		},
		form:true,
		tipo:'DateField',
		id_grupo:0,
		filtro_0:true,
		filterColValue:'ORDTRA.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio'
	};
// txt fecha_activa
	Atributos[4]= {
		validacion:{
			name:'fecha_activa',
			fieldLabel:'Fecha Activa',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:4		
		},
		form:true,
		tipo:'DateField',
		id_grupo:1,
		filtro_0:true,
		filterColValue:'ORDTRA.fecha_activa',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_activa'
	};
// txt fecha_final
	Atributos[5]= {
		validacion:{
			name:'fecha_final',
			fieldLabel:'Fecha Final',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:4		
		},
		form:true,
		tipo:'DateField',
		id_grupo:2,
		filtro_0:true,
		filterColValue:'ORDTRA.fecha_final',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_final'
	};
// txt estado_orden
	Atributos[6]={
		validacion:{
			name:'estado_orden',
			fieldLabel:'Estado',
			allowBlank:false,
			//align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','Registrado'],['1','Abierto'],['2','Cerrado']]}),
			renderer:render_orden_trabajo,
			width_grid:70,
			width:'20%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:1,
		defecto:0,
		filtro_0:true,
		filterColValue:'ORDTRA.estado_orden',
		save_as:'estado_orden'
	};
// txt id_usuario
	Atributos[7]={
		validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			allowBlank:true,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'60%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'60%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:0,
		defecto:usuario.id_usuario,
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_usuario'
	};


	Atributos[8]={
			validacion:{
				name:'id_depto',
				fieldLabel:'Departamento Contabilidad',
				allowBlank:true,
				emptyText:'Departamento Contabilidad...',
				desc: 'desc_depto', 
				store:ds_departamento_conta,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, 
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto_conta,
				width:300,
				width_grid:250,
				disable:false,
				grid_visible:true,
				grid_editable:false	
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			save_as:'id_depto',
		 };

	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Orden Trabajo',grid_maestro:'grid-'+idContenedor};
	var layout_orden_trabajo=new DocsLayoutMaestro(idContenedor);
	layout_orden_trabajo.init(config);

	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_orden_trabajo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/orden_trabajo/ActionEliminarOrdenTrabajo.php'},
		Save:{url:direccion+'../../../control/orden_trabajo/ActionGuardarOrdenTrabajo.php'},
		ConfirmSave:{url:direccion+'../../../control/orden_trabajo/ActionGuardarOrdenTrabajo.php'},
		
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,height:300,columnas:['90%'],
			grupos:
			[{tituloGrupo:'Registrar',columna:0,id_grupo:0},
			 {tituloGrupo:'Activar',columna:0,id_grupo:1},
			 {tituloGrupo:'Finalizar',columna:0,id_grupo:2}
			]
		}
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_finalizar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		btnEdit();
		if(NumSelect!=0){
			if(txt_estado_orden.getValue()=='1'){
				txt_estado_orden.setValue('2');
				CM_mostrarGrupo('Finalizar');
				CM_ocultarGrupo('Registrar');
				CM_ocultarGrupo('Activar');
			}else{
				CM_ocultarFormulario();
				Ext.MessageBox.alert('Estado', 'La Orden de Trabajo NO esta Activa')
			}
		}else{Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un elemento.')
		}
	}
	
	function btn_activar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		btnEdit();
		if(NumSelect!=0){
			if(txt_estado_orden.getValue()=='0'){
				txt_estado_orden.setValue('1');
				CM_mostrarGrupo('Activar');
				CM_ocultarGrupo('Registrar');
				CM_ocultarGrupo('Finalizar');
			}else{
				CM_ocultarFormulario();
				Ext.MessageBox.alert('Estado', 'La Orden de Trabajo esta Activa o Finalizada')
			}
		}else{Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un elemento.')
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		txt_estado_orden=ClaseMadre_getComponente('estado_orden');
	}
	
	this.btnEdit=function(){
		btnEdit();
		if(txt_estado_orden.getValue()=='1'){
			CM_ocultarFormulario();
			Ext.MessageBox.alert('Estado', 'Usted no Puede Modificar el Registro - La Orden de Trabajo esta Activada')
		}else {
			if(txt_estado_orden.getValue()=='2'){
				CM_ocultarFormulario();
				Ext.MessageBox.alert('Estado', 'Usted no Puede Modificar el Registro - La Orden de Trabajo esta Finalizada')
			}else{
				txt_estado_orden.setValue('0');	
				CM_ocultarComponente(getComponente('id_usuario'));
				CM_mostrarGrupo('Registrar');
				CM_ocultarGrupo('Activar');
				CM_ocultarGrupo('Finalizar');	
			}
		}
	}

	this.btnNew=function(){
		txt_estado_orden.setValue('0');
		CM_ocultarComponente(getComponente('id_usuario'));
		CM_mostrarGrupo('Registrar');
		CM_ocultarGrupo('Activar');
		CM_ocultarGrupo('Finalizar');
		btnNew();
	}
	
	this.btnEliminar=function(){
		if(txt_estado_orden.getValue()=='1'){
			Ext.MessageBox.alert('Estado', 'Usted no Puede Eliminar el Registro - La Orden de Trabajo esta Activada')
		}
		if(txt_estado_orden.getValue()=='2'){
			Ext.MessageBox.alert('Estado', 'Usted no Puede Eliminar el Registro - La Orden de Trabajo esta Finalizada')
		}
		if(txt_estado_orden.getValue()=='0'){	
			btnEliminar();
		}	
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_orden_trabajo.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton("../../../lib/imagenes/a_table_gear.png",'Activación',btn_activar,true,'Activación','Activar');
	this.AdicionarBoton("../../../lib/imagenes/a_table_gear.png",'Finalización',btn_finalizar,true,'Finalización','Finalizar');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_orden_trabajo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}