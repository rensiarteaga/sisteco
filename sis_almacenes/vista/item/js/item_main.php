<?php 
session_start();
?>
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
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	if($registro=="nuevo"){
		echo "reg="."'$registro'".';';
	} else {
		echo "reg="."'antiguo'".';';
	}
	?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:3,FiltroEstructura:false,FiltroAvanzado:fa,registro:reg};
	var elemento={pagina:new PaginaItem(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function PaginaItem(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_item;
	var elementos=new Array();
	var sw=0;
	var combo_supergrupo,combo_grupo,combo_subgrupo,combo_id1,combo_id2,combo_id3,txt_nombre,txt_descripcion,txt_codigo,txt_nivel_convertido,txt_fecha_reg,h_txt_codigo,h_txt_cod;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},
		[{name:'codigo',type:'string'},
		'id_item',
		'codigo',
		'descripcion',
		'precio_venta_almacen',
		'costo_estimado',
		'stock_min',
		'observaciones',
		'nivel_convertido',
		'estado_registro',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_unidad_medida_base',
		'id_id3',
		'id_id2',
		'id_id1',
		'id_subgrupo',
		'id_grupo',
		'id_supergrupo',
		'nombre',
		'nombre_id3',
		'nombre_id2',
		'nombre_id1',
		'nombre_subg',
		'nombre_grupo',
		'nombre_supg',
		'nombre_unid_base',
		'peso_kg',
		'mat_bajo_responsabilidad',
		'calidad',
		'descripcion_aux'
		]),
		remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			registro:paramConfig.registro
		}
	});
	/////DATA STORE COMBOS////////////
	var ds_unid_med_bas=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords:'TotalCount'},['id_unidad_medida_base','nombre','abreviatura'])
	});
	var ds_supergrupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre','codigo'])
	});
	var ds_grupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/grupo/ActionListarGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre','codigo'])
	});
	var ds_subgrupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/subgrupo/ActionListarSubGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},['id_subgrupo','nombre','codigo'])
	});
	var ds_id1=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id1/ActionListarId1.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id1',totalRecords:'TotalCount'},['id_id1','nombre','codigo'])
	});
	var ds_id2=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id2/ActionListarId2.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id2',totalRecords:'TotalCount'},['id_id2','nombre','codigo'])
	});
	var ds_id3=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id3/ActionListarId3.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id3',totalRecords:'TotalCount'},['id_id3','nombre','codigo'])
	});

	////////////////FUNCIONES RENDER ////////////
	function renderUnidMedBas(value,p,record){return String.format('{0}',record.data['nombre_unid_base'])}
	function renderId3(value,p,record){return String.format('{0}',record.data['nombre_id3'])}
	function renderId2(value,p,record){return String.format('{0}',record.data['nombre_id2'])}
	function renderId1(value,p,record){return String.format('{0}',record.data['nombre_id1'])}
	function renderSubgrupo(value,p,record){return String.format('{0}',record.data['nombre_subg'])}
	function renderGrupo(value,p,record){return String.format('{0}',record.data['nombre_grupo'])}
	function renderSupergrupo(value,p,record){return String.format('{0}',record.data['nombre_supg'])}
	var resultTplSupGru=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Cï¿½digo: </b>{codigo}</FONT>','</div>');
	var resultTplGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Cï¿½digo: </b>{codigo}</FONT>','</div>');
	var resultTplSubGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Cï¿½digo: </b>{codigo}</FONT>','</div>');
	var resultTplId1=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Cï¿½digo: </b>{codigo}</FONT>','</div>');
	var resultTplId2=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Cï¿½digo: </b>{codigo}</FONT>','</div>');
	var resultTplId3=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Cï¿½digo: </b>{codigo}</FONT>','</div>');
	var resultTplUniMed=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abreviatura: </b>{abreviatura}</FONT>','</div>');

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_item',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_item'
	};
	var filterCols_super_grupo=new Array();
	var filterValues_super_grupo=new Array();
	filterCols_super_grupo[0]='estado_registro';
	filterValues_super_grupo[0]='activo';

	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Super Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Super Grupo...',
			name:'id_supergrupo',
			sortCol:'supgru.nombre',
			desc:'nombre_supg',
			store:ds_supergrupo,
			valueField:'id_supergrupo',
			displayField:'nombre',
			filterCol:'supgru.nombre#supgru.codigo',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplSupGru,
			mode:'remote',
			filterCols:filterCols_super_grupo,
			filterValues:filterValues_super_grupo,
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderSupergrupo,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			grid_indice:4
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'supgru.nombre#supgru.codigo',
		save_as:'hidden_id_supergrupo'
	};

	var filterCols_grupo=new Array();
	var filterValues_grupo=new Array();
	filterCols_grupo[0]='supgru.id_supergrupo';
	filterValues_grupo[0]='%';
	filterCols_grupo[1]='g.estado_registro';
	filterValues_grupo[1]='activo';
	vectorAtributos[2]={
		validacion:{
			fieldLabel:'Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Grupo...',
			name:'id_grupo',
			desc:'nombre_grupo',
			store:ds_grupo,
			valueField:'id_grupo',
			displayField:'nombre',
			filterCol:'g.nombre#g.codigo',
			filterCols:filterCols_grupo,
			filterValues:filterValues_grupo,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplGrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderGrupo,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:300,
			grid_indice:5
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'g.nombre#g.codigo',
		save_as:'hidden_id_grupo'
	};

	var filterCols_subgrupo=new Array();
	var filterValues_subgrupo=new Array();
	filterCols_subgrupo[0]='supgru.id_supergrupo';
	filterValues_subgrupo[0]='%';
	filterCols_subgrupo[1]='g.id_grupo';
	filterValues_subgrupo[1]='%';
	filterCols_subgrupo[2]='sub.estado_registro';
	filterValues_subgrupo[2]='activo';
	vectorAtributos[3]={
		validacion:{
			fieldLabel:'Sub Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Sub Grupo...',
			name:'id_subgrupo',
			desc:'nombre_subg',
			store:ds_subgrupo,
			valueField:'id_subgrupo',
			displayField:'nombre',
			filterCol:'sub.nombre#sub.codigo',
			filterCols:filterCols_subgrupo,
			filterValues:filterValues_subgrupo,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplSubGrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderSubgrupo,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:300,
			grid_indice:6
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'sub.nombre#sub.codigo',
		save_as:'hidden_id_subgrupo'
	};

	var filterCols_id1=new Array();
	var filterValues_id1=new Array();
	filterCols_id1[0]='supgru.id_supergrupo';
	filterValues_id1[0]='%';
	filterCols_id1[1]='g.id_grupo';
	filterValues_id1[1]='%';
	filterCols_id1[2]='sub.id_subgrupo';
	filterValues_id1[2]='%';
	filterCols_id1[3]='id1.estado_registro';
	filterValues_id1[3]='activo';
	vectorAtributos[4]={
		validacion:{
			fieldLabel:'Identificador 1',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Identificador 1...',
			name:'id_id1',
			desc:'nombre_id1',
			store:ds_id1,
			valueField:'id_id1',
			displayField:'nombre',
			filterCol:'id1.nombre#id1.codigo',
			filterCols:filterCols_id1,
			filterValues:filterValues_id1,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId1,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderId1,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			grid_indice:7
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'id1.nombre#id1.codigo',
		save_as:'hidden_id_id1'
	};

	var filterCols_id2=new Array();
	var filterValues_id2=new Array();
	filterCols_id2[0]='supgru.id_supergrupo';
	filterValues_id2[0]='%';
	filterCols_id2[1]='g.id_grupo';
	filterValues_id2[1]='%';
	filterCols_id2[2]='sub.id_subgrupo';
	filterValues_id2[2]='%';
	filterCols_id2[3]='id1.id_id1';
	filterValues_id2[3]='%';
	filterCols_id2[4]='id2.estado_registro';
	filterValues_id2[4]='activo';
	vectorAtributos[5]={
		validacion:{
			fieldLabel:'Identificador 2',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Identificador 2...',
			name:'id_id2',
			desc:'nombre_id2',
			store:ds_id2,
			valueField:'id_id2',
			displayField:'nombre',
			filterCol:'id2.nombre#id2.codigo',
			filterCols:filterCols_id2,
			filterValues:filterValues_id2,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId2,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderId2,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			grid_indice:8
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'id2.nombre#id2.codigo',
		save_as:'hidden_id_id2'
	};

	var filterCols_id3=new Array();
	var filterValues_id3=new Array();
	filterCols_id3[0]='supgru.id_supergrupo';
	filterValues_id3[0]='%';
	filterCols_id3[1]='g.id_grupo';
	filterValues_id3[1]='%';
	filterCols_id3[2]='sub.id_subgrupo';
	filterValues_id3[2]='%';
	filterCols_id3[3]='id1.id_id1';
	filterValues_id3[3]='%';
	filterCols_id3[4]='id2.id_id2';
	filterValues_id3[4]='%';
	filterCols_id3[5]='id3.estado_registro';
	filterValues_id3[5]='activo';
	vectorAtributos[6]={
		validacion:{
			fieldLabel:'Identificador 3',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Identificador 3...',
			name:'id_id3',
			desc:'nombre_id3',
			store:ds_id3,
			valueField:'id_id3',
			displayField:'nombre',
			filterCol:'id3.nombre#id3.codigo',
			filterCols:filterCols_id3,
			filterValues:filterValues_id3,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId3,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderId3,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			grid_indice:9
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'id3.nombre#id3.codigo',
		save_as:'hidden_id_id3'
	};

	vectorAtributos[7]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:5,
			minLength:1,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:100,
			disabled:true,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ite.codigo',
		save_as:'txt_codigo'
	};

	vectorAtributos[8]={
		validacion:{
			name:'nombre',
			fieldLabel:'Item',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:2
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ite.nombre',
		save_as:'txt_nombre'
	};

	vectorAtributos[9]={
		validacion:{
			fieldLabel:'Unidad Medida',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Unidad Medida...',
			name:'id_unidad_medida_base',
			desc:'nombre_unid_base',
			store:ds_unid_med_bas,
			valueField:'id_unidad_medida_base',
			displayField:'nombre',
			filterCol:'UNMEDB.nombre#UNMEDB.abreviatura',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplUniMed,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderUnidMedBas,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:300,
			grid_indice:10
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'umb.nombre',
		save_as:'hidden_id_unidad_medida_base'
	};

	vectorAtributos[10]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:3
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ite.descripcion',
		save_as:'txt_descripcion'
	};

	vectorAtributos[11]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.itemCombo.estado_registro}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			grid_indice:15
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ite.estado_registro',
		defecto: "activo",
		save_as:'txt_estado_registro'
	};

	vectorAtributos[12]={
		validacion:{
			name:'precio_venta_almacen',
			fieldLabel:'Precio Venta',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:85,
			align:'right',
			renderer:'usMoney',
			grid_indice:11
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'ite.precio_venta_almacen',
		save_as:'txt_precio_venta_almacen'
	};

	vectorAtributos[13]={
		validacion:{
			name:'costo_estimado',
			fieldLabel:'Costo Estimado',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			align:'right',
			renderer:'usMoney',
			grid_indice:12
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'ite.costo_estimado',
		save_as:'txt_costo_estimado'
	};

	vectorAtributos[14]={
		validacion:{
			name:'stock_min',
			fieldLabel:'Stock Mí­nimo',
			allowBlank:true,
			allowDecimals:false,
			allowNegative:false,
			maxLength:30,
			minLength:0,
			minValue:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:90,
			align:'right',
			grid_indice:13
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'ite.stock_min',
		save_as:'txt_stock_min'
	};

	vectorAtributos[15]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			width:'80%',
			grid_visible:true,
			grid_editable:true,
			vtype:"texto",
			width_grid:150,
			grid_indice:14
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ite.observaciones',
		save_as:'txt_observaciones'
	};

	vectorAtributos[16]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:16
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'ite.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y',
		defecto:""
	};

	vectorAtributos[17]={
		validacion:{
			name:'nivel_convertido',
			fieldLabel:'nivel',
			allowBlank:true,
			maxLength:1,
			minLength:0,
			selectOnFocus:true,
			width:'50%',
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			grid_indice:17
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'txt_nivel_convertido',
		defecto:""
	};

	vectorAtributos[18]={
		validacion:{
			name:'peso_kg',
			fieldLabel:'Peso(Kg)',
			allowBlank:true,
			maxLength:20,
			allowDecimals:true,
			maxLength:20,
			allowNegative:false,
			selectOnFocus:true,
			width:'50%',
			grid_visible:true,
			grid_editable:true,
			width_grid:80,
			grid_indice:17,
			align:'right',
			decimalPrecision:5
		},
		tipo:'NumberField',
		filtro_0:false,
		save_as:'txt_peso_kg',
		defecto:""
	};
	vectorAtributos[19]={
		validacion:{
			name:'mat_bajo_responsabilidad',
			fieldLabel:'Mat Bajo Resp',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.itemCombo.mat_bajo_responsabilidad}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//width:'50%',
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:15
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ite.mat_bajo_responsabilidad',
		defecto: "no",
		save_as:'txt_mat_bajo_responsabilidad',
		defecto:'no'
	};

	vectorAtributos[20]={
		validacion:{
			name:'calidad',
			fieldLabel:'Calidad',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			width:'80%',
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			grid_indice:3
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'ite.calidad',
		save_as:'txt_calidad'
	};

	vectorAtributos[21]={
		validacion:{
			name:'descripcion_aux',
			fieldLabel:'Descripción Aux.',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			grid_visible:false,
			grid_editable:false,
			vtype:"texto",
			width_grid:130,
			grid_indice:3
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'ite.descripcion_aux',
		save_as:'txt_descripcion_aux'
	};

	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	// ---------- Inicia Layout ---------------//
	var config={titulo_maestro:"Items",grid_maestro:"grid-"+idContenedor};
	layout_item=new DocsLayoutMaestro(idContenedor);
	layout_item.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_item,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/item/ActionEliminarItem.php"},
		Save:{url:direccion+"../../../control/item/ActionGuardarItem.php"},
		ConfirmSave:{url:direccion+"../../../control/item/ActionGuardarItem.php"},
		Formulario:{
			guardar:overloadSave,
			html_apply:"dlgInfo"+idContenedor,width:'40%',height:'74%',minWidth:150,minHeight:200,labelWidth:75,closable:true,titulo:'Item'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		combo_supergrupo=ClaseMadre_getComponente('id_supergrupo');
		combo_grupo=ClaseMadre_getComponente('id_grupo');
		combo_subgrupo=ClaseMadre_getComponente('id_subgrupo');
		combo_id1=ClaseMadre_getComponente('id_id1');
		combo_id2=ClaseMadre_getComponente('id_id2');
		combo_id3=ClaseMadre_getComponente('id_id3');
		txt_nombre=ClaseMadre_getComponente('nombre');
		txt_descripcion=ClaseMadre_getComponente('descripcion');
		txt_codigo=ClaseMadre_getComponente('codigo');
		txt_nivel_convertido=ClaseMadre_getComponente('nivel_convertido');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		txt_mat_bajo_responsabilidad=ClaseMadre_getComponente('mat_bajo_responsabilidad');

		var onSuperGrupoSelect=function(e){
			var id=combo_supergrupo.getValue()
			combo_grupo.filterValues[0]=id;
			combo_grupo.modificado=true;
			combo_subgrupo.filterValues[0]=id;
			combo_subgrupo.modificado=true;
			combo_id1.filterValues[0]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[0]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[0]=id;
			combo_id3.modificado=true;
			combo_grupo.enable();
			combo_subgrupo.enable();
			combo_id1.enable();
			combo_id2.enable();
			combo_id3.enable();
			combo_grupo.allowBlank=false;
			combo_grupo.setValue('');
			combo_subgrupo.allowBlank=false;
			combo_subgrupo.setValue('');
			combo_id1.allowBlank=false;
			combo_id1.setValue('');
			combo_id2.allowBlank=false;
			combo_id2.setValue('');
			combo_id3.allowBlank=false;
			combo_id3.setValue('')
		};
		var onGrupoSelect=function(e){
			var id=combo_grupo.getValue()
			combo_subgrupo.filterValues[1]=id;
			combo_subgrupo.modificado=true;
			combo_id1.filterValues[1]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[1]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[1]=id;
			combo_id3.modificado=true;
			combo_subgrupo.allowBlank=false;
			combo_subgrupo.setValue('');
			combo_id1.allowBlank=false;
			combo_id1.setValue('');
			combo_id2.allowBlank=false;
			combo_id2.setValue('');
			combo_id3.allowBlank=false;
			combo_id3.setValue('')
		};
		var onSubGrupoSelect=function(e){
			var id = combo_subgrupo.getValue()
			combo_id1.filterValues[2]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[2]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[2]=id;
			combo_id3.modificado=true;
			combo_id1.allowBlank=false;
			combo_id1.setValue('');
			combo_id2.allowBlank=false;
			combo_id2.setValue('');
			combo_id3.allowBlank=false;
			combo_id3.setValue('')
		};
		var onId1Select=function(e){
			var id=combo_id1.getValue()
			combo_id2.filterValues[3]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[3]=id;
			combo_id3.modificado=true;
			combo_id2.allowBlank=false;
			combo_id2.setValue('');
			combo_id3.allowBlank=false;
			combo_id3.setValue('')
		};
		var onId2Select=function(e){
			var id=combo_id2.getValue()
			combo_id3.filterValues[4]=id;
			combo_id3.modificado=true;

			combo_id3.allowBlank=false;
			combo_id3.setValue('');
		};
		var onId3Select=function(e,record){
			setCodigoSecuencial(record)
		};
		var CopiarDescrip=function(e){
			if(txt_nombre.getValue()!=''){
				if(txt_descripcion.getValue()==''){
					txt_descripcion.setValue(txt_nombre.getValue())
				}
			}
		};
		combo_supergrupo.on('select',onSuperGrupoSelect);
		combo_supergrupo.on('change',onSuperGrupoSelect);
		combo_grupo.on('select',onGrupoSelect);
		combo_grupo.on('change',onGrupoSelect);
		combo_subgrupo.on('select',onSubGrupoSelect);
		combo_subgrupo.on('change',onSubGrupoSelect);
		combo_id1.on('select',onId1Select);
		combo_id1.on('change',onId1Select);
		combo_id2.on('select',onId2Select);
		combo_id2.on('change',onId2Select);
		combo_id3.on('select',onId3Select);
		combo_id2.on('change',onId2Select);
		txt_nombre.on('blur',CopiarDescrip)
	}
	function setCodigoSecuencial(record){
		Ext.Ajax.request({
			url:direccion+'../../../../sis_almacenes/control/item/ActionGetSecuencialItem.php',
			params:'id_id3='+combo_id3.getValue()+'&codigo_id3='+record.get('codigo'),
			method:'POST',
			success:function(resp){
				//jmh 17/12/2008
				var regreso=Ext.util.JSON.decode(resp.responseText);
				var cantidad = regreso.codigo;
				if(cantidad==undefined){
					valor=0;
				}
				else{
					//alert(cantidad);
					var aux = cantidad.split('.');
					var valor = aux[6];
				}
				valor++;
				txt_codigo.setValue('0'+valor)
			},
			failure:ClaseMadre_conexionFailure,
			timeout:paramConfig.TiempoEspera
		});
	}
	this.btnNew=function(){
		CM_ocultarComponente(txt_nivel_convertido);
		CM_ocultarComponente(txt_fecha_reg);
		//CM_ocultarComponente(txt_mat_bajo_responsabilidad);
		combo_supergrupo.enable();
		combo_grupo.disable();
		combo_subgrupo.disable();
		combo_id1.disable();
		combo_id2.disable();
		combo_id3.disable();
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(txt_nivel_convertido);
		CM_ocultarComponente(txt_fecha_reg);
		//CM_ocultarComponente(txt_mat_bajo_responsabilidad);
		h_txt_codigo=txt_codigo.getValue();
		//h_txt_cod=h_txt_codigo.substr(23,3);
		var editar = h_txt_codigo.split('.');
		txt_codigo.setValue(editar[6]);
		combo_supergrupo.disable()
		combo_grupo.disable();
		combo_subgrupo.disable();
		combo_id1.disable();
		combo_id2.disable();
		combo_id3.disable();
		ClaseMadre_btnEdit()
	};
	function btnCodigoFabricante(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data="maestro_id_item="+SelectionsRecord.data.id_item;
			data=data+"&maestro_nombre="+SelectionsRecord.data.nombre;
			data=data+"&maestro_descripcion="+SelectionsRecord.data.descripcion;
			var paramVentana={Ventana:{width:'85%',height:'80%',minWidth:150,minHeight:200}};
			layout_item.loadWindows(direccion+'../../codigo_fabricante/codigo_fabricante.php?'+data,"Registro Cï¿½digo del fabricante ["+SelectionsRecord.data.id_item+"]",paramVentana);
			layout_item.getVentana().on('resize',function(){layout_item.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	this.getLayout=function(){
		return layout_item.getLayout()
	};
	function btnItemReemplazo(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data="maestro_id_item="+SelectionsRecord.data.id_item;
			data=data+"&maestro_nombre="+SelectionsRecord.data.nombre;
			data=data+"&maestro_descripcion="+SelectionsRecord.data.descripcion;
			var paramVentana={Ventana:{width:'85%',height:'80%',minWidth:150,minHeight:200}};
			layout_item.loadWindows(direccion+'../../item_reemplazo/item_reemplazo.php?'+data,"Registro Reemplazo del Item ["+SelectionsRecord.data.id_item+"]",paramVentana);
			layout_item.getVentana().on('resize',function(){layout_item.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	this.getLayout=function(){
		return layout_item.getLayout()
	};
	function btnItemArchivo(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect != 0){
			var SelectionsRecord=sm.getSelected();
			var data="maestro_id_item="+SelectionsRecord.data.id_item;
			data=data+"&maestro_nombre="+SelectionsRecord.data.nombre;
			data=data+"&maestro_descripcion="+SelectionsRecord.data.descripcion;
			var paramVentana={Ventana:{width:'85%',height:'80%',minWidth:150,minHeight:200}};
			layout_item.loadWindows(direccion+'../../item_archivo/item_archivo.php?'+data,"Archivo Item ["+SelectionsRecord.data.id_item+"]",paramVentana);
			layout_item.getVentana().on('resize',function(){layout_item.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	function btnCaracteristicaItem(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect != 0){
			var SelectionsRecord=sm.getSelected();
			var data="maestro_id_item="+SelectionsRecord.data.id_item;
			data=data+"&maestro_nombre="+SelectionsRecord.data.nombre;
			data=data+"&maestro_descripcion="+SelectionsRecord.data.descripcion;
			var paramVentana={Ventana:{width:'85%',height:'80%',minWidth:150,minHeight:200}};
			layout_item.loadWindows(direccion+'../../caracteristica_item/caracteristica_item.php?'+data,"Registro Caracterï¿½sticas Item ["+SelectionsRecord.data.id_item+"]",paramVentana);
			layout_item.getVentana().on('resize',function(){layout_item.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	function btnActInacItem(){
		//Activar Inactivar Item
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelections();		
		
		if(NumSelect>0){
			if(confirm('Está seguro de Activar/Inactivar el(los) Item(s)?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cambiando estado del item...</div>",
					width:300,
					height:200,
					closable:false
				});
				//Obtiene los ids en una variable
				postData='cantidad_ids='+NumSelect;
				for(var i=0;i<NumSelect;i++){
					postData=postData+'&id_item_'+i+'='+SelectionsRecord[i].data.id_item;
				}
				//alert(postData);
				Ext.Ajax.request({
					url:direccion+"../../../control/item/ActionActivarInactivarItem.php",
					method:'POST',
					//params:{cantidad_ids:'1',id_item_0:SelectionsRecord.data.id_item},
					params:postData,
					success:function(resp){
						Ext.MessageBox.hide();
						//Ext.MessageBox.alert('Éxito','Cambio de estado realizado');
						var root = resp.responseXML.documentElement;
						var v_respuesta = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
						ClaseMadre_btnActualizar();
						Ext.MessageBox.alert('Respuesta',v_respuesta);
					},
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
				});			
			}
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function overloadSave(a,b){
		arr={registro:paramConfig.registro};
		ClaseMadre_save(a,b,arr);
	}
	
	this.getLayout=function(){
		return layout_item.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton("../../../lib/imagenes/detalle.png",'Caracterí­sticas Item',btnCaracteristicaItem,true,'caracteristica_item','');
	this.AdicionarBoton("../../../lib/imagenes/script_gear.png",'Datos del Fabricante',btnCodigoFabricante,false,'codigo_fabricante','');
	this.AdicionarBoton("../../../lib/imagenes/arrow_divide.png",'Reemplazos Item',btnItemReemplazo,false,'item_reemplazo','');
	this.AdicionarBoton("../../../lib/imagenes/vcard.png",'Archivos Item',btnItemArchivo,false,'item_archivo','');
	this.AdicionarBoton("../../../lib/imagenes/act.png",'Activar/Inactivar Item',btnActInacItem,false,'item_archivo','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_item.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}