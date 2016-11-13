<?php
session_start();
?>
//<script>
function main(){
	<?php
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";\n";
	echo "var idContenedor='$idContenedor';\n";
	?>
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_tipo_caracteristica:<?php echo $m_id_tipo_caracteristica;?>,codigo:'<?php echo $m_codigo;?>',descripcion:'<?php echo $m_descripcion;?>'};
var elemento={idContenedor:idContenedor,pagina:new PaginaCaracteristica(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

//<script>
function PaginaCaracteristica(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_caracteristica,h_txt_fecha_reg;
	var edit=false;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/caracteristica/ActionListarCaracteristica.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_caracteristica',
			totalRecords:'TotalCount'
		},[
		{name:'descripcion',type:'string'},
		'id_caracteristica',
		'nombre',
		'tipo_dato',
		'descripcion',
		'id_tipo_unidad_medida',
		'id_tipo_caracteristica',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_unid_med',
		'desc_tipo_caracteristica'
		]),
		remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_caracteristica:maestro.id_tipo_caracteristica
		}
	});
	/////////////////////////////////
	// DEFINICIÓN DATOS DEL MAESTRO//
	/////////////////////////////////
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['ID',maestro.id_tipo_caracteristica],['Código Característica',maestro.codigo],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//////////////
	//PARÁMETROS//
	//////////////
	//DATA STORE COMBOS
	ds_tipunimed=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/tipo_unidad_medida/ActionListarTipoUnidadMedida.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_unidad_medida',
			totalRecords:'TotalCount'
		},['id_tipo_unidad_medida','nombre','descripcion'])
	});
	//FUNCIONES RENDER
	function renderTipUniMed(value,p,record){return String.format('{0}',record.data['desc_tipo_unid_med'])}
	var resultTplTipUniMed=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	/////////// hidden idtipo_activo_proces//////
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_caracteristica',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_caracteristica'
	};
	//////// txt nombre ///////
	vectorAtributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			width:'50%'
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CAR.nombre',
		save_as:'txt_nombre'
	};
	/////////// combo tipo_dato//////
	vectorAtributos[2]={
		validacion:{
			name:'tipo_dato',
			fieldLabel:'Tipo de Dato',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['valor','tipo'],data:Ext.caracteristicaCombo.tipo_dato}),
			store:new Ext.data.SimpleStore({fields:['valor','tipo'],data:[['Entero','Entero'],['Decimal','Decimal'],['Texto','Texto'],['Fecha','Fecha']]}),
			valueField:'valor',
			displayField:'tipo',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:"75%"
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CAR.tipo_dato',
		defecto:'Entero',
		save_as:'txt_tipo_dato'
	};
	//////// txt descripcion ///////
	vectorAtributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:150,
			grow:true,
			width:'70%'
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'CAR.descripcion',
		save_as:'txt_descripcion'
	};
	/////////// chk_unidad_medida//////
	vectorAtributos[4]={
		validacion:{
			name:'unidad_medida',
			labelSeparator:'',
			boxLabel:'Unidad de Medida',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Checkbox',
		save_as:'chk_unidad_medida'
	};
	/////////// txt id_tipo_unidad_medida///////
	vectorAtributos[5]={
		validacion:{
			fieldLabel:'Tipo Unidad de Medida',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Tipo de Unidad de Medida...',
			name:'id_tipo_unidad_medida',
			desc:'desc_tipo_unid_med',
			store:ds_tipunimed,
			valueField:'id_tipo_unidad_medida',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'TUM.nombre#TUM.descripcion',
			typeAhead:true,
			forceSelection:true,
			tpl:resultTplTipUniMed,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderTipUniMed,
			disabled:true,
			width:200,
			grid_visible:true,
			grid_editable:true,
			width_grid:150 
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'TUM.nombre#TUM.descripcion',
		save_as:'txt_id_tipo_unidad_medida'
	};
	/////////// txt id_tipo_caracteristica//////
	vectorAtributos[6]={
		validacion:{
			name:'id_tipo_caracteristica',
			labelSeparator:'',
			inputType:"hidden",
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		save_as:'txt_id_tipo_caracteristica',
		defecto:maestro.id_tipo_caracteristica
	};
	// txt fecha_reg
	vectorAtributos[7]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:120,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAR.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''}
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	// ---------- Inicia Layout ---------------//
	var config={titulo_maestro:"Tipo de Caracteristicas (Maestro)",titulo_detalle:"Caracteristicas (Detalle)"};
	layout_caracteristica=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_caracteristica.init(config);
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////
	// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_caracteristica,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	/////////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ //
	///////////////////////////////////
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	////////////////////////////
	// DEFINICIÓN DE FUNCIONES//
	////////////////////////////
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/caracteristica/ActionEliminarCaracteristica.php"},
		Save:{url:direccion+"../../../control/caracteristica/ActionGuardarCaracteristica.php"},
		ConfirmSave:{url:direccion+"../../../control/caracteristica/ActionGuardarCaracteristica.php"},
		Formulario:{html_apply:"dlgInfo-"+idContenedor,width:'50%',height:300,minWidth:150,minHeight:200,closable:true,titulo:'Características',columnas:['96%']}
	};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tipo_caracteristica=datos.m_id_tipo_caracteristica;
		maestro.codigo=datos.m_codigo;
		maestro.descripcion=datos.m_descripcion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_caracteristica:maestro.id_tipo_caracteristica
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['ID',maestro.id_tipo_caracteristica],['Código Característica',maestro.codigo],['Descripción',maestro.descripcion]]);
		vectorAtributos[6].defecto=maestro.id_tipo_caracteristica;
		var paramFunciones={
	    btnEliminar:{url:direccion+"../../../control/caracteristica/ActionEliminarCaracteristica.php"},
		Save:{url:direccion+"../../../control/caracteristica/ActionGuardarCaracteristica.php"},
		ConfirmSave:{url:direccion+"../../../control/caracteristica/ActionGuardarCaracteristica.php"},
		Formulario:{html_apply:"dlgInfo-"+idContenedor,width:'50%',height:300,minWidth:150,minHeight:200,closable:true,titulo:'Características',columnas:['96%']}
		};
	this.InitFunciones(paramFunciones)
	};
	function iniciarEventosFormularios(){
		combo_tipo_dato=ClaseMadre_getComponente('tipo_dato');
		h_txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		combo_unidad_medida=ClaseMadre_getComponente('id_tipo_unidad_medida');
		chk_unidad_medida=ClaseMadre_getComponente('unidad_medida');
		function habilitar_unidad_medida(){
			if(!edit){
				habilitar_check_unid_med();
				if((combo_tipo_dato.getValue()=='Entero' || combo_tipo_dato.getValue()=='Decimal') && chk_unidad_medida.getValue()){
					combo_unidad_medida.allowBlank=false;
					combo_unidad_medida.setValue('');
					combo_unidad_medida.enable()
				}
				else{
					combo_unidad_medida.allowBlank=true;
					combo_unidad_medida.setValue('');
					combo_unidad_medida.disable()
				}
			}
		}
	  function habilitar_check_unid_med(){
			if(combo_tipo_dato.getValue()=='Texto' || combo_tipo_dato.getValue()=='Fecha'){
				chk_unidad_medida.checked=false;
				chk_unidad_medida.disable()
			}
			else{
				chk_unidad_medida.enable()
			}
		}
		combo_tipo_dato.on('change',habilitar_unidad_medida);
		combo_tipo_dato.on('select',habilitar_unidad_medida);
		chk_unidad_medida.on('check',habilitar_unidad_medida)
	}
	this.btnNew=function(){
		CM_ocultarComponente(h_txt_fecha_reg);
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		edit=true;
		CM_ocultarComponente(h_txt_fecha_reg);
		//Tiquea o destiquea el check en función de si tiene unidad de medida o no
		if(combo_unidad_medida.getValue()!=undefined && combo_unidad_medida.getValue()!=''){
			chk_unidad_medida.setValue('true');
			combo_unidad_medida.enable()
		}
		else{
			chk_unidad_medida.setValue('false');
			combo_unidad_medida.disable()
		}
		ClaseMadre_btnEdit();
		edit=false
	};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_caracteristica.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}