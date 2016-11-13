/**
 * Nombre:		  	    pagina_estado_autorizado.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-03 14:44:35
 */
function pagina_estado_autorizado(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_autorizado/ActionListarEstadoAutorizado.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_estado_autorizado',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_estado_autorizado',
		'id_usuario_autorizado',
		'id_concepto_colectivo',
		'estado_autorizado'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_usuario_autorizado:maestro.id_usuario_autorizado
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	function tabular(n)
	{ if (n>=0)	{return "  "+tabular(n-1)}
	else return "  "
	}
	
	var data_maestro=[['Responsable',' ' + maestro.desc_usuario+tabular(51-maestro.desc_usuario.length)],['',''],
					  ['Unidad Organizacional',' ' + maestro.desc_unidad_organizacional+tabular(51-maestro.desc_unidad_organizacional.length)]];
	
	//DATA STORE COMBOS

    var ds_usuario_autorizado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarUsuarioAutorizado.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','id_unidad_organizacional'])
	});

	//FUNCIONES RENDER
	
	function render_id_usuario_autorizado(value, p, record){return String.format('{0}', record.data['desc_usuario_autorizado']);}
	var tpl_id_usuario_autorizado=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_concepto_colectivo(value, p, record){return String.format('{0}', record.data['desc_concepto_colectivo']);}
	var tpl_id_concepto_colectivo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');
	
	function render_estado(value)
	{	
		if(value == 1){return "1. Formulación"}
		if(value == 2){return "2. Verificación Previa"}
		if(value == 3){return "3. Revisión Final"}
		if(value == 4){return "4. Revisión Final"}		//Anteproyecto
		if(value == 5){return "5. Aprobado"}
	}
	
	// Definición de datos //
	
	// hidden id_estado_autorizado
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_estado_autorizado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_estado_autorizado'
	};
// txt id_usuario_autorizado
	Atributos[1]={
		validacion:{
			name:'id_usuario_autorizado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_usuario_autorizado,
		save_as:'id_usuario_autorizado'
	};
// txt tipo_pres
	 Atributos[2] = {
		validacion: {
			name:'estado_autorizado',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Etapa Presupuestaria',
			vtype:'texto',
			emptyText:'Etapa...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','1. Formulación'],['2','2. Verificación Previa'],['4','4. Revisión Final'],['5','5. Aprobado']]}),
			valueField:'ID',
			displayField:'valor',
			renderer: render_estado,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid ,['3','Anteproyecto'],['4','Aprobado']
			grid_editable:true, //es editable en el grid
			width_grid:300, // ancho de columna en el grid
			width:250
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		filterColValue:'ESTAUT.estado_autorizado',
	 	save_as:'estado_autorizado'
	};	
 	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Autorización para Presupuestar (Maestro)',titulo_detalle:'Estapa(s) Autorizada(s) (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_estado_autorizado = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_estado_autorizado.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_estado_autorizado,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/estado_autorizado/ActionEliminarEstadoAutorizado.php',parametros:'&m_id_usuario_autorizado='+maestro.id_usuario_autorizado},
	Save:{url:direccion+'../../../control/estado_autorizado/ActionGuardarEstadoAutorizado.php',parametros:'&m_id_usuario_autorizado='+maestro.id_usuario_autorizado},
	ConfirmSave:{url:direccion+'../../../control/estado_autorizado/ActionGuardarEstadoAutorizado.php',parametros:'&m_id_usuario_autorizado='+maestro.id_usuario_autorizado},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Estapa Autorizada'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_usuario_autorizado=datos.m_id_usuario_autorizado;
		maestro.desc_usuario=datos.m_desc_usuario;
		maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional;
	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_usuario_autorizado:maestro.id_usuario_autorizado
			}
		};
		this.btnActualizar();
		data_maestro=[['Responsable',' ' + maestro.desc_usuario+tabular(45-maestro.desc_usuario.length)],['',''],
					  ['Unidad Organizacional',' ' + maestro.desc_unidad_organizacional+tabular(45-maestro.desc_unidad_organizacional.length)]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_usuario_autorizado;

		paramFunciones.btnEliminar.parametros='&m_id_usuario_autorizado='+maestro.id_usuario_autorizado;
		paramFunciones.Save.parametros='&m_id_usuario_autorizado='+maestro.id_usuario_autorizado;
		paramFunciones.ConfirmSave.parametros='&m_id_usuario_autorizado='+maestro.id_usuario_autorizado;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos   
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_estado_autorizado.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_estado_autorizado.getLayout().addListener('layout',this.onResize);
	layout_estado_autorizado.getVentana(idContenedor).on('resize',function(){layout_estado_autorizado.getLayout().layout()})
	
}