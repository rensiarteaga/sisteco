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
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_cbtes_regional(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_cbtes_regional(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array;  
	var componentes= new Array();

	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_depto/ActionListarCbteDepto.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cbte_depto',totalRecords:'TotalCount'
		},[		
		'id_cbte_depto',
		'descripcion',
		{
			name :'fecha_reg',
			type : 'date',
			dateFormat: 'd-m-Y h:i:s'
		},
		'usuario_reg',
		'id_depto',
		'desc_depto'
		]),remoteSort:true});

	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_conta/ActionListarDepartamentoConta.php?tipo_vista=rep_balance'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto_conta','id_depto','nombre_depto','desc_ep'])
	});


	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_depto}</FONT><br>','{desc_ep}','</div>');


	

	Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_cbte_depto',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false,
				width_grid:80 
			},
			tipo: 'Field',
			filtro_0:false
		};
	Atributos[1]={
		validacion:{
			fieldLabel: 'Identificador',
			name: 'id_cbte_depto',
			grid_visible:true, // se muestra en el grid
			grid_editable:false,
			align:'center',
			grid_indice:1,
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'cb.id_cbte_depto',
		form:false
	};

		
	Atributos[2]={
			validacion:{
				name:'id_depto',
				fieldLabel:'Departamento Contable',
				allowBlank: false,
				emptyText:'Departamento...',
				desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:20,
				minListWidth:'80%',
				//	onSelect:function(record){},
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto,
				grid_visible:true,
				grid_editable:false,
				width_grid:280,
				width:285,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filterColValue:'dep.nombre_depto#dep.codigo_depto',
			save_as:'h_id_depto'
		};

	Atributos[3] = {
			validacion : {
				name : 'descripcion',
				fieldLabel : 'Descripcion',
				allowBlank : false,
				typeAhead : true,
				loadMask : true,
				align : 'left',
				lazyRender : true,
				grid_visible : true, // se muestra en el grid
				grid_editable : false,// es editable en el grid
				forceSelection : true,
				width_grid : 260, // ancho de columna en el grid
				width : 285
			},
			tipo : 'TextArea',
			filtro_0 : true,
			filterColValue : 'cb.descripcion',
			filtro_1 : true,
			form : true,
			save_as : 'txt_descripcion'	
		};
	
	Atributos[4]={
			validacion : {
				name : 'fecha_reg',
				fieldLabel : 'Fecha Registro',
				format : 'd/m/Y',
				minValue : '01/01/1900',
				grid_visible : true,
				grid_editable : false,
				renderer : formatDate,
				align : 'center',
				width_grid : 130
			},
			tipo : 'DateField',
			form : false,
			filtro_0 : false,
			dateFormat : 'm-d-Y'
			
			};
	Atributos[5]={
			validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			form : false
		};

	function formatDate(value){return value?value.dateFormat('d/m/Y h:i:s'):''};

	//var config={titulo_maestro:'param_gral',grid_maestro:'grid-'+idContenedor};
	var config = {
			titulo_maestro : 'Comprobante_Departamento',
			grid_maestro : 'grid-' + idContenedor,
			urlHijo : '../../../sis_activos_fijos/vista/cbte_depto/cbte_depto_det.php'};
	var layout = new DocsLayoutMaestroDeatalle(idContenedor);
	layout.init(config);

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);

	var cm_EnableSelect = this.EnableSelect;
	var cm_DeselectRow = this.DeselectRow;
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

	var paramMenu={
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};

	this.EnableSelect = function(selEvent, rowIndex, selectedRow) 
	{
		cm_EnableSelect(selEvent, rowIndex, selectedRow);

		_CP.getPagina(layout.getIdContentHijo()).pagina.reload(selectedRow.data);
		_CP.getPagina(layout.getIdContentHijo()).pagina.desbloquearMenu();
	}

	this.DeselectRow = function(n, n1)
	{
		cm_DeselectRow(n, n1);
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		_CP.getPagina(layout.getIdContentHijo()).pagina.bloquearMenu();
	};
	
	var paramFunciones={ 
			btnEliminar:{url:direccion+'../../../control/cbte_depto/ActionEliminarCbteDepto.php'},
			Save:{url:direccion+'../../../control/cbte_depto/ActionGuardarCbteDepto.php'},
			ConfirmSave:{url:direccion+'../../../control/cbte_depto/ActionGuardarCbteDepto.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,columnas:['90%'],
				grupos:[
				        //{tituloGrupo:'Descripcion',columna:0,id_grupo:0},
				        {tituloGrupo:'Datos Comprobantes Departamento Contable',columna:0,id_grupo:0}
				        ],
				width:'50%',
				minWidth:150,
				minHeight:200,	
				closable:true,
				titulo:' Comprobantes Departamento Contable'
				//guardar:abrirVentana
				}
			};
	
	function iniciarEventosFormularios()
	{
		}

	this.getLayout=function(){return layout.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
		
	this.iniciaFormulario();

	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
