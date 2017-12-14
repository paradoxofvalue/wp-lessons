window.onload = function () {

    let isCasual = window.location;
        lessonsGroup = $('.lessonsGroup'),
        lessonsTutor = $('.lessonsTutor'),
        lessonsFlat = $('.lessonsFlat'),
        lessonsSubject = $('.lessonsSubject');

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
}