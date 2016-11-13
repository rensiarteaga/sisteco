/*
 * Ext JS Library 1.1.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */

/**
 * @class Ext.form.MonedaField
 * @extends Ext.form.TextField
 * Numeric text field that provides automatic keystroke filtering and numeric validation.
 * @constructor
 * Creates a new MonedaField
 * @param {Object} config Configuration options
 */
Ext.form.MonedaField = function(config){
    Ext.form.MonedaField.superclass.constructor.call(this, config);
};

Ext.extend(Ext.form.MonedaField, Ext.form.TextField,  {
    /**
     * @cfg {String} fieldClass The default CSS class for the field (defaults to "x-form-field x-form-num-field")
     */
    fieldClass: "x-form-field x-form-num-field",
    /**
     * @cfg {Boolean} allowDecimals False to disallow decimal values (defaults to true)
     */
    allowDecimals : true,
    /**
     * @cfg {String} decimalSeparator Character(s) to allow as the decimal separator (defaults to '.')
     */
    decimalSeparator : ".",
    milSeparator :false,
    milSep:",",
    /**
     * @cfg {Number} decimalPrecision The maximum precision to display after the decimal separator (defaults to 2)
     */
    decimalPrecision : 2,
     
    /**
     * @cfg {Boolean} allowNegative False to prevent entering a negative sign (defaults to true)
     */
    allowNegative : true,
    /**
     * @cfg {Number} minValue The minimum allowed value (defaults to Number.NEGATIVE_INFINITY)
     */
    minValue : Number.NEGATIVE_INFINITY,
    /**
     * @cfg {Number} maxValue The maximum allowed value (defaults to Number.MAX_VALUE)
     */
    maxValue : Number.MAX_VALUE,
    /**
     * @cfg {String} minText Error text to display if the minimum value validation fails (defaults to "The minimum value for this field is {minValue}")
     */
    minText : "The minimum value for this field is {0}",
    /**
     * @cfg {String} maxText Error text to display if the maximum value validation fails (defaults to "The maximum value for this field is {maxValue}")
     */
    maxText : "The maximum value for this field is {0}",
    /**
     * @cfg {String} nanText Error text to display if the value is not a valid number.  For example, this can happen
     * if a valid character like '.' or '-' is left in the field with no number (defaults to "{value} is not a valid number")
     */
    nanText : "{0} is not a valid number",

    // private
    //var allowed = "0123456789";
    
    initEvents : function(){
    	
        Ext.form.MonedaField.superclass.initEvents.call(this);
        var allowed = "0123456789";
        
        if(!this.allowDecimals){
        //    allowed += this.decimalSeparator;
        this.decimalPrecision=0;
        }
        if(this.allowNegative){
            allowed += "-";
        } 
   /*     if(this.allowMil){
           allowed += ",";
        this.milSeparator=true;
        } */
        if(this.allowNegative){
            allowed += "-";
        }
        this.stripCharsRe = new RegExp('[^'+allowed+'.,]', 'gi');
        
        var keyPress = function(e){
      
            var k = e.getKey();
    		//verifica que no se trate de ningun carcter especial
            if(!Ext.isIE && (e.isSpecialKey() || k == e.BACKSPACE || k == e.DELETE)){
                return;
            }
            var c = e.getCharCode();
            //si es un caracte qu eno este permitivo se detiene el evento 
            if(allowed.indexOf(String.fromCharCode(c)) === -1){e.stopEvent();}
         
 
		
		this.setValue(this.getRawValue()+String.fromCharCode(c));
		 e.stopEvent();
        };
        var render = function(c){
        	//alert("pinche render"+this.formatMoneda(this.getValue()));
    	   	
       return  this.formatMoneda(this.getValue());
    	};
        this.el.on("keypress", keyPress, this);
        this.on('render', render);
    },

    // private
    formatMoneda : function(value){
    	var allowed = "0123456789";
    	  var i=0;	
    	if(value!=''){
    	len= value.length;	
    	
    	for(i = 0; i < len; i++)if ((value.charAt(i) != '0') && (value.charAt(i) != this.decimalSeparator))break; 
		aux = '';
		//almacena el valor en la variqable aux 
		
		for(; i < len; i++)if (allowed.indexOf(value.charAt(i))!=-1)aux += value.charAt(i);	
		len=aux.length;
        auxdec='';
        
        if (len == 0)this.setValue('');
		/*Carga los decimales */
       if (len <=this.decimalPrecision  )
		{ 	count=len;
			auxdec+='0'+ this.decimalSeparator;
			while (this.decimalPrecision-count>0)
			{	auxdec+='0';	
				count++;
			}
			 return auxdec+aux;
		};	
    		
    	aux2='';
    	aux3='';
    	
    	len=aux.length;
    	//alert("longitud "+len+"valor "+aux);
    	if (len>this.decimalPrecision){
    	for (j = 0, i = len - this.decimalPrecision-1; i >= 0; i--){
				if (j == 3) {
				aux2 += this.milSep;
				j = 0;
				}
				aux2 +=aux.charAt(i);
				j++;	
				}
		//alert("valor invertido de aux 2  "+aux2);
		//alert(" volcado value "+value+" aux "+aux2);
    	len2 = aux2.length;
		
		/*invierte los enteros */
		for (i = len2 - 1; i >= 0; i--)
		aux3 +=aux2.charAt(i) ;
		//alert("  value "+value+" aux "+aux3);
		/*inserta los decimales*/
		if(this.allowDecimals){
		aux3 +=this.decimalSeparator+aux.substr(len - this.decimalPrecision, len);}
		return aux3; 
    	}
    	}
		
		else {return '';}
    }, 
    // private
    validateValue : function(value){
    	//alert("validar");
        if(!Ext.form.MonedaField.superclass.validateValue.call(this, value)){
            return false;
        }
        if(value.length < 1){ // if it's blank and textfield didn't flag it then it's valid
             return true;
        }
        var num = this.parseValue(value);
        
        if(isNaN(num)){
            this.markInvalid(String.format(this.nanText, value));
            return false;
        }
        if(num < this.minValue){
            this.markInvalid(String.format(this.minText, this.minValue));
            return false;
        }
        if(num > this.maxValue){
            this.markInvalid(String.format(this.maxText, this.maxValue));
            return false;
        }
        return true;
    },

    getValue : function(){
        return this.fixPrecision(this.parseValue(Ext.form.MonedaField.superclass.getValue.call(this)));
    },

    // private
    parseValue : function(value){
    	
        value = parseFloat(String(value).split(',').join('').replace(this.decimalSeparator, "."));
        return isNaN(value) ? '' : value;
    },

    // private
    fixPrecision : function(value){
        var nan = isNaN(value);
        if(!this.allowDecimals || this.decimalPrecision == -1 || nan || !value){
            return nan ? '' : value;
        }
        return parseFloat(value).toFixed(this.decimalPrecision);
    },

    setValue : function(v){
    	Ext.form.MonedaField.superclass.setValue.call(this,   this.formatMoneda(v));
    },

    // private
    decimalPrecisionFcn : function(v){
        return Math.floor(v);
    },

    beforeBlur : function(){
    	   	
        var v = this.parseValue(this.getRawValue());
        
        if(v){this.setValue(this.fixPrecision(v))}
    }
    
});