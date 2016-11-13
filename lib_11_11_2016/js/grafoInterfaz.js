/*
**********************************************************
Nombre de la clase:	    PaginaArb
Propósito:				clse principal donde se definen  las funcionalidades
de las paginas que manejan arboles
para ENDE
Valores de Retorno:		invoca a funciones para el manejo de datos (insert, update y delete)
Fecha de Creación:		10/12/07
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/

function GrafoInterfaz(paramConfig,parametrosDatos,ds_nodo,ds_arista,ContenedorLayout,idContenedor,config_ds){
	//---------------Conversion de variables o métodos a públicos
	this.seleccionar = seleccionar;
	
	
	//********** Definicion de variables **********//
	var configuracion=new Array;
	var Grupos=new Array();
	var parametros_barra_menu;//parametros para la configuracion de la barra de menu
	var paging;// barra de paginacion
	var dlgInfo1;//dialogo para el formulario
	var dlgLoading;
	var GuardarOtro=false;
	var Formulario1; // para el manejo del formulario
	var Formulario2; //para el manejo del formulario 2
	var vectorDatos=new Array;
	var cantidadAtributosEntrada=parametrosDatos.length;
	var cantidadAtributos=parametrosDatos.length;
	var tipoGrafo="nodo"; //String que toma los valores: nodo o arista para poder alternar el formualario
	var btnToggle;
	
	////////////////////////////////////////
	// ATRIBUTOS PARA EL MANEJO DE GRAFOS //
	////////////////////////////////////////
	var gNodo = new Array();//arreglo de nodos
	var diagrama = Joint.dia.fsa;//instanciamos el diagrama
	var fondo; //area de dibujo
	var flag = false; //habilita o deshabilita una función: insertarCircuito o borrar Circuito
	var jointNodos=false; //booleano que define si se habilita la selección de 2 nodos para ser unidos
	var opt1,opt2; // Variables opcionales para el manejo de posiciones.
	var nodoActual;
	var aristaActual;
	var editado = false;
	var idNodoEditado = new Array();
	var tipoGrafico = config_ds.tipo_grafico||"circulo";
	var attrNodo, attrNodoSel, attrNodoEspecial;
	var jOptions= config_ds.jOptions|| {
		//opciones default para las aristas
			data: {},
			draggable: true,
			interactive: false,
			attrs: {"stroke": "#8DB2E3", "stroke-width": "3", "stroke-dasharray":"none"}
		};
	var attrCirculo=config_ds.attrCirculo||{
		//atributos gráficos del nodo
			"fill":"#F3F7FB",
			"stroke": "#8DB2E3",
			"stroke-width":"1"
	};
	
	var attrCuadro=config_ds.attrCuadro||{
		"fill": '#F3F7FB',
		"stroke": '#8DB2E3'
	};
	
	var attrCuadroEspecial=config_ds.attrCuadroEspecial||{
		"fill": '#F3F7FB',
		"stroke": '#05E95B'
	};
	
	var attrCuadroSel=config_ds.attrCuadroSel||{
		"fill": '#F3F7FB',
		"stroke": '#FF0000',
		"stroke-width":"3"
	};
	var attrCirculoEspecial=config_ds.attrCirculoEspecial||{
		//atributo para el nodo especial
			"fill":"#F3F7FB",
			"stroke":"#0D86FF",
			"stroke-width":"2"
	};
	var attrCirculoSel=config_ds.attrCirculoSel || {
		//atributos gráficos del nodos seleccionado}
			"fill":"#F3F7FB",
			"stroke":"#FF0000",
			"stroke-width":"3"
	};
	
	//Asignamos la apariencia elegida para todos los nodos.
	if(tipoGrafico=="cuadro"){
		attrNodo=attrCuadro;
		attrNodoSel=attrCuadroSel;
		attrNodoEspecial=attrCuadroEspecial;
	}
	else{
		attrNodo=attrCirculo;
		attrNodoSel=attrCirculoSel;
		attrNodoEspecial=attrCirculoEspecial;
	}
	
	var tmpAttr; //Objeto de atributos temporal para guardar los atributos que se seleccionan

	Joint.paper(ContenedorLayout.getLayout().getRegion('center').getEl().id);
	/////////////////////
	// SELECTION MODEL //
	/////////////////////
	var sm=new Ext.grid.RowSelectionModel({singleSelect:false});

	///////////////////////////////
	//CREACION DE LOS COMPONENTES//
	///////////////////////////////

	//-------- varibles para el grid --------//
	var Ed=Ext.grid.GridEditor;
	var Componentes=new Array();
	var Componentes2=new Array();
	var Componentes_grid=new Array();
	var parametrosCM=new Array();

	for(var i=0;i<cantidadAtributos;i++){
		var vA=parametrosDatos[i].validacion;
		if(parametrosDatos[i].tipo=='LovTriggerField'||parametrosDatos[i].tipo=='LovItemsAlm'||parametrosDatos[i].tipo=='LovPartida'||parametrosDatos[i].tipo=='LovCuenta'||parametrosDatos[i].tipo=='LovServicio'){
			//para el que va en el formulario*/
			//vA.contenedor_id = Componentes[vA.indice_id];//formulario
			vA.origen='formulario';
			Componentes[i]=new Ext.form[parametrosDatos[i].tipo](vA);
		}
		else{
			if(parametrosDatos[i].form!=false){
				Componentes[i]=new Ext.form[parametrosDatos[i].tipo](vA)
			}
		}
		if(parametrosDatos[i].tipo=='ComboBox' && parametrosDatos[i].validacion.mode=='remote'&&parametrosDatos[i].form!=false){
			Componentes[i].store.on('loadexception',_CP.conexionFailure)
		}
	}

	// se establece por defecto que las columnas sean ordenables
	this.Init=function(){
		Ext.QuickTips.init();
		Ext.form.Field.prototype.msgTarget='qtip'; //muestra mensajes de error en el formulario
		// para capturar un error
		ds_nodo.addListener('loadexception',this.conexionFailure); //se recibe un error
		ds_arista.addListener('loadexception',this.conexionFailure); //se recibe un error
		
		//aregla la forma en que se ve el grid dentro del layout
		this.onResize=function(){
			ContenedorLayout.getLayout().layout();
		};
		this.onResizePrimario=function(){
			ContenedorLayout.getLayout().layout();
		};
	};

	this.reload=function(params){
		alert("Necesita sobrecargar la funcion reload reload")
	};
	
	////////////////////////////////////////////////////////////
	/////////////// FUNCIONES PARA EL LOADING //////////////////
	////////////////////////////////////////////////////////////
	this.load=function(params){
		_CP.loadingShow();
		crearDiagrama();
		var par ={start:0};
		Ext.apply(par,params);
		ds_nodo.load({
    			params:par,
				callback: function(){ds_arista.load({
    				params:par,
					callback: function(){cargarNodos(); cargarJoints();_CP.HideLoding()}
					});}
		});
    };
    function cargarNodos(){
 		var auxRecord;
 		var auxLabel2; //auxiliar de los labels
 		for(i=0;i<ds_nodo.data.length;i++){
 			auxRecord=ds_nodo.getAt(i);
 			var paramsNodo = {
 				id:	parseInt(auxRecord.id),
 				label:auxRecord.data[config_ds.label]||'',
 				label2:auxRecord.data[config_ds.label2]||'',
 				posX: parseInt(auxRecord.data[config_ds.posx])||100,
 				posY: parseInt(auxRecord.data[config_ds.posy])||100,
 				data: auxRecord.data, 
 				funcion: config_ds.funcionx
 			};
 			nuevoNodo(paramsNodo);
 		}
    }
    function cargarJoints(){
    	var auxRecord;
 		for(var i=0;i<ds_arista.data.length;i++){
 			auxRecord=ds_arista.getAt(i);
 			unirNodos(parseInt(auxRecord.data[config_ds.id_origen]),parseInt(auxRecord.data[config_ds.id_destino]),auxRecord.data);
 		}
 	}
    
    ////////////////////////////
    //// FUNCIONES DE DIBUJO ///
    ////////////////////////////
	function crearDiagrama(){ //crea el área de dibujo
		fondo = Joint._paper.rect(0,0,"100%","100%");  //la variable s representa el fondo del diagrama.
		fondo.click(function(event){clearSelection()});
		fondo.attr("fill","white");
	}
	
    function limpiarDiagrama(){
		Joint.resetPaper();
		fondo=undefined;
		Joint.dia._registeredObjects={};
		Joint.dia._registeredJoints={};
		gNodo = [];
		flag = false;
		jointNodos=false; 
		opt1=undefined;
		opt2=undefined;
		idNodoEditado=[];
		nodoActual = undefined;
		aristaActual = undefined;
	}
    
	function nuevoNodo(paramsNodo){
		if(paramsNodo.id==config_ds.id_nodo_especial){
			tmpAttr= attrNodoEspecial;
		}
		else{
			tmpAttr= attrNodo;
		}
		var i = gNodo.length;
		if(tipoGrafico=="cuadro"){
			gNodo[i]=diagrama.Member.create({
				id:paramsNodo.id,
				data: paramsNodo.data,
				avatar:undefined,
				rect: { x: parseInt(paramsNodo.posX), y: parseInt(paramsNodo.posY), width: config_ds.width||150, height: config_ds.height||60},
				name: paramsNodo.label2,
				position: paramsNodo.label,
				attrs:tmpAttr,
				shadow: config_ds.shadow||false
			})
		}
		else{
			gNodo[i] =  diagrama.State.create({
				id: paramsNodo.id,
				position: {x: paramsNodo.posX, y: paramsNodo.posY},
				label: paramsNodo.label,
				data: paramsNodo.data,
				radius: config_ds.radius||30,
				attrs:tmpAttr,
				shadow: config_ds.shadow||false
			});
		}
		var funcionx=seleccionar;
		//se adicionan los eventos a los nodos(1 nodo consta de 2 partes: wrapper e inner)
		if(config_ds.funcionx!=undefined){
			funcionx=config_ds.funcionx;
		}
		gNodo[i].wrapper.mouseup(function(event){seleccionar(gNodo[i]);});
		gNodo[i].wrapper.dblclick(function(event){funcionx(gNodo[i]);});
		//se añaden los eventos a todos los inner
		for(var j=0;j<gNodo[i].inner.length;j++){
			gNodo[i].inner[j].mouseup(function(event){seleccionar(gNodo[i]);});
			gNodo[i].inner[j].dblclick(function(event){funcionx(gNodo[i]);});
		}
		//gNodo[i].toggleGhosting();
	}
	
	function unirNodos(idInicio, idFin, data){//Une 2 nodos si no hay ninguna union previa entre ellos.
		var xInicio, xFin;
		xInicio = getIndex(idInicio);
		xFin = getIndex(idFin);
		var j;//variable auxiliar que agarra el joint despues de una operacion join.
		if((xInicio>=0)&&(xFin>=0)){
				jOptions.data = data;//añadimos la información adicional a las opciones del Joint
				j=gNodo[xInicio].joint(gNodo[xFin],jOptions).registerForever(gNodo);
				j.registerCallback("selectJoint", function(){seleccionar(this)});
				j.registerCallback("droppedSide", function(side){
					anclarArista(side);
				});
			}
		var xJoint = buscarJoint(idFin,idInicio);
		if(xJoint!= undefined){// ya hay una arista en sentido contrario entre estos 2 nodos
			var x1, x2, y1, y2, xm, ym;
			x1 = gNodo[xInicio].properties.position.x;
			x2 = gNodo[xFin].properties.position.x;
			y1 = gNodo[xInicio].properties.position.y;
			y2 = gNodo[xFin].properties.position.y;
			xm = Math.ceil((x1+x2)/2);
			ym = Math.ceil((y1+y2)/2);
			xJoint.setVertices([(xm+20)+' '+(ym-20)]).toggleSmoothing();
			j.setVertices([(xm-20)+' '+(ym+20)]).toggleSmoothing();
		}
		if(idInicio==idFin){//el nodo es recursivo
			//Vértices para los nodos recursivos
			var vertRecursivo = [    (gNodo[xInicio].properties.position.x-38)+' '+(gNodo[xInicio].properties.position.y+12),
			                         (gNodo[xInicio].properties.position.x-46)+' '+(gNodo[xInicio].properties.position.y+10),
			                         (gNodo[xInicio].properties.position.x-50)+' '+(gNodo[xInicio].properties.position.y+3),
			                         (gNodo[xInicio].properties.position.x-50)+' '+(gNodo[xInicio].properties.position.y-3),
			                         (gNodo[xInicio].properties.position.x-46)+' '+(gNodo[xInicio].properties.position.y-10),
			                     	 (gNodo[xInicio].properties.position.x-38)+' '+(gNodo[xInicio].properties.position.y-12)];
			j.setVertices(vertRecursivo).toggleSmoothing();
		}
	}
	
	function anclarArista(side){
		if((aristaActual.endObject().wholeShape == undefined)||(aristaActual.startObject().wholeShape == undefined)){
			//aristaActual = undefined;
			Ext.MessageBox.alert("Estado","No puede dejar la arista sin conexión",recargarPagina());
		}
		else{
			var xJoint = buscarJoint(aristaActual.startObject().wholeShape.properties.id,aristaActual.endObject().wholeShape.properties.id);
			if(xJoint== undefined){
				if (side=="start"){
					  getComponente(config_ds.id_origen).setValue(aristaActual.startObject().wholeShape.properties.id);
				}
				else {  // side === "end"
					  getComponente(config_ds.id_destino).setValue(aristaActual.endObject().wholeShape.properties.id);
				}
				btnEdit();
				dlgInfo1.buttons[0].enable();
			}
			else{
				Ext.MessageBox.alert("Estado","Ya existe una arista entre estos 2 nodos y esa direccion",recargarPagina());
			}
		}
	}
	
	function clearSelection(){
		if(nodoActual != undefined){
			nodoActual.wrapper.animate(tmpAttr,0);
			nodoActual = undefined;
		}
		if(aristaActual != undefined){
			aristaActual.hideHandle();
			aristaActual = undefined;
		}
	}
	function seleccionar(objeto){
		clearSelection();
		EnableSelect(objeto);
		if(objeto.properties ==undefined){//SI es undefined entonces es una arista
			tipoGrafo = "arista";
			aristaActual = objeto;
			aristaActual.showHandle();
		}
		else{
			tipoGrafo="nodo";
			nodoActual=objeto;
			tmpAttr=nodoActual.properties.attrs;
			nodoActual.wrapper.animate(attrNodoSel,0);
			if(RevisarPosicion(nodoActual)){
				//pregunta si la posicion se desplazo mas de 5 puntos en 'x' y 'y'
				//si es asi los considera como editado de posicion
				editado=true;
				if(buscarEditado(nodoActual.properties.id)==-1){
					idNodoEditado[idNodoEditado.length]=nodoActual.properties.id;
				}
			}
			//para unir 2 nodos
			if(jointNodos==true){
				flag=!flag;
				if(flag==true){
					opt1=nodoActual.properties.id;
				}
				else{
					opt2=nodoActual.properties.id;
					if((opt1 == undefined)||(opt2==undefined)){
						alert("no se puede insertar el joint");
					}
					else{
						var sw = false;
						if(idNodoEditado.length>0){//Para verificar si existen modificaciones hechas
							if(confirm('Las posiciones de los nodos han cambiado y se guardarán automáticamente. Desea Continuar?')){
								sw=true
							}
						}
						else{
							sw=true
						}
						if(sw) {
							var xJoint = buscarJoint(opt1,opt2);
							if(xJoint==undefined){
								tipoGrafo="arista";
								alternarComponentes();
								getComponente(config_ds.id_origen).setValue(opt1);
								getComponente(config_ds.id_destino).setValue(opt2);
								param_Formulario1.mostrar();
							}
							else{
								alert("Ya existe una arista entre estos 2 nodos y esa direccion");
							}
						}
					}
					btnToggle.toggle();
				}}
		}
	}
	
	//revisa si la posicion del nodo ha variado
	function RevisarPosicion(nodo){
		if((nodo.wrapper.attrs.cx >= nodo.properties.position.x+5) 
				||(nodo.wrapper.attrs.cy  >= nodo.properties.position.y+5)
				||(nodo.wrapper.attrs.cx  <= nodo.properties.position.x-5)
				||(nodo.wrapper.attrs.cy  <= nodo.properties.position.y-5)
				){
			return true;
		}
		return false;
	}
	function buscarEditado(id){
		var i;
		var indice=-1;
		for(i=0;i<idNodoEditado.length;i++){
			if(parseInt(id) == parseInt(idNodoEditado[i])){
				indice =i;
				break;
			}
		}
		return indice;
	}
	
	function buscarJoint(idInicio,idFin){
		var xJoint;
		var xInicio;
		xInicio = getIndex(idInicio);
		if(xInicio>=0){
			var flechas = gNodo[xInicio].joints();
			for(var i=0;i<flechas.length;i++){
				//revisa si hay una arista en la dirección idInicio -> idFin 
				// entre los nodos.
				if(flechas[i].startObject().wholeShape.properties.id == idInicio){
					if(flechas[i].endObject().wholeShape.properties.id == idFin){
						xJoint = flechas[i];
						break;
					}
				}
				/*revisa si hay una arista en la dirección idInicio<-idFin
				 * De esta forma se revisa si hay arista en cualquier direccion.
				if(flechas[i].endObject().wholeShape.properties.id == idInicio){
					if(flechas[i].startObject().wholeShape.properties.id == idFin){
						xJoint = flechas[i];
						break;
					}
				}*/
			}
		}
		return xJoint;
	}
	//obtiene la posición del id en el vector gNodo
	function getIndex(id){
		var i;
		var indice = -1;
		for(i=0;i<gNodo.length;i++){
			if(parseInt(gNodo[i].properties.id) == parseInt(id)){
				indice = i;
				break;
			}
		}
		return indice;
	}
	
	function getIdAristasDeNodo(idNodo){
		var auxRecord;
		var idArista = new Array();
		idNodo = parseInt(idNodo);
		for(var i=0;i<ds_arista.data.length;i++)
		{
			auxRecord=ds_arista.getAt(i);
			if(auxRecord.data[config_ds.id_origen] == idNodo)
			{
				idArista[idArista.length] = parseInt(auxRecord.id);
			}
			else
			{
				if(auxRecord.data[config_ds.id_destino] == idNodo)
				{
					idArista[idArista.length] = parseInt(auxRecord.Id);
				}
			}
		}
		return idArista;
	}
	

	/////////////////-/////
	// FUNCION ACTUALIZAR//
	///////////////////////
	
	this.recargarPagina = function(){
		loadingShow();
		limpiarDiagrama();
		crearDiagrama();
		ds_nodo.reload({
	        params:ds_nodo.lastOptions.params,
	        callback:function(){
				        ds_arista.reload({
				    	params:ds_nodo.lastOptions.params,
						callback: function(){cargarNodos();cargarJoints(); Ext.MessageBox.hide()}
						});}
	       	});
	};var recargarPagina = this.recargarPagina;
	
	this.btnActualizar=function(){
		var sw=false;
		var confirmar;			
		if(idNodoEditado.length>0){//Para verificar si existen modificaciones hechas
			if(confirm('Las posiciones de los nodos han cambiado y se perderán. Desea continuar?')){
				sw=true;
			}
		}
		else{
			sw=true;
		}
		if(sw){
			recargarPagina();
		}
	};
	var btnActualizar=this.btnActualizar;
	

	//////////////////////////////////////////////////////////////
	//---------      FUNCIONES FORMULARIO            -----------//
	//////////////////////////////////////////////////////////////
	this.mostrarFormulario=function(){
		dlgInfo1.show();
		Ext.form.Field.prototype.msgTarget='under'; //muestra mensajes de error
		limpiarInvalidos()
	};var mostrarFormulario=this.mostrarFormulario;
	
	this.ocultarFormulario=function(){
		dlgInfo1.hide();
		if(tipoGrafo=="arista"){
			recargarPagina();
		}
		Ext.form.Field.prototype.msgTarget='qtip'
	};var ocultarFormulario = this.ocultarFormulario;
	
	this.getFormulario=function(){
		return Formulario1
	};var getFormulario=this.getFormulario;

	this.renderFormulario=function(){
		Formulario1.render("form-ct2_"+param_Formulario1.html_apply)//dibuja el formulario
	};var renderFormulario=this.renderFormulario;


	///validacion de campos //
	this.ValidarCampos=function(){
		return Formulario1.isValid()
	};var ValidarCampos=this.ValidarCampos;

	//limpiar invalidos
	this.limpiarInvalidos=function(){
		return Formulario1.clearInvalid()
	};var limpiarInvalidos=this.limpiarInvalidos;

	///////////////////////////
	//FUNCION ENABLE SELECT  //
	//Funcion que se llama   //
	//al seleccionar una fila//
	///////////////////////////

	this.EnableSelect=function(objeto){
		var record;//es el primer registro selecionado
		if(objeto.properties ==undefined){//SI es undefined entonces es una arista
			tipoGrafo = "arista";
			record=objeto._opt.data;
		}
		else{
			tipoGrafo="nodo";
			record=objeto.properties.data;
		}
		for(var i=0;i<cantidadAtributos;i++){
			//if(parametrosDatos[i].validacion.tipo_grafo==tipoGrafo){//COMPROBAMOS QUE SOLO MUESTRE LOS DATOS DEL OBJETO SELECCIONADO: NODO O GRAFO
				if(parametrosDatos[i].form!=false){
					if(parametrosDatos[i].validacion.inputType!='file'&&parametrosDatos[i].tipo!='ComboBox'&&parametrosDatos[i].tipo!='epField'&&parametrosDatos[i].tipo!='LovItemsAlm'&&parametrosDatos[i].tipo!='LovPartida'&&parametrosDatos[i].tipo!='LovCuenta'&&parametrosDatos[i].tipo!='LovServicio'){
						if(record[parametrosDatos[i].validacion.name]===undefined){
							vectorDatos[i].setValue('')
						}
						else{
							vectorDatos[i].setValue(record[parametrosDatos[i].validacion.name])
						}
					}
					else{
						//para combos que se llenan remotamente
						//el store principal de proveer el id y la descripcion
						if(parametrosDatos[i].tipo=='ComboBox'){
							if(vectorDatos[i].mode=='remote'){
								if(!vectorDatos[i].store.getById(record[parametrosDatos[i].validacion.name])){
									//alert("XXX  " + vectorDatos[i].store.getById(record[parametrosDatos[i].validacion.name]))
									if(record[parametrosDatos[i].validacion.name] && record[parametrosDatos[i].validacion.name]!==' '){
										var  params = new Array();
										params[vectorDatos[i].valueField] = record[parametrosDatos[i].validacion.name];
										params[vectorDatos[i].displayField] = record[parametrosDatos[i].validacion.desc];
										var aux = new Ext.data.Record(params,record[parametrosDatos[i].validacion.name]);
										//var aux = new Ext.data.Record(params,vectorDatos[i].valueField);
										vectorDatos[i].store.add(aux)
									}
								}
							}
							vectorDatos[i].setValue(record[parametrosDatos[i].validacion.name])
						}
						if(parametrosDatos[i].tipo=='LovItemsAlm'||parametrosDatos[i].tipo=='LovPartida'||parametrosDatos[i].tipo=='LovCuenta'||parametrosDatos[i].tipo=='LovServicio'){
							var  p = new Array();
							p={id:record[parametrosDatos[i].validacion.name],desc:record[parametrosDatos[i].validacion.desc]};
							vectorDatos[i].setValue(p)
						}
						if(parametrosDatos[i].tipo=='epField'){
							var p = new Array();
							p={
								id_financiador:record[parametrosDatos[i].f],
								codigo_financiador:record[parametrosDatos[i].cf],
								nombre_financiador:record[parametrosDatos[i].nf],
								id_regional:record[parametrosDatos[i].r],
								codigo_regional:record[parametrosDatos[i].cr],
								nombre_regional:record[parametrosDatos[i].nr],
								id_programa:record[parametrosDatos[i].p],
								codigo_programa:record[parametrosDatos[i].cp],
								nombre_programa:record[parametrosDatos[i].np],
								id_proyecto:record[parametrosDatos[i].pr],
								codigo_proyecto:record[parametrosDatos[i].cpr],
								nombre_proyecto:record[parametrosDatos[i].npr],
								id_actividad:record[parametrosDatos[i].a],
								codigo_actividad:record[parametrosDatos[i].ca],
								nombre_actividad:record[parametrosDatos[i].na]
	
							};
							vectorDatos[i].setValue(p,false)
						}
	
					}
				}
			}
		//}
	};var EnableSelect=this.EnableSelect;
	
	/////////////////////////////////////////////
	/// FUNCIÓN PARA OCULTAR O NO COMPONENTES ///
	/////////////////////////////////////////////

	this.alternarComponentes = function()
	{
		for(var i=0;i<vectorDatos.length;i++){
			if(vectorDatos[i].tipo_grafo ==tipoGrafo)
			{
				if((vectorDatos[i].name == config_ds.posx)||(vectorDatos[i].name == config_ds.posy)||(vectorDatos[i].name==config_ds.id_origen)||(vectorDatos[i].name==config_ds.id_destino)){
					vectorDatos[i].disable();
				}
				else{
					vectorDatos[i].enable();
				}	
				mostrarComponente(vectorDatos[i]);
			}
			else
			{
				vectorDatos[i].disable();
				ocultarComponente(vectorDatos[i]);
			}
		}
	}; var alternarComponentes = this.alternarComponentes;
	////////////////////////////////////////////////////////////////////////////
	//----------------      FUNCION NUEVO               ----------------------//
	////////////////////////////////////////////////////////////////////////////
	//Se llama cuando se elige la opcion "nuevo" en la barra de menu
	//this.btnNew = function()
	this.btnNew=function(){
		//dlgInfo1.buttons[0].disable();
		var sw=false;
		var confirmar;			
		if(idNodoEditado.length>0){//Para verificar si existen modificaciones hechas
			if(confirm('Las posiciones de los nodos han cambiado y se guardarán automáticamente. Desea continuar?')){
				sw=true
			}
		}
		else{
			sw=true
		}
		if(sw) {
			tipoGrafo="nodo";
			if(tipoGrafo=="nodo"){
				dlgInfo1.buttons[1].show();
			}
			Formulario1.reset();
			for(var i=0;i<cantidadAtributos;i++){
					if(parametrosDatos[i].form!=false  &&  parametrosDatos[i].tipo=='epField' && vectorDatos[i].pregarga){
						vectorDatos[i].ep.cargaEPprimaria();
					}
					if(parametrosDatos[i].form!=false && parametrosDatos[i].tipo!='epField'){
						if( parametrosDatos[i].defecto){
							vectorDatos[i].setValue(parametrosDatos[i].defecto);
						}
					}
			}
			//incia valores ocultos
			alternarComponentes();
	        param_Formulario1.mostrar()
		}
	};var btnNew=this.btnNew;

	////////////////////////////////////////////////////////////////
	//----------------      FUNCION EDITAR     -------------------//
	////////////////////////////////////////////////////////////////
	this.btnEdit=function(){
			alternarComponentes();
			dlgInfo1.buttons[1].hide(); //apaga el boton de guardar nuevo
			if((nodoActual)||(aristaActual)){//Verifica si hay filas seleccionadas
					param_Formulario1.mostrar()
			}
			else{
				Ext.MessageBox.alert('Estado', 'Seleccione un item primero.')
			}
			dlgInfo1.buttons[0].disable()//apaga el boton de guardar
	};var btnEdit=this.btnEdit;

	///////////////////////////////////////////////////////////////-////////////
	//----------------      FUNCION PARA ELIMINAR       ----------------------//
	//   Funcion que se llama al para iniciar el formulario de edicion        //
	////////////////////////////////////////////////////////////////////////////
	//confirmacion para eliminar
	this.btnEliminar=function(pextra){
		alternarComponentes();
		var idSelect;
		if((nodoActual)||(aristaActual)){
			var sw=false;
			var confirmar;			
			if(idNodoEditado.length>0){//Para verificar si existen modificaciones hechas
				if(confirm('Las posiciones de los nodos han cambiado y se perderán. Desea continuar?')){
					sw=true
				}
			}
			else{
				sw=true
			}
			if(sw) {
				if(confirm(Funcion_btnEliminar.mensaje)){		
					parametrosFiltro="";
					var postData="cantidad_ids=1"; 
					//coloca los parametros del filtro
					postData=postData+Funcion_btnEliminar.parametros;
					
					var auxUrl;
					var nombreAux;
					//en la pos 0 del vector de atributo siempre estara la llave primaria
					if(nodoActual){
						idSelect = nodoActual.properties.data[config_ds.id_nodo];
						auxUrl = Funcion_btnEliminar.urlNodo;
						nombreId = config_ds.id_nodo;
						if(getIdAristasDeNodo(idSelect).length>0)
						{
							idSelect=undefined;
						}
						
					}
					if(aristaActual){
						idSelect = aristaActual._opt.data[config_ds.id_arista];
						auxUrl=Funcion_btnEliminar.urlArista;
						nombreId = config_ds.id_arista;
					}
						
					if(idSelect != undefined){
						postData=postData+"&"+nombreId+"_"+0+"="+idSelect;
						/*-----loading----*/
						Ext.MessageBox.show({
							title: 'Espere Por Favor...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Eliminando...</div>",
							width:150,
							height:200,
							closable:false
						});
						Ext.Ajax.request({
							url:auxUrl,
							params: postData,
							method:'POST',
							success: Funcion_btnEliminar.success,
							failure: Funcion_btnEliminar.failure,
							timeout: configuracion.TiempoEspera//TIEMPO DE ESPERA PARA DAR FALLO
						});
					}
					else{
						Ext.MessageBox.alert('Estado', 'El nodo seleccionado no debe estar enlazado a ninguna arista.');
					}
				}
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Seleccione un item primero.')
		}
	};var btnEliminar=this.btnEliminar;

	//Se llama cuando los datos de eliminacion se han enviado satisfactoriamente
	this.eliminarSucess=function(resp){
		Ext.MessageBox.hide();
		dlgInfo1.buttons[1].hide(); //apaga el boton de guardar nuevo
		if(resp.responseXML&&resp.responseXML.documentElement){
			var root = resp.responseXML.documentElement;
			var tc=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
			if(tipoGrafo=="nodo"){
				Ext.mensajes.msg('Eliminación Exitosa', 'Se tienen "{0}" nodos.',tc);
			}
			if(tipoGrafo=="arista"){
				Ext.mensajes.msg('Eliminación Exitosa', 'Se tienen "{0}" aristas.',tc);
			}
			// ----------- registro  de eventos ----------//
			var origen=undefined;
			if(root.getElementsByTagName('origen')[0]!= undefined){
				origen=root.getElementsByTagName('origen')[0].firstChild.nodeValue
			}
			parametros_mensaje={
				origen:origen,
				mensaje:root.getElementsByTagName('mensaje')[0].firstChild.nodeValue,
				tiempo_resp: root.getElementsByTagName('tiempo_resp')[0].firstChild.nodeValue,
				TotalCount:root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue
			}
			// ----------- fin  registro  de eventos ----------//
		}
		else{
			conexionFailure(resp)
		}
        recargarPagina();
	};var eliminarSucess=this.eliminarSucess;
	
	this.btnUnirNodos=function(o,x){
		var sw=false;
		var confirmar;
			jointNodos=x;
			clearSelection();
			btnToggle=o;	
	};var btnUnirNodos=this.btnUnirNodos;
	
	//////////////////////////////////////////////////////////
	//FUNCION PARA GRAVAR LOS DATOS MODIFICADOS DEL DIAGRAMA//
	//////////////////////////////////////////////////////////
	this.ConfirmSave=function(){
		///////////MODIFICAR ESTA FUNCIÓN.
		//var filas=ds.getModifiedRecords();
		tipoGrafo="nodo";
		alternarComponentes();
		if(idNodoEditado.length>0){//cant de regis modif > 0?
			postData = "cantidad_ids="+idNodoEditado.length;
			//if(confirm("Esta seguro de guardar los cambios?"))
			//{
				//postData, para el envio de datos a la capa de control
				postData += armarPostData();
				Ext.Ajax.request({
					url:Funcion_ConfirmSave.urlNodo,
					params:postData,
					method:'POST',
					success:Funcion_ConfirmSave.success,
					failure:Funcion_ConfirmSave.failure,
					argument:Funcion_ConfirmSave.argument,
					timeout:Funcion_ConfirmSave.timeout//TIEMPO DE ESPERA PARA DAR FALLO
				});
			//}
		}
	};var ConfirmSave=this.ConfirmSave;

	///////////////////////////////////////////////////////////////
	// Función de arma el contenido del postData de varios nodos //
	///////////////////////////////////////////////////////////////
	this.armarPostData=function(){
		
		var postData;
		var i=0;
		var indexNodo
		for(i=0;i<idNodoEditado.length;i++){
			indexNodo = getIndex(idNodoEditado[i]);
			var record=gNodo[indexNodo].properties.data;
			record.posx = gNodo[indexNodo].wrapper.attrs.cx;
			record.posy = gNodo[indexNodo].wrapper.attrs.cy;
			for(var j=0;j<cantidadAtributos;j++){
				parametrosDatos[j].save_as=parametrosDatos[j].save_as?parametrosDatos[j].save_as:parametrosDatos[j].validacion.name;
				//if(parametrosDatos[j].validacion.tipoGrafo =="nodo"){
					if(parametrosDatos[j].tipo!='DateField'&&parametrosDatos[j].form!=false){
						if(parametrosDatos[j].tipo=='epField'){
							postData=postData+"&txt_id_financiador_"+i+"="+record['id_financiador']+"&txt_id_regional_"+i+"="+record['id_regional']+"&txt_id_programa_"+i+"="+record['id_programa']+"&txt_id_proyecto_"+i+"="+record['id_proyecto']+"&txt_id_actividad_"+i+"="+record['id_actividad']
						}
						else{
							postData=postData+"&"+parametrosDatos[j].save_as+"_"+i+"="+record[parametrosDatos[j].validacion.name]
						}
					}
					else{
						if(record[parametrosDatos[j].validacion.name]!=""&&parametrosDatos[j].form!=false){
							postData=postData+"&"+parametrosDatos[j].save_as+"_"+i+"="+record[parametrosDatos[j].validacion.name].dateFormat(parametrosDatos[j].dateFormat)
						}
						else{
							postData=postData+"&"+parametrosDatos[j].save_as+"_"+i+"="+record[parametrosDatos[j].validacion.name]
						}
					}
				//}
			}
		}

		var parametrosFiltro="";
		for(var i=0;i<configuracion.CantFiltros;i++){
			parametrosFiltro=parametrosFiltro+"&filterCol_"+i+"="+ds.lastOptions.params["filterCol_"+i];
			parametrosFiltro=parametrosFiltro+"&filterValue_"+i+"="+ds.lastOptions.params["filterValue_"+i]
		}
		postData=postData+parametrosFiltro+Funcion_ConfirmSave.parametros; //parametros extra
		for(j=0;j<Funcion_ConfirmSave.parametros_ds.length;j++){
			var aux=Funcion_ConfirmSave.parametros_ds[j];
			postData=postData+"&"+aux+"="+ds.lastOptions.params[aux]
		}//Envio de los datos a la capa de control para su posterior almacenamiento
		return postData;
	};var armarPostData=this.armarPostData;
	
	
	//////////////////////////////////////
	// SAVE								//
	//GUARDA EL LOS DATOS DEL FORMULARIO//
	/////////////////////////////////////
	this.Save=function(){
		if(Funcion_Save.validar()){
			var postData = "cantidad_ids=1";
			var cont = idNodoEditado.length+1;
			var iAux = 0;
			var auxUrl; //variable auxiliar para almacena la url 1(nodo) o url 2(arista)
			if(tipoGrafo == "nodo"){
				auxUrl = Formulario1.urlNodo;
				if(idNodoEditado.length>0){
					postData = "cantidad_ids="+(cont);
					postData += armarPostData();
					iAux = cont-1;
				}
			}
			else{
				auxUrl = Formulario1.urlArista;
				ConfirmSave();
			}
			
			postData = postData + Funcion_Save.parametros;
			var cantidadAtributos = parametrosDatos.length;
			var postCadena = Formulario1.getValues;
			for(var i = 0 ; i <  cantidadAtributos; i ++){
				parametrosDatos[i].save_as=parametrosDatos[i].save_as?parametrosDatos[i].save_as:parametrosDatos[i].validacion.name;
				if(parametrosDatos[i].save_as && parametrosDatos[i].form!=false){
					if(parametrosDatos[i].tipo=='DateField'&&parametrosDatos[i].form!=false){
						hora=vectorDatos[i].getValue();
						if(hora != ""){//preguntamos si existe el objeto de fecha
							postData= postData+"&"+parametrosDatos[i].save_as+"_"+iAux+"="+ hora.dateFormat(parametrosDatos[i].dateFormat)
						}
						else{
							postData= postData+"&"+parametrosDatos[i].save_as+"_"+iAux+"="+hora
						}
					}
					else{
						if(parametrosDatos[i].tipo=='epField'){
							var p=vectorDatos[i].getValue();
							postData=postData+"&txt_id_financiador_0="+p['id_financiador']+"&txt_id_regional_0="+p['id_regional']+"&txt_id_programa_0="+p['id_programa']+"&txt_id_proyecto_0="+p['id_proyecto']+"&txt_id_actividad_0="+p['id_actividad']
						}
						else{

							postData= postData+"&"+parametrosDatos[i].save_as+"_"+iAux+"="+vectorDatos[i].getValue()
						}
					}
				}
			}

			//loading
			Ext.MessageBox.show({
				title: 'Espere Por Favor...',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
				width:150,
				height:200,
				closable:false
			});

			
			if(Formulario1.fileUpload==true){
				Ext.Ajax.request({
					form:'formulario_'+param_Formulario1.html_apply,
					url:auxUrl,
					params: postData,
					isUpload:Formulario1.fileUpload,
					//isUpload:false,
					method:Formulario1.method,
					success:Formulario1.success,
					argument:Funcion_Save.argument,
					failure:Formulario1.failure,
					timeout:Funcion_Save.timeout//TIEMPO DE ESPERA PARA DAR FALLO
				})
			}
			else{
				Ext.Ajax.request({
					url:auxUrl,
					params: postData,
					isUpload:Formulario1.fileUpload,
					method:Formulario1.method,
					success:Formulario1.success,
					argument:Funcion_Save.argument,
					failure:Formulario1.failure,
					timeout:Funcion_Save.timeout//TIEMPO DE ESPERA PARA DAR FALLO
				})
			}
		}
	};var Save = this.Save;

	//Funcion que se llama cuando se elige la opcion "guargar + nuevo" el el formulario
	this.SaveAndOther=function(){
		GuardarOtro = true;
		param_Formulario1.guardar()
	};var SaveAndOther=this.SaveAndOther;
	//Funcion que se invoca cuando el envio de datos es satisfactorio

	//////////////////////////////////////////////////////////////////////////
	//---------------    SAVE	SUCCESS    - ------------------------------ //
	//   GUARDA  LOS DATOS DEL FORMULARIO                                   //
	//////////////////////////////////////////////////////////////////////////
	//this.saveSuccess  = function(resp)
	this.saveSuccess=function(resp){
		Ext.MessageBox.hide();
		dlgInfo1.buttons[1].hide(); //apaga el boton de guardar nuevo
		if(resp.responseXML&&resp.responseXML.documentElement){
			var root = resp.responseXML.documentElement;
			if(!resp.argument.multi){
				if(GuardarOtro){
					parametros_barra_menu.nuevo.sobrecarga();
					GuardarOtro=false
				}else{
					param_Formulario1.ocultar()
				}
			}
			var tc=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
			if(tipoGrafo=="nodo")
			{
				Ext.mensajes.msg('Grabación exitosa', 'Se tienen "{0}" nodos.',tc);
			}
			if(tipoGrafo=="arista")
			{
				Ext.mensajes.msg('Grabación exitosa', 'Se tienen "{0}" aristas.',tc);
			}
			// ----------- registro  de eventos ----------//
			var origen=undefined;
			if(root.getElementsByTagName('origen')[0]!= undefined){
				origen=root.getElementsByTagName('origen')[0].firstChild.nodeValue
			}
			parametros_mensaje={
				origen:origen,
				mensaje:root.getElementsByTagName('mensaje')[0].firstChild.nodeValue,
				tiempo_resp: root.getElementsByTagName('tiempo_resp')[0].firstChild.nodeValue,
				TotalCount:root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue
			}
			// ----------- fin  registro  de eventos ----------//
		}
		else{
			conexionFailure(resp)
		}
        recargarPagina();
	};saveSuccess=this.saveSuccess;
	////////////////////////////////////////////////////////////////////////////////////////////
	//        ----------------      FUNCION CONEXIONFAILURE            ---------------------- //
	////////////////////////////////////////////////////////////////////////////////////////////

	function conexionFailure(resp1,resp2,resp3,resp4){
		ContenedorPrincipal.conexionFailure(resp1,resp2,resp3,resp4)
	};this.conexionFailure=conexionFailure;

	//////////////////////////////////////////////////////////////////////////
	//---------------      FUNCION INIT BARRA MENU--------------------------//
	//////////////////////////////////////////////////////////////////////////
	this.InitBarraMenu=function(param){
		parametros_barra_menu=param;
		this.barra=Boton;
		this.barra("ctree-"+idContenedor,idContenedor);
		//Barra de menus
		if(param.guardar){
			if(!param.guardar.sobrecarga){
				param.guardar.sobrecarga=this.ConfirmSave
			}
			this.AdicionarBoton("../../../lib/imagenes/save.jpg",'<b>Guardar<b>',param.guardar.sobrecarga,param.guardar.separador,'guardar','')
		}
		if(param.nuevo){
			//alert("en la barra  de menu" +this.btnNew)
			if(!param.nuevo.sobrecarga){
				param.nuevo.sobrecarga=this.btnNew
			}
			this.AdicionarBoton("../../../lib/imagenes/nuevo.png",'<b>Nuevo<b>',param.nuevo.sobrecarga,param.nuevo.separador,'nuevo','')
		}
		if(param.editar){
			if(!param.editar.sobrecarga){
				param.editar.sobrecarga=this.btnEdit
			}
			this.AdicionarBoton("../../../lib/imagenes/editar.png",'<b>Editar<b>',param.editar.sobrecarga,param.editar.separador,'editar','')
		}
		if(param.eliminar){
			if(!param.eliminar.sobrecarga){
				param.eliminar.sobrecarga = this.btnEliminar
			}
			this.AdicionarBoton("../../../lib/imagenes/eliminar.png",'<b>Eliminar<b>',param.eliminar.sobrecarga,param.eliminar.separador,'eliminar','')
		}
		if(param.actualizar){
			if(!param.actualizar.sobrecarga){
				param.actualizar.sobrecarga=this.btnActualizar
			}
			this.AdicionarBoton("../../../lib/imagenes/actualizar.jpg",'<b>Actualizar<b>',param.actualizar.sobrecarga,param.actualizar.separador,'actualizar','')
		}
		if(param.unirNodos){
			if(!param.unirNodos.sobrecarga){
				param.unirNodos.sobrecarga=this.btnUnirNodos
			}
			//this.AdicionarToggleBoton("../../../lib/imagenes/actualizar.jpg",'<b>Actualizar<b>',param.unirNodo.sobrecarga,param.unirNodo.separador,'actualizar','')
			this.AdicionarToggleBoton({
				icon:"../../../lib/imagenes/disconnect.png",
				cls:'x-btn-text-icon bmenu',
				tooltip:'<b>Unir Nodos<b>',
				toggleHandler:param.unirNodos.sobrecarga,
				nombre:'unirnodos',
				text:'Unir Nodos'
			})
		}
		//JGL
		if(param.excel){
			if(!param.excel.sobrecarga){
				param.excel.sobrecarga=this.btnExcel
			}
			this.AdicionarBoton("../../../lib/imagenes/excel_16x16.gif",'<b>Reporte Excel<b>',param.excel.sobrecarga,param.excel.separador,'Reporte Excel','')
		}
		//FIN JGL
	};
	/////////////////////////////////////////////////////////////////////////////////////
	//--- Definicion de los parametros por defectos para las fucniones ---------------//
	////////////////////////////////////////////////////////////////////////////////////
	//aqui se pueden  colocar parametros constantes
	
	var Funcion_btnEliminar={
		success:this.eliminarSucess, //funcion que se ejecuta cuando se tiene exito la conexion
		//argument: {multi: true},//arcumentos que se pasan a la funcion de succes
		failure:this.conexionFailure,//funcion que se ejecuta al fallar la conexion
		timeout:configuracion.TiempoEspera,//tiempo de espera para dar dallo
		urlNodo:"../../control/",
		urlArista:"../../control/",//sino tiene sobrecarga
		parametros:'',
		parametros_ds:[],//parametros variables que tomaran su valos del ds.lastoption
		mensaje: "Está¡ seguro de eliminar el registro?"
	};
	var Funcion_Save={
		success:this.saveSuccess,
		argument:{multi: false},
		failure:this.conexionFailure,
		timeout:configuracion.TiempoEspera,
		urlNodo:"../../control/",
		urlArista:"../../control/",
	    parametros:'',
		parametros_ds:[],
		validar:ValidarCampos
	};
	var Funcion_ConfirmSave={
		success:  this.saveSuccess, //funcion que se ejecuta cuando se tiene exito la conexion (la funcion generaliza de la clase madre)
	    parametros:'',
		argument: {multi: true},//arcumentos que se pasan a la funcion de succes
		failure:  this.conexionFailure,//funcion que se ejecuta al fallar la conexion
		timeout: configuracion.TiempoEspera,//tiempo de espera para dar dallo (sobrecargado)
		urlNodo:"../../control/", //si no tiene sobrecarga se especidica cual es la direccion del Action en la capa de control
		urlArista:"../../control/",
		parametros_ds:[]
	};
	//alert("save and " + this.SaveAndOther);
	
	var Funcion_btnUnirNodos={
		success:this.unirNodosSucess,
		argument:{multi: false},
		failure:this.conexionFailure,
		timeout:configuracion.TiempoEspera,
		url:"../../control/",
	    parametros:'',
		parametros_ds:[],
		validar:ValidarCampos
	};

	// -------------------- DEFINICION DE FUNCIONES --------------------//
	this.InitFunciones=function(param){
		if(param.btnEliminar){
			if(param.btnEliminar.urlNodo){Funcion_btnEliminar.urlNodo=param.btnEliminar.urlNodo}
			if(param.btnEliminar.urlArista){Funcion_btnEliminar.urlArista=param.btnEliminar.urlArista}
			if(param.btnEliminar.mensaje){Funcion_btnEliminar.mensaje=param.btnEliminar.mensaje}
			if(param.btnEliminar.parametros){
				var aux=new Array();
				Ext.apply(aux,Ext.urlDecode(decodeURIComponent(Funcion_btnEliminar.parametros.substring(1))));
				Ext.apply(aux,Ext.urlDecode(decodeURIComponent(param.btnEliminar.parametros.substring(1))));
				Funcion_btnEliminar.parametros="&"+Ext.urlEncode(aux)
			}
			if(param.btnEliminar.failure){Funcion_btnEliminar.failure=param.btnEliminar.failure}
			if(param.btnEliminar.success){Funcion_btnEliminar.success=param.btnEliminar.success}
			if(param.btnEliminar.argument){Funcion_btnEliminar.argument=param.btnEliminar.argument}
			if(param.btnEliminar.parametros_ds){Funcion_btnEliminar.parametros_ds=param.btnEliminar.parametros_ds}
		}
		if(param.Save){
			if(param.Save.urlNodo){Funcion_Save.urlNodo=param.Save.urlNodo}
			if(param.Save.urlArista){Funcion_Save.urlArista=param.Save.urlArista}
			if(param.Save.parametros){
				var aux=new Array();
				Ext.apply(aux,Ext.urlDecode(decodeURIComponent(Funcion_Save.parametros.substring(1))));
				Ext.apply(aux,Ext.urlDecode(decodeURIComponent(param.Save.parametros.substring(1))));
				Funcion_Save.parametros=Ext.urlEncode(aux);
				Funcion_Save.parametros="&"+Funcion_Save.parametros	
			}
			if(param.Save.argument){Funcion_Save.argument=param.Save.argument}
			if(param.Save.timeout){Funcion_Save.timeout=param.Save.timeout}
			if(param.Save.failure){Funcion_Save.failure=param.Save.failure}
			if(param.Save.success){Funcion_Save.success=param.Save.success}
			if(param.Save.validar){Funcion_Save.validar = param.Save.validar}
			if(param.Save.parametros_ds){Funcion_Save.parametros_ds= param.Save.parametros_ds}
		}
		if(param.ConfirmSave){
			if(param.ConfirmSave.urlNodo){Funcion_ConfirmSave.urlNodo=param.ConfirmSave.urlNodo}
			if(param.ConfirmSave.urlArista){Funcion_ConfirmSave.urlArista=param.ConfirmSave.urlArista}
			if(param.ConfirmSave.parametros){
				var aux=new Array();
				Ext.apply(aux,Ext.urlDecode(decodeURIComponent(Funcion_ConfirmSave.parametros.substring(1))));
				Ext.apply(aux,Ext.urlDecode(decodeURIComponent(param.ConfirmSave.parametros.substring(1))));
				Funcion_ConfirmSave.parametros=Ext.urlEncode(aux);
				Funcion_ConfirmSave.parametros="&"+Funcion_ConfirmSave.parametros
			}
			if(param.ConfirmSave.argument){Funcion_ConfirmSave.argument=param.ConfirmSave.argument}
			if(param.ConfirmSave.timeout){Funcion_ConfirmSave.timeout=param.ConfirmSave.timeout}
			if(param.ConfirmSave.failure){Funcion_ConfirmSave.failure=param.ConfirmSave.failure}
			if(param.ConfirmSave.success){Funcion_ConfirmSave.success=param.ConfirmSave.success}
			if(param.ConfirmSave.parametros_ds){Funcion_ConfirmSave.parametros_ds=param.ConfirmSave.parametros_ds}
		}
		if(param.Formulario1){
			Ext.apply(param_Formulario1,param.Formulario1)
		}
	};
	
	////////////////////////////////////////////////////////////
	//////// parametros de los Formularios /////////////////////
	///////////////////////////////////////////////////////////
	
	var param_Formulario1={
			titulo:'Formulario ...',
			html_apply:"dlgInfo1-"+idContenedor,
			guardar: this.Save,
			guardarOtro: this.SaveAndOther,
			cancelar: ocultarFormulario,
			ocultar: ocultarFormulario,
			mostrar: mostrarFormulario,
			modal:true,
			autoTabs:false,
			width:450,
			height:300,
			shadow:false,
			minWidth:150,
			minHeight:200,
			fixedcenter: true,
			constraintoviewport: true,
			draggable:true,
			proxyDrag: true,
			closable:true,
			upload:false,
			labelWidth:100,
			method:'post',
			columnas:['96%'],
			grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0}]
		};
	
	this.iniciaFormulario=function(){
		marcas_html="<div class='x-dlg-bd'><div id='form-ct2_"+param_Formulario1.html_apply+"'></div></div>";
		//var div_dlgInfo1=Ext.DomHelper.append('layout-'+idContenedor,{tag:'div',id:param_Formulario1.html_apply,html:marcas_html});
		var div_dlgInfo1=Ext.DomHelper.append(document.body,{tag:'div',id:param_Formulario1.html_apply,html:marcas_html});
		Formulario1 = new Ext.form.Form({
			id: 'formulario_'+param_Formulario1.html_apply,
			name:'formulario_'+param_Formulario1.html_apply,
			labelWidth: param_Formulario1.labelWidth, //label settings here cascade unless overridden
			method:param_Formulario1.method,
			method:'post',
			//waitMsgTarget: 'box-bd', //DEFINE EL TIPO DE LOADING QUE SE VERA AL CARGAR
			urlNodo:Funcion_Save.urlNodo,
			urlArista:Funcion_Save.urlArista,
			fileUpload:param_Formulario1.upload,
			success:Funcion_Save.success,
			failure:Funcion_Save.failure
		});
		dlgInfo1=new Ext.BasicDialog(div_dlgInfo1,{
			title:param_Formulario1.titulo,
			modal:param_Formulario1.modal,
			autoTabs:param_Formulario1.autoTabs,
			width:param_Formulario1.width,
			height:param_Formulario1.height,
			shadow:param_Formulario1.shadow,
			minWidth:param_Formulario1.minWidth,
			minHeight:param_Formulario1.minHeight,
			fixedcenter:param_Formulario1.fixedcenter,
			constraintoviewport:param_Formulario1.constraintoviewport,
			draggable:param_Formulario1.draggable,
			proxyDrag:param_Formulario1.proxyDrag,
			closable:param_Formulario1.closable
		});
		
		dlgInfo1.addKeyListener(27, param_Formulario1.cancelar);//tecla escape
		dlgInfo1.addButton('Guardar',param_Formulario1.guardar);
		dlgInfo1.addButton('Guardar + Nuevo',param_Formulario1.guardarOtro).hide();
		dlgInfo1.addButton('Declinar',param_Formulario1.cancelar);
		//declaracion de los parametros y varibles del formulario
		
		//se arma la estructura del formulario
		for(var i=0;i<param_Formulario1.columnas.length;i++){
			Formulario1.column({width: param_Formulario1.columnas[i],style:'margin-left:10px',clear:true});
			for(var j = 0 ; j < param_Formulario1.grupos.length;j++){
				if(param_Formulario1.grupos[j].columna==i){
					Grupos[j] = Formulario1.fieldset({legend:param_Formulario1.grupos[j].tituloGrupo});
					for(var k=0;k<cantidadAtributosEntrada;k ++){
						var id_grupo=0;
						if(parametrosDatos[k].id_grupo != undefined && parametrosDatos[k].id_grupo!=null){
							id_grupo = parametrosDatos[k].id_grupo
						}
						if(id_grupo==j){
							if(Componentes[k]){
								Formulario1.add(Componentes[k]);
								vectorDatos[k]= Componentes[k];
								vectorDatos[k].on('valid',function(){dlgInfo1.buttons[0].enable()})
							}
						}
					}
					Formulario1.end()// close the grupo
				}
			}
			Formulario1.end()// close the column
		}
		Formulario1.render("form-ct2_"+param_Formulario1.html_apply)//dibuja el formulario
	};var iniciaFormulario=this.iniciaFormulario;
	
	////////////////////////////////
	//      DEFINICION DE METODOS //
	// Lugar reservado para la definiciond emetodos //
	//////////////////////////////////////////////////
	
	this.getVectorDatos=function(){
		return vectorDatos
	};getVectorDatos=this.getVectorDatos;
	
	//-----   retorna un componete correspondiente al nombre intoroducido ----//
	this.getComponente=function(componente_name){
		var i=0;
		for(i=0;i<parametrosDatos.length;i++){
			if(parametrosDatos[i].validacion.name==componente_name){
				break;
			}
		}
		return vectorDatos[i];
	};var getComponente=this.getComponente;

	// ocultar componente
	this.ocultarComponente=function(comp){
		comp.el.up('.x-form-item').down('label').update('');
		comp.hide()
	};ocultarComponente=this.ocultarComponente;

	this.mostrarComponente=function(comp){
		comp.el.up('.x-form-item').down('label').update(comp.fieldLabel);
		comp.show()
	};mostrarComponente=this.mostrarComponente;

	//oculta todos los componentes del formulario
	this.ocultarTodosComponente=function(){
		for(var i=1;i<parametrosDatos.length;i++){
			if(parametrosDatos[i].form!=false){
				vectorDatos[i].el.up('.x-form-item').down('label').update('');
				vectorDatos[i].hide()
			}
		}
	};ocultarTodosComponente=this.ocultarTodosComponente;

	//muestra todos los componentes del formulario
	this.motrarTodosComponente=function(){
		for(var i=1;i<parametrosDatos.length;i++){
			if(parametrosDatos[i].form!=false){
				vectorDatos[i].el.up('.x-form-item').down('label').update(vectorDatos[i].fieldLabel);
				vectorDatos[i].show()
			}
		}
	};mostrarTodosComponente=this.mostrarTodosComponente;

	//mostrar grupos de datos
	this.mostrarGrupo=function(nom){
		j=0;
		tam=param_Formulario1.grupos.length;
		while(j<tam){if(Grupos[j].legend==nom){Grupos[j].show();j=tam}j++}
	};
	//ocultar grupos de datos
	this.ocultarGrupo=function(nom){
		j=0;
		tam= param_Formulario1.grupos.length;
		while(j<tam){if(Grupos[j].legend==nom){Grupos[j].hide();j=tam}j++}
	};

	//para capturar el dialogo
	this.getDialog=function(){
		return dlgInfo1
	};getDialog=this.getDialog;

	//funcion creada para limpiar los datos desde la ventana padre
	this.limpiarStore=function(){
		/////////////
		return true
	};

	this.bloquearMenu = function() {
		this.BloquearMenu();
		//paging.loading.disable();
		//bloquearOrdenamientoGrid()
	};
	this.desbloquearMenu = function() {
		this.DesbloquearMenu();
		//paging.loading.enable();
		//desbloquearOrdenamientoGrid()
	};
	
	//función para devolver el valor seleccionado
	this.getSelected = function(){
		if(nodoActual!=undefined){
			return nodoActual;
		}
		if(aristaActual!=undefined){
			return aristaActual;
		}
	};getSelected = this.getSelected;
	/*
	this.htmlMaestro=function(data){
		var  html="<table class='tabla_maestro'>";
		var j;
		for(j=0;j<data.length;j++){
			if(data[j]){
				if(j%2==0){
					if(j%4==0){
						html=html+"<tr class='gris'>";
					}
					else{
						html=html+"<tr class='blanco'>";
					}
				}
				html=html+"<td class='atributo'><pre><font face='Arial'>"+data[j][0]+":</font></pre></td><td class='valor'><pre><font face='Arial'>"+data[j][1]+"</font></pre></td>";
				if(j%2!=0){
					html=html+"</tr>";
				}
			}
		}
		if(j%2!=0){
			html=html+"<td></td><td></td></tr>";
		}
		html=html+'</table>';
		return html
	};*/

	this.Destroy=function(){
		this.grid.destroy(true,true);
		dlgInfo1.destroy(true,true);
		ContenedorLayout.getLayout().getEl().remove();
	};var Destroy=this.Destroy;

	function loadingShow(){
		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando...</div>",
			width:150,
			height:200,
			closable:false
		});
	}
}