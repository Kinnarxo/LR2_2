<?php
    $session_num = -1;
    $file_session_nums = "sessions.csv";
    $session_dir = "";
    $session_key_length = 64;
    $templ = "../sessions/%a%/%a%.csv";
    $f = fopen($file_session_nums, 'r+');

    if (key_exists("session_num", $_POST))
    {
        $session_num = (int)$_POST["session_num"];
        $session_dir = fopen(preg_replace("/%a%/", $session_num, $templ), 'r+');
        while (!feof($f))       // date rewriting
        {   $w = array();
            $w = fgetcsv($f, 1024, ',');
            if ($w[0] == $session_num)
            {
                fwrite($f, '\n' . $session_num . ',' . time());
                break;
            }
        }
    }
    else
    {
        $session_num = random_bytes($session_key_length);
        $flag1 = false;
        while (!feof($f))
        {   $w = array();
            $w = fgetcsv($f, 1024, ',');
            while ($w[0] == $session_num)
            {
                $session_num = random_bytes($session_key_length);
                $flag1 = true;
            }
            if ($flag1) { fseek($f, 0, SEEK_SET);  $flag1 = false;}
        }
        fwrite($f, '\n' . $session_num . ',' . time());
        mkdir('../sessions/'.$session_num);
        $session_dir = fopen(preg_replace("/%a%/", $session_num, $templ), 'w+');
    }
// Check if some IDs in file expired
    fseek($f, 0, SEEK_SET);
    $file_string_array = array();
    foreach (explode(trim(file_get_contents($f, false, null, SEEK_SET)), '\n') as $v)
    {   $mass = array();
        $mass = (str_getcsv(trim($v), ','));
        if ($mass[1] > time())
            $file_string_array[] = $v;
        else
        {
            $dirr = preg_replace("/%a%/", $mass[1], $templ);
            if (file_exists($dirr))
            {
                $dir_mas = scandir($dirr);
                foreach ($dir_mas as $v)   unlink($v);
            }
            rmdir($dirr);
        }
    }
    $file_string = implode('\n', $file_string_array);
    file_put_contents($f, $file_string);
?>