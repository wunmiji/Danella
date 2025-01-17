<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Danella Reset Password</title>
    <meta name="description" content="Danella Reset Password">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #fff;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" cellpadding="0" width="100%"
        style="@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap'); font-family: 'Quicksand', sans-serif; border: 0; background-color: #f2f3f8;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto; border: 0;" width="100%"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <a href="<?= base_url(); ?>" title="logo" target="_blank">
                                <img src="<?= base_url('assets/brand/danellatech-logo.png') ?>" alt="Logo" width="150"
                                    title="logo">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1
                                            style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Quicksand',sans-serif;">
                                            Password Reset</h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                        <h6
                                            style="color:#1e1e2d; font-weight:400; margin:0;font-size:17px;font-family:'Quicksand',sans-serif;">
                                            Hi, <?= $name; ?></h6>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin-top: 10px;">
                                            You are recieving this email because we recevied a password reset request
                                            for your account. Click the button below to proceed.
                                        </p>
                                        <a href="<?= base_url('/reset-password?token=' . $token) ?>"
                                            style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; margin-bottom:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;">Reset
                                            Password</a>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                            This password reset link is only valid for the next <?= $minutes; ?>
                                            minutes. <br>
                                            If you did not request a password reset, please ignore this email!
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                &copy; 
                                <strong>
                                    <a href="<?= base_url(); ?>" style="color:rgba(69, 80, 86, 0.7411764705882353);">DanellaTech</a>
                                </strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>