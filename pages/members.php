<?php

require_once 'dbfe/Frontend.php';

class members extends \dbfe\tableFormPage
{   
   /**
    * return the list of tables that shall be handled in this page
    */
   protected function configureTableList()
   {
      return [ 'Member',
               'rankings' // you are free to explicitly list any "view" here to define it's position in the presentation
      ];
   }
   
   /**
    * configure tables, no special configurations needed in this basic example.
    */
   protected function configureTables()
   {
      
   }
   
   /**
    * configure the entry selection for this page by providing a SelectQuery
    * that returns a list of all pages + any info needed to fine-tune the presentation
    * 
    * @see \dbfe\tableFormPage::configureEntrySelection()
    * 
    * @return \dbfe\SelectQuery 
    */
   protected function configureEntrySelection()
   {  
      $sel = new \dbfe\SelectQuery();
      $sel->columns    = [ 'MemberID', 'Name', 'null', 'year(Birth)' ];
      $sel->table_spec = 'Member';
      $sel->order      = [ 'Name' ];
      return $sel;
   }
   
   /** 
    * get any views provided by this page (optional)
    * @return array[string => SelectQuery]
    */
   protected function configureViewList()
   {
      $ranks = new \dbfe\SelectQuery();
      $ranks->columns    = ['MemberID', 't.Name as Tournament', 'Place', 'Day as "Date"', 'rank as Ranking' ];
      $ranks->table_spec = 'TournamentRankings tr left join Tournament t using(TournamentID)' 
                         .                      ' left join Member m using(MemberID)';
      $ranks->order      = ['"date" desc'];
      
      return [ 'rankings' => $ranks ];
   }
}
