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
var elemento={pagina:new trans_ingreso_salida(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  trans_ingreso_salida.js
 * Propósito: 		  para dibujar los ............
 * Autor:		  JoSé Abraham Mita Huanca
 * Fecha creación:	  2008-03-18 
 */
function trans_ingreso_salida(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var data_ep;
	// ------------------  PARÁMETROS --------------------------//
	var ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_persona',totalRecords:'TotalCount'},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
	});
	var resultTplEmp=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_empleado}</FONT>','</div>');
	//// txt_id_empleado
	var filterCols_funcionario=new Array();
	var filterValues_funcionario=new Array();
	filterValues_funcionario[0]='%';
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name:'id_persona',
			desc:'desc_persona',
			store:ds_empleado,
			valueField:'id_persona',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'desc_persona',
			typeAhead:true,
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			grid_visible:true,
			grid_editable:false,
			editable:true
		},
		id_grupo:0,
		save_as:'hidden_id_persona',
		tipo:'ComboBox'
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
		titulo_maestro:'Transferencia Ingreso Salida'	
	};
	layout_trans_ing_sal=new DocsLayoutProceso(idContenedor);
	layout_trans_ing_sal.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_trans_ing_sal,idContenedor);
	
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
		var titulo = "Transferencia Ingreso Salida";
		return titulo;
	}
	//datos necesarios para el filtro
	var paramFunciones = {
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../../control/_reportes/transferencia_ingreso_salida/ActionReporteTransferenciaIngresoSalida.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'70%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Transferencia',
		grupos:[{
			tituloGrupo:'Funcionario',
			columna: 0,
			id_grupo:0
		}
	]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_trans_ing_sal.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
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
				//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
