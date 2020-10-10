<?php

require_once 'dbfe/Frontend.php';

class welcome extends \dbfe\plainPage
{
   public function output()
   {
      print "<p>Welcome to the dbfe demo!</p>";
   }
}