<link href="<?php echo content_url() ?>/plugins/khai-lessons-plugin/schedule/styles.css" rel="stylesheet"
      type="text/css">
<div class="lessons-wrapper">
    <div class='centered'>
        <div class='info'>
            <p>
                <select class="lessonsGroup" name="group" id="group">
                </select>
                <select class="lessonsTutor" name="tutor" id="tutor">
                </select>
                <select class="lessonsFlat" name="flat" id="flat">
                </select>
                <select class="lessonsSubject" name="subject" id="subject">
                </select>
                <div style="text-align: center;">
                    <button id="send" class="btn btn-success">Отобразить</button>
                </div>
            </p>
        </div>
        <div id='schedule'>
            <div class='s-legend'>
                <div class='s-cell s-head-info'>
                    <div class='s-name'>TT</div>
                </div>
                <div class='s-week-day s-cell'>
                    <div class='s-day'>ПН</div>
                </div>
                <div class='s-week-day s-cell'>
                    <div class='s-day'>ВТ</div>
                </div>
                <div class='s-week-day s-cell'>
                    <div class='s-day'>СР</div>
                </div>
                <div class='s-week-day s-cell'>
                    <div class='s-day'>ЧТ</div>
                </div>
                <div class='s-week-day s-cell'>
                    <div class='s-day'>ПТ</div>
                </div>
            </div>
            <div class='s-container s-block'>
                <div class='s-head-info'>
                    <div class='s-head-hour'>
                        <div class='s-number'>1</div>
                        <div class='s-hourly-interval'>08:00 – 08:45</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>1</div>
                        <div class='s-hourly-interval'>08:50 – 09:35</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>2</div>
                        <div class='s-hourly-interval'>09:50 – 10:35</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>2</div>
                        <div class='s-hourly-interval'>10:40 – 11:25</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>3</div>
                        <div class='s-hourly-interval'>11:55 – 12:40</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>3</div>
                        <div class='s-hourly-interval'>12:45 – 13:30</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>4</div>
                        <div class='s-hourly-interval'>13:45 – 14:30</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>4</div>
                        <div class='s-hourly-interval'>14:35 – 15:20</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>5</div>
                        <div class='s-hourly-interval'>15:35 – 16:20</div>
                    </div>
                    <div class='s-head-hour'>
                        <div class='s-number'>5</div>
                        <div class='s-hourly-interval'>16:25 – 17:10</div>
                    </div>
                </div>
                <div class='s-rows-container'>
                    <div class='s-activities'>
                        <div class='s-act-row'></div>
                        <div class='s-act-row'></div>
                        <div class='s-act-row'></div>
                        <div class='s-act-row'></div>
                        <div class='s-act-row'></div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                    <div class='s-row s-hour-row'>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                        <div class='s-hour-wrapper s-cell'>
                            <div class='s-half-hour'></div>
                            <div class='s-half-hour'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .centered {
        position: relative;
        transform: translate(-50%, 0%);
    }
    .select2-container {
        width: 100%!important;
        margin: 10px 0!important;
    }
    .info {
        margin: 10px auto!important;
    }
    .info p {
        margin-bottom: 0;
    }
    .lessons-wrapper {
        position: relative;
        /*display: flex;*/
        /*height: 450px;*/
    }
    .s-act-name {
        font-size: 12px;
        line-height: 12px;
    }
    #send {
        width: 33%;
        min-width: 50px;
        margin: 15px;
        transition: 0.5s ease 0s;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?php echo content_url() ?>/plugins/khai-lessons-plugin/schedule/script.js"></script>


