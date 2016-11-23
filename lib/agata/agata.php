+-----------------------------------------------------------------+
| AGATA                                                           |
+-----------------------------------------------------------------+
| Licensed under GPL: www.fsf.org for further details             |
|                                                                 |
| Site: http://www.pablo.blog.br/agata                            |
+-----------------------------------------------------------------+
| Abstract: A Database reporting tool written in PHP-GTK          |
|                                                                 |
| Started in  August, 10, 2001                                    |
| Author: Pablo Dall'Oglio (pablo@dalloglio.net)                  |
+-----------------------------------------------------------------+

Starting Agata Report...

<?
define('OS', strtoupper(substr(PHP_OS, 0, 3)));

if (OS == 'WIN')
{
    define("bar", '\\');
    if (is_dir('C:\\temp'))
    {
        define("temp", 'C:\\temp');
    }
    else if (is_dir('C:\\windows\\temp'))
    {
        define("temp", 'C:\\windows\\temp');
    }
    else
    {
        define("temp", 'c:\\winnt\\temp');
    }
    dl('php_gtk.dll');
    setlocale(LC_ALL, 'english');
    Gtk::rc_parse('themes/AceIce/gtk/gtkrc');
}
else
{
    define("bar", '/');
    define("temp", '/tmp');
    dl('php_gtk.so');
    setlocale(LC_ALL, 'pt_BR');
}
define("AGATA_PATH", getcwd());

include_once 'include/util.inc';
include_once 'include/define.inc';
include_once 'classes/util/Trans.class';
include_once 'classes/core/Project.class';
include_once 'classes/core/Report.class';
include_once 'classes/core/Dictionary.class';
include_once 'classes/core/Label.class';
include_once 'classes/core/Layout.class';
include_once 'classes/core/AgataError.class';
include_once 'classes/core/AgataQuery.class';
include_once 'classes/core/AgataDataSet.class';
include_once 'classes/core/AgataConnection.class';
include_once 'classes/core/AgataCompatibility.class';
include_once 'classes/core/AgataCore.class';
include_once 'classes/core/AgataConfig.class';
include_once 'classes/core/AgataInterface.class';

class App
{
    function App()
    {
        if (!@file('include/setup.inc'))
        {
            new Dialog(_a('Permission Denied'), true, true, _a('File') . ': ' . AGATA_PATH . bar . 'include' . bar . 'setup.inc');
            return false;
        }
        include 'include/setup.inc';
        $this->agataConfig = AgataConfig::ReadConfig();
        
        if ($this->agataConfig)
        {
            $aLanguages = array('en', 'pt', 'es', 'de', 'fr', 'it', 'se', 'tk');
            $aThemes = array_merge('No theme', getSimpleDirArray('themes', false));
        /*    
            if ($this->agataConfig['general']['SplashScreen'])
            {
                $this->StartWindow = &new Gtkwindow(GTK_WINDOW_POPUP);
                $this->StartWindow->set_border_width(0);
                $this->StartWindow->set_position(GTK_WIN_POS_CENTER);
                $this->StartWindow->connect_object('destroy', array('Gtk', 'Main_quit'));
                $this->StartWindow->realize();
                
                $PixStart = Gdk::pixmap_create_from_xpm($this->StartWindow->window, null, 'interface/start_new.xpm');
                $Start = new GtkPixmap($PixStart[0], $PixStart[1]);
                
                $fixed = &new GtkFixed;
                $this->StartWindow->add($fixed);
                $fixed->put($Start, 0, 0);
                
                
                $this->Languages = &new GtkCombo();
                $this->Languages->set_usize(120,40);
                $EntryA = $this->Languages->entry;
                $EntryA->set_editable(false);
                $this->Languages->set_border_width(4);
                $this->Languages->set_popdown_strings($aLanguages);
                if ($Language)
                {
                    $EntryA->set_text($Language);
                }
                $fixed->put($this->Languages, 348, 170);
                
                $this->Themes = &new GtkCombo();
                $this->Themes->set_usize(120,40);
                $EntryB = $this->Themes->entry;
                $EntryB->set_editable(false);
                $this->Themes->set_border_width(4);
                $this->Themes->set_popdown_strings($aThemes);
                if ($Theme)
                {
                    $EntryB->set_text($Theme);
                }
                $fixed->put($this->Themes, 348, 220);
                
                $button = new GtkButton('   OK   ');
                $button->connect_object('clicked', array($this, 'Start'));
                $fixed->put($button, 416, 260);
                
                $button2 = new GtkButton(' ' . _a('Close') .  ' ');
                $button2->connect_object('clicked', array(Gtk, 'main_quit'));
                $fixed->put($button2, 334, 260);
                
                $this->StartWindow->show_all();
            }
            else
            {
                $this->Start();
            }*/
	    $this->Start();
        }
    }
    
    
    function Start()
    {/*
        if ($this->agataConfig['general']['SplashScreen'])
        {
            $this->StartWindow->hide();
            $entry1 = $this->Languages->entry;
            $entry2 = $this->Themes->entry;
            $Theme = $entry2->get_text();
            $Language = $entry1->get_text();
        }
        else
        {
            include 'include/setup.inc';
        }*/
        include 'include/setup.inc';
        $agataConfig = AgataConfig::FixConfig($this->agataConfig);
        if ($agataConfig)
        {
            if (AgataConfig::WriteSetup($Theme, $Language))
            {
                Trans::SetLanguage($Language);
                Gtk::rc_parse("themes/$Theme/gtk/gtkrc");
                new AgataInterface($agataConfig);
            }
        }
    }
}

$myapp = &new App;
Gtk::main();
?>
