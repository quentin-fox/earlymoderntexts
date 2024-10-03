<?php

//include_once("functions.php");

// HELPER FUNCTIONS

// generate sidebar

function sidebar($author) {

    $authors = simplexml_load_file('content/xml/authors.xml');

    $html = '<h4 style="text-align: center;">All Texts</h4>';

    $html .= '<form>';

    $html .= '<select id="author">';

    $html .= '<option value="{{ link(texts) }}">- select by author -</option>';

    foreach ($authors as $a) {

        $html .= ' <option value="{{ link(authors/' . $a->attributes()->id . ') }}"';

        if ((string)$a->attributes()->id == $author) {

            $html .= ' selected="selected"';

        }
        if($a->attributes()->shortname == "Damaris Masham")
            $a->attributes()->shortname = "Masham";
        $html .= '>' . $a->attributes()->shortname . ' (' . $a->attributes()->dates . ')</option>';

    }

    $html .= '</select>';

    $html .= '</form>';

    if ($author and ($author != 'conway') and ($author != 'damaris')) {

        $html .= '<img src="{{ asset(images/' . $author . '.jpg) }}">';
    }
    // } elseif($author == 'damaris'){
    //     $html .= '<p style="text-align: left;">There is no portrait of Damaris Masham. Two portraits of her are known to have been commissioned, one by her mother and one by John Locke; but both have disappeared.</p>';        
    // }

    return $html;

}



// PAGES

// 404 page

