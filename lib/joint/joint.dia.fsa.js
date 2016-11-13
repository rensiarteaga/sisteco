(function(global){ // BEGIN CLOSURE

var Joint = global.Joint,
     Element = Joint.dia.Element,
     point = Joint.point;

/**
* @name Joint.dia.fsa
* @namespace Holds functionality related to FSA diagrams.
*/
var fsa = Joint.dia.fsa = {};

/**
* Predefined arrow. You are free to use this arrow as the option parameter to joint method.
* @name arrow
* @memberOf Joint.dia.fsa
* @example
* var arrow = Joint.dia.fsa.arrow;
* s1.joint(s2, (arrow.label = "anEvent", arrow));
*/
fsa.arrow = {
    startArrow: {type: "none"},
    endArrow: {type: "basic", size: 5},
    attrs: {"stroke-dasharray": "none"}
};

/**
* Finite state machine state.
* @name State.create
* @methodOf Joint.dia.fsa
* @param {Object} properties
* @param {Object} properties.position Position of the State (e.g. {x: 50, y: 100}).
* @param {Number} [properties.radius] Radius of the circle of the state.
* @param {String} [properties.label] The name of the state.
* @param {Number} [properties.labelOffsetX] Offset in x-axis of the label from the state circle origin.
* @param {Number} [properties.labelOffsetY] Offset in y-axis of the label from the state circle origin.
* @param {Object} [properties.attrs] SVG attributes of the appearance of the state.
* @example
var s1 = Joint.dia.fsa.State.create({
position: {x: 120, y: 70},
label: "state 1",
radius: 40,
attrs: {
stroke: "blue",
fill: "yellow"
}
});
*/
fsa.State = Element.extend({
    object: "State",
    module: "fsa",
    init: function(properties){
// options


var p = this.properties;

//AAO 10012011
//aumentar parametro id y data
p.id = properties.id;
p.data= properties.data;
p.position = properties.position || point(0, 0);
p.radius = properties.radius || 30;
p.label = properties.label || "State";
p.labelOffsetX = properties.labelOffsetX || (p.radius / 2);
p.labelOffsetY = properties.labelOffsetY || (p.radius / 2 + 8);
p.attrs = properties.attrs || {};
if (!p.attrs.fill){
p.attrs.fill = "white";
}
// wrapper
this.setWrapper(this.paper.circle(p.position.x, p.position.y, p.radius).attr(p.attrs));
// inner
this.addInner(this.getLabelElement());
    },
    getLabelElement: function(){
var
p = this.properties,
bb = this.wrapper.getBBox(),
t = this.paper.text(bb.x, bb.y, p.label),
tbb = t.getBBox();
t.translate(bb.x - tbb.x + p.labelOffsetX,
bb.y - tbb.y + p.labelOffsetY);
return t;
    }
});

/**
 * Adicion hecha por aayviri- 03-03-2011
 * Crea un cuadro con dos líneas de información. y adición de imagenes.
 * 
*/

/**
* Organizational chart member.
* @methodOf Joint.dia.org
*/
fsa.Member = Element.extend({
    object: 'Member',
    module: 'fsa',
    init: function(properties) {
        var p = Joint.DeepSupplement(this.properties, properties, {
            attrs: { fill: 'lightgreen', stroke: '#008e09', 'stroke-width': 2 },
            id: '',
            data: '',
            name: '',
            position: '',
            nameAttrs: { 'font-weight': 'bold' },
            positionAttrs: {},
            swimlaneAttrs: { 'stroke-width': 1, stroke: 'black' },
            labelOffsetY: 10,
            radius: 10,
            shadow: true,
            avatar: '',
            padding: 5
        });
        this.setWrapper(this.paper.rect(p.rect.x, p.rect.y, p.rect.width, p.rect.height, p.radius).attr(p.attrs));
        if (p.avatar!='') {
            this.addInner(this.paper.image(p.avatar, p.rect.x + p.padding, p.rect.y + p.padding, p.rect.height - 2*p.padding, p.rect.height - 2*p.padding));
            p.labelOffsetX = p.rect.height;
        }
        //para validar si el tamaño es muy largo
        var tmax = 30;
        var auxt;
        
        if(p.name.length>tmax){
        	var xLineas = p.name.split("\n");
        	
        	p.name="";
        	for(var j=0;j<xLineas.length;j++){
	        	var xText = xLineas[j].split(" ");
	        	p.name += xText[0];
	        	auxt = xText[0].length;
	        	for(var i=1;i<xText.length;i++){
	        		if((auxt+xText[i].length)>tmax){
	        			p.name+="\n";
	        			auxt = 0;
	        		}
	        		p.name+=' '+xText[i];
	        		auxt += xText[i].length;
	        	}
	        	p.name+="\n";
        	}
        }
        //----------------------
        if (p.position) {
            var positionElement = this.getPositionElement();
            this.addInner(positionElement[0]);
            this.addInner(positionElement[1]); // swimlane
            this.addInner(positionElement[2]);
        }
    },
    getPositionElement: function() {
    	var p = this.properties;
    	//posicion del titulo: "position"
    	    var bb = this.wrapper.getBBox();
    	    var t = this.paper.text(bb.x + bb.width/2, bb.y + bb.height/2, p.position).attr(p.positionAttrs || {});
    	    var tbb = t.getBBox();
    	    
    		t.translate(bb.x - tbb.x + p.labelOffsetX, bb.y - tbb.y + tbb.height);
            
    		tbb = t.getBBox();
    		//posición de la linea
            var l = this.paper.path(['M', tbb.x, tbb.y + tbb.height + p.padding, 
                                     'L', tbb.x + tbb.width, tbb.y + tbb.height + p.padding].join(' '));
            //posicion del cuerpo: "name"
    	    var c = this.paper.text(bb.x + bb.width/2, bb.y + bb.height/2, p.name).attr(p.nameAttrs || {});
    	    var cbb = c.getBBox();
            c.translate(bb.x - cbb.x + p.labelOffsetX, bb.y - cbb.y + tbb.height*2 + p.labelOffsetY);
    	return [t, l, c];
    }
});



/**
* Finite state machine start state.
* @name StartState.create
* @methodOf Joint.dia.fsa
* @param {Object} properties
* @param {Object} properties.position Position of the start state (e.g. {x: 50, y: 100}).
* @param {Number} [properties.radius] Radius of the circle of the start state.
* @param {Object} [properties.attrs] SVG attributes of the appearance of the start state.
* @example
var s0 = Joint.dia.fsa.StartState.create({
position: {x: 120, y: 70},
radius: 15,
attrs: {
stroke: "blue",
fill: "yellow"
}
});
*/
fsa.StartState = Element.extend({
     object: "StartState",
     module: "fsa",
     init: function(properties){
// options
var p = this.properties;
p.position = properties.position || point(0, 0);
p.radius = properties.radius || 10;
p.attrs = properties.attrs || {};
if (!p.attrs.fill){
p.attrs.fill = "black";
}
// wrapper
this.setWrapper(this.paper.circle(p.position.x, p.position.y, p.radius).attr(p.attrs));
     }
});

/**
* Finite state machine end state.
* @name EndState.create
* @methodOf Joint.dia.fsa
* @param {Object} properties
* @param {Object} properties.position Position of the end state (e.g. {x: 50, y: 100}).
* @param {Number} [properties.radius] Radius of the circle of the end state.
* @param {Number} [properties.innerRadius] Radius of the inner circle of the end state.
* @param {Object} [properties.attrs] SVG attributes of the appearance of the end state.
* @param {Object} [properties.innerAttrs] SVG attributes of the appearance of the inner circle of the end state.
* @example
var s0 = Joint.dia.fsa.EndState.create({
position: {x: 120, y: 70},
radius: 15,
innerRadius: 8,
attrs: {
stroke: "blue",
fill: "yellow"
},
innerAttrs: {
fill: "red"
}
});
*/
fsa.EndState = Element.extend({
     object: "EndState",
     module: "fsa",
     init: function(properties){
// options
var p = this.properties;
p.position = properties.position || point(0, 0);
p.radius = properties.radius || 10;
p.innerRadius = properties.innerRadius || (p.radius / 2);
p.attrs = properties.attrs || {};
if (!p.attrs.fill){
p.attrs.fill = "white";
}
p.innerAttrs = properties.innerAttrs || {};
if (!p.innerAttrs.fill){
p.innerAttrs.fill = "black";
}
// wrapper
this.setWrapper(this.paper.circle(p.position.x, p.position.y, p.radius).attr(p.attrs));
// inner
this.addInner(this.paper.circle(p.position.x, p.position.y, p.innerRadius).attr(p.innerAttrs));
     },
     zoom: function(){
this.inner[0].scale.apply(this.inner[0], arguments);
     }
});

})(this); // END CLOSURE

