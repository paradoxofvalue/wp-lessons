window.onload = function () {

    let teacherName = $('.entry-title')[0].innerHTML,
        isTeacher = 0,
        lessonsGroup = $('.lessonsGroup'),
        lessonsTutor = $('.lessonsTutor'),
        lessonsFlat = $('.lessonsFlat'),
        lessonsSubject = $('.lessonsSubject');

    switch (teacherName) {
        case "Прохоров Александр Валерьевич": {
            teacherName = "Прохоров О В";
            break;
        }
        case "Лещенко Александр Борисович": {
            teacherName = "Лещенко О Б";
            isTeacher = 1;
            break;
        }
        case "Федорович Олег Евгеньевич": {
            teacherName = "Федорович О Є";
            isTeacher = 1;
            break;
        }
        case "Малеева Ольга Владимировна": {
            teacherName = "Малєєва О В";
            isTeacher = 1;
            break;
        }
        case "Момот Мирослав Александрович": {
            teacherName = "Момот М О";
            isTeacher = 1;
            break;
        }
        case "Яшина Елена Сергеевна": {
            teacherName = "Яшина О С";
            isTeacher = 1;
            break;
        }
        case "Еременко Наталия Валентиновна": {
            teacherName = "Єременко Н В";
            isTeacher = 1;
            break;
        }
        case "Юркевич Алина Юрьевна": {
            teacherName = "Гетьманська А Ю";
            isTeacher = 1;
            break;
        }
        case "Белоконь Юлия Анатольевна": {
            teacherName = "Білокінь Ю А";
            isTeacher = 1;
            break;
        }
        case "Миланов Михаил Владимирович": {
            teacherName = "Міланов М В";
            isTeacher = 1;
            break;
        }
        case "Губка Алексей Сергеевич": {
            teacherName = "Губка  О С";
            isTeacher = 1;
            break;
        }
        case "Попов Андрей Вячеславович": {
            teacherName = "Попов  А В";
            isTeacher = 1;
            break;
        }
        case "Головань Константин Владиславович": {
            teacherName = "Головань К В";
            isTeacher = 1;
            break;
        }
        case "Кулик Юрий Алексеевич": {
            teacherName = "Кулік Ю О";
            isTeacher = 1;
            break;
        }
        case "Соляник Татьяна Николаевна": {
            teacherName = "Соляник Т М";
            isTeacher = 1;
            break;
        }
        case "Рева Александр Анатольевич": {
            teacherName = "Рева О А";
            isTeacher = 1;
            break;
        }
        case "Смидович Леонид Сергеевич": {
            teacherName = "Смідович Л С";
            isTeacher = 1;
            break;
        }
        case "Елизева Алина Владимировна": {
            teacherName = "Єліз"; // set later
            isTeacher = 1;
            break;
        }
        case "Лещенко Юлия Александровна": {
            teacherName = "Лещенко Ю О"; // set later
            isTeacher = 1;
            break;
        }
    }

    if (isTeacher) {
        $('.info').hide();
        $.post(ajax_object.ajaxurl, {
            action: 'ajax_action',
            data: {
                tutor: teacherName,
            }
        }, function (data) {

            schedule.activities.delete("0");
            schedule.activities.delete("1");
            schedule.activities.delete("2");
            schedule.activities.delete("3");
            schedule.activities.delete("4");

            data = JSON.parse(data.slice(0, data.length - 1));

            let pairs = ["8.00-9.47", "9.49-11.50", "11.52-13.33", "13.40-15.21", "15.25-17.10", "17.25-19.00"];

            for (let index in data) {
                let lesson = data[index],
                    pair = pairs[lesson['pair'] - 1],
                    subject = lesson['subject'],
                    tutor = lesson['tutors'],
                    day = lesson['day'] - 1,
                    flat = lesson['flats'],
                    group = $('#group').val() || lesson['groups'],
                    subject_type = lesson['subject_type'];

                if (subject_type === "практическое занятие") {
                    schedule.activities.add(day, subject, pair, flat, group, tutor, "red");
                } else {
                    schedule.activities.add(day, subject, pair, flat, group, tutor, "blue");
                }

            }
        });
    } else {
        $.post(ajax_object.ajaxurl, {
            action: 'ajax_action',
        }, function (data) {
            data = JSON.parse(data.slice(0, data.length - 1));
            data.groups.unshift('');
            data.tutors.unshift('');
            data.flats.unshift('');
            data.subjects.unshift('');

            $(lessonsGroup).select2({
                placeholder: "Выберите группу",
                allowClear: true,
                data: data.groups,
            });
            $(lessonsTutor).select2({
                placeholder: "Выберите предподавателя",
                allowClear: true,
                data: data.tutors,
            });
            $(lessonsFlat).select2({
                placeholder: "Выберите аудиторию",
                allowClear: true,
                data: data.flats,

            });
            $(lessonsSubject).select2({
                placeholder: "Выберите предмет",
                allowClear: true,
                data: data.subjects,
            });

            $(lessonsGroup).on('select2:close', triggerHover);
            $(lessonsTutor).on('select2:close', triggerHover);
            $(lessonsFlat).on('select2:close', triggerHover);
            $(lessonsSubject).on('select2:close', triggerHover);
        });
    }

    function triggerHover() {
        console.log('test');
        $('#send').trigger('click');
    }

    $('#send').on('click',function () {
        let group = $('#group').val() || '',
            tutor = $('#tutor').val() || '',
            flat = $('#flat').val() || '',
            subject = $('#subject').val() || '';
        if (group || tutor || flat || subject) {
            $(this).className = 'btn btn-success';
            document.querySelector('#send').innerHTML = 'Отобразить';
        } else {
            $(this).className = 'btn btn-danger';
            document.querySelector('#send').innerHTML = 'Установите фильтр';
        }
    });

    $('#send').on('click', function () {
        let group = $('#group').val() || '',
            tutor = $('#tutor').val() || '',
            flat = $('#flat').val() || '',
            subject = $('#subject').val() || '';
        if (!group && !tutor && !flat && !subject) {
            return false;
        }
            $.post(ajax_object.ajaxurl, {
                action: 'ajax_action',
                data: {
                    group: group,
                    tutor: tutor,
                    flat: flat,
                    subject: subject,
                }
            }, function (data) {

                schedule.activities.delete("0");
                schedule.activities.delete("1");
                schedule.activities.delete("2");
                schedule.activities.delete("3");
                schedule.activities.delete("4");

                data = JSON.parse(data.slice(0, data.length - 1));

                let pairs = ["8.00-9.47", "9.49-11.50", "11.52-13.33", "13.40-15.21", "15.25-17.10", "17.25-19.00"];

                for (let index in data) {
                    let lesson = data[index],
                        pair = pairs[lesson['pair'] - 1],
                        subject = lesson['subject'],
                        tutor = lesson['tutors'],
                        day = lesson['day'] - 1,
                        flat = lesson['flats'],
                        group = $('#group').val() || lesson['groups'],
                        subject_type = lesson['subject_type'];

                    if (subject_type === "практическое занятие") {
                        schedule.activities.add(day, subject, pair, flat, group, tutor, "red");
                    } else {
                        schedule.activities.add(day, subject, pair, flat, group, tutor, "blue");
                    }

                }
            });

    });
};