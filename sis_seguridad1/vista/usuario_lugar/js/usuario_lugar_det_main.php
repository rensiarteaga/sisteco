<?php
/**
 * Nombre:		  	    usuario_lugar_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 12:49:08
 *
 */
session_start();
?>
//<script>
var pagina_usuario_lugar_det;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php
	if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	    	id_usuario:<?php echo $m_id_usuario;?>,id_persona:'<?php echo $m_id_persona;?>',apellido_paterno:'<?php echo $m_apellido_paterno;?>',apellido_materno:'<?php echo $m_apellido_materno;?>',nombre:'<?php echo $m_nombre;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_usuario_lugar_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_usuario_lugar_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 12:49:08
 */
function pagina_usuario_lugar_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	
	var vectorAtributos=new Array;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_lugar/ActionListarUsuarioLugar_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario_lugar',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_usuario_lugar',
			'id_lugar',
			'desc_lugar',
			'desc_usuario',
			'id_usuario'
	
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_usuario:maestro.id_usuario
			
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Persona ',maestro.apellido_paterno],['Cuenta ',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]}),cm:cmMaestro});
	gridMaestro.render();
	
	//DATA STORE COMBOS
    ds_lugar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lugar/ActionListarLugar_det.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, ['id_lugar','fk_id_lugar','nivel','codigo','nombre','ubicacion','telefono1','telefono2','fax','observacion'])
	});

    ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario/ActionListarUsuario.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario',
			totalRecords: 'TotalCount'
		}, ['id_usuario','id_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado'])
	});

	//FUNCIONES RENDER
	
			function render_id_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
			function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_usuario_lugar',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_usuario_lugar',
		id_grupo:0
	};
	 
// txt id_lugar
	vectorAtributos[1]= {
			validacion: {
			name:'id_lugar',
			fieldLabel:'Lugar',
			allowBlank:false,			
			emptyText:'Id Lugar...',
			desc: 'desc_lugar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_lugar,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre#LUGARR.ubicacion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_lugar,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.nombre',
		defecto: '',
		save_as:'txt_id_lugar',
		id_grupo:1
	};
	
// txt id_usuario
	vectorAtributos[2]= {
			validacion: {
			name:'id_usuario',
			fieldLabel:'  ',
			allowBlank:false,			
			emptyText:'Id Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'USUARI.id_persona#USUARI.apellido_paterno#USUARI.apellido_materno#USUARI.nombredesc',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:false,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'USUARI.id_persona',
		defecto: maestro.id_usuario,
		save_as:'txt_id_usuario',
		id_grupo:0
	};
	

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:' (Maestro)',
		titulo_detalle:'Usuario Lugar (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_usuario_lugar = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_usuario_lugar.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_usuario_lugar,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_saveSuccess=this.saveSuccess;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/usuario_lugar/ActionEliminarUsuarioLugar.php',parametros:'&m_id_usuario='+maestro.id_usuario},
	Save:{url:direccion+'../../../control/usuario_lugar/ActionGuardarUsuarioLugar.php',parametros:'&m_id_usuario='+maestro.id_usuario,
	success:miFuncionSuccess},
	ConfirmSave:{url:direccion+'../../../control/usuario_lugar/ActionGuardarUsuarioLugar.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
		width:'40% ',
		columnas:['95%'],
		minWidth:150,minHeight:200,closable:true,titulo: 'Lugar Usuario',
		grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos de Lugar',
				columna:0,
				id_grupo:1
			}]
		}
	};
	
	
	function iniciarEventosFormularios(){
	    ds_lugar.baseParams={txt_usuario:maestro.id_usuario}	    
	    
	    
	}
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_usuario=datos.m_id_usuario;
		maestro.id_persona=datos.m_id_persona;
		maestro.apellido_paterno=datos.m_apellido_paterno;
		maestro.apellido_materno=datos.m_apellido_materno;
		maestro.nombre= datos.m_nombre;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_usuario:maestro.id_usuario
				
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Persona ',maestro.apellido_paterno],['Cuenta ',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]);
		vectorAtributos[2].defecto=maestro.id_usuario;
		ClaseMadre_getComponente('id_lugar').store.baseParams.txt_usuario=maestro.id_usuario;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/usuario_lugar/ActionEliminarUsuarioLugar.php',parametros:'&m_id_usuario='+maestro.id_usuario},
			Save:{url:direccion+'../../../control/usuario_lugar/ActionGuardarUsuarioLugar.php',parametros:'&m_id_usuario='+maestro.id_usuario,
			success:miFuncionSuccess},
			ConfirmSave:{url:direccion+'../../../control/usuario_lugar/ActionGuardarUsuarioLugar.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
				width:'40% ',
			
			columnas:['95%'],
			minWidth:150,minHeight:200,closable:true,titulo: 'Lugar Usuario',
			
			grupos:[{
						tituloGrupo:'Invisible',
						columna:0,
						id_grupo:0
					},
					{
						tituloGrupo:'Datos de Lugar',
						columna:0,
						id_grupo:1
					}]
			}
		};
		iniciarEventosFormularios();
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function miFuncionSuccess(resp){
		CM_saveSuccess(resp);
		ClaseMadre_getComponente('id_lugar').modificado=true
	}
	
	
	this.btnNew = function()
	{
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//		var SelectionsRecord  = sm.getSelected();
//		var limpiar = sm.purgeListeners();
        dialog=ClaseMadre_getDialog();
		dialog.resizeTo('40%','30%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Lugar');
		ClaseMadre_btnNew()
	};
	
	this.btnEdit = function()
	{
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;

		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		dialog=ClaseMadre_getDialog();
		dialog.resizeTo('40%','30%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Lugar');
		ClaseMadre_btnEdit()
	};
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_usuario_lugar.getLayout()
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
    iniciarEventosFormularios();
	layout_usuario_lugar.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}