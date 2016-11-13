<?php
/**
 * Nombre:		  	    empleado_horario_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		12-08-2010
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
var maestro={id_empleado:<?php echo $m_id_empleado;?>,id_persona:'<?php echo $m_id_persona;?>',codigo_empleado:'<?php echo $m_codigo_empleado;?>',desc_persona:'<?php echo $m_desc_persona;?>',email1:'<?php echo $m_email1;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_empleado_horario(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_empleado_horario.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		11-08-2010
 */
function pagina_empleado_horario(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,ds_horario;
	
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado_horario/ActionListarEmpleadoHorario.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_horario',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado_horario',
		'id_empleado',
		'id_turno',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_reg',
		{name:'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'codigo_turno',
		'horario',
        'nombre_turno',
        'tipo_turno',
        'variacion'
        
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_empleado:maestro.id_empleado
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
    var dataMaestro=[['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]];
	var dsMaestro=new Ext.data.Store({proxy:new Ext.data.MemoryProxy(dataMaestro),reader:new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	
	ds_horario=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_control_asistencia/control/turno/ActionListarTurno.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_turno',totalRecords:'TotalCount'},
			['id_turno','nombre_turno','codigo_turno','hora_ini','hora_fin','descripcion','tipo_turno','dia_literal','hora_ini_semana','hora_fin_semana'])});
	
	//FUNCIONES RENDER
	function render_id_horario(value,p,record){return String.format('{0}',record.data['nombre_turno'])}
	var tpl_id_horario=new Ext.Template('<div class="search-item">','<b>Nombre Turno: <FONT COLOR="#B5A642">{codigo_turno}</FONT></b><br>','<B><FONT COLOR="#000000">Horario: </FONT></B><FONT COLOR="#B5A642">{hora_ini} - {hora_fin} ({dia_literal}: {hora_ini_semana}-{hora_fin_semana})</B></FONT><br>','<B><FONT COLOR="#000000">Tipo Horario: </FONT></B><FONT COLOR="#B5A642">{tipo_turno}</FONT><br>','<b><FONT COLOR="#000000">Observaciones: </FONT></b><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	function render_estado_reg(value){
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_horario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		save_as:'id_empleado_horario',
		tipo:'Field',
		filtro_0:false
	};
// txt id_empleado
	vectorAtributos[1]={
		validacion:{
			name:'id_empleado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_empleado,
		save_as:'id_empleado'
	};
	
	vectorAtributos[2]={
	validacion:{
		fieldLabel:'Horario',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Horario...',
		name:'id_turno',
		desc:'nombre_turno',
		store:ds_horario,
		valueField:'id_turno',
		displayField:'nombre_turno',
		queryParam:'filterValue_0',
		tpl:tpl_id_horario,
		filterCol:'TURNO.nombre_turno',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_horario,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:200,
		grid_indice:1
	},
	save_as:'id_turno',
	tipo:'ComboBox',
	filtro_0:true,
	filterColValue:'TURNO.nombre_turno'
};   

	vectorAtributos[4]={
			validacion:{
				name:'fecha_ini',
				fieldLabel:'Fecha Inicio',
				allowBlank:true,
				format:'d/m/Y', //formato para validacion
				minValue:'01/01/1900',
				disabledDaysText:'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer:formatDate,
				width_grid:95
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TURNO.fecha_ini',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_ini'
		};	


	vectorAtributos[5]={
			validacion:{
				name:'fecha_fin',
				fieldLabel:'Fecha Fin',
				allowBlank:true,
				format:'d/m/Y', //formato para validacion
				minValue:'01/01/1900',
				disabledDaysText:'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer:formatDate,
				width_grid:95				
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TURNO.fecha_fin',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_fin'
		};	
		

	
// txt fecha_registro
	vectorAtributos[3]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPHOR.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};	
	
	vectorAtributos[6]= {
		validacion: {
			name:'estado_reg',
			emptyText:'Estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPHOR.estado_reg',
		save_as:'estado_reg'
		};
			
			
			
	// txt hora_fin_p1
	vectorAtributos[7]={
		validacion:{
			name:'codigo_turno',
			fieldLabel:'Turno',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:5
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TURNO.codigo_turno'
	};
	// txt hora_ini_p1
	vectorAtributos[8]={
		validacion:{
			name:'horario',
			fieldLabel:'Horario',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TURNO.hora_ini#TURNO.hora_fin'
	};
	// txt hora_ini_p1
	vectorAtributos[9]={
		validacion:{
			name:'tipo_turno',
			fieldLabel:'Tipo Turno',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:7
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TURNO.tipo_turno'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	/*function render_tipo_periodo(value){
		if(value=='manana_tarde'){value='Mañana y Tarde'	}
		else{if (value=='manana'){
			value='Mañana'
		}
		else{if (value=='tarde'){
			value='Tarde'
		}
		else{
			value='Noche'
		}
		}
		}
		return value
	}*/
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Registro Empleados (Maestro)',
		titulo_detalle:'Horarios de Empleados (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_empleado_horario=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_empleado_horario.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado_horario,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/empleado_horario/ActionEliminarEmpleadoHorario.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Save:{url:direccion+'../../../control/empleado_horario/ActionGuardarEmpleadoHorario.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	ConfirmSave:{url:direccion+'../../../control/empleado_horario/ActionGuardarEmpleadoHorario.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Horarios'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_empleado=datos.m_id_empleado;
		maestro.id_persona=datos.m_id_persona;
		maestro.codigo_empleado=datos.m_codigo_empleado;
		maestro.desc_persona=datos.m_desc_persona;
		maestro.email1=datos.m_email1;
	    gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]]);
		vectorAtributos[1].defecto=maestro.id_empleado;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/empleado_horario/ActionEliminarEmpleadoHorario.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Save:{url:direccion+'../../../control/empleado_horario/ActionGuardarEmpleadoHorario.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	  ConfirmSave:{url:direccion+'../../../control/empleado_horario/ActionGuardarEmpleadoHorario.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Horarios'}};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_empleado:maestro.id_empleado
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
		
		
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_empleado_horario.getLayout()
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
	layout_empleado_horario.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}