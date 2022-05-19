<?php
    $mas = array();
    $mas['core'] =
"<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html' charset='utf-8'>
<link type='text/css' href='%style_name%_styles.css' rel='stylesheet'>
<script src='jquery-3.6.0.min.js'></script>
<script src='%script_name%.js'></script>
<title>%title%</title>
</head>
<body>
<div id='backgr'></div>
%body%
</body>
</html>";
    $mas['nav_panel'] = "<div id='navi'>
<div class='left_block'>%session_num%</div>
<div class='center_block'></div>
<div class='right_block' id='total_price'>%total_price% P<div id='basket_button'><img src='data/images/app/basket.png' height='60px'></div></div>
</div>";
    $mas['main'] = "<div id='main'>%main_content%</div><div id='main_bg'></div>";
    $mas['product'] = "<div class='product'>%prod_image% %prod_description% %page_type_depend_options%</div>";
    $mas['prod_image'] = "<picture class='prod_image'>
<source srcset='%image_name%.webp' media='(max-width: 200px)' type='image/webp'>
<img src='%image_name%.jpg' height='200px'>
</picture>";
    $mas['prod_description'] = "<div class='prod_description'>%text%</div>";
    $mas['prod_options_catalog'] = "<div class='add_prod' id='adder_%prod_id%'>Добавить в корзину</div>";
    $mas['prod_options_basket'] = "<div class='plus_prod' id='pluser_%prod_id%'>+</div><div class='minus_prod' id='minuser_%prod_id%'>-</div>";
    $mas['session_info'] = "<div id='session_info'><span>Номер сессии %session_number%</span></div>";
    $mas['bottom'] = "<div id = 'bottom'>
<div class = 'left_block'>Авторы лабораторной работы:<br>%author1%<br>%author2%<br>%author3%<br>%author4%</div>
<div class = 'center_block'><div class='middle_text'>%bottom_middle_text%</div></div>
<div class='right_block'><ul>
<li>%contacts1%</li>
</ul></div>
</div>";
    $mas['author1'] = "Павленко М.С.";
    $mas['author2'] = "Печурин Д.А.";
    $mas['author3'] = "Сошников С.А.";
    $mas['author4'] = "Однооркова А.В.";
    $mas['bottom_middle_text'] = "";
    $mas['contacts1'] = "<a href='https://vk.com/shrek_i'>Vk</a>";
    $mas['body_catalog'] = "";
    $mas['basket'] = "<div id='basket_body'>%body%</div>";


//not page-building templates
    $mas['session_file'] = "data/sessions/%a%.csv";
?>
