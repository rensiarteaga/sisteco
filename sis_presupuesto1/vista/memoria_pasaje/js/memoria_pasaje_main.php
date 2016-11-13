<?php
/**
 * Nombre:		  	    solicitud_compra_item_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
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
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_memoria_pasaje(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pag_descargo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_memoria_pasaje(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var componentes=new Array();
	var sw_filtro="false";	
	var dialog;
	//DATA STORE//
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mem_pasaje/ActionListarMemoriaPasaje.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_mem_pasaje',totalRecords:'TotalCount'},
		['id_mem_pasaje',
		 'id_destino',
		 'nombre_lugar',
		 'desc_destino',
		 'id_moneda',
		 'desc_moneda',
		 'periodo_pres',
		 'total_general',
		 'id_memoria_calculo',
		 'desc_memoria_calculo',
		 'desc_categoria',
		 'id_categoria']),remoteSort:true});
	// Definición de datos //
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	 var ds_destino=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords:'TotalCount'},['id_destino','importe_pasaje','importe_hotel','importe_viaticos','id_categoria','desc_categoria','id_lugar','desc_lugar','id_moneda','desc_moneda','imp_mon_pasaje','imp_mon_hotel','imp_mon_viatico'])});
	var ds_destino_imp_pasaje=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords:'TotalCount'},['id_destino','importe_pasaje','importe_hotel','importe_viaticos','id_categoria','desc_categoria','id_lugar','desc_lugar','id_moneda','desc_moneda','imp_mon_pasaje','imp_mon_hotel','imp_mon_viatico'])});
    var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});
    var ds_memoria_calculo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/memoria_calculo/ActionListarMemoriaCalculo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_memoria_calculo',totalRecords:'TotalCount'},['id_memoria_calculo','justificacion','tipo_detalle','id_concepto_ingas','id_partida_presupuesto','id_moneda'])
	});
	var ds_categoria=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/categoria/ActionListarCategoria.php'}),
				reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords:'TotalCount'},['id_categoria','desc_categoria']) });
	//FUNCIONES RENDER
	function render_id_destino(value,p,record){return String.format('{0}',record.data['desc_destino']);}
	var tpl_id_destino=new Ext.Template('<div class="search-item">','<b><i>Ciudad: {desc_lugar}</i></b>','<br><b><i>Moneda: </i></b><FONT COLOR="#B5A642">{desc_moneda}</FONT>','<br><b><i>Categorï¿½a: </i></b><FONT COLOR="#B5A642">{desc_categoria}</FONT>','</div>');

	function render_id_moneda(value,p,record){return String.format('{0}',record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function render_id_memoria_calculo(value,p,record){return String.format('{0}',record.data['desc_memoria_calculo']);}
	var tpl_id_memoria_calculo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{justificacion}</FONT><br>','</div>');

	function render_id_categoria(value,p,record){return String.format('{0}',record.data['desc_categoria']);}
	var tpl_id_categoria=new Ext.Template('<div class="search-item">','<b><i>{desc_categoria}</i></b></FONT>','</div>');
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store){		
		var monedas_for=new Ext.form.MonedaField();
		return monedas_for.formatMoneda(value)		 
	}
	function renderPeriodo(value,p,record){
		if(value == 1)
		{return "Enero"}
		if(value == 2)
		{return "Febrero"}
		if(value == 3)
		{return "Marzo"}
		if(value == 4)
		{return "Abril"}
		if(value == 5)
		{return "Mayo"}
		if(value == 6)
		{return "Junio"}
		if(value == 7)
		{return "Julio"}
		if(value == 8)
		{return "Agosto"}
		if(value == 9)
		{return "Septiembre"}
		if(value == 10)
		{return "Octubre"}
		if(value == 11)
		{return "Noviembre"}
		if(value == 12)
		{return "Diciembre"}};
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_mem_pasaje',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_mem_pasaje'
	};
// txt id_categoria
	Atributos[1]={
			validacion:{
			name:'id_categoria',
			fieldLabel:'Categoría',
			allowBlank:false,			
			emptyText:'Categoría...',
			desc:'desc_categoria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria,
			valueField:'id_categoria',
			displayField:'desc_categoria',
			queryParam:'filterValue_0',
			filterCol:'CATEGO.id_categoria',
			typeAhead:true,
			tpl:tpl_id_categoria,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_categoria,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CATEGO.id_categoria',
		save_as:'id_categoria'
	};
	// txt id_destino
	Atributos[2]={
			validacion:{
			name:'id_destino',
			fieldLabel:'Ciudad Destino',
			allowBlank:false,			
			emptyText:'Ciudad Destino...',
			desc:'desc_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_destino,
			valueField:'id_destino',
			displayField:'desc_lugar',
			queryParam:'filterValue_0',
			filterCol:'LUGARR.nombre',
			typeAhead:true,
			tpl:tpl_id_destino,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			onSelect:function(record){
			ds_destino_imp_pasaje.load
			({params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_destino:record.data.id_destino,
					id_moneda:maestro.id_moneda
					},
			callback: function(){componentes[2].setValue(ds_destino_imp_pasaje.getAt(0).data['id_destino']);
								componentes[6].setValue(ds_destino_imp_pasaje.getAt(0).data['imp_mon_pasaje']);
								componentes[6].setDisabled(false);componentes[2].collapse();				
								}
			})},
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:true		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'LUGARR.nombre',
		save_as:'id_destino'
	};
// txt cantidad
	Atributos[3]={
		validacion: {
			name:'nro_personas',
			fieldLabel:'Nro. Viajes',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			minListWidth:100,
			width:50,
			disabled:false
		},
		tipo:'NumberField',
		defecto:1,
		save_as:'nro_personas'
	};			
// txt id_moneda
	Atributos[4]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda ...',
			desc:'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField:'id_moneda',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		id_grupo:1,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
// txt periodo_pres
	Atributos[5]={
		validacion: {
			name:'periodo_pres',
			fieldLabel:'Periodo',
			allowBlank:false,
			emptyText:'Periodo...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Enero'],['2','Febrero'],['3','Marzo'],['4','Abril'],['5','Mayo'],['6','Junio'],['7','Julio'],['8','Agosto'],['9','Septiembre'],['10','Octubre'],['11','Noviembre'],['12','Diciembre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderPeriodo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:200,
			disable:false
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'MEMING.periodo_pres',
		defecto:1,
		save_as:'periodo_pres'
	};		
// txt total_general
	Atributos[6]={
		validacion:{
			name:'total_general',
			fieldLabel:'Importe Pasaje',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'MEMPAS.total_general',
		save_as:'total_general'
	};
// txt id_memoria_calculo
	Atributos[7]={
		validacion:{
			name:'id_memoria_calculo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_memoria_calculo'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	tituloM='Memoria de Cálculo';
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Memoria de Cálculo (Maestro)',titulo_detalle:'Memoria de Pasajes (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_memoria_pasaje= new DocsLayoutMaestro(idContenedor);
	layout_memoria_pasaje.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_pasaje,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.motrarTodosComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	var CM_btnSave=this.Save;
	var CM_getDialog=this.getDialog;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var getFormulario=this.getFormulario;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={ 
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/mem_pasaje/ActionEliminarMemoriaPasaje.php'},
		Save:{url:direccion+'../../../control/mem_pasaje/ActionGuardarMemoriaPasaje.php'},
		ConfirmSave:{url:direccion+'../../../control/mem_pasaje/ActionGuardarMemoriaPasaje.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Memoria de Pasajes',
	    guardar:filtro,grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Filtrar',columna:0,id_grupo:1}]
	    }};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		// alert (maestro.id_avance);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_memoria_calculo:maestro.id_memoria_calculo,
				m_id_moneda:maestro.id_moneda
			}
		};
		ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1};
		prueba.setValue(maestro.id_moneda);
		this.btnActualizar();
		Atributos[7].defecto=maestro.id_memoria_calculo;
		Atributos[4].defecto=maestro.id_moneda;
		paramFunciones.btnEliminar.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.Save.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.ConfirmSave.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		this.InitFunciones(paramFunciones);
		var CM_getBoton=this.getBoton;
		if(maestro.tipo_vista==2){
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
		}
		else{
			CM_getBoton('nuevo-'+idContenedor).enable();
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
		}
	};
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		dialog=CM_getDialog();
		}
	this.btnNew=function(){
		sw_filtro="false";	
		CM_mostrarGrupo('Datos');
		CM_ocultarGrupo('Filtrar');
		componentes[6].setDisabled(true);
		componentes[3].setValue(1);
		componentes[3].setDisabled(false);
		CM_btnNew();		
	};
	
	this.btnEdit=function(){
		sw_filtro="false";	
		CM_mostrarGrupo('Datos');
		CM_ocultarGrupo('Filtrar');
		componentes[3].setValue(1);
		componentes[3].setDisabled(true);
		componentes[6].setDisabled(false);
	 	CM_btnEdit();		
	};	
	function InitMemoriaPasaje(){
		grid=getGrid();
		dialog=CM_getDialog();
		sm=getSelectionModel();
		formulario=getFormulario();
		for(i=0;i<Atributos.length;i++){
			componentes[i]=getComponente(Atributos[i].validacion.name);
		}
		componentes[1].on('select',filtrar);
		componentes[1].on('cahnge',filtrar)
	};
	function filtrar(){
		componentes[2].setDisabled(false);
		componentes[2].setValue('');
		componentes[2].store.baseParams={m_id_categoria:componentes[1].getValue()};
		componentes[2].modificado=true
	}	
	function filtro(){	
		if (sw_filtro=="true"){	
	 	ds.load({
		params:{start:0,
				limit:paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_memoria_calculo:maestro.id_memoria_calculo,
				m_id_moneda:componentes[4].getValue()}});
				componentes[4].setValue(maestro.id_moneda);		
				CM_getDialog().hide()
		}
		else{
			CM_btnSave()
		}
	}
	var prueba=new Ext.form.ComboBox({
			store:ds_moneda,
			displayField:'nombre',
			typeAhead: true,
			mode:'local',
			triggerAction:'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField:'id_moneda',
			editable:false,			
			tpl:tpl_id_moneda			
	});
	ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
	});
	prueba.on('select',	function(){				
			ds.baseParams={valor_filtro:parseFloat(prueba.getValue()),filtro:1};	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});			
	});	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_memoria_pasaje.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-items.gif',' Insertar Documento',btn_documento,true,'Documento','Documento de Descargo');
	this.AdicionarBotonCombo(prueba,'prueba');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitMemoriaPasaje();
	this.bloquearMenu();
	layout_memoria_pasaje.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}