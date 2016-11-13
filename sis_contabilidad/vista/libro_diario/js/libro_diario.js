/**
* Nombre:		  	    pagina_libro_diario.js
* Propósito: 			pagina objeto principal
* Autor:				Ana Maria villegas
* Fecha creación:		2008-09-16 17:55:38
* Fecha ultima de actualización: 31/07/2009
*/
function pagina_libro_diario(idContenedor,direccion,paramConfig,maestro){
	var Atributos=new Array,sw=0;
	var g_comprobante;
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';

 	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_Fuente_financiamiento='';
	var g_tipo_auxiliar='Todos';

	
	var filtro;
	var fi=new Date(maestro.fecha_inicio);
	var ff=new Date(maestro.fecha_fin);
	//this.id_moneda='';
	var	g_id_moneda;
	var g_simbolo;
	var	g_id_moneda_desc='Ninguno';
	//alert (g_id_moneda_desc);
	
	var g_fecha_inicio=fi.getDate()+'/'+(fi.getMonth()+1)+'/'+fi.getFullYear();
	var g_fecha_fin=ff.getDate()+'/'+(ff.getMonth()+1)+'/'+ff.getFullYear();
	
		this.setMoneda=function(id_moneda,simbolo){g_id_moneda=id_moneda;g_simbolo=simbolo};
	
//alert(g_id_moneda);

	
	//this.getMoneda=function(id_moneda){g_id_moneda=id_moneda;};
	//this.getMoneda=getMoneda;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarLibroDiario.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_comprobante',totalRecords:'TotalCount'
		},[
		'id_comprobante',
		'nro_cbte',
		{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
		'prefijo',
		'nombre_acreedor',
		'aprobacion',
		'concepto_cbte',
		'desc_clase',
		'id_moneda',
		'desc_moneda',
		'momento_cbte',
		'titulo_cbte'
				
		]),remoteSort:true});

	 ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		m_id_depto:maestro.id_depto,
		m_id_moneda:1,
		m_fecha_inicio:maestro.fecha_inicio,
		m_fecha_fin:maestro.fecha_fin,
		m_tipo_vista:'libro_diario'}});
		 
		 
		//DATA STORE COMBOS

		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
		});

		var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['PERSON_15.apellido_paterno','PERSON_15.apellido_materno','PERSON_15.nombre'])
		});

	
		var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_fuente_financiamiento',totalRecords:'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla']),remoteSort:true});
   	    var ds_unidad_organizacional= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),remoteSort:true});

		var	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),reader: new Ext.data.XmlReader({record:'ROWS',id: 'id_financiador',totalRecords: 'TotalCount'}, ['id_financiador','nombre_financiador','codigo_financiador']),remoteSort:true});
		var	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_regional',totalRecords: 'TotalCount'}, ['id_regional','nombre_regional','codigo_regional']),remoteSort:true});
		var	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_programa',totalRecords: 'TotalCount'}, ['id_programa','nombre_programa','codigo_programa']),remoteSort:true});
		var	ds_proyecto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proyecto',totalRecords: 'TotalCount'}, ['id_proyecto','nombre_proyecto','codigo_proyecto']),remoteSort:true});
		var	ds_actividad=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_actividad',totalRecords: 'TotalCount'}, ['id_actividad','nombre_actividad','codigo_actividad']),remoteSort:true});
		var ds_cbte_clase = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_clase/ActionListarCbteClase.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_clase_cbte',totalRecords:'TotalCount'},[	'id_clase_cbte','desc_clase','estado_clase','id_documento','desc_documento'])});
		var ds_periodo_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'},['id_periodo_subsistema',
		'id_periodo','periodo','desc_periodo','id_subsistema','desc_subsistema','estado_periodo'])});


		/////***** ***///
		//padre=this;
	config_fuente_financiamiento={nombre:'Fuente Finan.',descripcion:'denominacion',id:'id_fuente_financiamiento',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_unidad_organizacional={nombre:'Unidad Org.',descripcion:'desc_unidad_organizacional',id:'id_unidad_organizacional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_financiador={nombre:'Financiado',descripcion:'nombre_financiador',id:'id_financiador',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_regional={nombre:'Regional',descripcion:'nombre_regional',id:'id_regional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_programa={nombre:'Programa',descripcion:'nombre_programa',id:'id_programa',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_proyecto={nombre:'SubPrograma',descripcion:'nombre_proyecto',id:'id_proyecto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_actividad={nombre:'Actividad',descripcion:'nombre_actividad',id:'id_actividad',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};

        
		function menuBotones()
	{
		 
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	  
	 	g_ids_fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente Finan.').menuBoton.getSelecion();
	 	g_ids_u_o=padre.getBotonMenuBotonNombre('Unidad Org.').menuBoton.getSelecion();
	 	g_ids_financiador=padre.getBotonMenuBotonNombre('Financiado').menuBoton.getSelecion();
	 	g_ids_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSelecion();
	 	g_ids_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSelecion();
	 	g_ids_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSelecion();
	 	g_ids_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSelecion();
	 	
	 	
		g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
		g_financiador=padre.getBotonMenuBotonNombre('Financiado').menuBoton.getSeleccionadosDesc();
		g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
		g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
		g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
		g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Org.').menuBoton.getSeleccionadosDesc();
		g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente Finan.').menuBoton.getSeleccionadosDesc();
		//g_tipo_auxiliar=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
	
		ds.baseParams={start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			
			id_cuenta:maestro.id_cuenta,
			fecha_inicio:g_fecha_inicio,
		    fecha_fin:g_fecha_fin,
			ids_fuente_financiamiento:g_ids_fuente_financiamiento,
			ids_u_o:g_ids_u_o,
			ids_financiador:g_ids_financiador,
			ids_regional:g_ids_regional,
			ids_programa:g_ids_programa,
			ids_proyecto:g_ids_proyecto,
			ids_actividad:g_ids_actividad,
			m_id_clase_cbte:maestro.id_clase_cbte,
		    m_id_moneda:g_id_moneda,
			m_tipo_vista:'libro_diario'
			
			};
	}



	
	if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
	if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
	if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
	if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
	if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
	/***********/
 
	/*if(epe==" "){epe="Todos"}*/
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
	
	
	
	 
	/*alert("asdfsdfj"+maestro.id_cuenta);
	exit;*/
	
	/* var data_maestro=[ ['Cuenta ',maestro.nro_cuenta+' '+ maestro.nombre_cuenta,'Moneda',g_desc_moneda],
					   ['Estructura Programatica','epe'] ,
					   ['Estructura Organizacional',g_unidad_organizacional ] ,
					   ['Fuente Financiamiento',g_Fuente_financiamiento],
					   ['Fecha Inicio',g_fecha_inicio,'Fecha Fin',g_fecha_fin,'Tipo de Reporte',g_tipo_auxiliar]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
*/


	/*function MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;
		//var  html="<table class='izquierda'><tr>";
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		//for(j=0;j<mayor;j++){html=html=+"<td>&nbsp;</td>";};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
		/*if(j%2!=0){
			html=html+"<td></td><td></td></tr>";
		}*/
		//html=html+'</table>';
		
	 
	/*	return html
	};
function tabular(n)
{ if (n>=0)	{return "  "+tabular(n-1)}
else return "  "
}*/

		//FUNCIONES RENDER

	/*	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','<b>Esatdo: </b><FONT COLOR="#B5A642">{estado_gestion}</FONT><br>','</div>');
*/
		function render_id_moneda_reg(value, p, record){return String.format('{0}', record.data['desc_moneda']);};
		




		var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');



		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{PERSON_15.apellido_paterno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.apellido_materno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.nombre}</FONT>','</div>');

		function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
		var tpl_id_subsistema=new Ext.Template('<div class="search-item">','<b>Código:</b><FONT COLOR="#B5A642">{codigo}</FONT>','<b>Subsistema:</b><FONT COLOR="#B5A642">{nombre_corto}</FONT>','</div>');

		function render_id_cbte_clase(value, p, record){return String.format('{0}', record.data['desc_clases']);}
		var tpl_id_cbte_clase=new Ext.Template('<div class="search-item">','<b>Calse Cbte: </b><FONT COLOR="#B5A642">{desc_clase}</FONT><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_clase}</FONT>','</div>');


		/**************/
		function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']+' - '+record.data['periodo_sub']);}

		var tpl_id_periodo_subsistema=new Ext.Template('<div class="search-item">','<b>Subsistema: </b><FONT COLOR="#B5A642">{desc_subsistema}</FONT><br>','<b>Periodo: </b><FONT COLOR="#B5A642">{desc_periodo}</FONT>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_periodo}</FONT>','</div>');


		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_comprobante
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_comprobante',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			save_as:'id_comprobante'
		};
		
		Atributos[1]={
			validacion:{
				name:'prefijo',
				fieldLabel:'Prefijo ',
				allowBlank:false,
				align:'right',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:30,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			defecto:0,
			form: false,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'DOCUME.prefijo',
			save_as:'prefijo'
		};
		
		// txt nro_cbte
		Atributos[2]={
			validacion:{
				name:'nro_cbte',
				fieldLabel:'Nro.',
				allowBlank:false,
				align:'right',
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			defecto:0,
			form: false,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPROB.nro_cbte',
			save_as:'nro_cbte'
		};
		
		// txt fecha_cbte
		Atributos[3]= {
			validacion:{
				name:'fecha_cbte',
				fieldLabel:'Fecha',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:80,
				disabled:false
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPROB.fecha_cbte',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_cbte'
		};
		
		//concepto_cbte
		Atributos[4]={
			validacion:{
				name:'concepto_cbte',
				fieldLabel:'Concepto',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:350,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPROB.concepto_cbte',
			save_as:'concepto_cbte'
		};

		// txt acreedor
		Atributos[5]={
			validacion:{
				name:'nombre_acreedor',
				fieldLabel:'Acreedor',
				allowBlank:true,
				maxLength:30,
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
			filtro_1:true,
			filterColValue:'COMPROB.acreedor',
			save_as:'acreedor'
		};
		// txt aprobacion
		Atributos[6]={
			validacion:{
				name:'aprobacion',
				fieldLabel:'Aprobación',
				allowBlank:true,
				maxLength:30,
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
			filtro_1:true,
			filterColValue:'COMPROB.aprobacion',
			save_as:'aprobacion'
		};
		
		Atributos[7]={
			validacion:{
				name:'desc_clase',
				fieldLabel:'Comprobante',
				allowBlank:false,
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
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'CBTECL.desc_clase',
			save_as:'desc_clase'
		};
		// txt id_moneda_reg
		Atributos[8]={
			validacion:{
				name:'id_moneda_reg',
				fieldLabel:'Moneda Registro',
				allowBlank:false,
				emptyText:'Moneda Registro...',
				desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_moneda,
				valueField: 'id_moneda',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre',
				typeAhead:true,
				tpl:tpl_id_moneda_reg,
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
				renderer:render_id_moneda_reg,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
		//	filtro_0:true,
		//	filterColValue:'MONEDA.nombre',
			save_as:'id_moneda_reg'
		};

		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'libro_diario',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/libro_diario/libro_diario_transaccion.php'};
		var layout_libro_diario=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_libro_diario.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_libro_diario,idContenedor);
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		//this.pagina(paramConfig,Atributos,ds,layout_solser,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_saveSuccess=this.saveSuccess;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente= this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;

		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			//	guardar:{crear:true,separador:false},
			//	nuevo:{crear:true,separador:true},
			//	editar:{crear:true,separador:false},
			//	eliminar:{crear:true,separador:false},
				actualizar:{crear:true,separador:false}
		};

		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));

		this.btnNew=function(){
			g_comprobante='';

			ClaseMadre_btnNew();

		};
	
		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/comprobante/ActionEliminarRegistroComprobante.php'},
			Save:{url:direccion+'../../../control/comprobante/ActionGuardarRegistroComprobante.php',
			
			},
			ConfirmSave:{url:direccion+'../../../control/comprobante/ActionGuardarRegistroComprobante.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'libro_diario'}
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos
		function iniciarEventosFormularios(){
			getSelectionModel().on('rowdeselect',function(){_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.bloquearMenu();});
		}
		 

		this.EnableSelect=function(sm,row,rec){
			cm_EnableSelect(sm,row,rec);
			_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.reload(rec.data,padre);
			_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.desbloquearMenu();
		}

	
		function btn_reporte_libro_diario(){
			
			if(g_id_moneda==undefined){
				g_id_moneda=1;
				g_simbolo='Bs'
			}
			
			
			
			var data='start=0';
			 data+='&fecha_inicio='+maestro.fecha_inicio;
			 data+='&id_moneda='+g_id_moneda;
			 data+='&fecha_fin='+maestro.fecha_fin;
			 data=data+'&m_simbolo='+g_simbolo;
			 data=data+'&m_nombre_depto='+maestro.nombre_depto;
			 data=data+'&m_id_depto='+maestro.id_depto;
		//	 alert (data);
			 
			 window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroDiario.php?'+data)

		}
		//reporte de Comprobante
		function btn_reporte_comprobante(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){

				var SelectionsRecord=sm.getSelected();
				var data='m_id_comprobante='+SelectionsRecord.data.id_comprobante;
				  data=data+'&m_id_moneda='+g_id_moneda;
				  data=data+'&m_simbolo='+g_simbolo;
				  data=data+'&m_desc_clases='+SelectionsRecord.data.titulo_cbte;
				  data=data+'&m_momento_cbte='+SelectionsRecord.data.momento_cbte;
				
				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFComprobante.php?'+data)

			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}
		
	  /* ds_fuente_financiamiento.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
						 		},
								callback: function(){padre.AdicionarMenuBoton(ds_fuente_financiamiento,config_fuente_financiamiento);}
									});
	   ds_unidad_organizacional.load({params:{
	  	                            start:0,
	                                limit: paramConfig.TamanoPagina,
	                                CantFiltros:paramConfig.CantFiltros
	                                },
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									});
		
        ds_financiador.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros

		},
		callback: function(){padre.AdicionarMenuBoton(ds_financiador,config_financiador);}
		});
	
		ds_regional.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros

		},
		callback: function(){padre.AdicionarMenuBoton(ds_regional,config_regional);}
		});
		ds_programa.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros

		},
		callback: function(){padre.AdicionarMenuBoton(ds_programa,config_programa);}
		});
		ds_proyecto.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros

		},
		callback: function(){padre.AdicionarMenuBoton(ds_proyecto,config_proyecto);}
		});
		ds_actividad.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros

		},
		callback: function(){padre.AdicionarMenuBoton(ds_actividad,config_actividad);}
		});*/
		




		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_libro_diario.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		
         
		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Diario',btn_reporte_libro_diario,true,'reporte_libro_diario','');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Comprobante',btn_reporte_comprobante,true,'reporte_comprobante','');
		padre=this;
		layout_libro_diario.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);

}
