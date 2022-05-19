<?php
    include("tpl.php");
    include("init.php");

    $page_type = $_POST['page'];
    $session_file = fopen(preg_replace('/%a%/', $session_num, $mas['session_file']), 'r+');
    $session_info_arr = fgetcsv($session_file, ',');
    //$goods_count = (int)trim($session_info_arr[0]);
    $total_price = (int)trim($session_info_arr[1]);

    switch ($page_type) {
        case 'catalog':
        {
            $file = fopen('/data/catalog_content.csv', 'r');
            flock($file, LOCK_EX); $file_str = explode('\n', file_get_contents($file)); flock($file, LOCK_UN); fclose($file);
            $goods = array();
            foreach($file_str as $v)
            {
                $goods[] = str_getcsv($v, ',');
            }
            $body_array = array();
            $body_array[] = preg_replace(array("/%session_num%/", '/%total_price%/'), array(substr($session_num, 0, 8) . '...', $total_price), $mas['nav_panel']);
            $main_array = array();
            $products_array = array();
            foreach ($goods as $v)
            {
                $prod_image = preg_replace(,,$mas['prod_image']);
                $prod_description = preg_replace(,,$mas['prod_description']);
                $page_type_depend_options = preg_replace(,,$mas['prod_options_catalog');
                $products_array[] = preg_replace(array('/%prod_image%/', '/%prod_description%/', '/%page_type_depend_options%/'), array($prod_image, $prod_description, $page_type_depend_options),$mas['product']);
            }
            $body_array[] = $main;

            $title = "Каталог";
            break;
        }
        case 'basket':
        {
            $basket_goods = array();
            foreach(explode('\n', file_get_contents($session_file)) as $v)
            {
                $basket_goods[] = str_getcsv($v, ',');
            }

            $title = "Корзина";
            break;
        }
    }

    fclose($session_file);
    $out = preg_replace(array("/%body%/", "/%title%/"), array($body, $title), $mas['core']);
    setcookie('sessionID', $session_num, time()+60*60*24*30);
    echo $out;
?>