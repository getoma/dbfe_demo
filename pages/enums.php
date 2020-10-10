<?php

require_once 'dbfe/Frontend.php';

class enums extends \dbfe\fullTablesFormPage
{
   protected function configureTableSelection()
   {
      return [ 'TournamentMode', 'labels' ];
   }

   protected function configureTables()
   {
   }
};
