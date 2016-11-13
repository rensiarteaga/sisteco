<?php
/**
 * Nombre:		  	    carta_docs_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-18 20:39:09
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
var maestro={id_carta:<?php echo $m_id_carta;?>,clase_carta:decodeURIComponent('<?php echo $m_clase_carta;?>'),desc_cuenta_bancaria_inst:decodeURIComponent('<?php echo $m_desc_cuenta_bancaria_inst;?>'),desc_proveedor:decodeURIComponent('<?php echo $m_desc_proveedor;?>'),importe_carta:decodeURIComponent('<?php echo $m_importe_carta;?>'),fecha_inicio:decodeURIComponent('<?php echo $m_fecha_inicio;?>'),fecha_vence:decodeURIComponent('<?php echo $m_fecha_vence;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_carta_docs(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);    

//view added

/**
 * Nombre:		  	    pagina_carta_docs.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-18 20:39:09
 */
function pagina_carta_docs(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{	var Atributos=new Array,sw=0;
    var componentes=new Array();
	//  DATA STORE //
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/carta_docs/ActionListarCartaDocs.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_carta_docs',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_carta_docs',
		'id_carta',
		'descri_docs',
		{name: 'fecha_presenta',type:'date',dateFormat:'Y-m-d'},
		'sw_presenta'
		]),remoteSort:true});

	// DEFINICIÓN DATOS DEL MAESTRO
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[
	//['id_carta',maestro.id_carta],
	['Clase Carta',render_clase_carta(maestro.clase_carta)],
	['Institucion',maestro.desc_cuenta_bancaria_inst],
	['Proveedor',maestro.desc_proveedor],
	['Importe Carta',maestro.importe_carta]
	];
	
	//DATA STORE COMBOS

    var ds_carta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/carta/ActionListarCarta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_carta',totalRecords: 'TotalCount'},['id_carta','nombre_unidad','nombre','clase_carta','tipo_carta'])
	});

	//FUNCIONES RENDER
	
	function render_id_carta(value, p, record){return String.format('{0}', record.data['desc_carta']);}
		var tpl_id_carta=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{nombre}</FONT><br>','<FONT COLOR="#B5A642">{clase_carta}</FONT><br>','<FONT COLOR="#B5A642">{tipo_carta}</FONT>','</div>');

	function render_sw_presenta(value){
		if(value==1){value='Obligatoria' }
		if(value==2){value='Opcional' }
		return value
	}
	
	function render_clase_carta(value){
		if(value==1){value='Entidad Financiera' }
		if(value==2){value='Institucion' }
		return value
	}
			
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_carta_docs',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_carta_docs'
	};
// txt id_carta
	Atributos[1]={
		validacion:{
			name:'id_carta',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_carta,
		save_as:'id_carta'
	};
// txt descri_docs
	Atributos[2]={
		validacion:{
			name:'descri_docs',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CARDOC.descri_docs',
		save_as:'descri_docs'
	};
	
	 Atributos[3]={
		validacion:{
			name:'sw_presenta',
			fieldLabel:'Presentación',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.carta_docs_combo.sw_presenta}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Obligatoria'],['2','Opcional']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_sw_presenta,
			grid_editable:false,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		save_as:'sw_presenta',
		defecto:'1'
		
		};
		
// txt fecha_presenta
	Atributos[4]= {
		validacion:{
			name:'fecha_presenta',
			fieldLabel:'Fecha Presentación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:150,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CARDOC.fecha_presenta',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_presenta'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cartas Registro (Maestro)',titulo_detalle:'carta_docs (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_carta_docs = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_carta_docs.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_carta_docs,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
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
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/carta_docs/ActionEliminarCartaDocs.php',parametros:'&id_carta='+maestro.id_carta},
	Save:{url:direccion+'../../../control/carta_docs/ActionGuardarCartaDocs.php',parametros:'&id_carta='+maestro.id_carta},
	ConfirmSave:{url:direccion+'../../../control/carta_docs/ActionGuardarCartaDocs.php',parametros:'&id_carta='+maestro.id_carta},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'carta_docs'}};
	
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
		
	maestro.id_carta=datos.m_id_carta;
	maestro.clase_carta=datos.m_clase_carta;
	maestro.desc_cuenta_bancaria_inst=datos.m_desc_cuenta_bancaria_inst;
	maestro.desc_proveedor=datos.m_desc_proveedor;
	maestro.importe_carta=datos.m_importe_carta;
	maestro.fecha_inicio=datos.m_fecha_inicio;
	maestro.fecha_vence=datos.m_fecha_vence;

	      	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_carta:maestro.id_carta
			}
		};
		this.btnActualizar();
		data_maestro=[
		['id_carta',maestro.id_carta],
		['Clase Carta',maestro.clase_carta],
		['Institucion',maestro.desc_cuenta_bancaria_inst],
		['Proveedor',maestro.desc_proveedor],
		['Importe Carta',maestro.importe_carta]
		/*['Fecha inicio',maestro.fecha_inicio],
		['Fecha vence',maestro.fecha_vence]*/
		];
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		Atributos[1].defecto=maestro.id_carta;

		paramFunciones.btnEliminar.parametros='&id_carta='+maestro.id_carta;
		paramFunciones.Save.parametros='&id_carta='+maestro.id_carta;
		paramFunciones.ConfirmSave.parametros='&id_carta='+maestro.id_carta;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		
	}
		
	function btn_fecha_presentacion(){
	var sm=getSelectionModel();
	var filas=ds.getModifiedRecords();
	var cont=filas.length;
	var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
				CM_ocultarComponente(componentes[2]);
				CM_ocultarComponente(componentes[3]);
				CM_mostrarComponente(componentes[4]);
				
				btnEdit();	
    		}
	    else{	Ext.MessageBox.alert('Estado','Debe seleccionar una documento de carta.')    }
	
	}
	
	
	
	function InitPaginaCartaDocs()
	{	for(var i=0; i<Atributos.length; i++)
		{	componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
	}
	
	this.btnNew=function(){
		CM_ocultarComponente(componentes[4]);
		CM_mostrarComponente(componentes[3]);
		CM_mostrarComponente(componentes[2]);
		btnNew();
	}
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
			
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			CM_ocultarComponente(componentes[4]);
			if(componentes[4].getValue()!='NULL' && componentes[4].getValue()!=''){
			Ext.MessageBox.alert('...', 'No se puede modificar porque tiene fecha de presentación.');	
			}
			else{
				btnEdit();			
			}
						
		 }
		 else
		{	Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');	}
	 }	
	 
	 
	 this.btnEliminar=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
			
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			CM_ocultarComponente(componentes[4]);
			if(componentes[4].getValue()!='NULL' && componentes[4].getValue()!=''){
			Ext.MessageBox.alert('...', 'No se puede eliminar porque tiene fecha de presentación.');	
			}
			else{
				btnEliminar();			
			}
						
		 }
		 else
		{	Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');	}
	 }	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_carta_docs.getLayout()};
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
			id_carta:maestro.id_carta
		}
	});
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Fecha de Presentación',btn_fecha_presentacion,true,'fecha_presenta','Fecha de Presentación');
	this.iniciaFormulario();
	InitPaginaCartaDocs();
	iniciarEventosFormularios();
	layout_carta_docs.getLayout().addListener('layout',this.onResize);
	layout_carta_docs.getVentana(idContenedor).on('resize',function(){layout_carta_docs.getLayout().layout()})
}