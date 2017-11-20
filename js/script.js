window.onload = function () {

    $.post(ajax_object.ajaxurl, {
        action: 'ajax_action',
    }, function (data) {
        data = JSON.parse(data.slice(0, data.length - 1));
        data.groups.unshift('');
        data.tutors.unshift('');
        data.flats.unshift('');
        data.subjects.unshift('');

        $('.lessonsGroup').select2({
            placeholder: "Выберите группу",
            allowClear: true,
            data: data.groups,
        });
        $('.lessonsTutor').select2({
            placeholder: "Выберите предподавателя",
            allowClear: true,
            data: data.tutors,
        });
        $('.lessonsFlat').select2({
            placeholder: "Выберите аудиторию",
            allowClear: true,
            data: data.flats,
        });
        $('.lessonsSubject').select2({
            placeholder: "Выберите предмет",
            allowClear: true,
            data: data.subjects,
        });
    });

    $('#send').on('click', function () {
        let group = $('#group').val() || '',
            tutor = $('#tutor').val() || '',
            flat = $('#flat').val() || '';
        $.post(ajax_object.ajaxurl, {
            action: 'ajax_action',
            data: {
                group: group,
                tutor: tutor,
                flat: flat,
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
                    group = lesson['groups'];

                schedule.activities.add(day, subject, pair, flat, group, tutor, "pink");
            }
            debugger;
        });
    });
}