function notfound() {

    $content = file_get_contents('content/notfound.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Page not found',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// home page

function home() {

    // add new visitors

     // new_visitors();

    $content = file_get_contents('content/home.html');

    return array(

        'template' => 'layout.html',

        'title' => 'Early Modern Texts',

        'activate' => 'home',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// Insert new visitors

// function new_visitors()

// {

//     global $conn;

//     // get current user IP Address

//     $adresseip = getRealIpAddr();

//     // Check User visit in 24 hours one time

//     $sqlsel = "SELECT * FROM `tbl_total_visitors` where DATE_FORMAT(current_date_time, '%Y-%m-%d') = '".date("Y-m-d")."' AND `user_ip` = '".$adresseip."'";

//     //echo $sqlsel; die;

//     $result = $conn->query($sqlsel);

//     $found_result = $result->num_rows;

//     // Add new record for home page visitors

//     if($found_result == 0):

//         $sqlinsert = "INSERT INTO `tbl_total_visitors` (`user_ip`, `current_date_time`) VALUES ('".$adresseip."', '".date("Y-m-d H:i:s")."')";

//         if(!$conn->query($sqlinsert)) echo 'Error: '. $conn->error;

//     endif;

// }// texts and authors

function texts() {

    $content = file_get_contents('content/texts.html');

    $authors = simplexml_load_file('content/xml/authors.xml');

    $list = '<ul>';
    // echo "<pre>";
    // print_r($authors);

    foreach ($authors->author as $a) {

        $list .= '<li><b><a href="{{ link(authors/'.$a->attributes()->id.') }}">'.$a->attributes()->name.' ('.$a->attributes()->dates.')</a></b><ul>';

        foreach ($a->text as $t) {

            if(!$t->attributes()->pdf){

                if(!empty($t->attributes()->year) && !empty($t->attributes()->title))

                $list .= '<p>'.$t->attributes()->title.' ('.$t->attributes()->year.')</p>';

            }

            else

            {
                if(!empty($t->attributes()->year) && !empty($t->attributes()->title)){
                $list .= '<li>'.$t->attributes()->title.' ('.$t->attributes()->year.')</li>';
            }

            }

            if ($t->text) {



            // $content .= '<ul>';

            foreach ($t->text as $text2) {
                $array_title = array('Book I', 'Book II', 'Book III', 'Book IV',);
                if(!in_array($text2->attributes()->title, $array_title)){
                    if(!empty($text2->attributes()->year) && !empty($text2->attributes()->title) && empty($text2->attributes()->third)){
                        if($text2->attributes()->nyear){
                            $new_title = str_replace(", 1705", " (1705)", $text2->attributes()->title);
                            $list .= '<li class="jawad">'.$new_title.'</li>';
                        }
                        else{
                            $list .= '<li>'.$text2->attributes()->title.' ('.$text2->attributes()->year.')</li>';
                        }
                        
                    }    
                }
                

            }



            // $content .= '</ul>';

        }

        }

        $list .= '</ul></li>';

    }

    $list .= '</ul>';

    $content .= $list;

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Texts',

        'activate' => 'texts',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}

function authors($author) {

    $authors = simplexml_load_file('content/xml/authors.xml');

    $author = $authors->xpath('//author[@id = "' . $author . '"]');

    $author = $author[0];

    if (empty($author)) {

        return notfound();

    }

    $content = '';

    $content .= '<h2>' . $author->attributes()->name . ', ' . $author->attributes()->dates . '</h2>';

    $content .= '<ul style="clear:left;">';

    foreach ($author->text as $text1) {



        // for epub file

        if ($text1->attributes()->epub) {

            if(!empty($text1->attributes()->epub)){

                $content .= '<a class="epub_version '.$text1->attributes()->class.' one_line" href="{{ asset(mobile/' . $text1->attributes()->epub . '.epub) }}">(Epub, ' . $text1->attributes()->kb . 'kb)</a>';

            }

        }



        // for mobi file first level

        if ($text1->attributes()->mobi) {

            if(!empty($text1->attributes()->mobi)){

                $content .= '<a class="mobi_version '.$text1->attributes()->class.'" href="{{ asset(mobile/' . $text1->attributes()->mobi . '.mobi) }}">(Mobi, ' . $text1->attributes()->kb . 'kb)</a> <br />';

            }

        }



        if(!empty($text1->attributes()->title)){

            if ($text1->attributes()->pdf) {

                $content .= '<li>';

                $content .= '<b>' . $text1->attributes()->title. '</b>, ' . $text1->attributes()->year;

            } 

            else{

                $content .= '';

            }

        }



        if ($text1->attributes()->pdf) {

            if(!empty($text1->attributes()->pdf)){

                $content .= ' (<a class="get_pdf_counts clicky_log_download" href="{{ asset(pdfs/' . $text1->attributes()->pdf . '.pdf) }}">PDF, ' . $text1->attributes()->kb . 'kb)</a>';

            }

        }elseif ($text1->attributes()->audio){

            $content .= '<p><img src="{{ asset(../assets/icons/icon-sound.jpg) }}" height="16" width="16" />&nbsp;&nbsp;'.

                '<a title="'.$text1->attributes()->title.'" class="get_audio_counts clicky_log_download color_red" href="{{ asset(audio/' . $text1->attributes()->audio . ') }}">' . $text1->attributes()->title . '</a></p>';

        }

        else{

            if(!empty($text1->attributes()->title))

                $content .= '<b>' . $text1->attributes()->title. '</b>, ' . $text1->attributes()->year;

        }

        // Get all 2nd level

        if ($text1->text) {



            $content .= '<ul>';

            foreach ($text1->text as $text2) {



                // for epub file

                if ($text2->attributes()->epub) {

                    if(!empty($text2->attributes()->epub)){

                        $content .= ' <a class="epub_version '.$text2->attributes()->class.' one_line" href="{{ asset(mobile/' . $text2->attributes()->epub . '.epub) }}">(Epub, ' . $text2->attributes()->kb . 'kb)</a>';

                    }

                }



                // for mobi file

                if ($text2->attributes()->mobi) {

                    if(!empty($text2->attributes()->mobi)){

                        $content .= ' <a class="mobi_version '.$text2->attributes()->class.' " href="{{ asset(mobile/' . $text2->attributes()->mobi . '.mobi) }}">(Mobi, ' . $text2->attributes()->kb . 'kb)</a> <br />';

                    }

                }



                if($text2->attributes()->audio):

                        $content .= '<p><img src="{{ asset(../assets/icons/icon-sound.jpg) }}" height="16" width="16" />&nbsp;&nbsp;'.

                            '<a title="'.$text2->attributes()->title.'" class="get_audio_counts clicky_log_download color_red" href="{{ asset(audio/' . $text2->attributes()->audio . ') }}">' . $text2->attributes()->title . '</a></p>';

                elseif($text2->attributes()->pdf):
                    // second text
                if ($text2->attributes()->second) {
                    $content .= '<li style="list-style: disc; margin-left: -17px;">';

                    $content .= '<b>' . $text2->attributes()->title. '</b>, ' . $text2->attributes()->year;
                    $content .= ' (<a class="get_pdf_counts clicky_log_download" href="{{ asset(pdfs/' . $text2->attributes()->pdf . '.pdf) }}">PDF, ' . $text2->attributes()->kb . 'kb)</a>';
                }
                // third text
                if ($text2->attributes()->third) {
                    $content .= '<p style="list-style: none; margin-left: -17px; padding-top: 12px;">';
                    $content .= $text2->attributes()->title;
                    $content .= '</p>';
                }
                if (!$text2->attributes()->second && !$text2->attributes()->third) {

                    // check attr for nyear
                    if($text2->attributes()->nyear){
                        $masham_text = $text2->attributes()->title;
                        $masham_text = str_replace(', 1705', " <span class='masham_title'>, 1705</span>", $masham_text);
                        $content .= '<li class="masham1705">' . $text2->attributes()->title . ' <a title="'.$masham_text.'" class="get_pdf_counts clicky_log_download" href="{{ asset(pdfs/' . $text2->attributes()->pdf . '.pdf) }}"><span class="bracket">(</span>PDF, ' .$text2->attributes()->kb . 'kb<span class="bracket">)</span></a>';
                    } else {
                        $content .= '<li>' . $text2->attributes()->title . ' (<a title="'.$text2->attributes()->title.'" class="get_pdf_counts clicky_log_download" href="{{ asset(pdfs/' . $text2->attributes()->pdf . '.pdf) }}">PDF, ' .$text2->attributes()->kb . 'kb</a>)';
                    }
                    
                }

                endif;

                // Get all third level

                if ($text2->text) {

                    foreach ($text2->text as $text3) {

                        if($text3->attributes()->audio):

                            $content .= '<p><img src="{{ asset(../assets/icons/icon-sound.jpg) }}" height="16" width="16" />&nbsp;&nbsp;'.

                            '<a title="'.$text3->attributes()->title.'" class="get_audio_counts clicky_log_download color_red" href="{{ asset(audio/' . $text3->attributes()->audio . ') }}">' . $text3->attributes()->title . '</a></p>';

                        elseif($text3->attributes()->pdf):

                            $content .= '<li style="margin-left: 15px;">' . $text3->attributes()->title . ' (<a title="'.$text3->attributes()->title.'" class="get_pdf_counts clicky_log_download" href="{{ asset(pdfs/' . $text3->attributes()->pdf . '.pdf) }}">PDF, ' .$text3->attributes()->kb . 'kb</a>)';

                        endif;

                        }

                    }

                $content .= '</li>';

            }



            $content .= '</ul>';

        }

        $content .= '</li>';

    }

    $content .= '</ul>';

    if ($author->attributes()->id == 'conway') {

        $content .= '<hr>';

        $content .= '<p>There is no picture of Anne Conway. A detail from a Dutch interior painting is often presented as showing her; but the owners of the painting, the Mauritshuis in The Hague, have told us that recent scholarship has shown that it&rsquo;s certainly not her.</p>';

        $content .= '<p></p>';

    }

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - ' . $author->attributes()->name,

        'activate' => 'texts',

        'sidebar' => sidebar($author->attributes()->id),

        'content' => $content

    );

}



// faqs and their answers

function faqs() {

    $content = file_get_contents('content/faqs.html');
    return array(

        'template' => 'layout.html',

        'title' => 'EMT - FAQs',

        'activate' => 'faqs',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}

// faqs and their answers

function faqss() {

    $content = file_get_contents('content/faqs.html');
    return array(

        'template' => 'layout.html',

        'title' => 'EMT - FAQs',

        'activate' => 'faqs',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}

function answer($question) {

    $content = file_get_contents('content/faqs/' . $question . '.html');

    if (!$content) {

        return notfound();

    }

    $sidebar = '';

    if (strpos($question, 'bennett') !== false) {

        $sidebar = sidebar('bennett');

    } else {

        $sidebar = sidebar(null);

    }

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - FAQs - ' . $question,

        'activate' => 'faqs',

        'sidebar' => $sidebar,

        'content' => $content

    );

}



// comments page

function comments() {

    $content = file_get_contents('content/comments.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Comments',

        'activate' => 'comments',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// contact page

function contact() {

    $content = file_get_contents('content/contact.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Contact',

        'activate' => 'contact',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}

// contact page

function contactme() {

    $content = file_get_contents('content/contactme.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Contact',

        'activate' => 'contact',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// audio page

function audio() {

    $content = file_get_contents('content/audio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'audio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// mwaudio page

function mwaudio() {

    $content = file_get_contents('content/mwaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'mwaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// dhaudio page

function dhaudio() {

    $content = file_get_contents('content/dhaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'dhaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// thaudio page

function thaudio() {

    $content = file_get_contents('content/thaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'thaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// th2audio page

function th2audio() {

    $content = file_get_contents('content/th2audio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'th2audio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// rdaudio page

function rdaudio() {

    $content = file_get_contents('content/rdaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'rdaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// jlaudio page

function jlaudio() {

    $content = file_get_contents('content/jlaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'jlaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// sdgaudio page

function sdgaudio() {

    $content = file_get_contents('content/sdgaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'sdgaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// jsmaudio page

function jsmaudio() {

    $content = file_get_contents('content/jsmaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'jsmaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// gwlaudio page

function gwlaudio() {

    $content = file_get_contents('content/gwlaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'gwlaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// anneconwayaudio page

function anneconwayaudio() {

    $content = file_get_contents('content/anneconwayaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'anneconwayaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// rousseauaudio page

function rousseauaudio() {

    $content = file_get_contents('content/rousseauaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'rousseauaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// nicolasaudio page

function nicolasaudio() {

    $content = file_get_contents('content/nicolasaudio.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'nicolasaudio',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}

// machiavelli page

function machiavelli() {

    $content = file_get_contents('content/machiavelli.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'machiavelli',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}

// edmund burke page

function edmund() {

    $content = file_get_contents('content/edmund.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Audio',

        'activate' => 'edmund',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// mistake page

function mistake() {

    $content = file_get_contents('content/faq/mistake.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Mistake',

        'activate' => 'mistake',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



// search page

function search() {

    $content = file_get_contents('content/search.html');

    return array(

        'template' => 'layout.html',

        'title' => 'EMT - Search',

        'activate' => 'search',

        'sidebar' => sidebar(null),

        'content' => $content

    );

}



