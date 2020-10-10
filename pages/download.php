<?php

require_once 'dbfe/Frontend.php';

/**
 * example for a file download solution, for all files stored directly in the database
 * (in this demo used in page "tournaments")
 * 
 * implementing it as a (dummy) page has the advantage, that
 * 1) you have direct access to the full infrastructure set up for dbfe (e.g. db handle)
 * 2) file access is automatically put behind any login prompt or other access protection you
 *    should have implemented around the dbfe integration 
 */
class download extends \dbfe\plainPage
{
   public function printHeader()
   {
      /* fetch the file from the database (stored in parameter 'file') */
      if( isset($_REQUEST['file']) )
      {
         $stmt = $this->getDbh()->prepare( 'select Name, Type, Size, Content from Uploads where Uploads_ID=?' );
         if( $stmt->execute( [$_REQUEST['file']] ) )
         {
            $filedata = $stmt->fetch(PDO::FETCH_ASSOC);
         }
      }
      else
      {
         $filedata = null;
      }
      
      if( $filedata )
      {
         header('Content-length: ' . $filedata['Size']);
         header('Content-type: '   . $filedata['Type']);
         header('Content-Disposition: attachment; filename=' . $filedata['Name'] );
         print $filedata['Content'];
      }
      else
      {
         header("HTTP/1.1 404 Not Found");
         header("Content-type: text/plain");
         print "file not found";
      }
      
      /* suppress any further output */
      return false;
   }
}
