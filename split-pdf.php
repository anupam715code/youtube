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













     function splitAllPages()
    {
        $filename       = 'abc.pdf'; 
        $dir            = 'media';

        $pdf            = new \setasign\Fpdi\Fpdi();
        $pageCount      = $pdf->setSourceFile($dir.'/'.$filename);
       

        $subDir = $dir.'/'.basename($filename, '.pdf');
        if (!is_dir($subDir))
        {
             mkdir($subDir, 0777, TRUE);
        }
        $existCounter   = 0;
        for ($i = 1; $i <= $pageCount; $i++) 
        {   
            $tpl  = $pdf->importPage($i, '/MediaBox');
            $pdf->getTemplateSize($tpl);
             $specs = $pdf->getTemplateSize($tpl);
            if($specs['width'] < $specs['height'])
            {
                $pdf->addPage('P');
            }else{
                $pdf->addPage('L');
            }
            $pdf->useTemplate($tpl);
           
            $specs = $pdf->getTemplateSize($tpl);
            $split_filename = $subDir.'/'.basename($filename, '.pdf').'_'.($i).'.pdf';

            $existCounter++;    

            $pdf->Output($split_filename, "F");
            $pdf = new \setasign\Fpdi\Fpdi();
            $pdf->setSourceFile($dir.'/'.$filename);
        }
        echo "File splitted in ".$existCounter."number of files!! Thanks!!";
    }  

  ?>  