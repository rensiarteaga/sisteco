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
	var elemento={pagina:new pagina_existencias_clasif(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
* Nombre:		  	    pagina_existencias_clasif_main.js
* Propósito: 			pagina objeto principal
* Autor:				RCM
* Fecha creación:		14-10-2008
*/
function pagina_existencias_clasif(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var data_ep;
	var cmb_Item,txt_nombre,txt_descripcion,txt_super_grupo,txt_grupo,txt_sub_grupo,txt_id1;
	var txt_id2,txt_id3,txt_unidad_medida,txt_unidad_medida;


	var ds_parametro_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro_almacen/ActionListarParametroAlmacen.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro_almacen',totalRecords: 'TotalCount'}, ['id_parametro_almacen','cierre','gestion','estado'])});
	var ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen/ActionListarAlmacenEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_almacen',totalRecords: 'TotalCount'}, ['id_almacen','nombre','descripcion'])});
	var ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen_logico/ActionListarAlmacenLogicoFisEPM.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_almacen_logico',totalRecords: 'TotalCount'}, ['id_almacen_logico','nombre','descripcion','desc_tipo_almacen'])});
	var ds_supergrupo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/supergrupo/ActionListarSuperGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre','codigo'])});
	var ds_grupo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/grupo/ActionListarGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre','codigo'])});
	var ds_subgrupo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/subgrupo/ActionListarSubGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},['id_subgrupo','nombre','codigo'])});
	var ds_id1=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/id1/ActionListarId1.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id1',totalRecords:'TotalCount'},['id_id1','nombre','codigo'])});
	var ds_id2=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/id2/ActionListarId2.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id2',totalRecords:'TotalCount'},['id_id2','nombre','codigo'])});
	var ds_id3=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/id3/ActionListarId3.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id3',totalRecords:'TotalCount'},['id_id3','nombre','codigo'])});


	//FUNCIONES RENDER

	//function renderParAlm(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
	function renderSupergrupo(value,p,record){return String.format('{0}',record.data['nombre_supg'])}
	function renderGrupo(value,p,record){return String.format('{0}',record.data['nombre_grupo'])}
	function renderSubgrupo(value,p,record){return String.format('{0}',record.data['nombre_subg'])}
	function renderId1(value,p,record){return String.format('{0}',record.data['nombre_id1'])}
	function renderId2(value,p,record){return String.format('{0}',record.data['nombre_id2'])}
	function renderId3(value,p,record){return String.format('{0}',record.data['nombre_id3'])}

	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_ep(value, p, record){return String.format('{0}', record.data['desc_almacen_ep']);}
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};

	var resultTplParAlm = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion}</b>','<br><FONT COLOR="#B5A642">Estado: {estado}</FONT>','</div>');
	var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogico = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
	var resultTplSupGru=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplSubGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplId1=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplId2=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplId3=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');

	// Definición de datos //
	/////////////////////////
	// hidden id_almacen
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_parametro_almacen',
			desc:'gestion',
			store:ds_parametro_almacen,
			valueField:'id_parametro_almacen',
			displayField:'gestion',
			filterCol:'PARALM.gestion',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParAlm,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			//renderer:renderParAlm,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			grid_indice:0
		},
		tipo:'ComboBox',
		save_as:'id_parametro_almacen',
		id_grupo:0
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
			typeAhead:true,
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
		filterColValue:'supgru.nombre#supgru.codigo',
		save_as:'id_supergrupo',
		id_grupo:1
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
			typeAhead:true,
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
		filterColValue:'g.nombre#g.codigo',
		save_as:'id_grupo',
		id_grupo:1
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
			typeAhead:true,
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
		filterColValue:'sub.nombre#sub.codigo',
		save_as:'id_subgrupo',
		id_grupo:1
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
			typeAhead:true,
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
		filterColValue:'id1.nombre#id1.codigo',
		save_as:'id_id1',
		id_grupo:1
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
			typeAhead:true,
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
		filterColValue:'id2.nombre#id2.codigo',
		save_as:'id_id2',
		id_grupo:1
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
			typeAhead:true,
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
		filterColValue:'id3.nombre#id3.codigo',
		save_as:'id_id3',
		id_grupo:1
	};


	fC= new Array();
	fV= new Array();
	fC[0]='id_almacen_logico';
	fV[0]='';

	vectorAtributos[7]={
		validacion:{
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Código Material',
			valueField: 'id_item',
			displayField: 'codigo',
			tipo:'ingreso',//determina el action a llamar
			filterCols:fC,
			filterValues:fV,
			allowBlank:true,
			maxLength:100,
			renderer:render_id_item,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:true,
			width_grid:90,
			width:200,
			pageSize:10,
			grid_indice:1,
			direccion:direccion+'../'
		},
		tipo:'LovItemsAlm',
		save_as:'id_item',
		filtro_0:true,
		defecto:'',
		filterColValue:'ITEM.codigo',
		id_grupo:2
	};

	vectorAtributos[8]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			grid_visible:true,
			grid_editable:false,
			disabled:true,
			grid_indice:3,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:true,
		save_as:'txt_nombre',
		filterColValue:'ITEM.nombre',
		id_grupo:2
	};

	vectorAtributos[9]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_descripcion',
		filterColValue:'ITEM.descripcion',
		id_grupo:2
	};

	vectorAtributos[10]= {
		validacion:{
			name:'unidad_medida',
			fieldLabel:'Unidad Medida',
			grid_visible:true,
			grid_editable:false,
			grid_indice:6,
			disabled:true,
			width:'95%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_unidad_medida',
		id_grupo:2
	};

	vectorAtributos[11]= {
		validacion:{
			name:'nombre_supg',
			fieldLabel:'SuperGrupo',
			grid_visible:true,
			grid_editable:false,
			grid_indice:9,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_super_grupo',
		id_grupo:2
	};

	vectorAtributos[12]= {
		validacion:{
			name:'nombre_grupo',
			fieldLabel:'Grupo',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_grupo',
		id_grupo:2
	};

	vectorAtributos[13]= {
		validacion:{
			name:'nombre_subg',
			fieldLabel:'SubGrupo',
			grid_visible:true,
			grid_editable:false,
			grid_indice:11,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_sub_grupo',
		id_grupo:2
	};

	vectorAtributos[14]= {
		validacion:{
			name:'nombre_id1',
			fieldLabel:'Identificador 1',
			grid_visible:true,
			grid_editable:false,
			grid_indice:12,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id1',
		id_grupo:2
	};

	vectorAtributos[15]= {
		validacion:{
			name:'nombre_id2',
			fieldLabel:'Identificador 2',
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id2',
		id_grupo:2
	};

	vectorAtributos[16]= {
		validacion:{
			name:'nombre_id3',
			fieldLabel:'Identificador 3',
			grid_visible:true,
			grid_editable:false,
			grid_indice:14,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id3',
		id_grupo:2
	};

	vectorAtributos[17]= {
		validacion:{
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep',
			minChars: 1,
			triggerAction: 'all',
			editable: false,
			grid_editable:false,
			grid_visible:false,
			grid_indice:14,
			width:300
		},
		tipo: 'epField',
		save_as:'hidden_id_ep1',
		id_grupo:0
	}

	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	vectorAtributos[18]= {
		validacion: {
			fieldLabel:'Almacén Físico',
			allowBlank:true,
			emptyText:'Almacén Físico...',
			name: 'id_almacen',
			desc: 'desc_almacen',
			store:ds_almacen,
			valueField: 'id_almacen',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMACE.nombre',
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacen,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'ALMACE.nombre',
		defecto: '',
		save_as:'id_almacen',
		id_grupo:0
	};

	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='x';
	vectorAtributos[19]= {
		validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacén Lógico',
			allowBlank:false,
			emptyText:'Almacén Lógico...',
			name: 'id_almacen_logico',
			desc: 'desc_almacen_logico',
			store:ds_almacen_logico,
			valueField: 'id_almacen_logico',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico,
			filterValues:filterValues_almacen_logico,
			typeAhead:true,
			forceSelection:true,
			tpl: resultTplAlmacenLogico,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre',
		defecto: '',
		save_as:'id_almacen_logico',
		id_grupo:0
	};

	vectorAtributos[20]= {
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText: 'Día no válido',
			renderer: formatDate
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha'
	};

	vectorAtributos[21]={
		validacion:{
			name:'clasif_item',
			fieldLabel:'Por',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.proc_existencias_clasifCombo.tipo}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['clasif', 'Clasificación'],['item', 'Item']]}),
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
		defecto: 'clasif',
		id_grupo:0
	};
	
	vectorAtributos[22]={
		validacion:{
			labelSeparator:'',
			name:'id_financiador',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_financiador'
	};
	
	vectorAtributos[23]={
		validacion:{
			labelSeparator:'',
			name:'id_regional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_regional'
	};
	
	vectorAtributos[24]={
		validacion:{
			labelSeparator:'',
			name:'id_programa',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_programa'
	};
	
	vectorAtributos[25]={
		validacion:{
			labelSeparator:'',
			name:'id_proyecto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_proyecto'
	};
	
	vectorAtributos[26]={
		validacion:{
			labelSeparator:'',
			name:'id_actividad',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_actividad'
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
	var config={
		titulo_maestro:'Existencia de Almacenes'

	};
	layout_existencia_almacen=new DocsLayoutProceso(idContenedor);
	layout_existencia_almacen.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_existencia_almacen,idContenedor);

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
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Existencias de Almacén";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/existencias_clasif/ActionExistenciasFisClasif.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'70%',
		columnas:['47%','47%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Almacen',
		grupos:[
		{tituloGrupo:'Almacén',columna:0,id_grupo:0},
		{tituloGrupo:'Por Clasificación',columna:1,id_grupo:1},
		{tituloGrupo:'Por Item',columna:1,id_grupo:2}
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		cmb_ep=ClaseMadre_getComponente('id_ep');
		combo_almacen = ClaseMadre_getComponente('id_almacen');
		combo_almacen_logico = ClaseMadre_getComponente('id_almacen_logico');
		combo_supergrupo=ClaseMadre_getComponente('id_supergrupo');
		combo_grupo=ClaseMadre_getComponente('id_grupo');
		combo_subgrupo=ClaseMadre_getComponente('id_subgrupo');
		combo_id1=ClaseMadre_getComponente('id_id1');
		combo_id2=ClaseMadre_getComponente('id_id2');
		combo_id3=ClaseMadre_getComponente('id_id3');
		cmb_Item=ClaseMadre_getComponente('id_item');
		txt_nombre=ClaseMadre_getComponente('nombre');
		txt_descripcion=ClaseMadre_getComponente('descripcion');
		txt_super_grupo=ClaseMadre_getComponente('nombre_supg');
		txt_grupo=ClaseMadre_getComponente('nombre_grupo');
		txt_sub_grupo=ClaseMadre_getComponente('nombre_subg');
		txt_id1=ClaseMadre_getComponente('nombre_id1');
		txt_id2=ClaseMadre_getComponente('nombre_id2');
		txt_id3=ClaseMadre_getComponente('nombre_id3');
		txt_unidad_medida=ClaseMadre_getComponente('unidad_medida');
		cmb_ClasifItem=ClaseMadre_getComponente('clasif_item');
		cmbGestion=ClaseMadre_getComponente('id_parametro_almacen');
		dteFecha=ClaseMadre_getComponente('fecha');
		txt_id_financiador=ClaseMadre_getComponente('id_financiador');
		txt_id_regional=ClaseMadre_getComponente('id_regional');
		txt_id_programa=ClaseMadre_getComponente('id_programa');
		txt_id_proyecto=ClaseMadre_getComponente('id_proyecto');
		txt_id_actividad=ClaseMadre_getComponente('id_actividad');

		//Define un valor por defecto al Tipo de reporte
		cmb_ClasifItem.setValue('clasif');

		//Oculta el frame de Item
		CM_ocultarGrupo('Por Item');

		var onItemSelect=function(e){
			rec=cmb_Item.lov.getSelect();
			txt_nombre.setValue(rec["nombre"]);
			txt_descripcion.setValue(rec["descripcion"]);
			txt_super_grupo.setValue(rec["nombre_supg"]);
			txt_grupo.setValue(rec["nombre_grupo"]);
			txt_sub_grupo.setValue(rec["nombre_subg"]);
			txt_id1.setValue(rec["nombre_id1"]);
			txt_id2.setValue(rec["nombre_id2"]);
			txt_id3.setValue(rec["nombre_id3"]);
			//txt_unidad_medida.setValue(rec["nombre_unid_base"]);
		};

		var onEpSelect = function(e){
			var ep=cmb_ep.getValue();
			data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			actualizar_ds_combos();
			//Limpia los valores de los combos
			combo_almacen.setValue('');
			combo_almacen_logico.setValue('');
			//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
			combo_almacen.modificado=true;
			combo_almacen_logico.modificado=true;
			//Carga los datos en variables ocultas
			txt_id_financiador.setValue(ep['id_financiador']);
			txt_id_regional.setValue(ep['id_regional']);
			txt_id_programa.setValue(ep['id_programa']);
			txt_id_proyecto.setValue(ep['id_proyecto']);
			txt_id_actividad.setValue(ep['id_actividad']);
		};

		var onAlmacenSelect = function(e) {
			var id = combo_almacen.getValue();
			//alert(id);
			if(id=='') id='x';
			combo_almacen_logico.filterValues[0] =  id;
			combo_almacen_logico.modificado = true;
			combo_almacen_logico.setValue('');
			combo_almacen.modificado=true
		};

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
		
		var onClasif_item_change=function(e){
			if(cmb_ClasifItem.getValue()=='clasif'){
				CM_ocultarGrupo('Por Item');
				CM_mostrarGrupo('Por Clasificación');
				//Vuelve opcional al item
				cmb_Item.allowBlank=true;
				//Vuelve obligatorios los campos de la clasificación
				combo_supergrupo.allowBlank=false;
				combo_grupo.allowBlank=false;
				combo_subgrupo.allowBlank=false;
				combo_id1.allowBlank=false;
				combo_id2.allowBlank=false;
				combo_id3.allowBlank=false;
				//Limpia los valores que no corresponden
				cmb_Item.setValue('');
			}
			else{
				CM_ocultarGrupo('Por Clasificación');
				CM_mostrarGrupo('Por Item');
				//Vuelve opcional al item
				combo_supergrupo.allowBlank=true;
				combo_grupo.allowBlank=true;
				combo_subgrupo.allowBlank=true;
				combo_id1.allowBlank=true;
				combo_id2.allowBlank=true;
				combo_id3.allowBlank=true;
				//Vuelve obligatorios los campos de la clasificación
				cmb_Item.allowBlank=false;
				//Limpia los valores que no corresponden
				combo_supergrupo.setValue('');
				combo_grupo.setValue('');
				combo_subgrupo.setValue('');
				combo_id1.setValue('');
				combo_id2.setValue('');
				combo_id3.setValue('');
			}
		};
		
		var onGestionSelect = function(e) {
			var id = cmbGestion.getValue();
			if(cmbGestion.store.getById(id)!=undefined){
				intGestion=cmbGestion.store.getById(id).data.gestion;
			
				//Define límites de la fecha
				dte_fecha_ini_valid = '01/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = '12/31/'+intGestion+' 00:00:00';
				
				//Instancia un objeto fecha con los datos obtenidos para que el DateFIeld los acepte sin problema
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);
				
				//Aplica la validación en la fecha
				dteFecha.minValue=dte_fecha_ini_valid;
				dteFecha.maxValue=dte_fecha_fin_valid;
				
				//Define un valor por defecto
				dteFecha.setValue(dte_fecha_fin_valid);
			}
		};

		cmb_Item.on('change',onItemSelect);
		cmb_ep.on('change',onEpSelect)
		combo_almacen.on('select',onAlmacenSelect);
		combo_almacen.on('change',onAlmacenSelect);
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
		cmb_ClasifItem.on('select',onClasif_item_change);
		cmbGestion.on('select',onGestionSelect);
	}

	function actualizar_ds_combos(){
		var datos=Ext.urlDecode(decodeURIComponent(data_ep));
		Ext.apply(combo_almacen.store.baseParams,datos);
		Ext.apply(combo_almacen_logico.store.baseParams,datos)
	}

	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
