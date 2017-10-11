<?php

/*
Plugin Name: Khai Lessons Plugin
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: teadrinker
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

function khLess_shortcodes_init()
{
    function khLess_shortcode($atts = [], $content = null)
    {
        // do something to $content

        // always return
        return '<h1>My Dick is big</h1>';
    }

    add_shortcode('khLess', 'khLess_shortcode');
}

add_action('init', 'khLess_shortcodes_init');


/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function khLess_settings_init()
{
    // register a new setting for "khLess" page
    register_setting('khLess', 'khLess_options');

    // register a new section in the "khLess" page
    add_settings_section(
        'khLess_section_developers',
        __('', 'khLess'),
        'khLess_section_developers_cb',
        'khLess'
    );

    // register a new field in the "khLess_section_developers" section, inside the "khLess" page
    add_settings_field(
        'khLess_field_pill', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Файл', 'Расписание'),
        'khLess_field_pill_cb',
        'khLess',
        'khLess_section_developers',
        [
            'label_for' => 'khLess_field_pill',
            'class' => 'khLess_row',
            'khLess_custom_data' => 'custom',
        ]
    );
}

/**
 * register our khLess_settings_init to the admin_init action hook
 */
add_action('admin_init', 'khLess_settings_init');

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.


// pill field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function khLess_field_pill_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('khLess_options');
    // output the field
    ?>
    <input type="file" name="file">

    <input type="submit" name="open_file" value="Загрузить расписание"/>


    <?php
}

/**
 * top level menu
 */
function khLess_options_page()
{
    // add top level menu page
    add_menu_page(
        'Настройка файла расписания',
        'Расписание',
        'manage_options',
        'khLess',
        'khLess_options_page_html'
    );
}

/**
 * register our khLess_options_page to the admin_menu action hook
 */
add_action('admin_menu', 'khLess_options_page');

/**
 * top level menu:
 * callback functions
 */
function khLess_options_page_html()
{
    global $wpdb;
    if ($_REQUEST['open_file']) {
        //если нажата кнопка "загрузить каталог"
        if ($_FILES['file']['name'] != '' && $_FILES['file']['error'] == 0) { //проверяем загрузился указаный фаил или нет
            $info = pathinfo($_FILES['file']['name']);
            //копируем полученный csv фаил в папку catalog в корне сайта
            if (copy($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/wordpress/schedule' . $info['extension'])) {
                // создаем в базе таблицу, если же он есть то пропускаем этот шаг.
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                $table_name = $wpdb->prefix . "schedule";


                $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/wordpress/schedule' . $info['extension'], true);
                $xmlObject = simplexml_load_string($file);
                $json = json_encode($xmlObject);
                $array = json_decode($json, TRUE);


                $sql = "DROP TABLE `" . $table_name . "`";
                $wpdb->query($sql);
                if ($wpdb->get_var("SHOW TABLES LIKE $table_name") != $table_name) {
                    $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `field1` varchar(40) NOT NULL,
                              `field2` varchar(40) NOT NULL,
                              `field3` varchar(40) NOT NULL,
                              `field4` varchar(40) NOT NULL,
                              `field5` varchar(40) NOT NULL,                            
                              PRIMARY KEY (`id`)
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

                    dbDelta($sql);
                    echo '<div id="message" class="updated fade"><p><strong>Каталог обновлен.</strong></p></div>';
                }

                $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/catalog/CatalogPard.' . $info['extension']);
                if ($file) {
                    $strings = explode("\n", $file); // построчно разбиваем фаил
                    for ($i = 0; $i < (count($strings) - 1); $i++) {//из каждой строки вырезаем значения полей
                        if ($found = explode(";", iconv("WINDOWS-1251", "UTF-8", $strings[$i]))) {
                            //записываем их в базу
                            $sql = 'INSERT INTO `' . $table_name . '` VALUES("","' . $found[0] . '","' . $found[1] . '","' . $found[2] . '","' . $found[3] . '","' . $found[4] . '");';
                            dbDelta($sql);
                        }
                    }


                } else echo "Не найден указаный CSV фаил! <font color='blue'>" . $_SERVER['DOCUMENT_ROOT'] . '/catalog/CatalogPard.' . $info['extension'] . "</font>";

            } else echo "Неудалось передать указаный фаил.";
        } else $error = "<font color='red'>Фаил не загружен!</font> Возможно вы не указали какой фаил хотите загрузить.";
    }
    ?>
    <div class="wrap">
        <h2>Расписание </h2>
        <form method="post" action="" enctype="multipart/form-data">
            <h3>Выполнить загрузку расписания</h3>
            <em>Для обновления расписание, выберите фаил с расширением <font color="blue">.xml</font>, расположенного на
                вашем компьютере.<em/>
                <br/>
                <br/><input type="file" name="file"/>
                <br/>
                <br/>
                <input type="submit" name="open_file" value="Загрузить каталог"/>
                <br/>
                <br/>
                <?= $error ?>
        </form>
    </div>
    <?php
}

?>
