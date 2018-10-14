<!DOCTYPE html>
<html lang="{$ContentLocale}">
    <head>
        <% base_tag %>
        <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        $MetaTags(false)
        <link rel="shortcut icon" href="themes/police/images/favicon.ico" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="/resources/themes/police/css/layout.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i" />
    </head>
    <body>
    <% include Header %>
    <div role="main">
        $Layout
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    $Form
                </div>
            </div>
        </div>
    </div>
    <% include Footer %>
    </body>
</html>
