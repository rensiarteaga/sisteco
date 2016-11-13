/*
****************************************************************************************************
Nombre de la clase:	    LOV
Propósito:				Lista de valores parametrizable para la búsqueda de IDS para llaves foráneas
Métodos:
Fecha de Creación:		04 - 05 - 07
Versión:				2.0.0
Autor:					Rensi Arteaga Copari
****************************************************************************************************
*/
function LOV(paramConfig)
{
	////////////////// DEFINICON   LOV  //////////////////
	var configuracion = {
		nombre: '', //nombre del componente se utiliza para genera los sub nombres para los componentes
		url:'', //direccion para generar el STORE
		title:'',   //titulo que va en el GRID
		datos: [],
		pageSize: 10
	};


	var value='';//varlor que se muetra (descripcion)
	var value_id=undefined;//valor oculto(id)
	var contenedor_id; //para el componente que va cotener el id obtenido
	var contenedor_value;//para el componeten que va contener la descripcion del id
	var valores_seleccionados=new Array();

	if(paramConfig.nombre!==null){configuracion.nombre=paramConfig.nombre;}
	if(paramConfig.url!==null){configuracion.url=paramConfig.url;}
	if(paramConfig.title!==null){configuracion.title= paramConfig.title;}
	if(paramConfig.datos!==null){configuracion.datos= paramConfig.datos;}
	if(paramConfig.filterCols!==null){configuracion.filterCols= paramConfig.filterCols;}
	if(paramConfig.filterValues!==null){configuracion.filterValues= paramConfig.filterValues;}
	if(paramConfig.pageSize!==null){configuracion.pageSize= paramConfig.pageSize;}

	var paramLOV={ //paramatros para configurar el LOV
		modal:true,
		autoTabs:false,
		width:450,
		height:300,
		shadow:false,
		minWidth:150,
		minHeight:200,
		fixedCenter: true,
		constraIntoviewport: true,
		draggable:true,
		proxyDrag: true,
		closable:true,
		center_split: false,
		center_titlebar: false,
		center_autoscroll: true,
		south_split: false,
		south_titlebar: false
	};

	var smLOV;// para el selecion model
	var cmLOV;// para el colum model
	var dsLOV; //para el DATA STORE
	var dom_dlgLOV; // elemento en el DOM que contendra el dialogo del LOV
	var dom_gridLOV;// elemento en el DOM que contendra el grid del LOV
	var dlgLOV=false;//dialogo para el formulario
	var gridLOV;
	var layoutLOV;

/////////////////////
//FUNCION INIT LOV//
///////////////////
	this.iniciaLOV=function(){
		var atiqueta_html="<div id='dlgLOV_" + configuracion.nombre + "'><div class='x-dlg-hd'>"+ configuracion.title + "</div><div id='gridLOV_"+configuracion.nombre+"'></div></div>";
		Ext.DomHelper.insertHtml('afterBegin',document.body,atiqueta_html);
		dom_dlgLOV = Ext.get('dlgLOV_'+configuracion.nombre);
		dom_gridLOV = Ext.get('gridLOV_'+configuracion.nombre);
		var showBtn;
		if(!dlgLOV){ // lazy initialize the dialog and only create it once
			dlgLOV=new Ext.LayoutDialog( dom_dlgLOV,{
				modal:paramLOV.modal,
				autoTabs:paramLOV.autoTabs,
				width:paramLOV.width,
				height:paramLOV.height,
				shadow:paramLOV.shadow,
				minWidth:paramLOV.minWidth,
				minHeight:paramLOV.minHeight,
				fixedCenter:paramLOV.fixedCenter,
				constraIntoviewport:paramLOV.constraIntoviewport,
				draggable:paramLOV.draggable,
				proxyDrag:paramLOV.proxyDrag,
				closable:paramLOV.closable,
				center:{
					split:paramLOV.center_split,
					titlebar:paramLOV.center_titlebar,
					autoScroll:paramLOV.center_autoscroll
				}
			});
			dlgLOV.addKeyListener(27,ocultarLOV);//tecla escape
			dlgLOV.addButton('Seleccionar',Seleccionar);
			dlgLOV.addButton('Cancelar',ocultarLOV);
			dlgLOV.on('beforehide',function(tab,e){
			var ColFiltro=configuracion.datos[0].dataIndex;
			if(configuracion.datos[0].filterColValue!==undefined){
					ColFiltro=configuracion.datos[0].filterColValue;
				}
				dsLOV.lastOptions={
					params:{
						start:0,
						limit:configuracion.pageSize,
						CantFiltros:'1',
						filterCol_0: ColFiltro,
						filterValue_0: ''
					}
				};
				ActualizaVariablesFiltro();
				return true;
			});
			layoutLOV = dlgLOV .getLayout();
			layoutLOV.beginUpdate();
			layoutLOV.add('center', new Ext.ContentPanel(dom_gridLOV,{fitToFrame:true, closable: false, title:configuracion.title}));
			layoutLOV.endUpdate();
		}
//  DATA STORE LOV
//Se forma el array para el xml con los parámetros de entrada
		var xml=new Array();
		for(var i=0;i<configuracion.datos.length;i++){
			xml[i]=configuracion.datos[i].dataIndex;
		}
		dsLOV=new Ext.data.Store({
			//Asigna url de donde se cargaran los datos
			proxy: new Ext.data.HttpProxy({url: configuracion.url}),
			//Se define la estructura del XML
			reader:new Ext.data.XmlReader({
				record: 'ROWS',
				id: xml[0],//nombre de la columna ID que se quiere obtener del LOV
				totalRecords:'TotalCount'
			},xml),remoteSort:true
		});
		//se definen los parametros iniciales de carga
		dsLOV.lastOptions={
			params:{
				start:0,
				limit:configuracion.pageSize,
				CantFiltros:1,
				filterCol_0:xml[0],
				filterValue_0:''}
		};
		ActualizaVariablesFiltro();
		dsLOV.addListener('loadexception',conexionFailure); //se recibe un error
//COLUMN MODEL
//Al cargar el COlumn model, no cargamos la columna del ID
		var datos_column=new Array;
		for(i=1;i<configuracion.datos.length;i++){
			datos_column[i-1]=configuracion.datos[i];
		}
		//cmLOV = new Ext.grid.DefaultColumnModel(configuracion.datos);
		cmLOV=new Ext.grid.DefaultColumnModel(datos_column);
		// se establece por defecto que las columnas sean ordenables
		cmLOV.defaultSortable=true;
//SELECTION MODEL
		//El SelectionModel es para la selecion
		smLOV=new Ext.grid.RowSelectionModel({singleSelect:true});
		//Detecta el evento de una fila seleccionada
		smLOV.addListener('rowselect', EnableSelectLOV); //se marca un registro
		//Se crea un grid editable
		gridLOV=new Ext.grid.EditorGrid(dom_gridLOV, {
			ds: dsLOV,
			cm: cmLOV,
			selModel: smLOV,
			enableColLock:false
		});
		//Dibuja el grid
		gridLOV.render();
		/////manejo de eventos de layoput
		function onResize(){
			var gridView=gridLOV.getView();
			gridView.layout();
		}
		layoutLOV.addListener('layout',onResize);
		//Crea barra de paginación
		var gridFootLOV = gridLOV.getView().getFooterPanel(true);

		//Agrega la barra de paginación al pie
		var pagingLOV=new Ext.PagingToolbar(gridFootLOV, dsLOV, {
			pageSize: configuracion.pageSize,
			displayInfo: false,
			displayMsg: 'registros {0} - {1} de {2}',
			emptyMsg: "No hay registros para mostrar"
		});
		InitFiltro(pagingLOV);
	};var iniciaLOV=this.iniciaLOV;

	//this.InitFiltro = function (Barra)
	function InitFiltro(Barra)
	{
		Barra.addSeparator();
		var quickMenuItems = new Array('<b class="menu-title">Filtrar Por</b>');

		// llena los elementos en el combo
		var atributosLov = configuracion.datos.length;
		for(var j = 1; j < atributosLov ; j ++)
		{

			//cambio para filtrar por un valor diferente al nombre de columna
			value = configuracion.datos[j].dataIndex;
			if(configuracion.datos[j].filterColValue!==undefined){
				value=configuracion.datos[j].filterColValue;
			}

			text=configuracion.datos[j].header;
			if(j==1){
			quickMenuItems.push(new Ext.menu.CheckItem({value:value,text:text,checked:true}));
			}
			else{
			quickMenuItems.push(new Ext.menu.CheckItem({value:value,text:text,checked:false}));
			}
		}
		var quickMenu = new Ext.menu.Menu({
			id: 'quickMenu_'+configuracion.nombre,
			items: quickMenuItems
		});
		Barra.add({
			text: 'Filtro',
			tooltip: 'Columnas por las que se filtra',
			icon: '../../../lib/images/m.png',
			cls: 'x-btn-text-icon btn-search-icon',
			menu: quickMenu
		});
		var sftb = Barra.addDom({
			tag: 'input',
			id: 'quicksearch_'+configuracion.nombre,
			type: 'text',
			size: 30,
			value: '',
			style: 'background: #F0F0F9;'
		});

		var searchBox = new Ext.form.Field({
			//hideTrigger: true,
			//hideClearButton:true,
			//hideClearButton: true,
			emptyText: "Type to quicksearch"
			//rememberOn: 'all'
			//rememberOn: 'delay'
		});
		searchBox.applyTo('quicksearch_'+configuracion.nombre);

		var onFilteringBeforeQuery = function(e) {



			var sw = true; //primera vez que entra al for
			var filterCol ="";
			var cuentaCol = 0;
			for (var p=0,items=quickMenuItems,len=items.length; p<len; p++)
			{
				if (items[p].checked)
				{
					cuentaCol ++;
					if(sw)
					{
						filterCol = items[p].value;
						sw = false;
					}
					else
					{
						filterCol = filterCol+"#"+items[p].value;
					}

				}

			}
			if(cuentaCol===0){
				searchBox.setValue("");
				searchBox.disable();
			}
			else{
			searchBox.enable();
			}
			var value=searchBox.getValue();
			dsLOV.lastOptions.params["filterCol_0"]=filterCol;
			dsLOV.lastOptions.params.start = 0;
			dsLOV.lastOptions.params["filterValue_0"]=value;
			dsLOV.load(dsLOV.lastOptions);
		};
		quickMenu.on('click', onFilteringBeforeQuery);
		//searchBox.on("specialkey", onFilteringBeforeQuery);
		searchBox.el.on('keyup', onFilteringBeforeQuery,  searchBox);
	}

	/////////////////// FUNCIONES /////////////////////////
	this.ocultarLOV=function(){
		dlgLOV.hide();
	};var ocultarLOV=this.ocultarLOV;
	//Función que muestra el LOV
	this.loadLOV=function(ds){
		ds.load(ds.lastOptions);
	};var loadLOV = this.loadLOV  ;
	//Funcion que se llama al seleccionar una fila
	this.EnableSelectLOV=function(selModel,row,selected){
		var SelectionsRecordLOV=selModel.getSelected(); //es el primer registro seleccionado
		if(selected && SelectionsRecordLOV!=-1){
			value_id=SelectionsRecordLOV.data[configuracion.datos[0].dataIndex];
			value=SelectionsRecordLOV.data[configuracion.datos[1].dataIndex];
			for(var q=0;q<configuracion.datos.length;q++){
			   valores_seleccionados[configuracion.datos[q].dataIndex]=SelectionsRecordLOV.data[configuracion.datos[q].dataIndex];
			}
		}
	};var EnableSelectLOV=this.EnableSelectLOV;
	//Función que se ejecuta al oprimir seleccionar
	this.Seleccionar=function(){
		var NumSelect=smLOV.getCount(); //recupera la cantidad de filas selecionadas
		if(NumSelect!=0){
			if(paramConfig.origen=='formulario'){
				contenedor_value.setValue(value);
				paramConfig.contenedor_id.setValue(value_id);
			}
			else{   //para registra la seleccion en el grid
				var SelectionsRecord=paramConfig.sm.getSelected(); //es el primer registro selecionado
				contenedor_value.setValue(value);
				SelectionsRecord.set(paramConfig.contenedor_id,value_id);//= value_id;
				SelectionsRecord.set(paramConfig.name,value);//= value_id;
			}
			ocultarLOV();
		}
		else{
			Ext.MessageBox.alert('Status', 'Seleccione un item primero.');
		}
	};var Seleccionar=this.Seleccionar;
	//iniciamos el LOV
	iniciaLOV();
	this.smLOV=smLOV;// para el selecion model
	this.cmLOV=cmLOV;// para el colum model
	this.dsLOV=dsLOV; //para el DATA STORE
	this.dlgLOV=dlgLOV ;//dialogo para el formulario
	this.gridLOV=gridLOV;//dialogo para el formulario
	this.mostrarLOV=function(cajaValue){
		contenedor_value=cajaValue; //contenedor del value
		ActualizaVariablesFiltro();
		this.dsLOV.load(this.dsLOV.lastOptions);
		this.smLOV.clearSelections();
		this.dlgLOV.show();
	};var mostrarLOV=this.mostrarLOV;
	function ActualizaVariablesFiltro(){
		for(var k=0;k<configuracion.filterValues.length;k++){
			var indice=k+1;
			dsLOV.lastOptions.params["filterCol_"+indice]=configuracion.filterCols[k];
			dsLOV.lastOptions.params["filterValue_"+indice]=configuracion.filterValues[k];
			dsLOV.lastOptions.params["filterAvanzado_"+indice]=true;
		}
		dsLOV.lastOptions.params.CantFiltros=configuracion.filterValues.length+1;
	}
	this.modifica_filterCols=function(indice,valor){
		configuracion.filterCols[indice]=valor;
	};
	var modifica_filterCols=this.modifica_filterCols ;
	this.modifica_filterValues=function(indice,valor){
		configuracion.filterValues[indice]=valor;
	};varmodifica_filterValues=this.modifica_filterValues;
	this.recuperar_valoresSelecionados=function(){
		return valores_seleccionados;
	}
	recuperar_valoresSelecionados=this.recuperar_valoresSelecionados;
	//conexion failure
	function conexionFailure(resp1,resp2,resp3){
		resp=resp3;     //error conexion en el ds de EXT
		var sw=false;
		if(resp.status==404&&!sw){
			var mensaje="<p>HTTP status: " + resp.status +" <br/> Status: " + resp.statusText +"<br/> No se encontro el Action requerido</p>";
			Ext.Msg.show({
				title: 'ERROR',
				msg: mensaje,
				minWidth:300,
				maxWidth :800,
				buttons: Ext.Msg.OK
				//width: 300,
			});
			sw=true;
		}
		if(resp.responseXML != undefined && resp.responseXML != null && !sw && resp.responseXML.documentElement != null && resp.responseXML.documentElement!= undefined){
			var root = resp.responseXML.documentElement;
			if(root.getElementsByTagName('mensaje')[0]){
				var oMensaje=root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
				var mensaje="HTTP status: "+resp.status+"<br/> Status: "+resp.statusText +"<br>"+ oMensaje;
			}
			else{
				var mensaje="HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br>"+ resp.responseText;
			}
			Ext.Msg.show({
				title:'ERROR',
				msg:mensaje,
				minWidth:300,
				maxWidth:800,
				buttons:Ext.Msg.OK
			});
			sw=true;
		}
		else{
			if(resp.status===-1&&!sw){
				var mensaje="<p>HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Tiempo de espera agotado</p>";
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					});
				sw=true;
			}
			if (resp.status===0&&!sw){
				var mensaje = "HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Fallo en su conexión de Internet";
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					
				});
				sw=true;
			}
			if(!sw){
				var mensaje = "respuesta indefinida, error en la transmision <br> respuesta obtenida:<br>"+ resp.responseText;
				Ext.Msg.show({
					title: 'ERROR',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
				});
			}

		}


	}
	this.conexionFailure=conexionFailure;
}

