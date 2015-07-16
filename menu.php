

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    function show_cmt(dish_id) {
        $.post("fetchComment.php", {dish_id: dish_id},
            function (data, status) {
                $("#" + dish_id).next(".collapse").find(".comment-content").html(data);
            })
    }
    $(document).ready(function () {
        $(".menu_items").on("click", function () {

            $(this).css("background-color", "#FFCC99").find("input[name='menu']").attr("checked", "checked");
            $(this).find(".glyphicon-ok").removeClass("hide");
            $(this).siblings(".menu_items").css("background-color", "#FFFFFF").find(".glyphicon-ok").addClass("hide");
            $(this).siblings(".menu_items").find("input[name='menu']").removeAttr("checked");
        }).on("mouseover", function () {
            $(this).css({"cursor": "hand"});
        }).on("mouseout", function () {
            $(this).css({"cursor": "pointer"});
        });
        $(".collapse").hide();
        $(".comment").click(function (e) {
            e.stopPropagation();

            if ($(this).parents(".menu_items").next('.collapse').css("display") == 'none') {
                show_cmt($(this).parents(".menu_items").attr("id"));
            }

            $(this).parents(".menu_items").next('.collapse').delay(50).slideToggle();

        });
        $(".well").click(function (e) {
            e.stopPropagation();
        });
        $(".order_submit").click(function(){
            var dish_id = $("input:checked").parents(".menu_items").attr("id");
            $.post("func-order.php", {
                dish_id:dish_id
            },function(data,status){
                $(".content").load("orderFinish.php");
            });
        });
        $(".comment_submit").click(function () {
            var dish_id = $(this).parents(".collapse").prev(".menu_items").attr("id");
            var content = $(this).parents(".collapse").find("textarea").val();
            if (!content) {
                alert("评论不能为空哦~");
            } else {
                $.post("addcomment.php", {
                    dish_id: dish_id,
                    content: content
                }, function (data, status) {
                    alert(data);
                    show_cmt(dish_id);
                })
            }
            $(this).parents(".collapse").find("textarea").val("");
        })
    });
</script>
<div class="menu_title">
    <h1 style="text-align: center;color:#000033">今日菜单</h1>
    <hr/>
</div>
<div class="row">
    <form>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php
            include("conn.php");
            foreach ($dbh->query('SELECT * from menu where flag = 0') as $tmp) {
                ?>
                <div class="table-bordered menu_items" id="<?php echo $tmp[0] ?>">
                    <input class="sr-only" type="radio" name="menu" value="option"/>

                    <div class="row">
                        <div class="col-md-3">
                            <?php
                            if (!empty($tmp[2])) {
                                ?>
                                <img src="<?php echo $tmp[2] ?>" class="food_pic"/>
                                <?php
                            } else {
                                ?>
                                <img src="jpg\0.gif" class="food_pic"/>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-7">
                            <h4><?php echo $tmp[1] ?></h4><br/>

                            <p><?php echo $tmp[4] ?></p>
                        </div>
                        <div class="col-md-1">
                            <div class="badge" style="margin-top: 20px;">12人</div>
                            <button class="btn btn-primary comment" type="button">
                                <span class="glyphicon glyphicon-comment"></span>
                            </button>
                        </div>
                        <div class="col-md-1">
                            <span class="glyphicon glyphicon-ok hide" style="color:green;margin:10px;"></span>
                        </div>
                    </div>
                </div>
                <div class="collapse">
                    <div class="well show_comment">

                        <div class="row">
                            <div class="col-md-10">
                                <textarea name="content" rows="auto" cols="80" class="comment_form"></textarea>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary comment_submit" type="button">提交</button>
                            </div>
                        </div>
                        <hr/>
                        <div class="comment-content">
                        </div>
                    </div>
                </div>
                <?php
            }
            $dbh = null;
            ?>
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning order_submit" type="button" style="position: fixed;margin-top:200px;">
                就吃这个了！
            </button>
        </div>
    </form>
</div>