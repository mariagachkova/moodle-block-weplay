/**
 * JS files for we play block
 */
// require(['jquery'], function($) {
//     $(function () {
//         console.log('Ready');
//     })
// });

require(['jquery',  'jqueryui', 'core/config', 'core/ajax'], function($, UI, mdlconfig, ajax) {

    $("li.refresh_icon").click(function () {
        console.log(111);
        var data = {
            userid: $(this).data('userid'),
            courseid: $(this).data('courseid')
        };

        $.post(M.cfg.wwwroot + '/blocks/course_overview/refresh_block_info.php',
            data
        ).done(function (new_data) {
            console.log(new_data);
            $('div.weplay-points b.points').html(new_data.points);
            $('div.block_wp-level').attribute('class', 'block_wp-level level-' + new_data.level);
            $('div.block_weplay .progress-bar').attribute('style', 'width:' + new_data.percent);
        });
        console.log(222);
    });

    // Refreshblockinfo.init();
});