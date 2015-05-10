<!doctype html>
<html lang="en">
<head>
    <meta name="robots" content="noindex, nofollow">
    <meta name="Googlebot" content="noindex, nofollow">

    <meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->title ?></title>
    <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>

    <meta name="keywords" content="<?= LN_SITE_KEYWORDS ?>">
    <meta name="author" content="Alexander Stoimenov">
    <meta name="description" content="<?= LN_SITE_DESCRIPTION ?>"/>

    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= $this->title ?>"/>
    <meta property="og:description" content="<?= LN_SITE_DESCRIPTION ?>"/>
    <meta property="og:image" content="http://littleninja.softuni-friends.org/ninjaProfile.png"/>
    <meta property="og:url" content="http://ln-blog.littleninja.softuni-friends.org<?= $_SERVER['REQUEST_URI'] ?>"/>
    <meta property="og:site_name" content="<?= LN_SITE_NAME ?>"/>
    <meta property="article:publisher" content="https://www.facebook.com/a.stoimenov91"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:description" content="<?= LN_SITE_DESCRIPTION ?>"/>
    <meta name="twitter:title" content="<?= $this->title ?>"/>
    <meta name="twitter:site" content="@astoimenov"/>
    <meta name="twitter:domain" content="<?= LN_SITE_NAME ?>"/>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/superhero/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../../styles/app.css"/>
    <link rel="stylesheet" href="../../../styles/underline.css"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
</head>
<body>
    <header>
        <?php include_once 'navigation.php'; ?>
    </header>
    <main id="main" class="container">
