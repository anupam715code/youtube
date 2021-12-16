<?php
    
    require_once('fpdf/fpdf.php');
    require_once('fpdi/src/autoload.php');

    //splitAllPages();
    split_pdf();

    function split_pdf()
    {
        $filename       = 'abc.pdf'; 
        $dir            = 'media';

        $pdf            = new \setasign\Fpdi\Fpdi();
        $pageCount      = $pdf->setSourceFile($dir.'/'.$filename);

        $pageFrom = 1;
        $pageTo   = 11;
        $existCounter = 0;
        for ($i = $pageFrom; $i <= $pageTo; $i++) 
        {   
            $tpl  = $pdf->importPage($i);
            $pdf->getTemplateSize($tpl);
            $pdf->addPage();

            $pdf->useTemplate($tpl,['adjustPageSize' => true]);
            $existCounter++;    
        }

        $split_filename = $dir.'/'.basename($filename, '.pdf').'_1_to_11.pdf';
        $pdf->Output($split_filename, "F");

        echo "File splitted with ".$existCounter." number of pages!! Thanks!!";
    }


  ?>  
