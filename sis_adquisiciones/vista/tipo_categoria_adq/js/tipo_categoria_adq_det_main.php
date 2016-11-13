<?php
/**
 * Nombre:		  	    tipo_categoria_adq_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 10:18:01
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

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
var maestro={id_categoria_adq:<?php echo $m_id_categoria_adq;?>,nombre:decodeURIComponent('<?php echo $m_nombre;?>'),descripcion:'<?php echo $m_descripcion;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_tipo_categoria_adq_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);




/**
 * Nombre:		  	    pagina_tipo_categoria_adq_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 10:18:01
 */
function pagina_tipo_categoria_adq_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_categoria_adq/ActionListarTipoCategoriaAdq_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_categoria_adq',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tipo_categoria_adq',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_categoria_adq',
		'desc_categoria_adq',
		'estado_categoria',
		'tipo',
		'nombre'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_categoria_adq:maestro.id_categoria_adq
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

        var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

	
	//DATA STORE COMBOS

	//FUNCIONES RENDER

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_categoria_adq
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_categoria_adq',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_tipo_categoria_adq'
	};
	// txt id_categoria_adq
	Atributos[1]={
		validacion:{
			name:'id_categoria_adq',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_categoria_adq,
		save_as:'id_categoria_adq'
	};
// txt nombre
	Atributos[2]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CATADQ.nombre#TIPCAT.nombre',
		save_as:'nombre'
	};
// txt tipo
	Atributos[3]={
			validacion: {
			name:'tipo',
			fieldLabel:'Tipo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Cotizacion','Cotizacion'],['Solicitud','Solicitud'],['Proceso','Proceso']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPCAT.tipo',
		defecto:'Cotizacion',
		save_as:'tipo'
	};
// txt estado_categoria
	Atributos[4]={
			validacion: {
			name:'estado_categoria',
			fieldLabel:'Estado registro',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPCAT.estado_categoria',
		defecto:'activo',
		save_as:'estado_categoria'
	};

// txt fecha_reg
	// txt fecha_reg
	Atributos[5]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:5
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CATADQ.fecha_reg',
		dateFormat:'m-d-Y'
	
	};


	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Categorías de Adquisiciones (Maestro)',titulo_detalle:'Tipo Categoría (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_categoria_adq = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tipo_categoria_adq.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_tipo_categoria_adq,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/tipo_categoria_adq/ActionEliminarTipoCategoriaAdq.php',parametros:'&m_id_categoria_adq='+maestro.id_categoria_adq},
	Save:{url:direccion+'../../../control/tipo_categoria_adq/ActionGuardarTipoCategoriaAdq.php',parametros:'&m_id_categoria_adq='+maestro.id_categoria_adq},
	ConfirmSave:{url:direccion+'../../../control/tipo_categoria_adq/ActionGuardarTipoCategoriaAdq.php',parametros:'&m_id_categoria_adq='+maestro.id_categoria_adq},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Tipo Categoria Adquisición'}};
	
	
	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/categoria_adq/ActionListarCategoriaAdq.php?m_id_categoria_adq='+maestro.id_categoria_adq}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria_adq',totalRecords: 'TotalCount'},['id_categoria_adq',
		'nombre',
		'observaciones',
		'descripcion',
		'precio_min','precio_max'
		])
		});
		
		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_categoria_adq:maestro.id_categoria_adq
			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Categoria',ds_maestro.getAt(0).get('nombre')],['Descripcion',ds_maestro.getAt(0).get('descripcion')],['Precio Minimo',ds_maestro.getAt(0).get('precio_min')],['Precio Maximo',ds_maestro.getAt(0).get('precio_max')]]));
		}
	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		    var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_categoria_adq=datos.m_id_categoria_adq;
            maestro.nombre=datos.m_nombre

            ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_categoria_adq:maestro.id_categoria_adq
				},
				callback:cargar_maestro
			});
			
		
			ds.load({
			 params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_categoria_adq:maestro.id_categoria_adq
			}
		});
		
		Atributos[1].defecto=maestro.id_categoria_adq;
		
		paramFunciones.btnEliminar.parametros='&m_id_categoria_adq='+maestro.id_categoria_adq;
		paramFunciones.Save.parametros='&m_id_categoria_adq='+maestro.id_categoria_adq;
		paramFunciones.ConfirmSave.parametros='&m_id_categoria_adq='+maestro.id_categoria_adq;
		this.InitFunciones(paramFunciones)
	};
	function btn_estado_compra_categoria_adq(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
			data=data+'&m_tipo='+SelectionsRecord.data.tipo;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;

			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_tipo_categoria_adq.loadWindows(direccion+'../../../vista/estado_compra_categoria_adq/estado_compra_categoria_adq_det.php?'+data,'Estado Compra Categoria',ParamVentana);
layout_tipo_categoria_adq.getVentana().on('resize',function(){
			layout_tipo_categoria_adq.getLayout().layout();
				})
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	}
		}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_categoria_adq.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Estado Compra Categoria',btn_estado_compra_categoria_adq,true,'estado_compra_categoria_adq','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_categoria_adq.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}