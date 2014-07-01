<?php

class WordPublish {

    public static function export($event) {

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $phpWord->addParagraphStyle('style1', array('spaceAfter' => 2, 'align' => 'center'));


        $phpWord->addFontStyle('title1', array('name' => 'Verdana', 'size' => 22, 'bold' => true, 'align' => 'center'));
        $phpWord->addFontStyle('title11', array('name' => 'Verdana', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('date', array('name' => 'Verdana', 'size' => 10, 'color' => '#0000e6', 'italic' => true));
        $phpWord->addFontStyle('title2', array('name' => 'Verdana', 'size' => 18, 'color' => '#0000e6'));
        $phpWord->addFontStyle('artist', array('name' => 'Verdana', 'size' => 16, 'color' => '#94285c', 'bold' => true));
        $phpWord->addFontStyle('title4', array('name' => 'Verdana', 'size' => 10, 'color' => '#94285c', 'italic' => true));
        $phpWord->addFontStyle('desc', array('name' => 'Verdana', 'size' => 10, 'color' => '#000000'));

        $section->addText('Mahogany Hall present', 'title1', 'style1');


        if (!isset($open)) {
            $open = substr($event['start_date_hour'], 11, 5);
        } else {
            $open = substr($event['opening_doors'], 11, 5);
        }


        $start = substr($event['start_date_hour'], 11, 5);
        $date = substr($event['start_date_hour'], 0, 10);
        $end = substr($event['ending_date_hour'], 11, 5);

        $title = $event['title_de'];
        $type = $event['nighttype']['name_de'];
        

        $section->addText($date, 'date');

        $section->addText($type, 'title2');
         $section->addText($title, 'title2');


        $section->addText('Artists Perfomers : ', 'title11');


        $artists = $event['artists'];

        foreach ($artists as $a) {
            $name = $a['name'];
            $sd = $a['short_description_de'];
            $genres = $a['genres'];
            foreach ($genres as $g) {

                $genre = $g['name_de'];


                $section->addText($name, 'artist');
                $section->addText($genre, 'title4');


                $section->addText($sd, 'desc');
            }
        }

        $section->addText('Additional : ', 'title11');



        $section->addText('Start : ' . $start);
        $section->addText('Opening doors : ' . $open);
        $section->addText('End : ' . $end);


        $ticketc = $event['ticketcategories'];

        $section->addText('Tickets : ', 'title11');

        foreach ($ticketc as $a) {
            $nameticket = $a['name_de'];
            $amount = $a['pivot']['amount'];



            $section->addText($nameticket . '   :  ' . $amount . 'Frs');
        }


// You can also put the appended element to local object like this:
// Finally, write the document:
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('testFlorent.docx');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save('helloWorld.odt');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'RTF');
        $objWriter->save('helloWorld.rtf');
    }

}
