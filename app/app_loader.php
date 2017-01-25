<?php
$base = __DIR__ . '/../app/';

$folders = [
'lib',
'model',
'controller',
'middleware',
'validation',
'route',
];

require_once $base.'controller/MasterController.php';
require_once $base.'model/MasterModel.php';



foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        require_once $filename;
    }
}


$path = $base.'modules';
$results = scandir($path);


foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;
    $final_path = $path."/".$result;
    if(is_dir($final_path)){
        $final_results = scandir($final_path);
        foreach ($final_results as $final_result) {
            if ($final_result === '.' or $final_result === '..') continue;
            foreach (glob($final_path . '/' . $final_result . "/*.php") as $k => $filename)
            {
                require_once $filename;
            }
        }

    }
}












/*


foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;

    if (is_dir($path . '/' . $result)) {
        foreach (glob($path . '/' . $result . "/*.php") as $k => $filename)
        {
            require_once $filename;

        }
    }
}*/