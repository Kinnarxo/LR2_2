<?php
    $sessionID = $_COOKIE['sessionID'];
    $filecontent = file_get_contents('data/sessions/$sessionID.csv');
    $mmas = explode("\n", $filecontent);
    $mas = array();
    foreach ($mmas as $v) if ($v != "") $mas[] = explode(',', $v);
    $count = (int)$mas[0][0]; $total_price = (int)$mas[0][1];

    $lgth = count($mas);
    $basket_array = array();
    for ($i = 1; $i < $lgth; $i++)
    {
        $prod_image = preg_replace('/%image_name%/','data/images/goods' . $mas[$i][2],$mas['prod_image']);
        $prod_description = preg_replace('/%text%/',$mas[$i][1],$mas['prod_description']);
        $page_type_depend_options = preg_replace('/%prod_id%/', $mas[$i][0],$mas['prod_options_catalog']);
        $basket_array[] = preg_replace(array('/%prod_image%/', '/%prod_description%/', '/%page_type_depend_options%/'), array($prod_image, $prod_description, $page_type_depend_options),$mas['product']);
    }
    $str = implode('',$basket_array);

?>



//ЭТОТ СКРИПТ ВООБЩЕ ДРУГОЕ ДОЛЖЕН ДЕЛАТЬ, ФРИК, А ИМЕННО ДОБАВЛЯТЬ В КОРЗИНУ ТОВАРЫ ПО НАЖАТИЮ КНОПКИ, И, НАВЕРНОЕ, ОБНОВЛЯТЬ КОРЗИНУ, НО НЕ ПОЛНОСТЬЮ, А ТОЛЬКО ТО, ЧТО ДОБАВИЛ + ЕСЛИ УЖЕ ДОБАВЛЕНО, ТО НЕ ДОБАВЛЯТЬ
