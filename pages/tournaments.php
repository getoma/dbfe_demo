<?php

require_once 'dbfe/Frontend.php';

class tournaments extends \dbfe\tableFormPage
{   
   /**
    * return the list of tables that shall be handled in this page
    */
   protected function configureTableList()
   {
      return [ 'Tournament', 'TournamentRankings' ];
   }
   
   /**
    * perform any custom configuration of tables
    */
   protected function configureTables()
   {
      /* setup file handler for "announcement" upload. */
      $fh = new \dbfe\dbFileHandler($this->getDbh(), sprintf('%sdownload?file=%%u', $_SERVER['SCRIPT_NAME'].'/' ));
      $this->getTable()->setFilehandler('Announcement', $fh, \dbfe\DispType::link, true);
      
      /* query to retrieve all members for rankings */
      $query = new \dbfe\SelectQuery();
      $query->columns    = [ 'MemberID', 'Name' ];
      $query->table_spec = 'Member';
      $query->order      = ['Name'];
      $this->getTable('TournamentRankings')->getColumn('MemberID')->setReferenceQuery($query);
   }
   
   /**
    * configure the entry selection for this page by providing a SelectQuery
    * that returns a list of all pages + any info needed to fine-tune the presentation
    * 
    * if your table contains a single "unique" column which shall be used as page title,
    * you can skip this method (delete it or let it return null). 
    * 
    * @see \dbfe\tableFormPage::configureEntrySelection()
    * 
    * @return \dbfe\SelectQuery 
    */
   protected function configureEntrySelection()
   {  
      $sel = new \dbfe\SelectQuery();
      $sel->columns    = [ 'TournamentID', 'Name', 'year(Day)', 'Place', 'Day' ];
      $sel->table_spec = 'Tournament';
      $sel->order      = [ 'Day desc' ];
      return $sel;
   }
}
