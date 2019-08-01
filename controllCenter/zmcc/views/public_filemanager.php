<div id="filemanager" class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">图像管理器</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-5">								
                    <a id="button-parent" href="<?php echo $parent; ?>" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="上一级"><i class="fa fa-level-up"></i></a>
                    <a id="button-refresh" href="<?php echo $refresh; ?>" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="刷新"><i class="fa fa-refresh"></i></a>
                    <button type="button" id="button-upload" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="上传"><i class="fa fa fa-upload"></i></button>
                    <button type="button" id="button-folder" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="新目录"><i class="fa fa-folder"></i></button>
                    <button type="button" class="btn btn-danger" id="button-delete" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa fa-trash-o"></i></button>
                    <button type="button" class="btn btn-success" id="myinsertImage" data-toggle="tooltip" data-placement="top" title="使用"><i class="fa fa fa-check"></i></button>
                </div>
                <div class="col-sm-7">
                    <div class="input-group">
                        <input type="text" name="search" value="" placeholder="检索中....." class="form-control">
                        <span class="input-group-btn">
                            <button type="button" data-toggle="tooltip" title="" id="button-search" class="btn btn-primary" data-original-title="检索"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <hr />
            <?php foreach (array_chunk($images, 4) as $image) { ?>
                <div class="row">
                    <?php foreach ($image as $image) { ?>
                        <div class="col-sm-3 col-xs-6 text-center">
                            <?php if ($image['type'] == 'directory') { ?>
                                <div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
                                <label>
                                    <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
                                    <?php echo $image['name']; ?></label>
                            <?php } ?>
                            <?php if ($image['type'] == 'image') { ?>
                                <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
                                <label>
                                    <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
                                    <?php echo $image['name']; ?></label>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <br />
            <?php } ?>
        </div>
        <div class="modal-footer"><nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php echo $linklist; ?>
                </ul>
            </nav></div>

    </div>
</div>
<script type="text/javascript">

<?php 
echo "host='http://".$_SERVER['HTTP_HOST']."';";
if ($target && $target != "undefined") { ?>
        $('a.thumbnail').on('click', function (e) {
            e.preventDefault();

    <?php if ($thumb && $thumb != "undefined") { ?>
                $('#<?php echo $thumb; ?>').find('img').attr('src', $(this).find('img').attr('src'));
    <?php } ?>

            $('#<?php echo $target; ?>').val($(this).parent().find('input').val());

            $('#modal-image').modal('hide');
        });
<?php } else { ?>

        /*商品图片控制*/
        $('a.thumbnail').on('click', function (e) {
            //当前活动标签
            e.preventDefault();
            var currtab = $(".nav-tabs").find(".active").find("a").attr("href");
            if (currtab == "#tab_7") {
                var src = $(this).find('img').attr('src');
                var val = $(this).parent().find('input').val();
                var newImg = $("#productImage").clone();
                newImg.find(":input").val(val);
                newImg.find("img").attr('src', src);
                $("#productImageList").find("a").last().before(newImg);
                $('#modal-image').modal('hide');
                productSlide();
            }
        });
<?php } ?>

    var insertList = [];
    $('input[name^=\'path\']').click(function (e) {
        var currtab = $(".nav-tabs").find(".active").find("a").attr("href");
        if ($(this).is(':checked')) {
            if (currtab == "#tab_1") {
                insertList.push("/upload/image" + $(this).val());
            } else {
                insertList.push($(this).val());
            }
        } else {
            var delindex = insertList.indexOf($(this).val());
            if (delindex > -1) {
                insertList.splice(delindex, 1);
            }
        }
    });
//插入选中的图片
    $("#myinsertImage").click(function (e) {
        e.preventDefault();
        var currtab = $(".nav-tabs").find(".active").find("a").attr("href");
        console.log(insertList);
        if (currtab == "#tab_1") {//详情页
            if (insertList.length == 0) {
                return;
            } else {
                for (var x in insertList) {
                    $(".summernote").summernote('insertImage', host+insertList[x]);
                }
            }
            $('#modal-image').modal('hide');
        }
        if (currtab == "#tab_7") {//轮播图
            if (insertList.length == 0) {
                return;
            } else {
                for (var x in insertList) {
                    var newImg = $("#productImage").clone();
                    newImg.find(":input").val(insertList[x]);
                    newImg.find("img").attr('src', "/upload/image" +insertList[x]);
                    $("#productImageList").find("a").last().before(newImg);
                    productSlide();
                }
            }
            $('#modal-image').modal('hide');
        }
        insertList = [];
    })


    $('a.directory').on('click', function (e) {
        e.preventDefault();

        $('#modal-image').load($(this).attr('href'));
    });

    $('.pagination a').on('click', function (e) {
        e.preventDefault();

        $('#modal-image').load($(this).attr('href'));
    });

    $('#button-parent').on('click', function (e) {
        e.preventDefault();

        $('#modal-image').load($(this).attr('href'));
    });

    $('#button-refresh').on('click', function (e) {
        e.preventDefault();

        $('#modal-image').load($(this).attr('href'));
    });

    $('input[name=\'search\']').on('keydown', function (e) {
        if (e.which == 13) {
            $('#button-search').trigger('click');
        }
    });

    $('#button-search').on('click', function (e) {
        var url = '<?php echo site_url("FileManager/index"); ?>?directory=<?php echo $directory; ?>';

                var filter_name = $('input[name=\'search\']').val();

                if (filter_name) {
                    url += '&filter_name=' + encodeURIComponent(filter_name);
                }

<?php if ($thumb) { ?>
                    url += '&thumb=' + '<?php echo $thumb; ?>';
<?php } ?>

<?php if ($target) { ?>
                    url += '&target=' + '<?php echo $target; ?>';
<?php } ?>

                $('#modal-image').load(url);
            });
//--></script>
<script type="text/javascript"><!--
        $('#button-upload').on('click', function () {
        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

        $('#form-upload input[name=\'file[]\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function () {
            if ($('#form-upload input[name=\'file[]\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: '<?php echo site_url("FileManager/upload"); ?>?directory=<?php echo $directory; ?>',
                                        type: 'post',
                                        dataType: 'json',
                                        data: new FormData($('#form-upload')[0]),
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        beforeSend: function () {
                                            $('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                                            $('#button-upload').prop('disabled', true);
                                        },
                                        complete: function () {
                                            $('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
                                            $('#button-upload').prop('disabled', false);
                                        },
                                        success: function (json) {
                                            if (json['error']) {
                                                alert(json['error']);
                                            }

                                            if (json['success']) {
                                                alert(json['success']);

                                                $('#button-refresh').trigger('click');
                                            }
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                        }
                                    });
                                }
                            }, 500);
                        });

                        $('#button-folder').popover({
                            html: true,
                            placement: 'bottom',
                            trigger: 'click',
                            title: '文件夹名称',
                            content: function () {
                                html = '<div class="input-group">';
                                html += '  <input type="text" name="folder" value="" placeholder="文件夹名称" class="form-control">';
                                html += '  <span class="input-group-btn"><button type="button" title="新目录" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
                                html += '</div>';

                                return html;
                            }
                        });

                        $('#button-folder').on('shown.bs.popover', function () {
                            $('#button-create').on('click', function () {
                                $.ajax({
                                    url: '<?php echo site_url("FileManager/folder"); ?>?directory=<?php echo $directory; ?>',
                                                    type: 'post',
                                                    dataType: 'json',
                                                    data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
                                                    beforeSend: function () {
                                                        $('#button-create').prop('disabled', true);
                                                    },
                                                    complete: function () {
                                                        $('#button-create').prop('disabled', false);
                                                    },
                                                    success: function (json) {
                                                        if (json['error']) {
                                                            alert(json['error']);
                                                        }

                                                        if (json['success']) {
                                                            alert(json['success']);

                                                            $('#button-refresh').trigger('click');
                                                        }
                                                    },
                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                                    }
                                                });
                                            });
                                        });

                                        $('#modal-image #button-delete').on('click', function (e) {
                                            if (confirm('确定吗？')) {
                                                $.ajax({
                                                    url: '<?php echo site_url("FileManager/delete"); ?>?',
                                                    type: 'post',
                                                    dataType: 'json',
                                                    data: $('input[name^=\'path\']:checked'),
                                                    beforeSend: function () {
                                                        $('#button-delete').prop('disabled', true);
                                                    },
                                                    complete: function () {
                                                        $('#button-delete').prop('disabled', false);
                                                    },
                                                    success: function (json) {
                                                        if (json['error']) {
                                                            alert(json['error']);
                                                        }

                                                        if (json['success']) {
                                                            alert(json['success']);

                                                            $('#button-refresh').trigger('click');
                                                        }
                                                    },
                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                                    }
                                                });
                                            }
                                        });
</script>
