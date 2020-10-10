<?php

require_once 'dbfe/Frontend.php';

/**
 * full table page template
 *
 * This base page class is meant for simple tables that shall be presented entirely
 * in a single page (i.e. no splitting of several entries into seperated sub pages).
 * On the other hand, you may configure a multiple tables to be displayed independently
 * via sub page selection.
 * 
 * Table referencing is not supported, only a single table may be displayed per sub page.
 *
 * @see \dbfe\tableFormPage
 */
class fullTablesFormPageTmpl extends \dbfe\fullTablesFormPage
{
   /**
    * configure the tables to be handled by this page.
    * Each page will get it's own sub page.
    * 
    * If there is only one page configured, no table selection will
    * be presented to the user, and this table will be presented directly.
    */
   protected function configureTableSelection()
   {
      return [ 'Table1', 'Table2', '...' ];
   }

   /**
    * apply custom configurations to the tables.
    *
    * @see \dbfe\tableFormPage::configureTables()
    */
   protected function configureTables()
   {
      /* attention: only one of the configured table will be loaded at a time.
       * Attempting to access any unloaded table will trigger an exception.
       * Therefore it's important to guard the configuration of each table
       * via $this->hasTable(...)
       */
      
      if( $this->hasTable('Table1') )
      {
         /* configure Table1 */         
      }
      
      if( $this->hasTable('Table2') )
      {
         /* configure Table2 */
      }
   }
};
