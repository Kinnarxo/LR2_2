<?php
    $session_num = -1;
    $file_session_nums = "data/sessions.csv";
    $session_key_length = 64;
    $templ = "data/sessions/%a%.csv";
    $f = fopen($file_session_nums, 'r+');
    flock($f, LOCK_EX);
    if (key_exists("sessionID", $_COOKIE))
    {
        $session_num = $_COOKIE["sessionID"];
        while (!feof($f))       // date rewriting
        {   $w = array();
            $w = fgetcsv($f, 1024, ',');
            if ($w[0] == $session_num)
            {
                fwrite($f, "\n" . $session_num . ',' . time());
                break;
            }
        }
    }
    else
    {
        $session_num = md5(random_bytes($session_key_length));
        $flag1 = false;
        while (!feof($f))
        {   $w = array();
            $w = fgetcsv($f, 1024, ',');
            while ($w && $w[0] == $session_num)
            {
                $session_num = md5(random_bytes($session_key_length));
                $flag1 = true;
            }
            if ($flag1) { fseek($f, 0, SEEK_SET);  $flag1 = false;}
        }
        $string = $session_num . "," . (time()+60*60*24*30) . "\n";
        fwrite($f, $string);
        $ff = fopen(preg_replace('/%a%/', $session_num,"data/sessions/%a%.csv"), 'x');
        fwrite($ff, "0,0\n");
    }
    flock($f, LOCK_UN);
    fclose($f);
// Check if some IDs in file expired
    $file_string_array = array();
    $cont = file_get_contents($file_session_nums);
    $arr = explode("\n", $cont);
    foreach ($arr as $v)
    {   if ($v === "") break;
        $mass = array();
        $mass = (str_getcsv($v, ','));
        if ($mass[1] > time())
            $file_string_array[] = $v;
        else unlink(preg_replace('/%a%/', $session_num, $templ));
    }
    $file_string = implode("\n", $file_string_array)."\n";
    file_put_contents($file_session_nums, $file_string);
?>
