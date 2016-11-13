/* Strip whitespace from the beginning and end of a string  */
String.prototype.trim = function(){
    return this.replace(/^\s*|\s*$/g, "");
};



GridSearch = function(config){
	Ext.apply(this,config);
	this.ramdonID = new Date().getTime().toString();
	if (this.serverSearch){
		this.createServerSearch();
	}	
	if (this.quickSearch){
		this.createQuickSearch();
	}
};

GridSearch.prototype.createServerSearch = function(){
	//Creamos el menú Radio o check
	var menu = new Ext.menu.Menu({id: 'serverSearchMenu_' + this.ramdonID});
	for(var i=0; i<this.cm.config.length; i++){
		if (this.cm.config[i].header.trim() != ""){
		  if (this.multipleServerSearch){
	    	menu.add(
				new Ext.menu.CheckItem({
					text: this.cm.config[i].header
				}
			));
		  }else{
	    	menu.add(
				new Ext.menu.CheckItem({
					text: this.cm.config[i].header,
					group: 'serverSearchMenuRadio_' + this.ramdonID
				}
			));			
		  }
		}
    };
	var ramdonID = this.ramdonID;
	menu.on('click', function(){
  	    Ext.get('serverSearchField_' + ramdonID).dom.disabled = true;
		for (var i=0; i<menu.items.items.length; i++){
			if (menu.items.items[i].checked){
				Ext.get('serverSearchField_' + ramdonID).dom.disabled = false;
				Ext.get('serverSearchField_' + ramdonID).dom.focus();
				break;
			}
		}
	});
	//Añadimos el menú al toolbar
	this.tb.add({
    	cls: 'x-btn-icon',
        text: this.serverSearchText ? this.serverSearchText : 'Buscar en...',
        menu: menu,
        tooltip: this.serverSearchTooltip ? this.serverSearchTooltip : ''
	});
	//Creamos el combo
    this.totalBoton = this.tb.addDom({
      tag: 'input',
      id: 'serverSearchField_' + this.ramdonID,
      type: 'text',
      size: 30,
      value: ''
    });
	var ds = this.ds;
	var cm = this.cm;
	var quickSearch = this.quickSearch;
	var ramdonID = this.ramdonID
    var filterBox = new Ext.form.HistoryClearableComboBox({
	  emptyText: 'Sin filtro de búsqueda total'
	});
	filterBox.onTrigger2Click = function(){
      if (filterBox.getValue().length!=0){
		filterBox.reset();
		ds.baseParams.filterQuery = '';
		ds.load({params:{start: 0, limit: ds.lastOptions.params.limit}});
      }
    };
    filterBox.applyTo('serverSearchField_' + this.ramdonID);
	Ext.get('serverSearchField_' + this.ramdonID).dom.disabled = true;
	var quickSearch = this.quickSearch ? this.quickSearch : false;
	var fechaRe = /(((0[1-9]|[12][0-9]|3[01])([/])(0[13578]|10|12)([/])(\d{4}))|(([0][1-9]|[12][0-9]|30)([/])(0[469]|11)([/])(\d{4}))|((0[1-9]|1[0-9]|2[0-8])([/])(02)([/])(\d{4}))|((29)(\.|-|\/)(02)([/])([02468][048]00))|((29)([/])(02)([/])([13579][26]00))|((29)([/])(02)([/])([0-9][0-9][0][48]))|((29)([/])(02)([/])([0-9][0-9][2468][048]))|((29)([/])(02)([/])([0-9][0-9][13579][26])))/
    filterBox.on("change", function(e) {							
      var value = filterBox.getValue().trim();
	  if (value != ""){
	    if(quickSearch){
	      Ext.get('quickSearchField_' + ramdonID).dom.value = "Sin filtro de búsqueda parcial";
	      //Ext.get('quickSearchField_' + ramdonID).dom.disabled = true;
          ds.clearFilter();		
		}
	  var aux1=[];
	  var aux2=[];
	  var aux3=[];
	  for (var i=0; i<menu.items.items.length; i++){
		if (menu.items.items[i].checked){
			for (var j=0; j<cm.config.length; j++){
				if (cm.config[j].header == menu.items.items[i].text){
					aux1[aux1.length] = cm.config[j].dataIndex;
					aux2[aux2.length] = cm.config[j].searchType ? cm.config[j].searchType : 'text';
					aux3[aux3.length] = cm.config[j].header;
				}
			}
		}
	  }
	  var sql = [];
	  var colsAdvertencia = [];
	  for(var j=0;j<aux1.length;j++){
  	    var quote = aux2[j] == 'text' ? "\"" : '';
		var comparator = aux2[j] == 'text' ? ' CONTAINS ' : ' = '
		if (!fechaRe.test(value) && aux2[j]=='date'){
			colsAdvertencia[colsAdvertencia.length] = aux3[j]; 	
		}else{
	  		sql[sql.length] = '[' + aux1[j] + '] ' + comparator + quote + value + quote;
		}
	  }
	  if (colsAdvertencia.length != 0){
	  	Ext.MessageBox.alert('Aviso', 'No se realizará la busqueda sobre "' + colsAdvertencia.join(', ') + '". El criterio de busqueda no tiene el formato "dd/mm/aaaa" esperado.');
	  }
	  //alert(sql.join(' OR '));
      //alert(escape(sql.join(' OR ')));
	  //alert(ds.lastOptions.params.limit);
      if(value.length>0){
		 ds.baseParams.filterQuery = escape(sql.join(' OR '));
  	  }else{
		 ds.baseParams.filterQuery = ''; 
	  }
	  ds.load({params:{start: 0, limit: ds.lastOptions.params.limit}});
	  }
    });
	//Añadimos separador al final
    this.tb.addSeparator();
};

