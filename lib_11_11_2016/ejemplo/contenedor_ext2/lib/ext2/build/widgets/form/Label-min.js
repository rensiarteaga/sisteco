/*
 * Ext JS Library 2.0.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.form.Label=Ext.extend(Ext.BoxComponent,{onRender:function(B,A){if(!this.el){this.el=document.createElement("label");this.el.innerHTML=this.text?Ext.util.Format.htmlEncode(this.text):(this.html||"");if(this.forId){this.el.setAttribute("htmlFor",this.forId)}}Ext.form.Label.superclass.onRender.call(this,B,A)}});Ext.reg("label",Ext.form.Label);