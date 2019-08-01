<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
        <link rel="stylesheet" href="dist/css/skins/all-skins.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <?php include 'public_header.php'; ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php'; ?>
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        权限错误
                    </h1>

                </section>
                <section class="content">
                  <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>

                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php'; ?>
            </footer>
            <aside class="control-sidebar control-sidebar-dark">
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>
                <div class="tab-content">
                    <div class="tab-pane" id="control-sidebar-home-tab"></div>
                </div>
            </aside>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/common.js"></script>
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script>
            //广告位筛选
            // $('input[name=\'filter_ad_position\']').autocomplete({
            //     'source': function (request, response) {
            //         $.ajax({
            //             url: '/index.php/advert/getPositionJson/'+$("#filter_ad_position").val(),
            //             dataType: 'json',
            //             success: function (json) {
            //                 response($.map(json, function (item) {
            //                     return {
            //                         label: item['ad_position_name'],
            //                         value: item['ad_position_id']
            //                     }
            //                 }));
            //             }
            //         });
            //     },
            //     'select': function (item) {
            //         $('input[name=\'position_id\']').val(item['value']);
            //         $('input[name=\'filter_ad_position\']').val(item['label']);
            //     }
            // });

            

             $('input[name=\'filter_ad_position\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Advert/autoPosition'); ?>'+'?position=' + request,
                                                        dataType: 'json',
                                                        success: function (json) {
                                                            response($.map(json, function (item) {
                                                            console.log(item);
                                                                return {
                                                                    label: item['ad_position_name'],
                                                                    value: item['ad_position_id']
                                                                }
                                                            }));
                                                        }
                                                    });
                                                },
                                                'select': function (item) {
                                                    $('input[name=\'filter_ad_position\']').val(item['label']);
                                                    $('input[name=\'position_id\']').val(item['value']);
                                                }
                                            });

            $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
                $(this).parent().remove();
            });

        </script>
        <script type="text/javascript">
            (function(){
                $('input:radio[name="ad_type"]').click(function(){
                    var type = $('input[name="ad_type"]:checked').val();
                    if(type == '2'){
                        $('#upfile').show();
                        $('#video_url').hide();
                        $('#content').hide();
                    }else if(type == '3'){
                        $('#upfile').hide();
                        $('#video_url').show();
                        $('#content').hide();
                    }else{
                        $('#upfile').hide();
                        $('#video_url').hide();
                        $('#content').show();
                    }
                });
            })()
        </script>
    </body>
</html>
