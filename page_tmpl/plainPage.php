<?php

require_once 'dbfe/Frontend.php';

/**
 * plain page
 * 
 * a page that does nothing (by default).
 * 
 * it can be augmented with basic functionality by overriding any 
 * interface it provides.
 * 
 * This template includes the interface you'll most commonly use to implement
 * a custom page.
 * But you are free to override any method of plainPage if needed.
 * 
 * @see \dbfe\plainPage
 *
 */
class plainPage extends \dbfe\plainPage
{   
 
   /**
    * generate the html output of this page and print it to stdout
    * {@inheritDoc}
    * @see \dbfe\plainPage::output()
    */
   public function output()
   {
      
   }
   
   /**
    * place any needed $_REQUEST[] processing in this function
    * {@inheritDoc}
    * @see \dbfe\PlainPage::input()
    */
   public function input()
   {
   }
}