//////////////////////////////////////////////////////////////////////////
//---------------      COMPONET LOV          -------------------------- //
//   inicia los elementos para la contruccion del LOV                   //
//////////////////////////////////////////////////////////////////////////

Ext.form.LovTriggerField=function(config){
	Ext.form.LovTriggerField.superclass.constructor.call(this, config);
	this.nombre=this.getId();
	configuracion={
		nombre:this.nombre, //nombre del componente se utiliza para genera los sub nombres para los componentes
		url:this.url,           //direccion para generar el STORE
		title:this.title,  //titulo que va en el GRID
		datos:this.datos,        //definicion de datos
		filterCols:this.filterCols,        //columnas extras para el filtro
		filterValues:this.filterValues,        //valores extra para el filtro
		pageSize: this.pageSize,
		contenedor_id:this.contenedor_id, //contenedor del value
		origen:this.origen, //contenedor del value
		sm:this.sm, //contenedor del value
		name:this.name //contenedor del value
	};
	this.lov=new LOV(configuracion);
};
Ext.extend(Ext.form.LovTriggerField,Ext.form.TriggerField,
{
	defaultAutoCreate:{tag: "input", type: "text", size: "24", autocomplete: "off"},
	nombre:undefined, //nombre del componente se utiliza para genera los sub nombres para los componentes
	url:'',//direccion para generar el STORE
	title:'',//titulo que va en el GRID
	datos: [],//definicion de datos
	filterCols:[],//columnas extras para el filtro
	filterValues:[],//valores extra para el filtro
	pageSize:10,//tamaño de pagina
	paramLOV:{//paramatros para configurar el LOV
		modal:false,
		autoTabs:false,
		width:450,
		height:300,
		shadow:false,
		minWidth:150,
		minHeight:200,
		fixedCenter: true,
		constraIntoviewport: true,
		draggable:true,
		proxyDrag: true,
		closable:true,
		center_split: false,
		center_titlebar: false,
		center_autoscroll: true,
		south_split: false,
		south_titlebar: false
	},
	smLOV:undefined,// para el selecion model
	cmLOV:undefined,// para el colum model
	dsLOV:undefined, //para el DATA STORE
	dom_dlgLOV:undefined, // elemento en el DOM que contendra el dialogo del LOV
	dom_gridLOV:undefined,// elemento en el DOM que contendra el grid del LOV
	dlgLOV:false,//dialogo para el formulario
	gridLOV:undefined,
	layoutLOV:undefined,
	pagingLOV:undefined,
	triggerClass:'x-form-search-trigger',
	value:undefined,   //valor que se muestra
	value_id:undefined,//valor oculto (el que se deberia guardar)
	editable:false,
	//se ejecuta al oprimir el boton
	onTriggerClick:function(){
		this.lov.mostrarLOV(this);
	},
	initEvents:function(){
		Ext.form.ComboBox.superclass.initEvents.call(this);
		this.keyNav = new Ext.KeyNav(this.el, {
		"enter":function(e){
			this.lov.mostrarLOV(this);
		},
		"esc" : function(e){
			this.lov.ocultarLOV();
		}
		});
		this.el.dom.setAttribute('readOnly', true);
		this.el.addClass('x-combo-noedit');
	}
});