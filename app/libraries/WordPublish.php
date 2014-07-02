<?php

class WordPublish {

    public static function export($event) {

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $phpWord->addParagraphStyle('style1', array( 'align' => 'center', 'spaceBefore' => 500));
        $phpWord->addParagraphStyle('style11', array( 'align' => 'center', 'spaceBefore' => 20));
        $phpWord->addParagraphStyle('style2', array('spaceAfter' => 2, 'align' => 'center','spaceBefore' => 20 ));


        $phpWord->addFontStyle('title1', array('name' => 'Verdana', 'size' => 22, 'bold' => true));
        $phpWord->addFontStyle('title11', array('name' => 'Verdana', 'size' => 18, 'bold' => true));
        $phpWord->addFontStyle('date', array('name' => 'Verdana', 'size' => 10,'italic' => true));
        $phpWord->addFontStyle('title2', array('name' => 'Verdana', 'size' => 32, 'bold'=>true));
        $phpWord->addFontStyle('title22', array('name' => 'Verdana', 'size' => 18));
        $phpWord->addFontStyle('title222', array('name' => 'Verdana', 'size' => 18, 'bold' => true));
        $phpWord->addFontStyle('artist', array('name' => 'Verdana', 'size' => 16, 'color' => '#94285c', 'bold' => true));
        $phpWord->addFontStyle('title4', array('name' => 'Verdana', 'size' => 10, 'color' => '#94285c', 'italic' => true));
        $phpWord->addFontStyle('desc', array('name' => 'Verdana', 'size' => 10, 'color' => '#000000'));
        $section->addImage('public/img/mahogany.jpg', array('width' => 210, 'height' => 210, 'align' => 'center'));
        $section->addText('presents', 'title22', 'style1');


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



        $section->addText('« ' . strtoupper($title) . ' »', 'title2', 'style2');
        $section->addText($type, 'title222', 'style11');
        $section->addText($date, 'date', 'style11');




        $section->addText('with', 'title22', 'style1');


        $artists = $event['artists'];

        foreach ($artists as $a) {
            $name = $a['name'];
            $sd = $a['short_description_de'];
            $genres = $a['genres'];
            foreach ($genres as $g) {

                $genre = $g['name_de'];


                $section->addText($name, 'artist', 'style11');
                $section->addText($genre, 'title4', 'style11');


                $section->addText($sd, 'desc', 'style11');
            }
        }

        $section->addText('Additional informations ', 'title11', 'style1');



        $section->addText('Start : ' . $start, '', 'style11');
        $section->addText('Opening doors : ' . $open, '', 'style11');
        $section->addText('End : ' . $end, '', 'style11');


        $ticketc = $event['ticketcategories'];

        $section->addText('Tickets', 'title11', 'style1');

        foreach ($ticketc as $a) {
            $nameticket = $a['name_de'];
            $amount = $a['pivot']['amount'];



            $section->addText($nameticket . ' : ' . $amount . ' CHF', '', 'style11');
        }


// You can also put the appended element to local object like this:
// Finally, write the document:
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('public/export/'. $date .'-'.$title.'.docx');

    }

}
