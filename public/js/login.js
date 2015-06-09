$(function () {
    var app = {};
    /* 验证码变更 */
    $("#captcha_a").click(function () {
        $(this).find('img').each(function () {
            app.img_src ? null : app.img_src = $(this).attr('src');
            $(this).attr('src', app.img_src + "?" + Math.random());
        });
    });

/* 表单验证 */
    $("#login_form").formValidation();
});