<pre><?php

$file = fopen('programma.csv', 'r');
$res = [];
$people = [];
while($line = fgetcsv($file)){
    // if(preg_match('/^[0-9]{1,2}:[0-9]{2}/', $line[1])){
    //     echo substr($line[1], 0, 5).'|'.$line[5];
    //     if(strpos($line[2], 'Keynote') !== false){
    //         echo 'Keynote';
    //     }
    //     var_dump($line);
    //     echo '<br/>';
    // }
    if(preg_match('/^[0-9]{1}-[0-9]{2}/', $line[5])){
        $authors = explode(',', str_replace([' and ', ', '], ',', $line['4']));
        $res[$line['5']] = [
            'start' => substr($line[1], 0, 5),
            'title' => $line[3],
            'authors' => $authors,
            'is_keynote' => strpos($line[2], 'Keynote') !== false
        ];
        $people = array_merge($people, $authors);
    }
}
var_dump([$people, $res]);