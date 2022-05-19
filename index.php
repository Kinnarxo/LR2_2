<?php
    include("tpl.php");
    include("init.php");

    $page_type = $_POST['page'];
    $session_file = fopen(preg_replace('/%a%/', $session_num, $mas['session_file']), 'r+');
    $session_info_arr = fgetcsv($session_file, ',');
    //$goods_count = (int)trim($session_info_arr[0]);
    $total_price = (int)trim($session_info_arr[1]);

    switch ($page_type) {
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
        default:
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
                $prod_image = preg_replace('/%image_name%/','data/images/goods' . $v[2],$mas['prod_image']);
                $prod_description = preg_replace('/%text%/',$v[1],$mas['prod_description']);
                $page_type_depend_options = preg_replace('/%prod_id%/', $v[0],$mas['prod_options_catalog']);
                $products_array[] = preg_replace(array('/%prod_image%/', '/%prod_description%/', '/%page_type_depend_options%/'), array($prod_image, $prod_description, $page_type_depend_options),$mas['product']);
            }
            $products = implode("",$products_array);
            $main_array[] = $products;
            $main = implode("", $main_array);
            $body_array[] = $main;
            $bottom = preg_replace(array('/%author1%/','/%author2%/','/%author3%/','/%author4%/','/%bottom_middle_text%/','/%contacts1%/'),array($mas['author1'],$mas['author2'],$mas['author3'],$mas['author4'],$mas['bottom_middle_text'],$mas['contacts1']),$mas['bottom']);
            $body_array[] = $bottom;

            $body = implode("", $body_array);
            $title = "Каталог";
            break;
        }
    }

    fclose($session_file);
    $out = preg_replace(array("/%body%/", "/%title%/"), array($body, $title), $mas['core']);
    setcookie('sessionID', $session_num, time()+60*60*24*30);
    echo $out;
?>