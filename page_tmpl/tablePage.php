<?php

require_once 'dbfe/Frontend.php';

/**
 * table page template
 * 
 * Most of your pages will use this template, i.e. be based on tableFormPage
 * 
 * tableFormPage pages will handle a single primary table and any "sub" tables that are connected to it.
 * 
 * @see \dbfe\tableFormPage
 */
class tablePage extends \dbfe\tableFormPage
{   
   /**
    * return the list of tables that shall be handled in this page
    */
   protected function configureTableList()
   {
      return [ 'primaryTable', 'connectedTable1', 'connectedTable2' ];
   }
   
   /**
    * perform any custom setups of tables, e.g.
    * - configure a file handler, via $this->getTable()->setFilehandler()
    * - configure a selection display to a referenced table, via $this->getTable()->getColumn()->setReferenceQuery()
    * - configure a hardcoded selection for a column: $this->getTable()->getColumn()->setValueSelection()
    * - configure display order of a connected table: $this->getTable()->setOrdering()
    */
   protected function configureTables()
   {
      
   }
   
   /**
    * configure the entry selection for this page by providing a SelectQuery
    * that returns a list of all Entries + any info needed to fine-tune the presentation
    * 
    * if your table contains a single "unique" column which shall be used as page title,
    * you can skip this method (delete it or let it return null).
    * 
    * The returned column needs to provide *at least* two columns. Layout:
    * [ 'primary key', 'entry title', ( 'group name', ('title_specifier', ('title_specifier', ...) ) ) ]
    * 
    * primary key: primary key column of the primary table for this page
    * page title:  title that shall be used in the link to this entry. 
    * group name:  entries can be visually grouped. Define groups by providing the group names
    *              If omitted, set to null, or the same group name on every entry is given, no grouping is done.
    * title_specifier: if there are any "page title" duplicates within a group, any additionally 'title_specifier'
    *                  columns will be added to the title in brackets, until a unique name is derived.
    * 
    * @see \dbfe\tableFormPage::configureEntrySelection()
    * 
    * @return \dbfe\SelectQuery|array
    */
   protected function configureEntrySelection()
   {
      $sel = new \dbfe\SelectQuery();
      $sel->columns    = [ 'primary_key', 'title_column', 'group_column', 'title_specifier' ];
      $sel->table_spec = 'primaryTable';
      $sel->order      = [ ];
      return $sel;
   }
   
   /** 
    * get any views provided by this page (optional)
    * @return array[string => SelectQuery]
    * 
    * @see \dbfe\tableFormPage::configureViewList()
    */
   protected function configureViewList()
   {
      return [];
   }
}
