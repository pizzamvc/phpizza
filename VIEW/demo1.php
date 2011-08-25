<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */


class View extends CustomView{
    public function __construct() {
        // Set titles & other attributes here
        $this->title = "Demo 1";
    }
    
    public function printMainPageContent() {
        // This function must be implemented!
        // now follows html:
        ?>
                    This view was loaded without any controller <br /><br />
                    To pass an parameter and get it in the view without the help of controller 
                    use get method. <a href="demo1.html?id=hello!">Example here</a>
                    <br />
                    
        <?php
            if(isset($_REQUEST['id']))
                echo "parameter passed via get method: " . $_REQUEST['id'];
    }
}

?>