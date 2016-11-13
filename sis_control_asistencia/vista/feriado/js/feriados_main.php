<?php 
/**
 * Nombre:		  	    tipo_horario_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
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
<?php if($_SESSION["ss_filtro_avanzado"]!=''){
	echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_feriados(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_tipo_horario_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_feriados(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var layout_feriados;
	var h_txt_fecha,h_txt_feriado_nacional,h_txt_id_lugar;
	var ds_lugar;
	var sw=0;
	var componentes=new Array;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/feriado/ActionListarFeriado_.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_feriado',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_feriado',
		'motivo',
		'feriado_nacional',
		'id_lugar',
		'desc_lugar',
		{name:'fecha_feriado',type:'date',dateFormat:'Y-m-d'},
		'dia_feriado',
		'mes_feriado'			
		]),remoteSort:true});
		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	ds_lugar=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php?feriado=1'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			totalRecords:'TotalCount'
		}, ['id_lugar','codigo','nombre','nivel'])
	});
	function render_feriado_nacional(value)
	{
		if(value=='si'){value='Si'}
		else{
			value='No' }
		return value
	}
	function render_mes_feriado(value)
	{
		if(value=='1'){value='Enero'}
		if(value=='2'){value='Febrero'}
		if(value=='3'){value='Marzo'}
		if(value=='4'){value='Abril'}
		if(value=='5'){value='Mayo'}
		if(value=='6'){value='Junio'}
		if(value=='7'){value='Julio'}
		if(value=='8'){value='Agosto'}
		if(value=='9'){value='Septiembre'}
		if(value=='10'){value='Octubre'}
		if(value=='11'){value='Noviembre'}
		if(value=='12'){value='Diciembre'}
		return value
	}
	function render_id_lugar(value,p,record){return String.format('{0}',record.data['desc_lugar'])}
	var tpl_id_lugar=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i>','<b><br>Codigo: </b><FONT COLOR="#B5A642">{codigo}</FONT>','</div>'); //
	
	//Definición de datos
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_feriado',
			//fieldLabel: 'Codigo',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_feriado'
	};
	///////// fecha ////////
	vectorAtributos[1]={
		validacion:{
			name:'fecha_feriado',
			fieldLabel:'Fecha Feriado',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:false, // se muestra en el grid
			grid_editable:false
		},
		tipo:'DateField',
		filtro_0:false,
		save_as:'txt_fecha_feriado',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[2]={
		validacion:{
			name:'dia_feriado',
			fieldLabel:'Dia',
			allowBlank:true,
			maxLength:100,
			minLength:2,
			selectOnFocus:true,		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		form:false,
		tipo:'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filterColValue:'dia_feriado'
	};
	vectorAtributos[3]={
		validacion:{
			name:'mes_feriado',
			fieldLabel:'Mes',
			allowBlank:true,
			maxLength:100,
			minLength:2,
			selectOnFocus:true,		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer:render_mes_feriado,
			width_grid:120 // ancho de columna en el gris
		},
		form:false,
		tipo:'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filterColValue:'mes_feriado'
	};
	////////// txt motivo //////
	vectorAtributos[4]={
		validacion:{
			name:'motivo',
			fieldLabel:'Motivo Feriado',
			allowBlank:true,
			maxLength:100,
			minLength:2,
			selectOnFocus:true,		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filterColValue:'fer.motivo',
		save_as:'txt_motivo'
	};
	vectorAtributos[5]={
			validacion: {
			name:'feriado_nacional',
			fieldLabel:'Feriado Nacional',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['no','No'],['si','Si']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			renderer:render_feriado_nacional,
			width_grid:120
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'fer.feriado_nacional',
		save_as:'txt_feriado_nacional'
	};
	// txt id_gestion
	vectorAtributos[6]={
			validacion:{
			name:'id_lugar',
			fieldLabel:'Lugar',
			allowBlank:true,	
			emptyText:'Lugar...',
			desc:'desc_lugar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_lugar,
			valueField:'id_lugar',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'LUGARR.nombre#LUGARR.codigo',
			typeAhead:false,			
			tpl:tpl_id_lugar,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_lugar,
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'lug.nombre',
		save_as:'hidden_id_lugar'
	};
	
	
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	var config={titulo_maestro:'Tipo de Horario',grid_maestro:'grid-'+idContenedor};
	var layout_feriados=new DocsLayoutMaestro(idContenedor);
	layout_feriados.init(config);
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_feriados,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_EnableSelect=this.EnableSelect;
	
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/feriado/ActionEliminarFeriado_.php'},
		Save:{url:direccion+'../../../control/feriado/ActionGuardarFeriado_.php'},
		ConfirmSave:{url:direccion+'../../../control/feriado/ActionGuardarFeriado_.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:280,	//alto
		width:350,		
		closable:true,
		titulo:'Feriados'}
	};	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		 h_txt_fecha=ClaseMadre_getComponente('fecha_feriado');
	     h_txt_feriado_nacional=ClaseMadre_getComponente('feriado_nacional');
	     h_txt_id_lugar=ClaseMadre_getComponente('id_lugar');
	    var onSwFeriadoNacional=function(e){
			var id=h_txt_feriado_nacional.getValue();
			if(id=='no'){
				CM_mostrarComponente(h_txt_id_lugar);
				h_txt_id_lugar.store.baseParams={feriado:1};
				h_txt_id_lugar.modificado=true; 
				h_txt_id_lugar.setValue('');
				h_txt_id_lugar.allowBlank=false
			}
			else{
				CM_ocultarComponente(h_txt_id_lugar);
				h_txt_id_lugar.modificado=true; 
				h_txt_id_lugar.setValue('');
				h_txt_id_lugar.allowBlank=true
			}
		};
		h_txt_feriado_nacional.on('select',onSwFeriadoNacional);
	        h_txt_feriado_nacional.on('change',onSwFeriadoNacional)
	}
	this.btnNew = function()
	{   
		CM_ocultarComponente(h_txt_id_lugar);
		ClaseMadre_btnNew()
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_feriados.getLayout()
	};
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_feriados.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}