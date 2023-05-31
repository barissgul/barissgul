<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	
	$row_giris = $cSubData->getGirisResim(); 
?>
<!DOCTYPE html>
<html lang="tr">
    <head>
       <meta charset="utf-8">
        <title> <?=$row_site->TITLE?> </title>
        <meta name="description" content="Login">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="msapplication-tap-highlight" content="no">
        <link rel="stylesheet" media="screen, print" href="smartadmin/css/vendors.bundle.css">
        <link rel="stylesheet" media="screen, print" href="smartadmin/css/app.bundle.css">
        <link rel="apple-touch-icon" sizes="180x180" href="smartadmin/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="smartadmin/img/favicon/favicon-32x32.png">        
        <link rel="stylesheet" media="screen, print" href="smartadmin/css/fa-brands.css">
        <link rel="stylesheet" media="screen, print" href="smartadmin/css/miscellaneous/lightgallery/lightgallery.bundle.css">
    </head>
    <body>
        <div class="page-wrapper">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                                <a href="/" class="page-logo-link press-scale-down d-flex align-items-center">
                                    <img src="favicon.ico" alt="SmartAdmin WebApp" style="height: 48px" aria-roledescription="logo">
                                    <span class="page-logo-text mr-1 fw-500"> <?=$row_site->BASLIK?> </span>
                                </a>
                            </div>
                            <a href="/giris.do" class="ml-auto btn btn-default fw-500"> <?=dil2("Giriş")?> </a>
                        </div>
                    </div>
                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                                       	<?=dil2("Üyelik Başvurusu")?>
                                        <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                                           <?=dil2("Üye olmak için formu doldurunuz. En kısa zamanda sahacı sizi arayacaktır")?>
                                        </small>
                                    </h2>
                                </div>
                                <div class="col-xl-6 ml-auto mr-auto">
                                    <div class="card p-4 rounded-plus bg-faded">
                                        <div class="alert alert-primary text-dark" role="alert">
                                            <strong>Not!</strong> <?=dil2("Hasarlı araç ihalesine katılmak için formu doldurunuz!")?>
                                        </div>
                                        <form id="js-login" novalidate="" action="intel_analytics_dashboard.html">
                                            <div class="form-group row">
                                                <label class="col-xl-12 form-label" for="fname"><?=dil2("Adınız ve Soyadınız")?></label>
                                                <div class="col-6 pr-1">
                                                    <input type="text" id="fname" class="form-control" placeholder="Adınız" required>
                                                    <div class="invalid-feedback"><?=dil2("Bu alanı doldurunuz")?></div>
                                                </div>
                                                <div class="col-6 pl-1">
                                                    <input type="text" id="lname" class="form-control" placeholder="Soyadınız" required>
                                                    <div class="invalid-feedback"><?=dil2("Bu alanı doldurunuz")?></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="emailverify"><?=dil2("Email adresiniz")?></label>
                                                <input type="email" id="emailverify" class="form-control" placeholder="Email" required>
                                                <div class="invalid-feedback"><?=dil2("Bu alanı doldurunuz")?></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="emailverify"><?=dil2("Telefon numaranız")?></label>
                                                <input type="tel" id="emailverify" class="form-control" placeholder="Telefon" required>
                                                <div class="invalid-feedback"><?=dil2("Bu alanı doldurunuz")?></div>
                                            </div>
                                            
                                            <div class="row no-gutters">
                                                <div class="col-md-3 ml-auto text-right">
                                                    <button id="js-login-btn" type="submit" class="btn btn-block btn-danger btn mt-3"><?=dil2("Gönder")?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-block text-center text-white">
                            2019 © OtoKonfor A.Ş &nbsp;<a href='http://www.otokonfor.com' class='text-white opacity-40 fw-500' title='otokonfor.com' target='_blank'>otokonfor.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="smartadmin/js/vendors.bundle.js"></script>
        <script src="smartadmin/js/app.bundle.js"></script>
        <script src="smartadmin/js/miscellaneous/lightgallery/lightgallery.bundle.js"></script>
        <script>
            $("#js-login-btn").click(function(event) {
                var form = $("#js-login")
                if (form[0].checkValidity() === false){
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.addClass('was-validated');
            });
        </script>
    </body>
</html>
