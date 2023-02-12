<?php
function getPagination($pg, $numperpage, $query, $sql, &$start_record, &$num_row) {
   global $connection;

   if ($sql!="") {
      if ($pg=="") {
         $pg=1;
      }

      $start_record=(($pg-1)*$numperpage);

      $result=mysqli_query($connection, $sql);
      $num_row=mysqli_num_rows($result);

      if ((int)($num_row/$numperpage)==($num_row/$numperpage)) {
         $num_page=$num_row/$numperpage;
      } else {
         $num_page=(int)($num_row/$numperpage)+1;
      }

      $prev_pg=$pg-1;
      $next_pg=$pg+1;

     
       $prev_query=$query."&pg=".$prev_pg;
      $next_query=$query."&pg=".$next_pg;
     
      

      if ($num_page>1) {
         $s.="<nav aria-label=\"Page navigation\">";
         $s.="<ul class=\"pagination justify-content-center\">";
         if ($pg>1) {
            $s.="<li class=\"paginate_button page-item\"><a class=\"page-link\" data-tooltip title='Previous Page' href=\"index.php?".$prev_query."\"><<</a></li>";
//            $s.="<li><a href=\"index.php?".$prev_query."\"><span uk-pagination-previous></span></a></li>";
            if ($pg>6) {
               $s.="<li class=\"paginate_button page-item\">...</li>";
            }
         }

         for ($i=1; $i<=$num_page; $i++) {
            if (($i>=$pg-5) & ($i<=$pg+5)) {
               if ($i!=$pg) {
                  $query.="&pg=".$i;
                  $s.="<li class=\"paginate_button page-item\"><a class=\"page-link\" href=\"index.php?".$query."\">$i</a></li>";
               } else {
                  $s.="<li class=\"paginate_button page-item active\"><span class=\"page-link\">$i <span class=\"sr-only\">(current)</span></span></li>";
               }
            }
         }

         if ($pg<$num_page) {
            if ($pg < ($num_page-5)) {
               $s.="<li class=\"paginate_button page-item\">...</li>";
            }

            $s.="<li class=\"paginate_button page-item\"><a class=\"page-link\" data-tooltip title='Next Page' href=\"index.php?".$next_query."\">>></a></li>";
//            $s.="<li><a href=\"index.php?".$next_query."\"><span uk-pagination-next></span></a></li>";
         }
         $s.="</ul>";
         $s.="</nav>";

         return $s;
      } else {
         return "<br>";
      }
   }
}

?>