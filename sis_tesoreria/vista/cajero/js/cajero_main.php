<?php
/**
 * Nombre:		  	    cajero_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:45
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

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
var maestro={
id_caja:<?php echo $m_id_caja;?>,
tipo_caja:decodeURIComponent('<?php echo $m_tipo_caja;?>'),
desc_unidad_organizacional:decodeURIComponent('<?php echo $m_desc_unidad_organizacional;?>')
};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={idContenedor:idContenedor,pagina:new pagina_cajero(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//sub view added

/**
 * Nombre:		  	    pagina_cajero.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:45
 */
function pagina_cajero(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//  DATA STORE //
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cajero',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_cajero',
		'id_caja',
		'desc_caja',
		'id_empleado',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'desc_empleado',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},
		'estado_cajero'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[
	
	['Tipo Caja',render_tipo_caja(maestro.tipo_caja)],
	['Unidad Organizacional',maestro.desc_unidad_organizacional]];
	
	//DATA STORE COMBOS

    var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['nombre','tipo_caja'])
	});

    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),
    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['apellido_paterno','apellido_materno','nombre','codigo_empleado','desc_persona','id_empleado','id_persona'])
	//reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},[ 'id_empleado','id_persona',	'desc_persona',	'codigo_empleado',	'nombre_tipo_documento','doc_id','email1'])		
	                                                                                          
    });
	
	//FUNCIONES RENDER
	
		function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_caja']);}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','<FONT COLOR="#B5A642">{tipo_caja}</FONT>','</div>');

		function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','</div>');
	      
        function render_tipo_caja(value){
		if(value==1){value='Caja' }
		if(value==2){value='Caja Chica' }
		if(value==3){value='Fondo Rotatorio' }
		return value
	}
        
       function render_estado_cajero(value){
		if(value==1){value='Activo' }
		if(value==2){value='Inactivo' }
		if(value==3){value='Responsable'}
		return value
	    }
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cajero',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cajero'
	};
// txt id_caja
	Atributos[1]={
		validacion:{
			name:'id_caja',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_caja,
		save_as:'id_caja'
	};
// txt id_empleado
Atributos[2]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:false,			
			emptyText:'Funcionario...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			//displayField: 'id_persona',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:true,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:240,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_2.apellido_paterno#PERSON_2.apellido_materno#PERSON_2.nombre##EMPLEA_2.codigo_empleado',
		save_as:'id_empleado'
	};
	
// txt fecha_inicio
	Atributos[3]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJERO.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio'
	};
// txt fecha_final
	Atributos[4]= {
		validacion:{
			name:'fecha_final',
			fieldLabel:'Fecha Final',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJERO.fecha_final',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_final'
	};

	Atributos[5]={
		validacion:{
			name:'estado_cajero',
			fieldLabel:'Estado Cajero',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.cajero_combo.estado_cajero}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Activo'],['2','Inactivo'],['3','Responsable']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_estado_cajero,
			grid_editable:false,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		save_as:'estado_cajero',
		defecto:'1',
		id_grupo:0
		};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cajas (Maestro)',titulo_detalle:'cajero (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_cajero = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cajero.init(config);
		
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_cajero,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;

//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));//IMPORTANTE
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cajero/ActionEliminarCajero.php',parametros:'&m_id_caja='+maestro.id_caja},
	Save:{url:direccion+'../../../control/cajero/ActionGuardarCajero.php',parametros:'&m_id_caja='+maestro.id_caja},
	ConfirmSave:{url:direccion+'../../../control/cajero/ActionGuardarCajero.php',parametros:'&m_id_caja='+maestro.id_caja},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'cajero'}};
		
		function 	 MaestroJulio(data){
		var mayor=0;		
		var j;
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
	return html
	};	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_caja=datos.m_id_caja;
    maestro.tipo_caja=datos.m_tipo_caja;
    maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_caja:maestro.id_caja
			}
		};
		
		this.btnActualizar();
		data_maestro=[
		['Caja',maestro.id_caja],
		['Tipo Caja',maestro.tipo_caja],
		['Unidad Organizacional',maestro.desc_unidad_organizacional]
		];
		
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		Atributos[1].defecto=maestro.id_caja;

		paramFunciones.btnEliminar.parametros='&m_id_caja='+maestro.id_caja;
		paramFunciones.Save.parametros='&m_id_caja='+maestro.id_caja;
		paramFunciones.ConfirmSave.parametros='&m_id_caja='+maestro.id_caja;
		this.InitFunciones(paramFunciones)
	};
	
	function btn_inactivar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_cajero='+SelectionsRecord.data.id_cajero;
			data=data+'&m_id_caja='+SelectionsRecord.data.id_caja;
			if(componentes[5].getValue()=='2'){
			Ext.MessageBox.alert('...', 'El Estado ya es Inactivo.');		
			}
			else{
				
				
			Ext.MessageBox.confirm("Atención","Esta seguro Inactivar a este cajero(a)?",
			function(btn){if(btn=='yes'){ Ext.Ajax.request({url:direccion+"../../../control/cajero/ActionGuardarCajeroBotton.php",
					params:data,
					method:'POST',
					failure:ClaseMadre_conexionFailure,
					timeout:100000});	
					ClaseMadre_btnActualizar()	;} });		
				
 
				
			
			}
			
		}
		else
		{	Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
	function InitPaginaCaja()
	{	for(var i=0; i<Atributos.length; i++)
		{	componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)	}
	}
	
	this.btnNew=function(){
		btnNew();
		CM_mostrarComponente(componentes[2]);
		CM_mostrarComponente(componentes[4]);	
		CM_mostrarComponente(componentes[5]);	
		//componentes[5].setDisabled(true);
		componentes[5].setValue('1');
		CM_ocultarComponente(componentes[4]);
		
	}
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
			
		if(NumSelect!=0){
			if(componentes[5].getValue()=='2'){
			Ext.MessageBox.alert('...', 'El Estado ya es Inactivo, nose Puede Modificar.');		
			}
		    else{
		    var SelectionsRecord=sm.getSelected();
			CM_ocultarComponente(componentes[2]);
			CM_ocultarComponente(componentes[4]);
			CM_ocultarComponente(componentes[5]);
		    btnEdit();	
		    }
				
		 }
		 else
		{	Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');	}
		  
	 }	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cajero.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_caja:maestro.id_caja
		}
	});
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Inactivar',btn_inactivar,false,'Inactivar','Inactivar');
	
	
	this.iniciaFormulario();
	InitPaginaCaja();
	iniciarEventosFormularios();
	layout_cajero.getLayout().addListener('layout',this.onResize);
	layout_cajero.getVentana(idContenedor).on('resize',function(){layout_cajero.getLayout().layout()})
}