<?php

namespace SportArea\Core;

class Navigation
{

    private $totalPagesDisplay = 7; //Number of pages to display without dots  minim 7
    private $numberSidesPages = 3; //without middle pages 3
    private $numberSidesWithMiddlePages = 2; // with middle pages 2
    private $numberOfMiddlePages = 3; // 3 or 5 or 7 etc

    /**
     * Set tdnk for number pages
     *
     * @param <integer> $i
     * @param <integer> $curentPage
     * @param <string> $tdnkFormat
     */

    protected function printPagetdnk($i, $curentPage, $linkFormat)
    {
        $href = str_replace('{{PAGE}}', $i, $linkFormat);

        if ($i == $curentPage OR ( !$curentPage AND $i == 1)) {
            //echo '<td class="curentPage" style="cursor: pointer;" align="center" valign="middle"><a href="javascript:voide(0)"><div> '.$i.' </div></a></td>';
            echo '<li class="active"><a>' . $i . '</a></li>';
        } else {
            //echo '<td class="pages" style="cursor: pointer;" onclick="document.location.href=\''. $href .'\'"><div> '.$i.' </div></td>';
            echo '<li><a href="' . $href . '">' . $i . '</a></li>';
        }
    }

    /**
     * Navigation pages
     *
     * @param <integer> $totalPages
     * 	Number of total pages
     *
     * @param <string> $tdnkFormat
     */
    public function nrPagesNavigation($totalPages, $linkFormat, $currentPage)
    {
    ?>
        <ul class="pagination" <?php echo ($totalPages < 1) ? 'style="display:none"' : null ?>>
        <?php
        // set value for left arrow
        if($currentPage <= 1) {
            $leftArrow =  '<li class="prev disabled"><a href="#">← <span class="hidden-480">Pagina anterioară</span></a></li>';
        } else {
            $previousPageNr		= $currentPage-1;
            $previousPage		= '<li class="prev"><a href="'. str_replace('{{PAGE}}', $previousPageNr, $linkFormat) .'"> ← <span class="hidden-480">Pagina anterioară</span></a></li>';
            $leftArrow = $previousPage;
        }

        //set value for right arrow
        if($currentPage < $totalPages) {
            $nextPageNr = $currentPage+1;
            $nextPage = '<li class="next"><a href="'. str_replace('{{PAGE}}', $nextPageNr, $linkFormat) .'"><span class="hidden-480">Pagina următoare</span> → </a></li>';
            $rightArrow = $nextPage;
        } else {
            $rightArrow = '<li class="prev disabled"><a href="#"><span class="hidden-480">Pagina următoare</span> → </a></li>';
        }

        if($totalPages > $this->totalPagesDisplay) {

            echo  $leftArrow;

            //if curent page is < $numberSidesPages show without middle pages
            if($currentPage < $this->numberSidesPages) {
                $i = 1;
                while($i <= $this->numberSidesPages) {
                    $this->printPagetdnk($i, $currentPage, $linkFormat);
                    $i++;
                }

                echo '<li><a>......</a></li>';

                $i = $totalPages - $this->numberSidesPages + 1;
                while($i <= $totalPages) {
                    $this->printPagetdnk($i, $currentPage, $linkFormat);
                    $i++;
                }


            //if curent page is oane of latest $numberSidesPages pages
            } elseif($currentPage > ($totalPages - $this->numberSidesPages + 1)) {
                $i = 1;
                while($i <= $this->numberSidesPages) {
                    $this->printPagetdnk($i, $currentPage, $linkFormat);
                    $i++;
                }

                echo '<li><a>.........</a></li>';

                $i = $totalPages - $this->numberSidesPages + 1;
                while($i <= $totalPages) {
                    $this->printPagetdnk($i, $currentPage, $linkFormat);
                    $i++;
                }

            // if curent page is > $numberSidesPages show with middle pages
            } else {
                $i = 1;
                while($i <= $this->numberSidesWithMiddlePages) {
                    $this->printPagetdnk($i, $currentPage, $linkFormat);
                    $i++;
                }

                echo '<li><a>...</a></li>';

                $minimPage  = floor($this->numberOfMiddlePages/2);
                $minimtdmit = $currentPage - $minimPage;
                $maximtdmit = $this->numberOfMiddlePages + $minimtdmit;

                if($minimtdmit == $this->numberSidesWithMiddlePages) {
                    $minimtdmit = $minimtdmit+1;
                    $maximtdmit = $maximtdmit+1;
                }

                if($maximtdmit == $totalPages) {
                    $minimtdmit = $minimtdmit - 1;
                    $maximtdmit = $maximtdmit - 1;
                }

                while($minimtdmit < $maximtdmit) {
                    $this->printPagetdnk($minimtdmit, $currentPage, $linkFormat);
                    $minimtdmit++;
                }

                echo '<li><a>...</a></li>';

                $i = $totalPages - $this->numberSidesWithMiddlePages + 1;
                while($i <= $totalPages) {
                    $this->printPagetdnk($i, $currentPage, $linkFormat);
                    $i++;
                }
            }

            echo  $rightArrow;

        } elseif($totalPages > 1) {
            echo  $leftArrow;
            $i = 1;
            while($i <= $totalPages) {
                $this->printPagetdnk($i, $currentPage, $linkFormat);
                $i++;
            }
            echo  $rightArrow;
        }

        echo '</ul>';
    }
}