GridSearch.prototype.createQuickSearch = function() {
	//Creamos el menú Radio o check
	var menu = new Ext.menu.Menu({id: 'quickSearchMenu_' + this.ramdonID});
	for(var i=0; i<this.cm.config.length; i++){
 	    if (this.cm.config[i].header.trim() != ""){
		  if (this.multipleQuickSearch){
		    menu.add(
				new Ext.menu.CheckItem({
					text: this.cm.config[i].header
				}
			));
		  }else{
	    	menu.add(
				new Ext.menu.CheckItem({
					text: this.cm.config[i].header,
					group: 'quickSearchMenuRadio_' + this.ramdonID
				}
			));				
		  }
		}
    };
	var ramdonID = this.ramdonID;
	menu.on('click', function(){
  	    Ext.get('quickSearchField_' + ramdonID).dom.disabled = true;
		for (var i=0; i<menu.items.items.length; i++){
			if (menu.items.items[i].checked){
				Ext.get('quickSearchField_' + ramdonID).dom.disabled = false;
				Ext.get('quickSearchField_' + ramdonID).dom.focus();
				break;
			}
		}
	});
	this.tb.add({
    	cls: 'x-btn-icon',
        text: this.quickSearchText ? this.quickSearchText : 'Busqueda rápida...',
        menu: menu,
        tooltip: this.quickSearchTooltip ? this.quickSearchTooltip : ''
	});
	//Creamos el combo
    this.tb.addDom({
      tag: 'input',
      id: 'quickSearchField_' + this.ramdonID,
      type: 'text',
      size: 30,
      value: ''
    });
    this.searchBox = new Ext.form.HistoryClearableComboBox({
	  emptyText: "Sin filtro de búsqueda parcial",
      hideComboTrigger: true,
      rememberOn: 'all'
    });
    this.searchBox.applyTo('quickSearchField_' + this.ramdonID);
	Ext.get('quickSearchField_' + this.ramdonID).dom.disabled = true;
	var ds = this.ds;
	var cm = this.cm;
	this.searchBox.onTrigger2Click = function(){
          searchBox.setValue('');
  		  searchBox.setRawValue(searchBox.emptyText);
          searchBox.el.addClass(searchBox.emptyClass);
  		  searchBox.disabled = true;
          ds.clearFilter();
	};
	var searchBox = this.searchBox
	var onFilteringBeforeQuery = function(e) {
      var value = searchBox.getValue();
      if (value.length==0) {
        ds.clearFilter();
      }else{
        value = value.replace(/^\s+|\s+$/g, "");
        if (value=="") return;
		var aux1=[];
		for (var i=0; i<menu.items.items.length; i++){
			if (menu.items.items[i].checked){
				for (var j=0; j<cm.config.length; j++){
					if (cm.config[j].header == menu.items.items[i].text){
						aux1[aux1.length] = cm.config[j].dataIndex;
					}
				}
			}
		}
        ds.filterBy(function(r) {
        	valueArr = value.split(/\ +/);
            for (var i=0; i<valueArr.length; i++) {
            	re = new RegExp(Ext.escapeRe(valueArr[i]), "i");
				var aux2 = false;
				for (var j=0; j<aux1.length; j++){
					if (re.test(r.data[aux1[j]]) == false){
						aux2 = false;
					}else{
						aux2 = true;
						break;
					}
				}
				if (aux2 == false){
					return false;
				}
              }
              return true;
           });
      }
    };
    searchBox.on("change", onFilteringBeforeQuery);
	//Añadimos separador al final
    this.tb.addSeparator();
};