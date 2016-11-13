<?php
/**
 * Nombre:		  	    metaproceso_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:42:30
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
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	
	
	
var paramConfig={TamanoPagina:100,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={tabla:'<?php echo $m_tabla;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_desc_tabla(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_desc_tabla(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var layout_desc_tabla;
	var parametrosFiltro;
	var grid;
	var dialog;
	var sm;
	var vectorAtributos=new Array();
	var formulario;
	var sw=0;
	var imprimir=false;
	var pos=1;

	
	ds = new Ext.data.Store({
		
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/desc_tabla/ActionListarDescripcionTabla.php'}),
		
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'nombre',
			totalRecords: 'TotalCount'

		}, [
		
		{name: 'desc', type: 'string'},
		'nombre',
		'label',
		'grid_visible',
		'grid_editable',
		
		'disabled',
		'width_grid',
		'width',
		
		'filtro',
		'defecto',
		'dt',
		'desc',
		'prefijo',
		'tabla',
		'desc_tabla',
		'modificado'
		
		]),

		remoteSort: false 
	});

ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tabla:maestro.tabla
		}
	});
	
	var cmMaestro = new Ext.grid.ColumnModel([
	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
	]);

	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
	}
	function italic(value){
		return '<i>'+value+'</i>';
	}

	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
    ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[
['Relación',maestro.tabla]]}),
cm:cmMaestro
});
	gridMaestro.render();
	
	vectorAtributos[0] = { 
		validacion: {
			name: 'nombre',
			fieldLabel: 'Campo',
			width: '98%',
			grid_visible:true, 
			grid_editable:false, 
			width_grid:80 
			
		},
		tipo: 'TextField',
		save_as:'txt_nombre',
		filtro_0:true,
		filterColValue:'a.attname'
		};
	vectorAtributos[1] = { 
		validacion: {
			name: 'label',
			fieldLabel: 'Etiqueta',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:80,
			renderer:etiqueta 
			
		},
		tipo: 'TextField',
		save_as:'txt_label'
		};
	vectorAtributos[2] = { 
		validacion: {
			name:'grid_visible',
			fieldLabel: 'Grid Visible',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:90,
			renderer:formatBoolean 
			
		},
		tipo:'Checkbox',
		save_as:'txt_grid_visible'
		};
		
	vectorAtributos[3] = { 
		validacion: {
			name: 'grid_editable',
			fieldLabel: 'Grid Editable',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:90,
			renderer:formatBoolean 
			
		},
		tipo: 'Checkbox',
		save_as:'txt_grid_editable'
		};
	
	vectorAtributos[4] = { 
		validacion: {
			name: 'disabled',
			fieldLabel: 'Disabled',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:90,
			renderer:formatBoolean 
			
		},
		tipo: 'Checkbox',
		save_as:'txt_disabled'
		};
	vectorAtributos[5] = { 
		validacion: {
			name: 'width_grid',
			fieldLabel: 'Ancho Grid',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:80,
			renderer:anchoGrid 
			
		},
		tipo: 'TextField',
		save_as:'txt_width_grid'
		};
	vectorAtributos[6] = { 
		validacion: {
			name: 'width',
			fieldLabel: 'Ancho Form',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:80,
			renderer:anchoForm 
			
		},
		tipo: 'TextField',
		save_as:'txt_width'
		};
	
	vectorAtributos[7] = { 
		validacion: {
			name: 'filtro',
			fieldLabel: 'Filtro',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:80,
			renderer:formatBoolean  
			
		},
		tipo: 'Checkbox',
		save_as:'txt_filtro'
		};
	
	vectorAtributos[8] = { 
		validacion: {
			name: 'dt',
			fieldLabel: 'Dato Descriptivo',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:80,
			renderer:formatBoolean  
			
		},
		tipo: 'Checkbox',
		save_as:'txt_dt'
		};
	
	
	vectorAtributos[9] = { 
		validacion: {
			name: 'desc',
			fieldLabel: 'Descripción Campo',
			width: '98%',
			grid_visible:true, 
			grid_editable:true, 
			width_grid:100,
			renderer:descripcion
			
		},
		tipo: 'TextArea',
		save_as:'txt_desc'
		};
	vectorAtributos[10] = {
		validacion:{
			labelSeparator:'',
			name: 'tabla',
			inputType:'hidden'
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_tabla'
	};	
	
	
	vectorAtributos[11] = {
		validacion:{
			labelSeparator:'',
			name: 'desc_tabla',
			grid_visible:false, 
			grid_editable:true
					},
		tipo: 'TextField',
		filtro_0:false,
		save_as:'txt_desc_tabla'
	};	
	
	vectorAtributos[12] = {
		validacion:{
			fieldLabel: 'Defecto',
			name: 'defecto',
			grid_visible:true, 
			grid_editable:true
					},
		tipo: 'TextField',
		filtro_0:false,
		save_as:'txt_defecto'
	};	
	
	
	
	
	
	
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	function indice(val,cell,record,row,colum,store){
		
		var band=0;
		
		
		for(var i=0;i<store.getCount();i++){
			if(store.getAt(i).get('grid_indice')!=""){
				band=1;
			}
		}
		
		if (band==0)
		{
			for(var i=1;i<store.getCount();i++){
				if(store.getAt(i).get('grid_visible')=='true'){
					store.getAt(i).set('grid_indice',pos);
					
					pos=pos+1;
				}
			
			}
		}
		return record.get('grid_indice');
	};
	
	function formatBoolean(value){
        if(value=="true"){
        	return "si";
        	
        }else{
        	
        	return "no";
        }
    };

	function etiqueta(val,cell,record,row,colum,store){
	        
			if(val==""){
				record.set('label',record.get('nombre'))
	        	return record.get('label');
	        	
	        }else{
	        	
	        	return val;
	        }
	};
	function descripcion(val,cell,record,row,colum,store){
	        
			if(val==""){
				record.set('desc',record.get('nombre'))
	        	return record.get('desc');
	        	
	        }else{
	        	
	        	return val;
	        }
	};
	
	function anchoForm(val,cell,record,row,colum,store){
	        
			var cadena="100%";
			if(val==""){
	        	record.set('width',cadena)
	        	return record.get('width');
	        	
	        }else{
	        	
	        	return val;
	        }
	};
	function anchoGrid(val,cell,record,row,colum,store){
	        
			 var cadena="100";
			if(val==""){
	        	record.set('width_grid',cadena);
	        	return record.get('width_grid');
	        	
	        }else{
	        	
	        	return val;
	        }
	};
	
	
	var config={
		titulo_maestro:"Metaproceso",
		titulo_detalle:"Descripción Tabla"
	};
	layout_desc_tabla = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_desc_tabla.init(config);
	
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_desc_tabla,idContenedor);

	
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_mostrarFormulario=this.mostrarFormulario;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_ConfirmSave=this.ConfirmSave;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
	
	
	var paramMenu={
		guardar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};	
	
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;
	var paramFunciones={
		Formulario:{
			titulo:'Metaproceso',
			//html_apply:"dlgInfo-"+idContenedor,
			width:'70%',
			height:'93%',
			minWidth:200,
			minHeight:150,
			closable:true,
			
		},
		ConfirmSave:{url:direccion+'../../../../sis_seguridad/control/desc_tabla/ActionGuardarDescripcionTabla.php'},
	};
	
this.reload=function(params){
var datos=Ext.urlDecode(decodeURIComponent(params));

maestro.tabla=datos.m_tabla
ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tabla:maestro.tabla
		}
	});
	/*ds.lastOptions.params={
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tabla:maestro.tabla
			
		};
	

	this.btnActualizar();*/
gridMaestro.getDataSource().removeAll()
gridMaestro.getDataSource().loadData([

['Relación',maestro.tabla]]);



	var paramFunciones={
		Formulario:{
			titulo:'Metaproceso',
			//html_apply:"dlgInfo-"+idContenedor,
			width:'70%',
			height:'93%',
			minWidth:200,
			minHeight:150,
			closable:true,
			
		},
		ConfirmSave:{url:direccion+'../../../../sis_seguridad/control/desc_tabla/ActionGuardarDescripcionTabla.php'},
		
	};

};
this.btnActualizar=function(){
	pos=1;
	ClaseMadre_btnActualizar();
}

this.ConfirmSave=function(){
	for(var i=0;i<ds.getCount();i++){
		ds.getAt(i).set('modificado',1);
	}
	
	ClaseMadre_ConfirmSave();
	
	
}
	this.getLayout=function(){
		return layout_desc_tabla.getLayout();
	};
	
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i];
			}
		}
	};
	
	
	
	
	
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	
	
	this.Init(); 
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	
	this.iniciaFormulario();
	
		
	
	

	layout_desc_tabla.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}