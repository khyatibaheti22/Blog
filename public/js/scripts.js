/*!
* Start Bootstrap - Landing Page v6.0.6 (https://startbootstrap.com/theme/landing-page)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-landing-page/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project
$.ajaxSetup({
    error: function (e, t, n) {
        404 == e.status && (e.responseJSON.message ? showNotify("error", e.responseJSON.message) : showNotify("error", "Something went wrong."));
    },
}),
$(function (e) {
    $.validator.setDefaults({
        highlight: function (e) {
            $(e).closest(".form-group").addClass("has-error");
        },
        unhighlight: function (e) {
            $(e).closest(".form-group").removeClass("has-error"), $(e).closest(".input-group").removeClass("has-error"), $(e).parent("div").removeClass("has-error");
        },
        errorElement: "span",
        errorClass: "help-block",
        errorPlacement: function (e, t) {
             t.hasClass('other_exp_job') && e.insertAfter($(t).parent().parent().parent()).find('.help-block').length > 0
                ? e.insertAfter($(t).parent().parent().parent()).css("color", "red")
                : t.parent(".input-group").length
                ? e.insertAfter($(t).parent()).css("color", "red")
                : "client_image" == $(t).attr("id")
                ? e.insertAfter($(t).parent().parent()).css("color", "red")
                : t.is("select")
                ? e.insertAfter($(t).parent()).css("color", "red")
                  : t.hasClass('contact-message')
                  ? e.insertAfter($(t).parent().parent()).css('color', 'red')
                : t.is('#image')
                ? e.insertAfter($('#image_error')).css('text-align','center')
                : e.insertAfter($(t)).css("color", "red");
        },
        invalidHandler: function (e, t) {},
    }),
        $("form").validate({
            rules: { confirm_password: { equalTo: "#password" }, email: { email: "#email" }, phonenumber: { phoneNumber: "#phonenumber", minlength: 6, maxlength: 20 } },
            message: { phonenumber: { minlength: "Please enter at least 6 numbers.", maxlength: "Please enter at most 20 numbers." } },
        }),
        $("#form_login").validate({ rules: { email_username: { required: !0, email_username_reg: "#email_username" } } }),
        $("#passwordForm").validate({ rules: { confirm_password: { equalTo: "#password" } } }),
        $.validator.addMethod(
            "email_username_reg",
            function (e, t) {
                return this.optional(t) || /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(e) || /^[a-zA-Z0-9 ' ’]*$/.test(e);
            },
            "Please enter valid credentials."
        ),
        $.validator.addMethod(
            "email",
            function (e, t) {
                return this.optional(t) || /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(e);
            },
            "Please enter the valid email address."
        ),
        $.validator.addMethod(
            "passcheck",
            function (e, t) {
                return this.optional(t) || /^(?=.*\d)(?=.)(?=.*[a-zA-Z]).{8,30}$/.test(e);
            },
            "Password must contain at least 8 and max 30 characters including one letter and one number."
        ),
        $.validator.addMethod(
            "notempty",
            function (e, t) {
                return /^(?!\s*$).+/.test(e);
            },
            "Please enter value, is required."
        ),
        jQuery.validator.addMethod(
            "nospecialChar",
            function (e, t) {
                return /^[a-zA-Z0-9 ' ’]*$/.test($(t).val());
            },
            "Please do not include special characters."
        ),
        jQuery.validator.addMethod(
            "noSpace",
            function (e, t) {
                var n = !0,
                    a = e.substring(0, 1);
                return "" == $.trim(a) && (n = !1), n;
            },
            "No space please and don't leave it empty"
        ),
        jQuery.validator.addMethod("url", function (e, t) {
            return (
                0 == e.length ||
                (/^(https?|ftp):\/\//i.test(e) || ((e = "https://" + e), $(t).val(e)),
                /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(
                    e
                ))
            );
        }),
        $.validator.addMethod(
            "phoneNumber",
            function (e, t) {
                return this.optional(t) || /(?=[0-9+()][0-9 \–\-+()]+[0-9]$)^(?=.*[ \–\-+()])?(?=.*[0-9]).*$/.test(e);
            },
            "Please enter a valid phone number"
        ),
        $.validator.addMethod(
            "alfaname",
            function (e, t) {
                return this.optional(t) || /^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/.test(e);
            },
            "Please enter a valid name"
        ),
        $.validator.addMethod(
            "maxleng",
            function (e, t) {
                var n = $(t).attr("maxlength");
                ("" != n && void 0 !== n) || (n = "25");
                var a = !0;
                return e.length > n && (a = !1), ($.validator.messages.maxleng = "Please enter no more than " + n + " characters"), a;
            },
            $.validator.messages.maxleng
        ),
        $.validator.addMethod(
            "fixleng",
            function (e, t) {
                var n = $(t).attr("maxlength"),
                    a = $(t).attr("minlength");
                ("" != n && void 0 !== n) || (n = "25"), ("" != a && void 0 !== a) || (a = "5");
                var o = !0;
                return (e.length == n && a == n) || (o = !1), ($.validator.messages.fixleng = "Please enter length of " + n + " digits"), o;
            },
            $.validator.messages.fixleng
        ),

        $.validator.addMethod("regx", function (e, t) {
            return this.optional(t) || /(?=[A-Za-z][A-Za-z0-9]+[A-Za-z0-9]$)^(?=.*[A-Za-z]).*$/.test(e)
        }, "Please enter valid username"),


        setTimeout(function () {
            [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function (e) {
                return new bootstrap.Tooltip(e);
            });
        }, 1e3);
});

$("form").validate({
    rules: { 
        email_username:{
            required:true,
        },
        name:{
            required:true,
        },
        confirm_password: { 
            equalTo: "#password" 
        },
        email: {
            required:true,
            email: "#email" 
        }, 
        phonenumber: { 
            required:true,
            phoneNumber: "#phonenumber", 
            minlength: 6, 
            maxlength: 20 
        } 
    },
    message: {
        phonenumber: { 
            minlength: "Please enter at least 6 numbers.", 
            maxlength: "Please enter at most 20 numbers." 
        } 
    },
});
function showNotify(e, t) {
    alertify.set("notifier", "position", "top-right");
    var n = "";
    "" != e &&
        "" != t &&
        ("success" == e
            ? ((n = '<i class="mdi mdi-check-all label-icon"></i> <strong>Success</strong> - ' + t), alertify.success(n))
            : "error" == e
            ? ((n = '<i class="mdi mdi-block-helper label-icon" ></i> <strong>Error </strong> - ' + t), alertify.error(n))
            : "warning" == e
            ? ((n = '<i class="mdi mdi-alert-outline label-icon" ></i> <strong>Warning </strong> - ' + t), alertify.warning(n))
            : ((n = '<i class="mdi mdi-alert-circle-outline label-icon" ></i> <strong>Info </strong> -' + t), alertify.message(n)));
}