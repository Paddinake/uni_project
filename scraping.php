<?php
include_once('simple_html_dom.php');

$open = array();
$high = array();
$low = array();
$close = array();
$closeA = array();

$period1 = 0;
$period2 = microtime();

function getPOSIX(){
    echo microtime();
    return microtime();
}

function scraping_IMDB($url) {
    // create HTML DOM
    $html = file_get_html($url);

    // get title
    $ret['Title'] = $html->find('title', 0)->innertext;

    // get rating
    $ret['Rating'] = $html->find('div[class="general rating"] b', 0)->innertext;

    // get overview
    foreach($html->find('div[class="info"]') as $div) {
        // skip user comments
        if($div->find('h5', 0)->innertext=='User Comments:')
            return $ret;

        $key = '';
        $val = '';

        foreach($div->find('*') as $node) {
            if ($node->tag=='h5')
                $key = $node->plaintext;

            if ($node->tag=='a' && $node->plaintext!='more')
                $val .= trim(str_replace("\n", '', $node->plaintext));

            if ($node->tag=='text')
                $val .= trim(str_replace("\n", '', $node->plaintext));
        }

        $ret[$key] = $val;
    }
    
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function scrape_yahoo($url){
    $html = file_get_html($url);

    $str = $html;

    $rowData=array();


    $table = $html->find('table',0);

    foreach($table->find('tr') as $row){
        $exdiv = array();
        foreach($row->find('td') as $cell){
            $exdiv[] = $cell->plaintext;
        }
        $rowData[] = $exdiv;

    }

    echo '<table>';
    foreach ($rowData as $row => $tr) {
        echo '<tr>';
        foreach ($tr as $td)
            echo '<td>' . $td .'</td>';
        echo '</tr>';
    }
    echo '</table>';
}


// -----------------------------------------------------------------------------
// test it!
/*$ret = scraping_IMDB('http://imdb.com/title/tt0335266/');

foreach($ret as $k=>$v)
    echo '<strong>'.$k.' </strong>'.$v.'<br>';*/

//$ret = scrape_yahoo('https://finance.yahoo.com/quote/SKT/history?period1=738540000&period2=1576018800&interval=div%7Csplit&filter=div&frequency=1mo')
$ret = scrape_yahoo("https://finance.yahoo.com/quote/SKT/history?period1=738540000&period2=1576018800&interval=1mo&filter=history&frequency=1mo");


?>