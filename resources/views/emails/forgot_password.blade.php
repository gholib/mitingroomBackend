<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>MitingRoom</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            min-width: 100% !important;
        }
        img {
            height: auto;
        }
        .content {
            width: 100%;
            max-width: 600px;
        }
        .header {
            padding: 40px 30px 20px 30px;
        }
        .innerpadding {
            padding: 30px 30px 30px 30px;
        }
        .borderbottom {
            border-bottom: 1px solid #f2eeed;
        }
        .h2, .bodycopy {
            color: #153643;
            font-family: sans-serif;
        }
        .h2 {
            padding: 0 0 15px 0;
            font-size: 24px;
            line-height: 28px;
            font-weight: bold;
        }
        .bodycopy {
            font-size: 16px;
            line-height: 22px;
        }
        .button {
            text-align: center;
            font-size: 18px;
            font-family: sans-serif;
            font-weight: bold;
            padding: 0 30px 0 30px;
        }
        .button a {
            color: #ffffff;
            text-decoration: none;
        }
        .footer {
            padding: 20px 30px 15px 30px;
        }
        .footercopy {
            font-family: sans-serif;
            font-size: 14px;
            color: #ffffff;
        }
        .footercopy a {
            color: #ffffff;
            text-decoration: underline;
        }
        @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {
                display: none !important;
            }
            body[yahoo] .buttonwrapper {
                background-color: transparent !important;
            }
            body[yahoo] .button {
                padding: 0 !important;
            }
            body[yahoo] .button a {
                background-color: #e05443;
                padding: 15px 15px 13px !important;
            }
            body[yahoo] .unsubscribe {
                display: block;
                margin-top: 20px;
                padding: 10px 50px;
                background: #2f3942;
                border-radius: 5px;
                text-decoration: none !important;
                font-weight: bold;
            }
        }
    </style>
</head>

<body yahoo bgcolor="#ffffff">
<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px;">
                <tr>
                    <td bgcolor="" class="header">
                        <table align="center"
                               border="0"
                               cellpadding="0"
                               cellspacing="0"
                               style="width: 100%;">
                            <tr>
                                <td height="30">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td>
                                            </td>
                                            <td class="h2" style="padding: 3px 0 0 0;">
                                                Салом,
                                                {{$title}}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="innerpadding borderbottom">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="h2">
                                    Забыли пароль?
                                </td>
                            </tr>
                            <tr>
                                <td class="bodycopy"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="innerpadding borderbottom">
                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                               style="width: 100%;">
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="bodycopy">
                                                Для сброса пароля воспользуйтесь данной ссылкой.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 20px 0 0 0;">
                                                <table class="buttonwrapper" bgcolor="#8057b4" border="0"
                                                       cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td class="button" height="45">
                                                            <a href="{{ $content }}"
                                                               target="_blank">Перейти</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bodycopy">
                                                <br>
                                                <br>
                                                или скопировав, вставьте ее в браузер.
                                                <p>{{ $content }}</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <br>
                                                Если вы не запрашивали сброс пароля, свяжитесь с нами, ответив на это письмо.
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td class="footer" bgcolor="#44525f">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" class="footercopy">
                                    Алиф Капитал {{ date('Y') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
