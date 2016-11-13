<?php 
/**
 * Nombre:		  	    concepto_cta_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:44
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
id_concepto_ingas:'<?php echo $m_id_concepto_ingas;?>',
desc_concepto_ingas:'<?php echo $m_desc_concepto_ingas;?>',
id_partida:'<?php echo $m_id_partida;?>',
desc_partida:'<?php echo $m_desc_partida;?>'

};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={idContenedor:idContenedor,pagina:new pagina_concepto_cta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_concepto_cta.js
 * Propósito: 			pagina objeto principal
 * Autor:				Ana Maria V 
 * Fecha creación:		2008-10-21 09:30:44
 * Fecha de Mod:        10/08/2009
 * Desc. Mod:           El combo auxiliar no pasaba a la siguiente página y era por el límite el cual estaba declarado antes en esta vista eso trae problemas.
 */
function pagina_concepto_cta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var id_cuenta; 
	var presupuesto;	
	var cm_presupuesto;
	//---DATA STORE
	var ds = new Ext.data.Store({
	        proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionListarConceptoCta.php'}),
	 		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_concepto_cta',totalRecords:'TotalCount'
		},[		
		'id_concepto_cta',
		'id_concepto_ingas',
		'id_cuenta',
		'desc_cta2',
		'id_presupuesto',
		'desc_presupuesto',
		'nombre_auxiliar',
		'id_auxiliar'
		]),remoteSort:true});
  
	
	//DATA STORE COMBOS
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');

	var data_maestro=[
	
	//['ID',maestro.id_concepto_ingas],
	['Concepto Ingreso',maestro.desc_concepto_ingas],
	['Partida',maestro.desc_partida]];
   
   
	
   var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
			['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','desc_cta2']) });
		  
 	var ds_auxiliar=new Ext.data.Store({	proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarCuentaAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},
		['id_cuenta_auxiliar','id_cuenta','nombre_cuenta','id_auxiliar','nombre_auxiliar','codigo_auxiliar']),remoteSort:true});	
			  
  var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
																																								'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
																																								'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
																																								'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																																								'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin' 
																																								]),
	baseParams:{sw_inv_gasto:'no',m_id_concepto_gasto:maestro.id_concepto_ingas}
	});


	//FUNCIONES RENDER		
		
		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',	
		'<br>  <FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br>  <FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');
		
		function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cta2']);}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b>{nombre_cuenta}</b>','<br><FONT COLOR="#B5A642"><b>Nombre:</b> {nombre_cuenta}</FONT>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta:</b> {nro_cuenta}</FONT>','</div>');
	
		
		function render_auxiliar(value,p,record){return String.format('{0}',record.data['nombre_auxiliar'])};
		var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>{nombre_auxiliar}</b>','<br><FONT COLOR="#B5A642"><b>Código:</b> {codigo_auxiliar}</FONT>','</div>');
		
		
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_cta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_concepto_cta'
	};

	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_ingas',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_concepto_ingas'
	};
	
	Atributos[2]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			emptyText:'Presupuesto....',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto#presup.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:450,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto#presup.id_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
	Atributos[3]={
			validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			store:ds_cuenta,
		    displayField: 'desc_cta2',
			valueField: 'id_cuenta',
			desc:'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nombre_cuenta',
			typeAhead:false,
			tpl:tpl_id_cuenta,
			forceSelection:true,
			mode:'remote',
			queryDelay:100,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUENTA.nombre_cuenta',
		save_as:'id_cuenta',
		id_grupo:0
	};
	
	Atributos[4]={
		validacion:{
			    name:'id_auxiliar',
				fieldLabel:'Auxiliar de Cuenta',
				allowBlank:false,
				emptyText:'Auxiliar...',
			    desc:'nombre_auxiliar',
				store:ds_auxiliar,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam:'filterValue_0',
				filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				tpl:tpl_id_auxiliar,
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:250,
				grow:true,
				resizable:true,
				triggerAction:'all',
				editable:true,
				renderer:render_auxiliar,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:300 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			save_as:'id_auxiliar',
			id_grupo:0
	};
	
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Concepto Ingas',titulo_detlle:'Concepto Cuenta',grid_maestro:'grid-'+idContenedor};
	var layout_concepto_cta=new DocsLayoutDetalle(idContenedor);
	layout_concepto_cta.init(config);

	
	// INICIAMOS HERENCIA //
		
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_concepto_cta,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
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
	var EstehtmlMaestro=this.htmlMaestro;

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroConceptoIngas(data_maestro));//IMPORTANTE
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionEliminarConceptoCta.php',parametros:'&m_id_concepto_ingas='+maestro.id_concepto_ingas},
		Save:{url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionGuardarConceptoCta.php',parametros:'&m_id_concepto_ingas='+maestro.id_concepto_ingas},
		ConfirmSave:{url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionGuardarConceptoCta.php',parametros:'&m_id_concepto_ingas='+maestro.id_concepto_ingas},
		Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		height:260,width:450,
		minWidth:150,minHeight:200,
		closable:true,titulo:'Concepto Cuenta',
		grupos:[{
			tituloGrupo:'ConceptoCta',
			columna: 0,
			id_grupo:0
		}
				
	    ]
		}};
		
		
		function 	 MaestroConceptoIngas(data){
		var mayor=0;		
		var j;
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
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
	return html
	};	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//alert (datos.m_id_concepto_ingas);
	maestro.id_concepto_ingas=datos.m_id_concepto_ingas;
	maestro.desc_concepto_ingas=datos.m_desc_concepto_ingas;
	maestro.desc_partida=datos.m_desc_partida;
	maestro.id_partida=datos.m_id_partida;
   		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_concepto_ingas:maestro.id_concepto_ingas
			}
		};
		
		this.btnActualizar();
	
		data_maestro=[
		
	    ['Concepto Ingreso',maestro.desc_concepto_ingas],
	    ['Partida',maestro.desc_partida]
		];
		 Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroConceptoIngas (data_maestro));
		
    	Atributos[1].defecto=maestro.id_concepto_ingas;
		cm_presupuesto.store.baseParams={sw_inv_gasto:'no',m_id_concepto_gasto:maestro.id_concepto_ingas};
		cm_presupuesto.modificado=true;
		
		
    	//ds_presupuesto.baseParams={sw_inv_gasto:'si'};
		paramFunciones.btnEliminar.parametros='&m_id_concepto_ingas='+maestro.id_concepto_ingas;
		paramFunciones.Save.parametros='&m_id_concepto_ingas='+maestro.id_concepto_ingas;
		paramFunciones.ConfirmSave.parametros='&m_id_concepto_ingas='+maestro.id_concepto_ingas;
		this.InitFunciones(paramFunciones)
	};



	function InitPaginaConceptoCta()
	{	for(var i=0; i<Atributos.length; i++)
		{	
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		
		
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
	 id_cuenta=ClaseMadre_getComponente('id_cuenta');
	 id_auxiliar=ClaseMadre_getComponente('id_auxiliar');
	 cmbCuenta = ClaseMadre_getComponente('id_cuenta');
	 cm_presupuesto=ClaseMadre_getComponente('id_presupuesto');
	 
	 var onCuentaSelect = function(e) {
			var id = cmbCuenta.getValue();
			id_auxiliar.store.baseParams={maestro_id_cuenta:id,m_sw_concepto_cta:'si'};
		    id_auxiliar.modificado=true;
		};
	 var onPresupuestoSelect = function(e) {
			var id = cm_presupuesto.getValue();
			id_auxiliar.store.baseParams={maestro_id_cuenta:id,m_sw_concepto_cta:'si'};
		    id_auxiliar.modificado=true;
		};
	 
	    cmbCuenta.on('select', onCuentaSelect);
		
	 
	 }
	 
	 this.btnNew=function(){
	 	ds_cuenta.baseParams={m_id_partida:maestro.id_partida,sw_reg_comp:'si'};
	 	cmbCuenta.modificado=true;
	 	btnNew();
	 	
	 	
	 }	
	 this.btnEdit=function(){
	 	ds_cuenta.baseParams={m_id_partida:maestro.id_partida,sw_reg_comp:'si'};
	 	cmbCuenta.modificado=true;
	 	btnEdit();
	 }	
	 
	
						
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_concepto_cta.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_concepto_ingas:maestro.id_concepto_ingas
		}
	});
	
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','cajeros',btn_cajero,true,'cajero','');

	this.iniciaFormulario();
	InitPaginaConceptoCta();
	iniciarEventosFormularios();
	layout_concepto_cta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}


