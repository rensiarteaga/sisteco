<?php /* Smarty version 2.5.0, created on 2003-04-23 14:03:38
         compiled from ric.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'htmlentities', 'ric.tpl', 4, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<h1 align="center"><?php echo $this->_tpl_vars['name']; ?>
</h1>
<pre>
<?php echo $this->_run_mod_handler('htmlentities', true, $this->_tpl_vars['contents']); ?>

</pre>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("footer.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>