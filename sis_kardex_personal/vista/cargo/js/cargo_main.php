<?php 
/**
 * Nombre:		  	    cargo_main.php
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
var elemento={pagina:new pagina_cargo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**            
 * Nombre:		  	    pagina_cargo_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_cargo(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var layout_cargo;
	var txt_codigo,txt_nombre,txt_fecha_reg;
	var sw=0;
	var componentes=new Array;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/cargo/ActionListarCargo.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_cargo',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_cargo',
		'id_escala_salarial','id_tipo_contrato',
		'numero_item',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'usuario_reg',
		'tipo_item',
		'codigo_cargo',
		'nombre_cargo',	
		
		'estado_reg','desc_tipo_contrato','desc_escala_salarial'
		]),remoteSort:true});
	
	
	
	
	var ds_escala_salarial=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/escala_salarial/ActionListarEscalaSalarial.php?estado_escala=activo'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_escala_salarial',
		totalRecords: 'TotalCount'
	}, ['id_escala_salarial','nombre','nivel','descripcion','sueldo_mensual'])
});
	
	var resultTplES=new Ext.Template(
			'<div class="search-item">',
			'<b>Nivel: </b>{nivel} - {nombre}',
			'<b><br>{descripcion}</b>',
			'</div>'
			);	
	
	var ds_tipo_contrato=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/tipo_contrato/ActionListarTipoContrato.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_tipo_contrato',
		totalRecords: 'TotalCount'
	}, ['id_tipo_contrato','codigo','nombre'])
});
		
	
	function render_id_escala_salarial(value,p,record){return String.format('{0}',record.data['desc_escala_salarial'])}	
	function render_tipo_contrato(value,p,record){return String.format('{0}',record.data['desc_tipo_contrato'])}	
	function render_tipo_item(value, p, record){ 
		if(value==0){ 
			return 'Tiempo Completo'; 
		} else{ 
			if(value==2){ 
				return 'Medio Completo'; 
			}else{
			  return 'Horas';}
		}
	}

	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//Definición de datos
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_cargo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_cargo'
	};
	

	
	vectorAtributos[1]={
			validacion: {
			name:'id_tipo_contrato',
			fieldLabel:'Tipo Contrato',
			allowBlank:false,			
			//emptyText:'Funcionario...',
			desc:'desc_tipo_contrato', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_contrato,
			valueField:'id_tipo_contrato',
			displayField:'nombre',
			filterCol:'TIPCON.codigo#TIPCON.nombre',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			width:'100%',
			resizable:true,
		/*	confTrigguer:{
				url:direccion+'../../../../sis_kardex_personal/vista/tipo_contrato/tipo_contrato.php',
			    paramTri:'prueba:XXX',		
			    title:'Tipo contrato',
			    param:{width:800,height:800},
			    idContenedor:idContenedor,
			   // clase_vista:'pagina_persona'
		},*/
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_tipo_contrato,
			grid_visible:true,
			grid_editable:false,
			locked:true,
			grid_indice:2,
			
			width_grid:230 // ancho de columna en el gris
		},
		tipo:'ComboTrigger',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		filterColValue:'CARGO.desc_tipo_contrato',
		defecto: '',
		save_as:'id_tipo_contrato'
	};
	
	
	vectorAtributos[2]={
			validacion: {
			name:'id_escala_salarial',
			fieldLabel:'Escala Salarial',
			allowBlank:false,			
			//emptyText:'Funcionario...',
			desc:'desc_escala_salarial', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_escala_salarial,
			valueField:'id_escala_salarial',
			displayField:'descripcion',
			filterCol:'ESCSAL.codigo#ESCSAL.nombre',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			tpl:resultTplES,
			grow:true,
			width:'100%',
			resizable:true,
			confTrigguer:{
				url:direccion+'../../../../sis_kardex_personal/vista/escala_salarial/escala_salarial.php',
			    paramTri:'prueba:XXX',		
			    title:'Escala Salarial',
			    param:{width:800,height:800},
			    idContenedor:idContenedor,
			   // clase_vista:'pagina_persona'
		},
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_escala_salarial,
			grid_visible:true,
			grid_editable:false,
			locked:true,
			grid_indice:2,
			
			width_grid:230 // ancho de columna en el gris
		},
		tipo:'ComboTrigger',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		filterColValue:'CARGO.desc_escala_salarial',
		defecto: '',
		save_as:'id_escala_salarial'
	};
	
	
	
	
	
	
	// txt nombre
	vectorAtributos[3]={
		validacion:{
			name:'tipo_item',
			fieldLabel:'Tipo Item',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','Tiempo Completo'],['1','Medio Tiempo'],['2','Horas']]}),
			valueField:'ID',
			displayField:'valor',
			maxLength:30,
			minLength:0,
			renderer: render_tipo_item,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			forceSelection:true,
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CARGO.tipo_item',
		save_as:'tipo_item'
	};	
	
	
	
	
	
	/*
	 * 
	 * 
	 *  Atributos[6]={//==> se usa//30
			validacion: {
			name:'tipo_pago',
			fieldLabel:'Tipo de Pago',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['caja','Pago en Caja'],['devengado','Cheque'],['transferencia','Transferencia Bancaria'],['avance','Cuenta Documentada']]}),
			valueField:'ID',
			displayField:'valor',
			onSelect:function(record){
				
				getComponente('tipo_pago').setValue(record.data.ID);
				getComponente('tipo_pago').collapse();
				
				if(record.data.ID=='caja'){
					cambiar_tipo('caja');
				}
				else if(record.data.ID=='devengado'||record.data.ID=='transferencia'){
					cambiar_tipo('devengado');
					CM_mostrarComponente(getComponente('factura_total'));
				}
				else{
					cambiar_tipo('avance');
				}
			
			},
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:80,
			grid_indice:8,
			width:180,
			disabled:false,
			renderer:tipo_pago
		},
		tipo:'ComboBox',
		form: true,
		defecto:'devengado',
		save_as:'tipo_pago',
		id_grupo:1
	};
	 * 
	 * */
	// txt codigo
	vectorAtributos[4]={
		validacion:{
			name:'numero_item',
			fieldLabel:'N° Item',
			allowBlank:true,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CARGO.numero_item',
		save_as:'numero_item'	
	};
	
	vectorAtributos[5]={
			validacion:{
				name:'codigo_cargo',
				fieldLabel:'Codigo',
				allowBlank:false,
				maxLength:4,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'CARGO.codigo_cargo',
			save_as:'codigo_cargo'
		};	
	
	
	vectorAtributos[6]={
			validacion:{
				name:'nombre_cargo',
				fieldLabel:'Nombre',
				allowBlank:false,
				maxLength:80,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'CARGO.nombre_cargo',
			save_as:'nombre_cargo'
		};	
	
	vectorAtributos[7]={
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CARGO.estado_reg',
		defecto:'activo'
	};
	
	vectorAtributos[8]= {	
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format:'d/m/Y', //formato para validacion
				minValue:'01/01/1900',
				disabledDaysText:'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer:formatDate,
				width_grid:100
			},
			form:false,
			filtro_0:true,
			
			filterColValue:'TIPCON.fecha_reg',
			tipo:'DateField',
			dateFormat:'m-d-Y',
			save_as:'txt_fecha_reg'	
		};
	
	vectorAtributos[9]={
			validacion:{
				labelSeparator:'',
				name:'usuario_reg',
				//inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'usuario_reg',
			form:false
		};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	var config={titulo_maestro:'Cargo',grid_maestro:'grid-'+idContenedor};
	var layout_cargo=new DocsLayoutMaestro(idContenedor);
	layout_cargo.init(config);
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_cargo,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/cargo/ActionEliminarCargo.php'},
		Save:{url:direccion+'../../../control/cargo/ActionGuardarCargo.php'},
		ConfirmSave:{url:direccion+'../../../control/cargo/ActionGuardarCargo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		titulo:'Cargo'}
	};	
		
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
	    txt_codigo=ClaseMadre_getComponente ('codigo');
        txt_nombre=ClaseMadre_getComponente ('nombre');
        txt_id_tipo_contrato=ClaseMadre_getComponente ('id_tipo_contrato');
		
        CM_ocultarComponente(ClaseMadre_getComponente('numero_item'));
        
        var onTipoContrato= function(e){
        	
        	
        if (e.value<='2'){
        	
        	ClaseMadre_getComponente('numero_item').allowBlank=false;
        	CM_mostrarComponente(ClaseMadre_getComponente('numero_item'));
        }else{
        	
        	ClaseMadre_getComponente('numero_item').allowBlank=true;
        	CM_ocultarComponente(ClaseMadre_getComponente('numero_item'));
        }
        }
        txt_id_tipo_contrato.on ('change',onTipoContrato);
        txt_id_tipo_contrato.on ('select',onTipoContrato);
	}
	
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});
		
	};
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_cargo.getLayout()
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
	  
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cargo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}