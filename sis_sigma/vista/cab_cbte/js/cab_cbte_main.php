<?php
/**
 * Nombre:		  	    cab_cbte_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		02/08/2010
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:3,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_declaracion:<?php echo $m_id_declaracion;?>,gestion:'<?php echo $m_gestion;?>',mes:'<?php echo $m_mes;?>',estado:'<?php echo $m_estado;?>',id_gestion:<?php echo $m_id_gestion;?>,id_parametro:<?php echo $m_id_parametro;?>};idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_cab_cbte(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_cab_cbte.js
* Proposito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaciï¿½n:		02/08/2010
*/
function pagina_cab_cbte(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var cmbProveedor;
	var componentes=new Array();
	var num_cotizaciones=0;
    var combo_depto,combo_cbte;
    var combo_depto_orig,combo_cbte_orig;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cab_cbte/ActionListarCabCbte.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cab_cbte',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cab_cbte',
		'nro_cbte',
		'id_cbte',
		'compromiso',
	 	'devengado',
		'pagado',
		'operacion',
		'nro_cbte_orig',
		'id_cbte_orig',
		{name: 'fecha_validacion',type:'date',dateFormat:'Y-m-d'},
		'tipo_mov',
		'tipo_pago',
		'tipo',
		'id_declaracion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'tipo_reg',
		'presentado',
		'observaciones',
		'modificado'
		]),remoteSort:true});

	//DATA STORE COMBOS
    var ds_cbte=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/comprobante/ActionListarRegistroComprobante.php?m_sw_vista=sigma'}),
    	reader: new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords:'TotalCount'},['id_comprobante','nro_cbte','desc_clase','acreedor','nombre_depto']),baseParams:{m_id_declaracion:maestro.id_declaracion}
    });
    
    //FUNCIONES RENDER   	
    function render_cbte_orig(value, p, record){return String.format('{0}', record.data['id_cbte_orig']);}
    
    function render_cbte(value, p, record){return String.format('{0}', record.data['id_cbte']);}
	var tpl_id_cbte=new Ext.Template('<div class="search-item">',
										'<b>Nro: </b><FONT COLOR="#0000ff">{nro_cbte} - {id_comprobante}</FONT>',
										'<br><b>Tipo: </b><FONT COLOR="#0000ff">{desc_clase}</FONT>',
										'<br><b>Acreedor: </b><FONT COLOR="#0000ff">{acreedor}</FONT>',
										'<br><b>Depto: </b><FONT COLOR="#0000ff">{nombre_depto}</FONT>','</div>');
 
	function render_presentado(value, p, record){
		if(value=='t'){
			return 'Si';
		} else{
			return '<span style="color:red;font-size:8pt"><b>NO</b> </span>';
		}
	}
		
	function render_tipo(value){
		if(value=='gasto'){value='Gasto'}
		else if(value=='recurso'){value='Recurso'}
		return value
	}
	
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////

	// hidden id_cotizacion
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cab_cbte',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			name:'tipo',
			fieldLabel:'Tipo',
			allowBlank:false,
	        typeAhead: true,
		    loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['gasto','Gasto'],['recurso','Recurso']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_tipo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:1
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.tipo',
		id_grupo:0
	};
	
	Atributos[2]= {
		validacion: {
			name:'compromiso',
			fieldLabel:'Compromiso',
			allowBlank:false,
			loadMask: true,
			triggerAction: 'all',
			store:new Ext.data.SimpleStore({
				fields:['ID','valor'],data:[['S','S - Si'],['N','N - No']						           
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:120,
			width_grid:70,
			align:'center',
			grid_indice:2
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.compromiso',
		id_grupo:0
	};
	
	Atributos[3]= {
		validacion: {
			name:'devengado',
			fieldLabel:'Devengado',
			allowBlank:false,
			loadMask: true,
			triggerAction: 'all',
			store:new Ext.data.SimpleStore({
				fields:['ID','valor'],data:[['S','S - Si'],['N','N - No']						           
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:120,
			width_grid:70,
			align:'center',
			grid_indice:2
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.devengado',
		id_grupo:0
	};
	
	Atributos[4]= {
		validacion: {
			name:'pagado',
			fieldLabel:'Pagado',
			allowBlank:false,
			loadMask: true,
			triggerAction: 'all',
			store:new Ext.data.SimpleStore({
				fields:['ID','valor'],data:[['S','S - Si'],['N','N - No']						           
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:120,
			width_grid:70,
			align:'center',
			grid_indice:2
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.pagado',
		id_grupo:0
	};

	//var filterCols_id_cbte=new Array();
    //var filterValues_id_cbte=new Array();
    //filterCols_id_cbte[0]='compro.id_depto';
    //filterValues_id_cbte[0]='%';
	Atributos[5]={
		validacion:{
			fieldLabel:'ID.Cbte.',
			allowBlank:false,
			vtype:'texto',
			emptyText:'ID.Cbte...',
			name:'id_cbte',
			desc:'id_cbte',
			store:ds_cbte,
			valueField:'id_comprobante',
			displayField:'nro_cbte',
			queryParam:'filterValue_0',
			tpl:tpl_id_cbte,
			filterCol:'COMPRO.nro_cbte',
			//filterCols:filterCols_id_cbte,
		    //filterValues:filterValues_id_cbte,
			typeAhead:true,
			forceSelection:true,
			renderer:render_cbte,		
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			align:'right',
			grid_indice:7
		},
		tipo:'ComboBox',
		filtro_0:true,
		//filtro_1:true,
		//filtro_2:true,
		filterColValue:'c.id_cbte',
		id_grupo:0
	};
	
	Atributos[6]={
		validacion:{
			name:'nro_cbte_orig',
			fieldLabel:'Correl.Orig.',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:14,
			disabled:true
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.nro_cbte_orig',
		id_grupo:1
	};
	
	Atributos[7]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Correl.',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:5
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.nro_cbte',
		id_grupo:0
	};

	Atributos[8]={
		validacion:{									
			name:'operacion',
			fieldLabel:'Operacion',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({
				fields:['ID','valor'],data:[['O','O - Documento Original'],['R','R - Documento de Reversión']
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:65,
			align:'center',
			grid_indice:11
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.operacion',
		id_grupo:0
	};
	
	Atributos[9]={
		validacion:{
			name:'fecha_validacion',
			fieldLabel:'Fecha Validacion',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:10,
			align:'center',
			renderer:formatDate
		},
		tipo: 'Field',
		form:false,
		filtro_0:false,
		dateFormat:'m-d-Y',
		filterColValue:'c.fecha_validacion',
		id_grupo:0
	};
		
	Atributos[10]={
		validacion:{
			name:'tipo_mov',
			fieldLabel:'Tipo Mov',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({
				fields:['ID','valor'],data:[['N','N - Gasto Normal'],['R','R - Gasto de Regularizacion']
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			align:'center',
			grid_indice:12
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.tipo_mov',
		id_grupo:0
	};
	
	Atributos[11]={
		validacion:{
			name:'tipo_pago',
			fieldLabel:'Tipo Pago',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({
				fields:['ID','valor'],data:[['B','B - Beneficiarios'],['A','A - Acreedores']
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			align:'center',
			grid_indice:13
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.tipo_pago'
	};

	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'id_declaracion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[13]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:19,
			renderer:formatDate
		},
		tipo: 'Field',
		form:false,
		filtro_0:false,
		dateFormat:'m-d-Y',
		filterColValue:'c.fecha_reg',
		id_grupo:0
	};

	var filterCols_id_cbte_orig=new Array();
    var filterValues_id_cbte_orig=new Array();
    filterCols_id_cbte_orig[0]='compro.id_depto';
    filterValues_id_cbte_orig[0]='%';	
	Atributos[14]={
		validacion:{
			fieldLabel:'Id.Cbte.Orig.',
			allowBlank:true,
			vtype:'texto',
			emptyText:'Cbte.Orig...',
			name:'id_cbte_orig',
			desc:'id_cbte_orig',
			store:ds_cbte,
			valueField:'id_comprobante',
			displayField:'nro_cbte',
			queryParam:'filterValue_0',
			tpl:tpl_id_cbte,
			filterCol:'COMPRO.nro_cbte',
			filterCols:filterCols_id_cbte_orig,
		    filterValues:filterValues_id_cbte_orig,
			typeAhead:true,
			forceSelection:true,
			renderer:render_cbte_orig,		
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:75,
			grid_indice:16,
			align:'right',
			disabled:true					
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.id_cbte_orig',
		id_grupo:1
	};
		
	Atributos[15]={
		validacion:{
			name:'modificado',
			fieldLabel:'Modificado',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			grid_indice:-1
		},
		tipo:'Field',
		form:false,
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.modificado',
		id_grupo:0
	};
	
	Atributos[16]={
		validacion:{
			name:'presentado',
			fieldLabel:'Presentado',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:-2,
			renderer:render_presentado
		},
		tipo: 'Field',
		form:false,
		filtro_0:false,
		filtro_1:false,
		filtro_2:false,
		filterColValue:'c.nro_cbte',
		id_grupo:0
	};
	
	Atributos[17]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			maxLength:200
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'c.observaciones',
		id_grupo:0
	};
	
	Atributos[18]={
		validacion:{
			name:'tipo_reg',
			fieldLabel:'Tipo Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		form:false,
		filterColValue:'c.tipo_reg',
		id_grupo:0
	};
	
	Atributos[19]={
		validacion:{
			name:'modificado',
			fieldLabel:'Modificado',
			grid_visible:true,
			grid_editable:false,
			width_grid:50
		},
		tipo:'Field',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		form:false,
		filterColValue:'c.modificado',
		id_grupo:0
	};

	//----------- FUNCIONES RENDER
	function formatDate(value){
	     return value?value.dateFormat('d/m/Y'):''
	}

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:' (Maestro)',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_sigma/vista/cbte_det/cbte_det.php'};

	var layout = new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
	layout.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnDelete=this.btnEliminar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_saveSuccess=this.saveSuccess;
	var CM_mostrarComponente=this.mostrarComponente;
	var getDialog=this.getDialog;
	var getGrid=this.getGrid;
	var enableSelect=this.EnableSelect;
	var selModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;

	//DEFINICION DE LA BARRA DE MENU
	var paramMenu={guardar:{crear:true,separador:true},nuevo:{crear:true,separador:true},actualizar:{crear:true,separador:false},eliminar:{crear:true,separador:false},editar:{crear:true,separador:false}};
	
	//DEFINICION DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cab_cbte/ActionEliminarCabCbte.php',parametros:'&m_id_declaracion='+maestro.id_declaracion},
		Save:{url:direccion+'../../../control/cab_cbte/ActionGuardarCabCbte.php',parametros:'&m_id_declaracion='+maestro.id_declaracion},
		ConfirmSave:{url:direccion+'../../../control/cab_cbte/ActionGuardarCabCbte.php',parametros:'&m_id_declaracion='+maestro.id_declaracion},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['47%','47%'],width:'50%',minWidth:350,minHeight:200,	closable:true,titulo:'Cabecera',grupos:[
		{
			tituloGrupo:'Datos Generales',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Reversion',
			columna:1,
			id_grupo:1
		}]}
	};

	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_declaracion=datos.m_id_declaracion;
		maestro.gestion=datos.m_gestion;
		maestro.mes=datos.m_mes;
		maestro.estado=datos.m_estado;
		maestro.id_gestion=datos.m_id_gestion;
		maestro.id_parametro=datos.m_id_parametro;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_declaracion:maestro.id_declaracion
			}
		};
		
		ds_cbte.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_declaracion:maestro.id_declaracion,
				m_sw_vista:'sigma'
			}
		};
		
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();

		this.btnActualizar();
		iniciarEventosFormularios();
		
		Atributos[12].defecto=maestro.id_declaracion;
		paramFunciones.Save.parametros='&m_id_declaracion='+maestro.id_declaracion;
		paramFunciones.ConfirmSave.parametros='&m_id_declaracion='+maestro.id_declaracion;
		this.iniciarEventosFormularios;
		this.InitFunciones(paramFunciones);
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		cmbOperacion=getComponente('operacion');
        cmbCbteOrig=getComponente('id_cbte_orig');
        txtCbteOrig=getComponente('nro_cbte_orig');
        
        var habilitarCbteReg = function() {
        	if(cmbOperacion.getValue()=='R'){
        		cmbCbteOrig.enable();
        		cmbCbteOrig.allowBlank=false;
        		txtCbteOrig.enable();
        		txtCbteOrig.allowBlank=false;
        		
        	} else{
        		cmbCbteOrig.setValue('');
        		cmbCbteOrig.disable();
        		cmbCbteOrig.allowBlank=true;
        		
        		txtCbteOrig.setValue('');
        		txtCbteOrig.disable();
        		txtCbteOrig.allowBlank=true;
        	}
        }
        
        cmbOperacion.on('blur',habilitarCbteReg);
        cmbOperacion.on('select',habilitarCbteReg);
	}
	
	//evento de deselecion de una linea de grid
	getSelectionModel().on('rowdeselect',function(){
		if(_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore()){
			_CP.getPagina(layout.getIdContentHijo()).pagina.bloquearMenu();
		}
	})

	this.EnableSelect=function(sm,row,rec){
		_CP.getPagina(layout.getIdContentHijo()).pagina.reload(rec.data,maestro);
		if(rec.data.tipo_reg=='registrado'){
		   _CP.getPagina(layout.getIdContentHijo()).pagina.desbloquearMenu();	
		}
		enableSelect(sm,row,rec);
	}

	//para que los hijos puedan ajustarse al tamaï¿½o  
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre

	this.InitBarraMenu(paramMenu);

	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_declaracion:maestro.id_declaracion
		}
	});
	
	layout.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}