<?php
/**
 * Nombre:		  	    memoria_recurso_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-11 09:20:34
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
var elemento={idContenedor:idContenedor,pagina:new pagina_memoria_recurso(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_memoria_recurso.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-11 09:20:34
 */
function pagina_memoria_recurso(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var sw_filtro;
	var dialog;	
	var tipoDeCambio;
	var importe_concepto;
	var importe_final;
	var ds2;
	var meses = new Array;
	var h_id_moneda;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/mem_ingreso/ActionListarRecurso.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_mem_ingreso',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_mem_ingreso',
			'periodo_pres',
			'id_memoria_calculo',
			'desc_memoria_calculo',
			'id_moneda',
			'desc_moneda',
			'total_general'
		]),remoteSort:true});
		
	/*ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1}		

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_memoria_calculo:maestro.id_memoria_calculo			
		}
	});
	
	function tabular(n)
	{ 
		if (n>=0)	
		{	
			return "  "+tabular(n-1)
		}
		else return "  "
	}*/
	// DEFINICIÓN DATOS DEL MAESTRO
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	/*var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[ ['Presupuesto de',maestro.tipo_pres+tabular(40-maestro.tipo_pres.length)],['Presupuestar en',maestro.desc_moneda+tabular(50-maestro.desc_moneda.length)],
					   ['Unidad',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa],
					   ['Regional',maestro.nombre_regional ],['Subprograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]];
	*/
	//DATA STORE COMBOS
    /*var ds_memoria_calculo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/memoria_calculo/ActionListarMemoriaCalculo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_memoria_calculo',totalRecords: 'TotalCount'},['id_memoria_calculo','justificacion','tipo_detalle','id_concepto_ingas','id_partida_presupuesto'])
	});*/

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});

	//FUNCIONES RENDER
	
	function render_id_memoria_calculo(value, p, record){return String.format('{0}', record.data['desc_memoria_calculo']);}
	var tpl_id_memoria_calculo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{justificacion}</FONT><br>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{		
		var monedas_for=new Ext.form.MonedaField();
		return monedas_for.formatMoneda(value)		 
	}
	
	function renderPeriodo(value, p, record){
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
		{return "Diciembre"}
		else
		{return "T O T A L :"}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_mem_ingreso
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_mem_ingreso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_mem_ingreso'
	};
	
	// txt estado_gral
	Atributos[1]={
		validacion: {
			name:'tipo_insercion',
			fieldLabel:'Tipo inserción',
			allowBlank:false,
			emptyText:'Tipo ...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','En meses especificos'],['2','Repetir en los doce meses'],['3','Distribuir mensualmente']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			minListWidth:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MEMSER.periodo_pres',
		//defecto:1,
		save_as:'tipo_insercion'
	};
	
