<?php 
/**
 * Nombre:		  	    tipo_doc_institucion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:03:56
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	    echo "var idCaif= $id_caiff;";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_caiff:<?php echo $id_caiff;?>};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_tipo_doc_institucion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};

//var elemento={pagina:new pagina_tipo_doc_institucion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_tipo_doc_institucion_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:03:56
 */
function pagina_tipo_doc_institucion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var maestro;
	/////////////////
	//  DATA STORE //
	/////////////////  
	var ds = new Ext.data.Store({
		//proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/comprobante/ActionListarRegistroComprobante.php'}),
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/caiff/ActionListarCaiffAjusteCbte.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_comprobante',totalRecords:'TotalCount'
		},[
		'id_comprobante',
		'id_parametro',
		'desc_parametro',
		'id_periodo_subsistema',
		'desc_periodo_lite',
	    {name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
		'nro_cbte',
		'acreedor',
		'aprobacion',
		'concepto_cbte',
		'sw_caif_rep',
		'sw_actualizacion'
		]),

		//baseParams:{m_id_caiff:maestro.id_caiff,m_sw_vista:'caiff'},
		//remoteSort:true
		});
	
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_caiff:maestro.id_caiff,
			m_sw_vista:'caiff'
		}
	});
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	 var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',
			id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
			'cantidad_nivel','estado_gestion']),
			baseParams:{m_estado:2}
      });
	
	
	 var ds_periodo_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
			reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'},['id_periodo_subsistema','id_periodo','periodo','desc_periodo','id_subsistema','desc_subsistema','estado_periodo',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'nombre_largo'])});	
	
	 function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']+' - '+record.data['desc_periodo']);}
		var tpl_id_periodo_subsistema=new Ext.Template('<div class="search-item">','<b>Subsistema: </b><FONT COLOR="#B5A642">{nombre_largo}</FONT><br>','<b>Periodo: </b><FONT COLOR="#B5A642">{desc_periodo}</FONT>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_periodo}</FONT>','</div>');
		
	 function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_gestion}</FONT><br>','</div>');
	
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
//id_comprobante	
/*vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_comprobante',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			id_grupo:0,
			filtro_0:false,
			save_as:'id_comprobante'
		};
	*/
// txt nombre_tipo_doc
vectorAtributos[0]={
		validacion:{
			name:'id_comprobante',
			fieldLabel:'ID',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			queryParam: 'filterValue_0',
			filterCol:'COMPRO.id_comprobante',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'COMPRO.id_comprobante',
		save_as:'id_comprobante',
		id_grupo:0
	};

vectorAtributos[1]={
		validacion:{
			name:'desc_parametro',
			fieldLabel:'Parametro',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'desc_parametro',
		save_as:'desc_parametro'
	};
vectorAtributos[2]={
		validacion:{
			name:'desc_periodo_lite',
			fieldLabel:'Periodo ',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'desc_periodo_lite',
		save_as:'desc_periodo_lite'
	};

vectorAtributos[3]= {
	validacion:{
		name:'fecha_cbte',
		fieldLabel:'Fecha Registro',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '31/01/2001',
		disabledDaysText: 'Día no válido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width_grid:85,
		disabled:false		
	},
	form:true,
	tipo:'DateField',
	filtro_0:true,
	filterColValue:'COMPRO.fecha_cbte',
	dateFormat:'m-d-Y',
	id_grupo:1,
	defecto:new Date(),
	save_as:'fecha_cbte'
   };

vectorAtributos[4]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Número',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		defecto:0,
		form: false,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'COMPRO.nro_cbte',
		save_as:'nro_cbte'
	};
vectorAtributos[5]={
	validacion:{
		name:'acreedor',
		fieldLabel:'Acreedor',
		allowBlank:true,
		maxLength:100,
		minLength:0,
		selectOnFocus:true,
		vtype:'texto',
		grid_visible:true,
		grid_editable:false,
		width_grid:100,
		width:'100%',
		disabled:false		
	},
	tipo: 'TextField',
	form: true,
	filtro_0:true,
	id_grupo:3,
	filterColValue:'COMPRO.acreedor',
	save_as:'acreedor'
};

vectorAtributos[5]={
	validacion:{
		name:'aprobacion',
		fieldLabel:'Aprobación',
		allowBlank:true,
		maxLength:150,
		minLength:0,
		selectOnFocus:true,
		vtype:'texto',
		grid_visible:true,
		grid_editable:false,
		width_grid:100,
		width:'100%',
		disabled:false		
	},
	tipo: 'TextField',
	form: true,
	filtro_0:true,
	id_grupo:3,
	filterColValue:'COMPRO.aprobacion',
	save_as:'aprobacion'
};
vectorAtributos[6]={
	validacion:{
		name:'concepto_cbte',
		fieldLabel:'Concepto',
		allowBlank:false,
		maxLength:1500,
		minLength:0,
		selectOnFocus:true,
		vtype:'texto',
		grid_visible:true,
		grid_editable:false,
		width_grid:100,
		width:'100%',
		disabled:false		
	},
	tipo: 'TextField',
	form: true,
	filtro_0:true,
	id_grupo:4,
	filterColValue:'COMPRO.concepto_cbte',
	save_as:'concepto_cbte'
};

vectorAtributos[7]={
		validacion:{
			name:'sw_caif_rep',
			fieldLabel:'sw_caif_rep',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'	
		},
		tipo: 'ComboBox',
		defecto:0,
		form: true ,
		id_grupo:0,
 		save_as:'sw_caif_rep'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'Ajuste Comprobante',
		grid_maestro:'grid-'+idContenedor,
		urlHijo:'../../../sis_presupuesto/vista/caiff/caiff_ajuste_transac.php'
	};
	layout_tipo_doc_institucion=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_tipo_doc_institucion.init(config);

	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_doc_institucion,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		//btnEliminar:{url:direccion+'../../../control/tipo_doc_institucion/ActionEliminarTipoDocInstitucion.php'},
		Save:{url:direccion+'../../../control/tipo_doc_institucion/ActionGuardarTipoDocInstitucion.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_doc_institucion/ActionGuardarTipoDocInstitucion.php'},
		Formulario:{
			titulo:'AjusteComprobante',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'40%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos de Ajuste de Comprobantes',
				columna:0,
				id_grupo:0
			}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
			//maestro=params;
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_caiff=datos.id_caiff;
		
		this.InitFunciones(paramFunciones);
			ds.lastOptions={params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_caiff:maestro.id_caiff,
						m_sw_vista:'caiff'
		}};
						
	   	this.btnActualizar();
		this.desbloquearMenu();
		};
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_doc_institucion.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	//para que los hijos puedan ajustarse al tamaño
	this.EnableSelect=function(sm,row,rec){
		_CP.getPagina(layout_tipo_doc_institucion.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_tipo_doc_institucion.getIdContentHijo()).pagina.desbloquearMenu();
		//enable(sm,row,rec);
	}
	this.getLayout=function(){return layout_tipo_doc_institucion.getLayout()};
	
	/*this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};*/

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				layout_tipo_doc_institucion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
				/*ds.load({params:{start:0,
					limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});*/

				
}