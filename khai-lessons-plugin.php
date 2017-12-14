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
        get_template_part('template', 'schedule');
    }

    add_shortcode('khLess', 'khLess_shortcode');
}

add_action('init', 'khLess_shortcodes_init');


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

add_action('admin_init', 'khLess_settings_init');

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

add_action('admin_menu', 'khLess_options_page');

function khLess_options_page_html()
{
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
                <input type="submit" name="open_file" value="Загрузить расписание"/>
                <br/>
                <br/>
                <?= $error ?: '' ?>
        </form>
    </div>

    <?php
    global $wpdb;
    if ($_REQUEST['open_file']) {
        //если нажата кнопка "загрузить каталог"
        if ($_FILES['file']['name'] != '' && $_FILES['file']['error'] == 0) { //проверяем загрузился указаный фаил или нет
            $info = pathinfo($_FILES['file']['name']);
            //копируем полученный csv фаил в папку catalog в корне сайта
            if (copy($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/wordpress/schedule.' . $info['extension'])) {
                // создаем в базе таблицу, если же он есть то пропускаем этот шаг.
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


                $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/wordpress/schedule.' . $info['extension'], true);

                if ($file) {
                    $xmlObject = simplexml_load_string($file);
                    $json = json_encode($xmlObject);
                    $array = json_decode($json, TRUE);
                    $lessons = $array['Lesson'];

                    $groupsToOptions = [];
                    $flatsToOptions = [];
                    $tutorsToOptions = [];
                    $subjectToOptions = [];

                    $table_name = $wpdb->prefix . "schedule";


                    $sql = "DROP TABLE `" . $table_name . "`";
                    $wpdb->query($sql);
                    if ($wpdb->get_var("SHOW TABLES LIKE $table_name") != $table_name) {
                        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `cycle` int NOT NULL,
                              `day` int NOT NULL,
                              `pair` int NOT NULL,
                              `subject` text NOT NULL,
                              `subject_type` text NOT NULL,                            
                              `groups` text NOT NULL,                            
                              `flats` text NULL,                            
                              `tutors` text NULL,                            
                              PRIMARY KEY (`id`)
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

                        dbDelta($sql);
                        echo '<div id="message" class="updated fade"><p><strong>Рассписание обновлено.</strong></p></div>';
                    }


                    for ($i = 100; $i < count($lessons); $i++) {
                        $lesson = $lessons[$i];
                        foreach ($lesson as $key => $value) {
                            switch ($key) {
                                case 'Groups': {
                                    $groups = '';
                                    if (count($value['Group'])) {
                                        foreach ($value['Group'] as $group) {
                                            $groups .= $group['@attributes']['Text'] . " | ";

                                            if (!in_array($group['@attributes']['Text'], $groupsToOptions)) {
                                                array_push($groupsToOptions, $group['@attributes']['Text']);
                                            }
                                        }
                                    } else {
                                        $groups = $value[0]['@attributes']['Text'];
                                        if (!in_array($groups, $groupsToOptions)) {
                                            array_push($groupsToOptions, $groups);
                                        }
                                    }

                                    break;
                                }
                                case 'Cycle': {
                                    $cycle = $value["@attributes"]["Index"];
                                    break;
                                }
                                case 'Day': {
                                    $day = $value["@attributes"]["Index"];
                                    break;
                                }
                                case 'Pair': {
                                    $pair = $value["@attributes"]["Index"];
                                    break;
                                }
                                case 'Subject': {
                                    $subject = $value["@attributes"]["Text"];
                                    if (!in_array($subject, $subjectToOptions)) {
                                        array_push($subjectToOptions, $subject);
                                    }
                                    break;
                                }
                                case 'SubjectType': {
                                    $subjectType = $value["@attributes"]["Text"];
                                    break;
                                }
                                case 'Flats': {
                                    $flats = '';
                                    if (count($value['Flat'])) {
                                        foreach ($value['Flat'] as $flat) {
                                            $flats .= $flat['@attributes']['Text'] . " | ";
                                            if (!in_array($flat['@attributes']['Text'], $flatsToOptions)) {
                                                array_push($flatsToOptions, $flat['@attributes']['Text']);
                                            }
                                        }
                                    } else {
                                        $flats = $value[0]['@attributes']['Text'];
                                        if (!in_array($flats, $flatsToOptions)) {
                                            array_push($flatsToOptions, $flats);
                                        }
                                    }

                                    break;
                                }
                                case 'Tutors': {
                                    $tutors = '';
                                    if (count($value['Tutor'])) {
                                        foreach ($value['Tutor'] as $tutor) {
                                            $tutors .= $tutor['@attributes']['Text'] . " | ";
                                            if (!in_array($tutor['@attributes']['Text'], $tutorsToOptions)) {
                                                array_push($tutorsToOptions, $tutor['@attributes']['Text']);
                                            }
                                        }
                                    } else {
                                        $tutors = $value[0]['@attributes']['Text'];
                                        if (!in_array($tutors, $tutorsToOptions)) {
                                            array_push($tutorsToOptions, $tutors);
                                        }
                                    }

                                    break;
                                }
                            }
                        }

                        $sql = 'INSERT INTO `' . $table_name . '` VALUES("","' . $cycle . '","' . $day . '","' . $pair . '","' . $subject . '","' . $subjectType . '","' . $groups . '","' . $flats . '","' . $tutors . '");';
                        dbDelta($sql);

                    }
                    $groupsToOptions = json_encode($groupsToOptions);
                    $flatsToOptions = json_encode($flatsToOptions);
                    $tutorsToOptions = json_encode($tutorsToOptions);
                    $subjectToOptions = json_encode($subjectToOptions);
                    if (get_option("lessonPluginGroups")) {
                        update_option("lessonPluginGroups", $groupsToOptions);
                    } else {
                        add_option("lessonPluginGroups", $groupsToOptions);
                    }
                    if (get_option("lessonPluginFlats")) {
                        update_option("lessonPluginFlats", $flatsToOptions);
                    } else {
                        add_option("lessonPluginFlats", $flatsToOptions);
                    }
                    if (get_option("lessonPluginTutors")) {
                        update_option("lessonPluginTutors", $tutorsToOptions);
                    } else {
                        add_option("lessonPluginTutors", $tutorsToOptions);
                    }
                    if (get_option("lessonPluginSubjects")) {
                        update_option("lessonPluginSubjects", $subjectToOptions);
                    } else {
                        add_option("lessonPluginSubjects", $subjectToOptions);
                    }

                } else echo "Неудалось передать указаный фаил.";
            } else $error = "<font color='red'>Фаил не загружен!</font> Возможно вы не указали какой фаил хотите загрузить.";
        }
    }
}

function ajax_action_stuff()
{
    if ($_POST['data']) {
        global $wpdb;
        $group = $_POST['data']['group'];
        $tutor = $_POST['data']['tutor'];
        $flat = $_POST['data']['flat'];
        $subject = $_POST['data']['subject'];
        $sqlFilter = '';

        $date = date('W');
        $cycle = ($date % 2)?1:2;

        $sqlFilter .= "`cycle` = $cycle ";

        if (!empty($group)) {
            $sqlFilter .= "AND `groups` LIKE '%{$group}%' ";
        }
        if (!empty($tutor)) {
            $sqlFilter .= "AND `tutors` LIKE '%{$tutor}%' ";
        }
        if (!empty($flat)) {
            $sqlFilter .= "AND `flats` LIKE '%{$flat}%' ";
        }
        if (!empty($subject)) {
            $sqlFilter .= "AND `subject` LIKE '%{$subject}%' ";
        }
        $sql = "SELECT * FROM `{$wpdb->prefix}schedule` WHERE {$sqlFilter}";
        $results = $wpdb->get_results($sql);
        echo json_encode($results);

    } else {
        $flats = json_decode(get_option("lessonPluginFlats"));
        $tutors = json_decode(get_option("lessonPluginTutors"));
        $groups = json_decode(get_option("lessonPluginGroups"));
        $subjects = json_decode(get_option("lessonPluginSubjects"));

        $data = new stdClass();
        $data->flats = $flats;
        $data->tutors = $tutors;
        $data->groups = $groups;
        $data->subjects = $subjects;

        echo json_encode($data);
    }
}

add_action('wp_ajax_ajax_action', 'ajax_action_stuff'); // ajax for logged in users
add_action('wp_ajax_nopriv_ajax_action', 'ajax_action_stuff'); // ajax for not logged in users

function enqueue_scripts_styles_init()
{
//    wp_enqueue_script( 'ajax-script', get_template_directory_uri().'/js/script.js', array('jquery'), 1.0 ); // jQuery will be included automatically
    wp_enqueue_script('ajax-script', plugins_url('/js/script.js', __FILE__)); // jQuery will be included automatically
    // get_template_directory_uri() . '/js/script.js'; // Inside a parent theme
    // get_stylesheet_directory_uri() . '/js/script.js'; // Inside a child theme
    // plugins_url( '/js/script.js', __FILE__ ); // Inside a plugin
    wp_localize_script('ajax-script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php'))); // setting ajaxurl
}

add_action('init', 'enqueue_scripts_styles_init');


?>