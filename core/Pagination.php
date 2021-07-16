<?php
class Pagination{
    private $no_of_rows;
    private $rows_per_pg = 5;
    private $last_pg;
    private $pg_no = 1;
    private $prev;
    private $next;
    
    public function setRowsPerPg($rows_per_pg){
        $this->rows_per_pg = $rows_per_pg;
    }

    public function paginate($no_of_rows, $links,$pg){

        $this->no_of_rows = $no_of_rows;
        
        if (isset($pg)) {
            $this->pg_no = preg_replace('#[^0-9]#', '', $pg);
           
        } else {
            $this->pg_no = 1;
            
        }
        
        $this->last_pg = ceil($no_of_rows / $this->rows_per_pg);
        if ($this->last_pg < 1) {
            $this->last_pg = 1;
        }
        if ($this->pg_no < 1) {
            $this->pg_no = 1;
        } else if ($this->pg_no > $this->last_pg) {
            $this->pg_no = $this->last_pg;
        }
        
        $pagination = "<br/>
            <div class='pagination pagination-lg' style='margin: 0 auto;width:100%;text-align:center;'>
                <p class='pagination' style='text-align:center;'>";
        
        if ($this->last_pg != 1) {

            if ($this->pg_no > 1) {
                $this->prev = $this->pg_no - 1;
                $pagination .= '<a style="margin:1px;" href="' . $links . $this->prev . '"><i id="my_pagi' . ($this->pg_no - 1) . '"class="fa fa-backward page-link my-pagi"" aria-hidden="true"></i></a>&nbsp;&nbsp';
                for ($i = $this->pg_no - 4; $i < $this->pg_no; $i++) {
                    if ($i > 0) {
                        $pagination .= '<a id="' . $i . '" class="my-pagi" style="text-decoration:none;" href="' . $links . $i . '">' . $i . '</a>&nbsp;&nbsp';
                    }
                }
            }
            $pagination .= "<a id='my_pagi$this->pg_no' class='btn my-pagi rounded-0' style='font-weight:bold;background-color: #D1CFCA;'>" . $this->pg_no . "&nbsp;</a>";
            for ($i = $this->pg_no + 1; $i <= $this->last_pg; $i++) {
                $pagination .= '<a id="my_pagi' . $i . '"class="btn my-pagi' . '" href="' . $links . $i . '">' . $i . '</a>&nbsp;&nbsp';
                if ($i >= $this->pg_no + 4) {
                    break;
                }
            }
            if ($this->pg_no != $this->last_pg) {
                $this->next = $this->pg_no + 1;
                $pagination .= '<a href="' . $links . $this->next . '"><i id="my_pagi_next' . ($this->pg_no + 1) . '"class="fa fa-forward my-pagi page-link" aria-hidden="true"></i></a>&nbsp;&nbsp';
            }
         
        }
        $pagination .= "</p></div>";
        
        if (($this->pg_no * $this->rows_per_pg) <= $this->no_of_rows) {
            $pagination .= "<p style='font-weight:bold;text-align:center;'>" . $this->pg_no * $this->rows_per_pg . " / " . $this->no_of_rows . "</p>";
        } elseif (($this->pg_no * $this->rows_per_pg) > $this->no_of_rows && $this->no_of_rows != null) {
            //echo $this->no_of_rows;
            $pagination .= "<p style='font-weight:bold;text-align:center;'>" . $this->no_of_rows . " / " . $this->no_of_rows . "</p>";
        }
        
        return $pagination;
        
    }

}