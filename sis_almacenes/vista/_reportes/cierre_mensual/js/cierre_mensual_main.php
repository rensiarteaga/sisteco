//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var elemento={pagina:new RepCierreMensualAlmacen(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
//view added

function RepCierreMensualAlmacen(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var data_ep,combo_almacen,txt_fecha_cierre,layout_rep_cierre_mensual;
	//DATA STORE
	ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_almacenes/control/almacen/ActionListarAlmacen.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_almacen',totalRecords:'TotalCount'},['id_almacen','codigo','nombre','descripcion','direccion','via_fil_max','via_col_max','bloqueado','cerrado','nro_prest_pendientes','nro_ing_no_finalizados','nro_sal_no_finalizadas','observaciones','fecha_ultimo_inventario','fecha_reg','id_regional'])});
	// Template combo
	var resultTplAlm=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	filterCols_almacen[0]='ALMACE.cerrado';
	filterValues_almacen[0]='No';
	filterCols_almacen[1]='ALMACE.bloqueado';
	filterValues_almacen[1]='no';
	vectorAtributos[0]={
			validacion:{
			name:'id_almacen',
			fieldLabel:'Almacen',
			allowBlank:true,			
			emptyText:'Almacen...',
			desc:'nombre', 
			store:ds_almacen,
			valueField:'id_almacen',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			typeAhead:true,
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
			forceSelection:true,
			tpl:resultTplAlm,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:300,
			grow:true,
			width:'90%',
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true
			},
		tipo:'ComboBox',
		id_grupo:0,
		filterColValue:'ALMACE.nombre#ALMACE.descripcion',
		defecto:'',
		save_as:'txt_id_almacen'
	};
	// txt fecha_reg
	vectorAtributos[1]={
		validacion:{
			name:'fecha_cierre',
			fieldLabel:'Fecha de Cierre',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:90,
			disabled:false
		},
		tipo:'DateField',
		id_grupo:0,
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_cierre'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Cierre Mensual de Almacenes"};
	layout_rep_cierre_mensual=new DocsLayoutProceso(idContenedor);
	layout_rep_cierre_mensual.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
	this.pagina(paramConfig,vectorAtributos,layout_rep_cierre_mensual,idContenedor);
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		combo_almacen=ClaseMadre_getComponente('id_almacen');
		txt_fecha_cierre=ClaseMadre_getComponente('fecha_cierre');
		
	}
	function actualizar_ds_almacen(){
	  combo_almacen.store.proxy=new Ext.data.HttpProxy({url:direccion+'../../../../../sis_almacenes/control/almacen/ActionListarAlmacenEP.php?'+data_ep})
	}
	function retorno(){
		Ext.MessageBox.hide();//ocultamos el loading
		var id_almacen=combo_almacen.getValue();
		     Ext.Ajax.request({
					url:direccion+'../../../../../sis_almacenes/control/cierre_almacen/ActionListarCierreAlmacen.php?id_almacen='+id_almacen,
					method:'GET',
					success:ter,
					timeout:100000
				})		
		}
	function ter(resp){
		var root = resp.responseXML.documentElement;
		var d_fecha_apertura=new Date();
		var d_fecha_cierre=new Date();
			var d_id_almacen = root.getElementsByTagName('id_almacen')[0].firstChild.nodeValue;
			var d_codigo=root.getElementsByTagName('codigo')[0].firstChild.nodeValue;
			var d_nombre=root.getElementsByTagName('nombre')[0].firstChild.nodeValue;
			var d_direccion=root.getElementsByTagName('direccion')[0].firstChild.nodeValue;
			var d_descripcion=root.getElementsByTagName('descripcion')[0].firstChild.nodeValue;
//			/var d_observaciones=root.getElementsByTagName('observaciones')[0].firstChild.nodeValue;
			var d_observaciones='';
			 d_fecha_apertura=root.getElementsByTagName('fecha_apertura')[0].firstChild.nodeValue;
			 d_fecha_cierre=root.getElementsByTagName('fecha_cierre')[0].firstChild.nodeValue;
			 CerrarAlmacen(d_id_almacen,d_codigo,d_nombre,d_direccion,d_descripcion,d_observaciones,d_fecha_apertura,d_fecha_cierre);
			 mostrarFrm()
			}
	function CerrarAlmacen(d_id_almacen,d_codigo,d_nombre,d_direccion,d_descripcion,d_observaciones,d_fecha_apertura,d_fecha_cierre){
	marcas_html="<div class='x-dlg-hd'>"+'Cierre Mensual de Almacen'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
	var div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
	Formulario=new Ext.form.Form({
				id:'frm_'+idContenedor,
				name:'frm_'+idContenedor,
				labelWidth:150 // label settings here cascade unless overridden				
			});
	dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
		        modal:true,
		        labelWidth:150,
				width:470,
				height:300,
				minWidth:paramFunciones.Formulario.minWidth,
				minHeight:paramFunciones.Formulario.minHeight,
				closable:paramFunciones.Formulario.closable,
				center:{
				titlebar:false,
				autoScroll:true,
				tabPosition:'top',
				alwaysShowTabs:false,
				closeOnTab:true,
				//resizeTabs:true,
				fitToFrame:true}
			});
			
	var existencias=function(){existenciasAlm(d_id_almacen)};
	var ingresos=function(){ingresosAlm(d_id_almacen,d_fecha_apertura,d_fecha_cierre)};
	var salidas=function(){salidasAlm(d_id_almacen,d_fecha_apertura,d_fecha_cierre)};
	dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
	dlgFrm.addButton('Terminar',ocultarFrm);
	dlgFrm.addButton('Saldo Existencias Físicas',existencias);
	dlgFrm.addButton('Resumen de Entradas',ingresos);
	dlgFrm.addButton('Resumen de Salidas',salidas);
	//creación de componentes
	id_almacen=new Ext.form.Field({
		labelSeparator:'',
			name:'id_almacen',
			inputType:'hidden',
			grid_visible:false, 
			value:d_id_almacen,
			grid_editable:false
	});
	codigo=new Ext.form.TextField({
		name:'codigo',
		fieldLabel:'Código',
		allowBlank:true,
		maxLength:100,
		minLength:0,
		selectOnFocus:true,
		value:d_codigo,
		disabled:true,
		width:150
	});
	nombre=new Ext.form.TextField({
		    name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			value:d_nombre,
			disabled:true,
			width:180
	});
	direcciones=new Ext.form.TextField({
		    name:'direccion',
			fieldLabel:'Dirección',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			value:d_direccion,
			disabled:true,
			width:210
	});
	descripcion=new Ext.form.TextField({
		    name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			value:d_descripcion,
			disabled:true,
			width:210
	});
	observaciones=new Ext.form.TextField({
		    name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			value:d_observaciones,
			disabled:true,
			width:210
	});
	fecha_apertura=new Ext.form.TextField({
		    name:'fecha_apertura',
			fieldLabel:'Fecha de Apertura',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			format:'d/m/Y',
			grid_visible:true,
			grid_editable:true,
			value:d_fecha_apertura,
			disabled:true,
			width:85
	});
	fecha_cierre=new Ext.form.TextField({
		    name:'fecha_cierre',
			fieldLabel:'Fecha de Cierre',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			format:'d/m/Y',
			grid_visible:true,
			grid_editable:true,
			value:d_fecha_cierre,
			disabled:true,
			width:85
	});
	Formulario.fieldset({legend:'Información del Almacen'},id_almacen,codigo,nombre,direcciones,descripcion,observaciones,fecha_apertura,fecha_cierre);
	Formulario.render("form-ct2_"+idContenedor)
     }
    function ocultarFrm(){dlgFrm.hide();Ext.MessageBox.hide();combo_almacen.reset();txt_fecha_cierre.reset()}
    function mostrarFrm(){dlgFrm.show()}
    function ingresosAlm(d_id_almacen,d_fecha_apertura,d_fecha_cierre){	
		window.open(direccion+'../../../../control/_reportes/ingresos_fisico/ActionReporteIngresosFisico.php?txt_id_almacen='+d_id_almacen+'&txt_fecha_apertura='+d_fecha_apertura+'&txt_fecha_cierre='+d_fecha_cierre,'Reporte de Ingresos','resizable=1,toolbar=1,location=1,menubar=1')
	}
	function salidasAlm(d_id_almacen,d_fecha_apertura,d_fecha_cierre){	
		window.open(direccion+'../../../../control/_reportes/salidas_fisico/ActionReporteSalidasFisico.php?txt_id_almacen='+d_id_almacen+'&txt_fecha_apertura='+d_fecha_apertura+'&txt_fecha_cierre='+d_fecha_cierre,'Reporte de Salidas','resizable=1,toolbar=1,location=1,menubar=1')	
	}
	function existenciasAlm(d_id_almacen){	
		window.open(direccion+'../../../../control/_reportes/existencia_almacen/ActionReporteExistenciaAlmacen.php?txt_id_almacen='+d_id_almacen,'Reporte de Existencias','resizable=1,toolbar=1,location=1,menubar=1')
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={ 
		Formulario:{ 
			labelWidth:75,
			url:direccion+'../../../../../sis_almacenes/control/cierre_almacen/ActionCierreMensualAlmacen.php',
			abrir_pestana:false,
			fileUpload:false,
			success:retorno,
			columnas:[305,305],
			grupos:[{ 
			tituloGrupo:'Seleccion de Almacen',
			columna:0,
			id_grupo:0}]
			,parametros:''}
	};
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}