// txt periodo_pres
	Atributos[2]={
		validacion: {
			name:'periodo_pres',
			fieldLabel:'Periodo',
			allowBlank:true,
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
			grid_editable:true,
			width_grid:150,
			minListWidth:100,
			disable:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MEMING.periodo_pres',
		//defecto:1,
		id_grupo:0,
		save_as:'periodo_pres'
	};			
	
	// txt total_general
	Atributos[3]={
		validacion:{
			name:'total_general',
			fieldLabel:'Importe',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:12,
			grid_visible:true,
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:150,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMING.total_general',
		//id_grupo:0,
		save_as:'total_general'
	};
	
	// txt id_memoria_calculo
	Atributos[4]={
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
		//defecto:maestro.id_memoria_calculo,
		//id_grupo:0,
		save_as:'id_memoria_calculo'
	};
	
// txt id_moneda
	/*Atributos[5]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
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
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		//defecto:maestro.id_moneda,
		id_grupo:1,
		save_as:'id_moneda'
	};*/
	
	Atributos[5]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_moneda'
	};

	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Memoria Calculo (Maestro)',titulo_detalle:'Memoria de Recursos (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	var layout_memoria_recurso = new DocsLayoutMaestro(idContenedor);
	layout_memoria_recurso.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_recurso,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.motrarTodosComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	var CM_getDialog=this.getDialog;
	var CM_procesoSuccess=this.procesoSuccess;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};

		
	//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/mem_ingreso/ActionEliminarRecurso.php'},
	Save:{url:direccion+'../../../control/mem_ingreso/ActionGuardarGrillaMemRecurso.php'},
	ConfirmSave:{url:direccion+'../../../control/mem_ingreso/ActionGuardarGrillaMemRecurso.php'},
	Formulario:{
		titulo:'Memoria de Recursos',
		html_apply:'dlgInfo-'+idContenedor,
		height:300,
		width:720,
		minWidth:150,
		minHeight:200,	
		closable:true,
		guardar:miSave}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		
		maestro=m;
				
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_memoria_calculo:maestro.id_memoria_calculo
			}
		};
		
		CM_ocultarComponente(h_total_general);		
		
		ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1};
		prueba.setValue(maestro.id_moneda);
		this.btnActualizar();		
		
		//Atributos[4].defecto=maestro.id_memoria_calculo;
		//Atributos[5].defecto=maestro.id_moneda;

		paramFunciones.btnEliminar.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.Save.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.ConfirmSave.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;		
		this.InitFunciones(paramFunciones);				
	};
	
	this.btnNew=function()
	{		
		CM_ocultarComponente(h_total_general);
		
		ds2.rejectChanges();
		ds2.removeAll();
		CM_getDialog().buttons[1].disable();	//deshab-hab boton guardar del formulario
		
		ClaseMadre_btnNew();		
	};
	
	this.btnEliminar=function()
    {		
    	CM_btnEliminar();
    	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
    }	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
		//para iniciar eventos en el formulario
		h_id_moneda = getComponente('id_moneda');		
		h_periodo_pres = getComponente('periodo_pres');
		h_tipo_insercion = getComponente('tipo_insercion');//texto
		h_total_general = getComponente('total_general');//texto		
		h_id_memoria_calculo = getComponente('id_memoria_calculo');
		h_id_mem_ingreso = getComponente('id_mem_ingreso');	
		
		CM_ocultarComponente(h_total_general);
		CM_ocultarComponente(h_periodo_pres);
		
		function insercion()
		{
			h_id_moneda.setValue(maestro.id_moneda);
			h_id_memoria_calculo.setValue(maestro.id_memoria_calculo);
			
			if(h_tipo_insercion.getValue()==1)
			{
				CM_ocultarComponente(h_total_general);
			}
			else
			{				
				CM_mostrarComponente(h_total_general);
				h_total_general.allowBlank = false;
				h_total_general.on('blur',saltar);				
			}
			
			ds2.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,			
				tipo_insercion:h_tipo_insercion.getValue(),
				total_general:h_total_general.getValue(),
				id_memoria_calculo:h_id_memoria_calculo.getValue(),
				id_moneda:h_id_moneda.getValue(),
				id_mem_ingreso:h_id_mem_ingreso.getValue()
			}
		    });
		    
		    grid2.stopEditing();
			ds2.rejectChanges();
		    ds2.removeAll();
		}
	
		h_tipo_insercion.on('select',insercion);		
	}
	
	var CM_Save = this.Save;
		
	function miSave(a,b)
	{		
		CM_Save(a,b,ds2.getAt(0).data);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}
	
	var CM_ConfirmSave = this.ConfirmSave;
	this.ConfirmSave=function()
	{		
		CM_ConfirmSave();	
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	};
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
			
	var Ed=Ext.grid.GridEditor;
	
	function formatBoolean(value){
        return value ? 'Yes' : 'No';  
    };
	
	var cmol = new Ext.grid.ColumnModel(
        [
        {
           header: "ENE",
           dataIndex: 'mes_01',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "FEB",
           dataIndex: 'mes_02',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "MAR",
           dataIndex: 'mes_03',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "ABR",
           dataIndex: 'mes_04',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "MAY",
           dataIndex: 'mes_05',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
       
        {
           header: "JUN",
           dataIndex: 'mes_06',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "JUL",
           dataIndex: 'mes_07',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "AGO",
           dataIndex: 'mes_08',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "SEP",
           dataIndex: 'mes_09',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "OCT",
           dataIndex: 'mes_10',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
         {
           header: "NOV",
           dataIndex: 'mes_11',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
			   
           }))
        },
        {
           header: "DIC",
           dataIndex: 'mes_12',
           width: 50,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false,
			   allowDecimals:false,
			   allowNegative:false,
			   decimalPrecision:0
           }))
        },
        {
           header: "TOTAL",
           dataIndex: 'total',
           width: 50
        }]);
        
    // by default columns are sortable
    cmol.defaultSortable = false;  
	
	//---DATA STORE
	var ds2 = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/mem_ingreso/ActionListarGrillaMemRecurso.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_mem_ingreso',totalRecords:'TotalCount'
		},[		
		  'descripcion',
			{name:'mes_01' ,mapping: 'mes_01', type: 'int'},
			{name:'mes_02' ,mapping: 'mes_02', type: 'int'},
			{name:'mes_03' ,mapping: 'mes_03', type: 'int'},
			{name:'mes_04' ,mapping: 'mes_04', type: 'int'},
			{name:'mes_05' ,mapping: 'mes_05', type: 'int'},
			{name:'mes_06' ,mapping: 'mes_06', type: 'int'},
			{name:'mes_07' ,mapping: 'mes_07', type: 'int'},
			{name:'mes_08' ,mapping: 'mes_08', type: 'int'},
			{name:'mes_09' ,mapping: 'mes_09', type: 'int'},
			{name:'mes_10' ,mapping: 'mes_10', type: 'int'},
			{name:'mes_11' ,mapping: 'mes_11', type: 'int'},
			{name:'mes_12' ,mapping: 'mes_12', type: 'int'},
			{name:'total'  ,mapping: 'total',  type: 'int'},
			'fila'
           
		]),remoteSort:false});
		
	this.iniciaFormulario(
	{
		width:655,
		legend:'Distribución', 
		id:'grilla_adicional'+idContenedor
	});	 
	
	Ext.get('grilla_adicional'+idContenedor).createChild({
        tag:'div', 
        id:'grid-adicional2'+idContenedor,
        style:"border:1px solid #99bbe8;overflow: hidden; width: 650px; height: 50px;position:relative;left:0;top:0;"
      
    });
    
    function saltar()
    {
    	if(h_tipo_insercion.getValue() == 2)
		{
			anual();
		}
		
		if(h_tipo_insercion.getValue() == 3)
		{
			prorateo();
		}
    }
    
    function anual()
    {
    	var monto_mes = h_total_general.getValue();
    	var conv = '';
		
		for(var i=0; i <= 11; i++)
		{
			if((i+1) < 10)
			{
				conv = 'mes_0';
				conv = conv + (i+1);
			}
			if((i+1) >= 10)
			{
				conv = 'mes_';
				conv = conv + (i+1);
			}
							
			meses[i] = monto_mes;  	
			  					
  			ds2.getAt(0).set(conv,(meses[i]));
  			ds2.commitChanges();
		}
    }
    
    function prorateo() 
    {    	
    	var monto_mes = h_total_general.getValue()/12; 
    	var suma = 0;
    	var conv = '';
		
		for(var i=0; i < 11; i++)
		{
			if((i+1) < 10)
			{
				conv = 'mes_0';
				conv = conv + (i+1);
			}
			if((i+1) >= 10)
			{
				conv = 'mes_';
				conv = conv + (i+1);
			}
							
			//meses[i] = monto_mes;  	
			suma = suma + Math.round(monto_mes); 
			  					
  			ds2.getAt(0).set(conv,(Math.round(monto_mes) ) );
  			ds2.commitChanges();
		}
				
		/*meses[11] = parseFloat(h_total_general.getValue()) - suma;
		meses[11] = Math.round(meses[11]);*/
		
		ds2.getAt(0).set('mes_12',Math.round(h_total_general.getValue()-suma));	
  		ds2.commitChanges()	
    }
	
	var grid2 = new Ext.grid.EditorGrid('grid-adicional2'+idContenedor, 
    {
        ds: ds2,
        cm: cmol,
        enableColLock:false
    });
    grid2.render();
    
    ds2.on('update',function(e)
    {
    	total_reformulacion(e);
		ds2.commitChanges()    	     	
    })
            
  	function total_reformulacion(e)
  	{  	
  		var rec = ds2.getAt(0);
  	  		
  		rec.data['total'] = parseFloat(rec.data['mes_01'])+ parseFloat(rec.data['mes_02']) + parseFloat(rec.data['mes_03']) + parseFloat(rec.data['mes_04']) + parseFloat(rec.data['mes_05']) + parseFloat(rec.data['mes_06']) + parseFloat(rec.data['mes_07']) + parseFloat(rec.data['mes_08']) + parseFloat(rec.data['mes_09']) + parseFloat(rec.data['mes_10']) + parseFloat(rec.data['mes_11']) + parseFloat(rec.data['mes_12']);
  		
  		rec.data['total'] = Math.round(rec.data['total']);
  		  		    	
    	ds2.getAt(0).set('total',rec.data['total']);
    	    	
    	ds2.commitChanges()
    }
	
	var prueba=new Ext.form.ComboBox({
			store: ds_moneda,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',
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
	
	/*function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}*/

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_memoria_recurso.getLayout()};
	//para el manejo de hijos
	
	/*this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);*/
	
//codigo para bloquear los botones de modificacion dependiendo del estado del presupuesto
	/*var CM_getBoton=this.getBoton;
		
	if(maestro.tipo_vista==2)
	{
		CM_getBoton('guardar-'+idContenedor).disable();
		CM_getBoton('nuevo-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
	}
	else
	{
		CM_getBoton('guardar-'+idContenedor).enable();
		CM_getBoton('nuevo-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();
	}*/	
//Fin codigo de bloqueo de botones
	
	//this.InitFunciones(paramFunciones);
	
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-proce.bmp','Cambia la Moneda para Consultar los Importes',btn_moneda_datos,true,'moneda_datos','Moneda de Consulta');
	this.AdicionarBotonCombo(prueba,'prueba');		//Adicionamos un combo para filtrar por moneda
	
	//this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_memoria_recurso.getLayout().addListener('layout',this.onResize);
	layout_memoria_recurso.getVentana(idContenedor).on('resize',function(){layout_memoria_recurso.getLayout().layout()});

	//layout_memoria_recurso.getVentana().addListener('beforehide',salta)
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}