/*
**********************************************************
Nombre de la clase:	    PaginaArb
Prop�sito:				clse principal donde se definen  las funcionalidades
de las paginas que manejan arboles
para ENDE
Valores de Retorno:		invoca a funciones para el manejo de datos (insert, update y delete)
Fecha de Creaci�n:		10/12/07
Versi�n:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function PaginaArb(paramConfig,Atributos,ContenedorLayout,idContenedor,DatosNodo,DatosDefecto){

	var configuracion=[];
	var Grupos=[];
	var Componentes=[];
	var dlgInfo;
	var nodo={};
	var ctree;
	var loadTree;
	var sm;
	var raiz;
	var proceso;
	var ctxMenu;
	var Formulario;
	var getBoton
	
	//declaracion de funciones
	this.guardar=guardar;
	this.btnNew=btnNew;
	this.btnNewRaiz=btnNewRaiz;
	this.btnEdit=btnEdit;
	this.btnEliminar=btnEliminar;
	this.btnActualizar=btnActualizar;
	this.guardarSuccess=guardarSuccess;
	this.eliminarSuccess=eliminarSuccess;
	this.conexionFailure =conexionFailure;
	this.mostrarFormulario=mostrarFormulario;
	this.ocultarFormulario=ocultarFormulario;
	this.iniciaFormulario=iniciaFormulario;
	this.EnableSelect=EnableSelect;
	this.onBeforeMove=onBeforeMove;
	this.ctxMenu=ctxMenu;
	this.setValuesBasicos=setValuesBasicos;
	this.getFormulario=getFormulario;
	this.actualizarNodo=actualizarNodo;
	this.prepareCtx=prepareCtx;
	this.getCtxMenu=getCtxMenu;

	var layout=ContenedorLayout.getLayout();
	var hideLoading=layout.el.unmask.createDelegate(layout.el);
	//configuracion por defecto
	configuracion.TiempoEspera=paramConfig.TiempoEspera?paramConfig.TiempoEspera:120000;

	//Armamos el Formulario

	for(var i=0;i<Atributos.length;i++){

		var vA=Atributos[i].validacion;

		if(Atributos[i].form!=false){
			Componentes[i]=new Ext.form[Atributos[i].tipo](vA);
		}

		if(Atributos[i].tipo=='ComboBox' && Atributos[i].form){
			vA.store.addListener('loadexception',ContenedorPrincipal.conexionFailure)
		}

	}

	// the component tree



	//////////////////////////////////////
	//  	Funciones de inicio 		//
	//////////////////////////////////////

	this.Init=function(){
		Ext.QuickTips.init();
		Ext.form.Field.prototype.msgTarget='qtip'; //muestra mensajes de error en el formulario

		loadTree = new Ext.tree.TreeLoader({clearOnLoad:funListar.clearOnLoad,dataUrl:funListar.url,baseParams:funListar.baseParams});
		ctree = new Ext.tree.TreePanel("tree-"+idContenedor,{
			animate:true,
			loader:loadTree	,
			//enableDrag:true,
			//enableDrop:true,
			enableDD:funListar.enableDD,
			containerScroll: true,
			//lines:funListar.lines,
			rootVisible:funListar.rootVisible,

		});
		ctree.on('contextmenu',this.prepareCtx);

		///////////////////////////////////////////////////
		//---------       Creacion del Arbol  -----------//
		///////////////////////////////////////////////////



		raiz=new Ext.tree.AsyncTreeNode({
			allowDrag:funListar.allowDrag,
			allowDrop:funListar.allowDrop,
			id:funListar.id,
			text:funListar.text,
			cls:funListar.cls
		});

		// para capturar un error
		loadTree.addListener('loadexception',this.conexionFailure); //se recibe un error
		ctree.setRootNode(raiz);
		sm = ctree.getSelectionModel();
		sm.addListener('beforeselect',this.EnableSelect);		
		ctree.addListener('dblclick',function(){if(getBoton('editar-'+idContenedor)){funBasicas.edit()}});			
		ctree.addListener('beforeMove',this.onBeforeMove);
		ctree.render();
		raiz.expand();
		this.onResizePrimario=function(){
			layout.layout()
		};
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',function(){layout.layout()});
	};
	
	//se ejecuta al seleccionar un nodo
	function EnableSelect(n,n1){

		for(var i=0;i<Atributos.length;i++){

			if(Atributos[i].form!=false){
				if(Atributos[i].validacion.inputType!='file'&&Atributos[i].tipo!='ComboBox'&&Atributos[i].tipo!='epField'&&Atributos[i].tipo!='LovItemsAlm'){
					if(!n1.attributes[Atributos[i].validacion.name]){
						Componentes[i].setValue('')
					}
					else{
						Componentes[i].setValue(n1.attributes[Atributos[i].validacion.name])
					}
				}
				else{
					//para combos que se llenan remotamente
					//el store principal de proveer el id y la descripcion
					if(Atributos[i].tipo=='ComboBox'){
						if(Componentes[i].mode == 'remote'){
							if(Componentes[i].store.getById(n1.attributes[Atributos[i].validacion.name])===undefined){
								var  params = new Array();
								params[Componentes[i].valueField] = n1.attributes[Atributos[i].validacion.name];
								params[Componentes[i].displayField] = n1.attributes[Atributos[i].validacion.desc];
								var aux = new Ext.data.Record(params,n1.attributes[Atributos[i].validacion.name]);
								Componentes[i].store.add(aux)
							}
							Componentes[i].setValue(n1.attributes[Atributos[i].validacion.name])
						}
						else{
							Componentes[i].setValue(n1.attributes[Atributos[i].validacion.name])
						}
					}
				}
			}
		}
	}



	//////////////////////////////////////////////////////////////////////////
	//---------------      DRAG AND DROP          --------------------------//
	//////////////////////////////////////////////////////////////////////////


	function onBeforeMove(tree,n,oldParent,newParent){
		// : ( Tree tree, Node node, Node oldParent, Node newParent, Number index )
		//parabuscar en los padres y evitar recursividad
		var sw=true;
		var llave=true
		var  naux=newParent;
		while(naux.parentNode){
			if(naux.attributes.id==n.attributes.id){
				llave=false
			}
			naux=naux.parentNode
		}

	
		if(newParent.attributes.id!='id'&&!newParent.findChild('id',n.id)&&llave){
			var vec={};
			vec.id=n.attributes.id;
			vec.id_p=oldParent.attributes.id;
			vec.id_pn=newParent.attributes.id;
			vec.tipo=n.attributes.tipo;
			var postData='datos='+encodeURIComponent(Ext.encode(vec))+'&proc=dd';

			Ext.Ajax.request({
				url:funBasicas.url,
				params:postData,
				method:'POST',
				success:DDSuccess,
				argument:{oldParent:oldParent,nodo:n,newParent:newParent,proc:'dd'},
				failure:funBasicas.failure,
				timeout:configuracion.TiempoEspera
			});
			return true
		}
		else{
			return false
		}

	}
	function DDSuccess(resp){
		var regreso = Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='false'){
			resp.argument.newParent.removeChild(resp.argument.nodo);
			var copy = new Ext.tree.AsyncTreeNode(
			Ext.apply({allowDelete:true,expanded:true}, resp.argument.nodo.attributes)

			);
			resp.argument.oldParent.appendChild(copy)
		}
		else{
			resp.argument.nodo.attributes.id_p=resp.argument.newParent.attributes.id

		}
	}



	//////////////////////////////////////////////////////////////////////////
	//---------------      FUNCIONES BASICAS      --------------------------//
	//////////////////////////////////////////////////////////////////////////




	function guardar(){
		if(funBasicas.validar()){
			for(var i=0;i<Atributos.length;i++){
				if(Atributos[i].form!=false){
					var save_as=Atributos[i].save_as?Atributos[i].save_as:Atributos[i].validacion.name;
					nodo[save_as]=Componentes[i].getValue()
				}
			}
		
			Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
					width:150,
					height:200,
					closable:false
				});
				
			var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc='+proceso;
			Ext.Ajax.request({
				url:funBasicas.url,
				params: postData,
				method:'POST',
				success:funBasicas.add_success,
				argument:{proc:proceso,nodo:sm.getSelectedNode()},
				failure:funBasicas.failure,
				timeout:configuracion.TiempoEspera
			});
		}

	}

	function guardarSuccess(resp){
		Ext.MessageBox.hide();
		if(resp.argument.proc=='add'){
			regreso = Ext.util.JSON.decode(resp.responseText);
			nodo.id=regreso.id;
			//carga datos por defecto segun el tipo de nodo
			//var aux = DatosDefecto[nodo.tipo]
			
			/*nodo.icon=aux.icon;
			nodo.allowDelete=aux.allowDelete?aux.allowDelete:true;
			nodo.allowEdit=aux.allowEdit?aux.allowEdit:true;
			nodo.allowDrag=aux.allowDrag?aux.allowDrag:true;
			nodo.allowDrop=aux.allowDrop?aux.allowDrop:true;*/
			///////////////////////////////////

			//setea los nuevos atributos al nuevo nodo
			nodo.attributes={};
			for(var i=0;i<Atributos.length;i++){

				if(Atributos[i].form!=false){
					nodo.attributes[Atributos[i].validacion.name]=Componentes[i].getValue()
				}
			}
			Ext.apply(nodo,DatosDefecto[nodo.tipo]);
			
			if(nodo.text!=undefined){
				nodo.text=Componentes[nodo.text].getValue()
			}

			var nodo_aux = new Ext.tree.AsyncTreeNode(nodo);
			if(nodo.tipo!=funListar.raiz){
				sm.getSelectedNode().appendChild(nodo_aux)
				}
				else {
					raiz.appendChild(nodo_aux);
				}
		}
		else{
			if(resp.argument.proc=='upd'){  // suponemos que es el proceso de modificar
				var n=sm.getSelectedNode();				
				var aux = DatosDefecto[nodo.tipo];
				if(Componentes[aux.text]){
					n.setText(Componentes[aux.text].getValue())
				}
				//setea los nuevos atributos al nuevo nodo
				for(var i=0;i<Atributos.length;i++){

					if(Atributos[i].form!=false){
						n.attributes[Atributos[i].validacion.name]=Componentes[i].getValue()
					}
				}
			}
		}
		nodo={};//reseta el valor del nodo
		//ocultamos ventana
		funFormulario.ocultar();
		sm.clearSelections()
	}




	////////////////////////////para eliminar

	function btnEliminar(){
		proceso='del';
		var n = sm.getSelectedNode();
		if(n && n.attributes.allowDelete){
			if(confirm("Realmente desea eliminar el nodo")){
				var eliminados={};
				for(var i=0;i<DatosNodo.length;i++){
					eliminados[DatosNodo[i]]=n.attributes[DatosNodo[i]]
				}
				layout.el.mask('Mandando los datos el servidor...', 'x-mask-loading');
				var postData='datos='+encodeURIComponent(Ext.encode(eliminados))+'&proc=del';
				if(funBasicas.params){
					postData=postData+"&"+funBasicas.params
				}
				Ext.Ajax.request({
					url:funBasicas.url,
					params: postData,
					method:'POST',
					success:funBasicas.del_success,
					argument:{proc:'del',nodo:n},
					failure:funBasicas.failure,
					timeout:configuracion.TiempoEspera
				});
			}
		}
		else{
			alert("Este nodo no puede eliminarse")
		}
	}

	function eliminarSuccess(resp){
		hideLoading();
		ctree.getSelectionModel().selectPrevious();
		resp.argument.nodo.parentNode.removeChild(resp.argument.nodo)
	}


	function setValuesBasicos(n,proc){
		nodo={};
		Ext.apply(nodo,n);
		proceso=proc
	}
	function getFormulario(){
		return Formulario;
	}

	//////////////Para adicionar un nodo raiz

	function btnNewRaiz(){
		proceso='add';
		nodo={};
		nodo.id='null';
		nodo.id_p='null';
		nodo.tipo=funListar.raiz;
		Formulario.reset();
		funFormulario.mostrar()
	}
	//////////////////////////////////////

	function btnNew(){
		proceso='add';
		nodo={};
		var n = sm.getSelectedNode();
		if(n&&!n.attributes.leaf){
			nodo['id']='null';
			nodo['id_p']=n.attributes.id;
			nodo['tipo']='rama';
			Formulario.reset();
			funFormulario.mostrar()
		}
		else{
			alert("Seleccione un Nodo primero del tipo rama")
		}
	}


	function btnEdit(params){
		var n = sm.getSelectedNode();
		if(n && n.attributes.allowEdit){
			proceso='upd';
			nodo={};
			
			if(n){
				for(var i=0;i<DatosNodo.length;i++){
					nodo[DatosNodo[i]]=n.attributes[DatosNodo[i]]
				}
				funFormulario.mostrar()
			}
			if(params){
				Ext.apply(nodo,params)
			}
		}
		else{
			alert("Seleccione un nodo editable")
		}
	}

	function btnActualizar(){
		raiz.reload()
	}

	function conexionFailure(resp,resp2,resp3){
		if(resp.argument){
			if(resp.argument.oldParent){
				resp.argument.oldParent.reload()
			}
			if(resp.argument.nodo){
				resp.argument.nodo.parentNode.reload()
			}
			if(resp.argument.newParent){
				resp.argument.newParent.reload()
			}
		}		
		hideLoading();
		ContenedorPrincipal.conexionFailure(resp,resp2,resp3)
	}


	//////////////////////////////////////////////////////////////
	//---------      FUNCIONES FORMULARIO            -----------//
	//////////////////////////////////////////////////////////////
	function mostrarFormulario(){
		dlgInfo.show();
		Ext.form.Field.prototype.msgTarget='under'; /*muestra mensajes de error*/
		limpiarInvalidos()
	}

	function ocultarFormulario(){
		dlgInfo.hide();
		sm.clearSelections();
		Ext.form.Field.prototype.msgTarget='qtip'
	}

	function iniciaFormulario(){
		marcas_html="<div class='x-dlg-bd'><div id='form-ct2_"+funFormulario.html_apply+"'></div></div>";
		//var div_dlgInfo=Ext.DomHelper.append('layout-'+idContenedor,{tag:'div',id:funFormulario.html_apply,html:marcas_html});
		var div_dlgInfo=Ext.DomHelper.append(document.body,{tag:'div',id:funFormulario.html_apply,html:marcas_html});
		Formulario = new Ext.form.Form({
			id: 'formulario_'+funFormulario.html_apply,
			name:'formulario_'+funFormulario.html_apply,
			//labelAlign: 'top',
			labelWidth: funFormulario.labelWidth, // label settings here cascade unless overridden
			method:"POST",
			url:funBasicas.url,
			fileUpload:funFormulario.upload,
			success:funBasicas.success,
			failure:funBasicas.failure
		});
		dlgInfo=new Ext.BasicDialog(div_dlgInfo,{
			title:funFormulario.titulo,
			modal:funFormulario.modal,
			autoTabs:funFormulario.autoTabs,
			width:funFormulario.width,
			height:funFormulario.height,
			shadow:funFormulario.shadow,
			minWidth:funFormulario.minWidth,
			minHeight:funFormulario.minHeight,
			fixedcenter:funFormulario.fixedcenter,
			constraintoviewport:funFormulario.constraintoviewport,
			draggable:funFormulario.draggable,
			proxyDrag:funFormulario.proxyDrag,
			closable:funFormulario.closable
		});

		dlgInfo.addKeyListener(27, funFormulario.cancelar);//tecla escape
		dlgInfo.addButton('Guardar',funFormulario.guardar);
		dlgInfo.addButton('Declinar',funFormulario.cancelar);
		//declaracion de los parametros y varibles del formulario
		//se arma la estructura del formulario

		for(var i=0;i<funFormulario.columnas.length;i++){
			Formulario.column({width: funFormulario.columnas[i],style:'margin-left:10px',clear:true});
			for(var j = 0 ; j < funFormulario.grupos.length;j++){
				if(funFormulario.grupos[j].columna == i){
					Grupos[j] = Formulario.fieldset({legend:funFormulario.grupos[j].tituloGrupo});
					for(var k=0;k<Atributos.length;k ++){
						var id_grupo=0;
						if( Atributos[k].id_grupo != undefined && Atributos[k].id_grupo != null){
							id_grupo =  Atributos[k].id_grupo
						}
						if(id_grupo==j){
							if(Componentes[k]){
								Formulario.add(Componentes[k])


								//Componentes[k].on('valid',function(){dlgInfo.buttons[0].enable()})
							}

						}
					}
					Formulario.end()// close the grupo
				}
			}
			Formulario.end()// close the column
		}
		Formulario.render("form-ct2_"+funFormulario.html_apply)//dibuja el formulario

	}


	this.getFormulario=function(){
		return Formulario
	};var getFormulario=this.getFormulario;

	this.renderFormulario=function(){
		Formulario.render("form-ct2_"+funFormulario.html_apply)/*dibuja el formulario*/
	};var renderFormulario=this.renderFormulario;
	
	
	this.reload=function(params){	
		alert("Necesita sobrecargar la funcion reload reload")	
	}


	///validacion de campos //
	this.ValidarCampos=function(){
		return Formulario.isValid()
	};var ValidarCampos=this.ValidarCampos;

	//limpiar invalidos
	this.limpiarInvalidos=function(){
		return Formulario.clearInvalid()
	};var limpiarInvalidos=this.limpiarInvalidos;

	this.Destroy=function(){
		delete paramConfig;
		delete Atributos;
		delete ContenedorLayout;
		delete idContenedor;
		delete DatosNodo;
		delete DatosDefecto;
		ContenedorLayout.getLayout().getEl().remove()
		for(var i=0;i<=Componentes.length;i++){
			if(Componentes[i]){
				Componentes[i].destroy(true)
			}
		}
		Componentes=undefined;
		dlgInfo.destroy(true,true);
		ctree.getEl().remove();
		ctree.purgeListeners();
		delete this
	};

	this.getTreePanel = function(){
		return ctree
	};
	this.getTreeRaiz = function(){
		return raiz
	};

	this.getLoader = function(){
		return loadTree
	};
	//--  manejo de componentes en el formulario --//

	this.getComponente=function(componente_name){
		var i=0;
		for(i=0;i<Atributos.length;i++){
			if(Atributos[i].validacion.name===componente_name){
				break
			}
		}
		return Componentes[i]
	};

	// ocultar componente
	this.ocultarComponente=function(comp){
		comp.el.up('.x-form-item').down('label').update('');
		comp.hide()
	};

	this.mostrarComponente=function(comp){
		comp.el.up('.x-form-item').down('label').update(comp.fieldLabel);
		comp.show()
	};

	//oculta todos los componentes del formulario
	this.ocultarTodosComponente=function(){
		for(var i=1;i<Atributos.length;i++){
			Componentes[i].el.up('.x-form-item').down('label').update('');
			Componentes[i].hide()
		}
	};ocultarTodosComponente=this.ocultarTodosComponente;

	//muestra todos los componentes del formulario
	this.motrarTodosComponente=function(){
		for(var i=1;i<Atributos.length;i++){
			Componentes[i].el.up('.x-form-item').down('label').update(Componentes[i].fieldLabel);
			Componentes[i].show()
		}
	};

	//mostrar grupos de datos
	this.mostrarGrupo=function(nom){
		j=0;
		tam=funFormulario.grupos.length;
		while(j<tam){if(Grupos[j].legend==nom){Grupos[j].show();j=tam}j++}
	};
	//ocultar grupos de datos
	this.ocultarGrupo=function(nom){
		j=0;
		tam= funFormulario.grupos.length;
		while(j<tam){if(Grupos[j].legend==nom){Grupos[j].hide();j=tam}j++}
	};

	//para capturar el dialogo
	this.getDialog=function(){
		return dlgInfo
	};

	this.getSm=function(){
		return sm
	};

	this.ctxMenu=function(){
		return ctxMenu
	};



	///menu contextual
	// context menus

	ctxMenu = new Ext.menu.Menu({
		id:'copyCtx',
		items: [{
			id:'expand',
			handler:expandAll,
			cls:'expand-all',
			text:'Expandir todos'
		},{
			id:'collapse',
			handler:collapseAll,
			cls:'collapse-all',
			text:'Colapsar todos'
		},{
			id:'reload',
			handler:this.actualizarNodo,
			icon:'../../../lib/imagenes/act.png',
			text:'Actualizar nodo'

		},'-',{
			id:'remove',
			handler:this.btnEliminar,
			cls:'remove-mi',
			text: 'Remover elemento'
		}]
	});

	function prepareCtx(node, e){
		node.select();
		ctxMenu.items.get('remove')[node.attributes.allowDelete ? 'enable' : 'disable']();
		ctxMenu.items.get('reload')[!node.leaf ? 'enable' : 'disable']();
		ctxMenu.showAt(e.getXY());
	}


	function actualizarNodo(){
		ctxMenu.hide();
		setTimeout(function(){
			var n = sm.getSelectedNode();
			if(!n.leaf){n.reload()}
		}, 10);
	}

	function collapseAll(){
		//var n = sm.getSelectedNode();
		ctxMenu.hide();
		setTimeout(function(){
			raiz.eachChild(function(n){
				n.collapse(false, false);
			});
		}, 10);
	}

	function expandAll(){
		var n = sm.getSelectedNode();
		ctxMenu.hide();
		setTimeout(function(){
			//raiz.eachChild(function(n){
				
				//n.expand(false, false);
				n.expand(true)
			//});
		}, 10);
	}
	
	function getCtxMenu(){
		return ctxMenu;
	}







	//////////////////////////////////////////////////////////////////////////
	//---------------      FUNCION INIT BARRA MENU--------------------------//
	//////////////////////////////////////////////////////////////////////////

	this.InitBarraMenu=function(param){
		parametros_barra_menu=param;
		var rImagen='../../../lib/imagenes/';
		this.barra=Boton;
		this.barra("ctree-"+idContenedor,idContenedor);

		//this.barra("btree-"+idContenedor,idContenedor);


		if(param.nuevoRaiz){
			//alert("en la barra  de menu" +this.btnNew)
			if(!param.nuevoRaiz.sobrecarga){
				param.nuevoRaiz.sobrecarga=this.btnNewRaiz
			}
			this.AdicionarBoton(rImagen+param.nuevoRaiz.img,'<b>'+param.nuevoRaiz.tip+'<b>',param.nuevoRaiz.sobrecarga,param.nuevoRaiz.separador,'nuevor','')
		}
		if(param.nuevo){
			//alert("en la barra  de menu" +this.btnNew)
			if(!param.nuevo.sobrecarga){
				param.nuevo.sobrecarga=this.btnNew
			}
			this.AdicionarBoton(rImagen+param.nuevo.img,'<b>'+param.nuevo.tip+'<b>',param.nuevo.sobrecarga,param.nuevo.separador,'nuevo','')
		}
		if(param.eliminar){
			if(!param.eliminar.sobrecarga){
				param.eliminar.sobrecarga = this.btnEliminar
			}
			this.AdicionarBoton(rImagen+param.eliminar.img,'<b>'+param.eliminar.tip+'<b>',param.eliminar.sobrecarga,param.eliminar.separador,'eliminar','')
		}
		if(param.editar){
			//alert("en la barra  de menu" +this.btnNew)
			if(!param.editar.sobrecarga){
				param.editar.sobrecarga=funBasicas.edit
			}
			this.AdicionarBoton(rImagen+param.editar.img,'<b>'+param.editar.tip+'<b>',param.editar.sobrecarga,param.editar.separador,'editar','')
		}

		if(param.actualizar){
			if(!param.actualizar.sobrecarga){
				param.actualizar.sobrecarga=this.btnActualizar
			}
			this.AdicionarBoton(rImagen+"actualizar.jpg",'<b>Actualizar<b>',param.actualizar.sobrecarga,param.actualizar.separador,'actualizar','')
		}
		getBoton=this.getBoton			
	};
	
		
		
	
		
	



	var funFormulario={
		titulo:'Formulario ...',
		html_apply:"dlgInfo-"+idContenedor,
		guardar: this.guardar,
		cancelar:this.ocultarFormulario,
		ocultar:this.ocultarFormulario,
		mostrar:this.mostrarFormulario,
		modal:true,
		autoTabs:false,
		width:450,
		height:500,
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

	
	var funBasicas={
		url:'../',
		add_success:this.guardarSuccess,
		del_success:this.eliminarSuccess,
		params:undefined,
		validar:ValidarCampos,
		failure:this.conexionFailure,
		edit:this.btnEdit

	};

	var funListar={
		url:'../',
		raiz:'raiz',
		allowDrag:true,
		allowDrop:true,
		id:'id',
		text:'Raiz',
		cls:'croot',
		lines:false,
		rootVisible:false,
		enableDD:true,
		clearOnLoad:false
	};


	// -------------------- DEFINICION DE FUNCIONES --------------------//
	this.InitFunciones=function(param){
		var pF=param.Formulario;
		var pB=param.Basicas;
		var pL=param.Listar;

		if(pF){
			if(pF.titulo){funFormulario.titulo=pF.titulo}
			if(pF.guardar){funFormulario.guardar=pF.guardar}
			if(pF.cancelar){funFormulario.cancelar=pF.cancelar}
			if(pF.ocultar){funFormulario.ocultar=pF.ocultar}
			if(pF.mostrar){funFormulario.mostrar=pF.mostrar}
			if(pF.modal){funFormulario.modal=pF.modal}
			if(pF.autoTabs){funFormulario.autoTabs=pF.autoTabs}
			if(pF.width){funFormulario.width=pF.width}
			if(pF.height){funFormulario.height=pF.height}
			if(pF.shadow){funFormulario.shadow=pF.shadow}
			if(pF.minWidth){funFormulario.minWidth=pF.minWidth}
			if(pF.minHeight){funFormulario.minHeight=pF.minHeight}
			if(pF.fixedcenter){funFormulario.fixedcenter=pF.fixedcenter}
			if(pF.constraintoviewport){funFormulario.constraintoviewport=pF.constraintoviewport}
			if(pF.draggable){funFormulario.draggable=pF.draggable}
			if(pF.proxyDrag){funFormulario.proxyDrag=pF.proxyDrag}
			if(pF.closable){funFormulario.closable=pF.closable}
			if(pF.upload){funFormulario.upload=pF.upload}
			if(pF.method){funFormulario.method = pF.method}
			if(pF.labelWidth){funFormulario.labelWidth=pF.labelWidth}
			if(pF.columnas){funFormulario.columnas= pF.columnas}
			if(pF.grupos){funFormulario.grupos=pF.grupos}
			if(pF.html_apply){funFormulario.html_apply=pF.html_apply}


		}
		if(pB){
			if(pB.add_success){funBasicas.add_success=pB.add_success}
			if(pB.del_success){funBasicas.del_success=pB.del_success}
			if(pB.failure){funBasicas.failure=pB.failure}
			if(pB.url){funBasicas.url=pB.url}
			if(pB.edit){funBasicas.edit=pB.edit}			
		}
		if(pL){
			if(pL.url){funListar.url=pL.url}
			if(pL.allowDrag){funListar.allowDrag=pL.allowDrag}
			if(pL.allowDrop){funListar.allowDrop=pL.allowDrop}
			if(pL.id){funListar.id=pL.id}
			if(pL.text){funListar.text=pL.text}
			if(pL.cls){funListar.cls=pL.cls}
			if(pL.lines){funListar.lines=pL.lines}
			if(pL.rootVisible){funListar.rootVisible=pL.rootVisible}
			if(pL.enableDD){funListar.enableDD=pL.enableDD}
			if(pL.clearOnLoad){funListar.clearOnLoad=pL.clearOnLoad}
			if(pL.raiz){funListar.raiz=pL.raiz}
			funListar.baseParams=pL.baseParams
		}
	};

}