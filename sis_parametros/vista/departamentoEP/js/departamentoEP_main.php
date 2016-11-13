<?php
/**
 * Nombre:		  	    departamentoEP_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-01-23 11:04:01
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
var maestro={id_depto:<?php echo $id_depto;?>,codigo_depto:decodeURIComponent('<?php echo $codigo_depto;?>'),nombre_depto:decodeURIComponent('<?php echo $nombre_depto;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_departamentoEP(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_departamentoEP.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2009-01-23 11:04:01
 */
function pagina_departamentoEP(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var id_ep;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto_ep/ActionListarDepartamentoEP.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depto_ep',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_depto_ep',
		'id_depto',
		'desc_depto',
		'id_ep',
		'desc_ep',
		'estado',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa','codigo_proyecto','codigo_actividad'
		,'nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
		'id_depto_division','division'
		]),remoteSort:true});
	
	// DEFINICIï¿½N DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['ID Depto.',maestro.id_depto],['Codigo ',maestro.codigo_depto],['Departamento ',maestro.nombre_depto]];
	
	//DATA STORE COMBOS
    var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto/ActionListarDepto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado'])
	});

    var ds_depto_div = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto_div/ActionListarDepartamentoDiv.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_division',totalRecords: 'TotalCount'},['id_depto_division','id_depto','desc_depto','codigo_division','division','estado']),
		baseParams:{id_depto:maestro.id_depto, sw_del:'si'}
    });
    
    var ds_fina_regi_prog_proy_acti = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fina_regi_prog_proy_acti/ActionListarFinaRegiProgProyActi.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fina_regi_prog_proy_acti',totalRecords: 'TotalCount'},['id_fina_regi_prog_proy_acti','descripcion_programa','codigo_programa','descripcion_proyecto','codigo_proyecto','descripcion_actividad','codigo_actividad','desc_frppa'])
	});

	//FUNCIONES RENDER
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','<FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');
	
	function render_id_depto_div(value, p, record){return String.format('{0}', record.data['division']);}
	var tpl_id_depto_div=new Ext.Template('<div class="search-item">','<FONT COLOR="#0000ff">{codigo_division}-{division}</FONT><br>','<FONT COLOR="#B5A642">{desc_depto}</FONT>','</div>');

	function render_id_ep(value, p, record){return String.format('{0}', record.data['desc_ep']);}
	var tpl_id_ep=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_frppa}</FONT><br>','<FONT COLOR="#B5A642">{codigo_programa}</FONT><br>','<FONT COLOR="#0000ff">{descripcion_proyecto}</FONT><br>','<FONT COLOR="#B5A642">{codigo_proyecto}</FONT><br>','<FONT COLOR="#0000ff">{descripcion_actividad}</FONT><br>','<FONT COLOR="#B5A642">{codigo_actividad}</FONT>','</div>');

	/////////////////////////
	// Definicion de datos //
	/////////////////////////
	
	// hidden id_depto_ep
	//en la posicion 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depto_ep',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	// txt id_depto
	Atributos[1]={
		validacion:{
			name:'id_depto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_depto
	};
	
	// txt id_ep
	Atributos[2]= {
		validacion:{
			pregarga:false,
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programatica',
			name:'id_ep',
			queryDelay:250,
			minChars: 1,
			triggerAction: 'all',
			grid_indice:2,
			width:300,
			grid_visible:true,
			grid_editable:false	
		},
		tipo: 'epField',
		filtro_0:true,
		filterColValue:'VPM.nombre_financiador#VPM.nombre_regional#VPM.nombre_programa#VPM.nombre_proyecto#VPM.nombre_actividad',
		save_as:'id_ep'
	};
	
	Atributos[3]= {
		validacion:{
			fieldLabel:'División',
			name:'id_depto_division',
			allowBlank:true,
			desc:'division',
			store:ds_depto_div,
			valueField:'id_depto_division',
			displayField:'division',
			queryParam:'filterValue_0',
			filterCol:'DEPDIV.division',
			typeAhead:false,
			forceSelection:false,
			tpl:tpl_id_depto_div,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto_div,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300	
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,			
		filterColValue:'DEPDIV.division',
		save_as:'id_depto_division'
	};
	
	Atributos[4]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:50,
			width:100
		},
		tipo:'ComboBox',
		defecto:'activo',
		form: true,
		filtro_0:true,
		filterColValue:'DEPEP.estado'
	};
	
	Atributos[5]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_ep'
	};
	
	Atributos[6]={
		validacion:{
			name:'id_ep',
			fieldLabel:'ID EP',
			inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			align: 'right',
			width_grid:60
		},
		tipo:'Field',
		form: false,
		filtro_0:false,
		save_as:'id_epe'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Departamentos (Maestro)',titulo_detalle:'departamentoEP (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_departamentoEP = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_departamentoEP.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_departamentoEP,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	
	//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/depto_ep/ActionEliminarDepartamentoEP.php',parametros:'&id_depto='+maestro.id_depto},
	Save:{url:direccion+'../../../control/depto_ep/ActionGuardarDepartamentoEP.php',parametros:'&id_depto='+maestro.id_depto},
	ConfirmSave:{url:direccion+'../../../control/depto_ep/ActionGuardarDepartamentoEP.php',parametros:'&id_depto='+maestro.id_depto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'departamentoEP'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_depto:maestro.id_depto
			}
		};
		
		this.btnActualizar();
		
		ds_depto_div.baseParams={
				id_depto:maestro.id_depto, 
				sw_del:'si'
		}
		
		data_maestro=[['ID Depto.',maestro.id_depto],['Codigo ',maestro.codigo_depto],['Departamento ',maestro.nombre_depto]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_depto;

		paramFunciones.btnEliminar.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.Save.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.ConfirmSave.parametros='&id_depto='+maestro.id_depto;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
		id_ep=ClaseMadre_getComponente('id_fina_regi_prog_proy_acti');
	    cmbEp=ClaseMadre_getComponente('id_ep');
	    
		var onEpSelect = function(e){
			var ep=cmbEp.getValue();
			id_ep.setValue(ep['id_fina_regi_prog_proy_acti']);
		};
		
		cmbEp.on('change',onEpSelect);
		cmbEp.on('select',onEpSelect);
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_departamentoEP.getLayout()};
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_depto:maestro.id_depto
		}
	});
	
	ds_depto_div.load({
		params:{
			start:0,
			limit:10,
			id_depto:maestro.id_depto, 
			sw_del:'si'
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_departamentoEP.getLayout().addListener('layout',this.onResize);
	layout_departamentoEP.getVentana(idContenedor).on('resize',function(){layout_departamentoEP.getLayout().layout()})
}