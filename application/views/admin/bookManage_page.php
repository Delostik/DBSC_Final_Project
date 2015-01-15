<script>
    function upload() {
        $("#coverForm").submit();
    }
    
    $(document).ready(function() {
        $("#btn_addBook").css('cursor', 'pointer');
        $("#btn_addCategory").css('cursor', 'pointer');
        $("#btn_addBook").click(function(event) {
            $("#addBookPanel").toggle(200);
            $("#addCover").hide(200);
            $("#addCategoryPanel").hide(200);
            event.stopPropagation();
        });
        $("#btn_addCategory").click(function(event) {
            $("#addCategoryPanel").toggle(200);
            $("#addCoverPanel").hide(200);
            $("#addBookPanel").hide(200);
            event.stopPropagation();
        });
        $(".btn_addCover").click(function(event) {
            $("#addCoverPanel").toggle(200);
        	$("#addCategoryPanel").hide(200);
            $("#addBookPanel").hide(200);
            $("#bid").val($(this).attr('bid'));
            event.stopPropagation();
        });
        $("#addBookPanel").click(function(event) {
            event.stopPropagation();
        });
        $("#addCategoryPanel").click(function(event) {
            event.stopPropagation();
        });
        $("#addCoverPanel").click(function(event) {
            event.stopPropagation();
        });
        $("body").click(function() {
        	$("#addBookPanel").hide(200);
        	$("#addCategoryPanel").hide(200);
        	$("#addCoverPanel").hide(200);
        });

    });
</script>
<div class="container minh">
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">详细信息</div>
                <!-- Table -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width=50px>#</th>
                            <th width=350px>书名</th>
                            <th width=60px>单价</th>
                            <th width=50px>库存</th>
                            <th width=80px>借阅次数</th>
                            <th>借阅记录</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php 
                        if ($books)
                        {
                            $cnt = 0;
                            foreach ($books as $row)
                            {
                                echo "<tr><td>". ++$cnt. "</td>
                                          <td>". $row['name']. "</td>
                                          <td>". $row['price']. "</td>
                                          <td>". $row['stock']. "</td>
                                          <td>". $row['borrow']. "</td>
                                          <td><a href='". base_url(). "admin/record/". $row['bid']. "'><button type='button' class='btn btn-default btn-xs'>　查看　</button></a></td>
                                          <td><a href='#'><button type='button' class='btn btn-default btn-xs btn_addCover' bid='".$row['bid']."'>添加封面</button></a></td>
                                          <td><a href='". base_url(). "admin/modify/". $row['bid']. "'><button type='button' class='btn btn-default btn-xs'>修改信息</button></a></td>
                                      </tr>";
                                
                            }    
                        }
                    ?>
                </table>
            </div>
        </div>
        <div class="col-md-3 col-md-pull-9">
            <div class="list-group">
                <?php 
                    if ($category)
                    {
                        foreach ($category as $row)
                        {
                            if ($pageCid == $row['cid'])
                            {
                                $html = "<a class='list-group-item active' ";
                            }
                            else 
                            {
                                $html = "<a class='list-group-item' ";
                            }
                            $html .= "href='". base_url(). "admin/bookManage/". $row['cid']. "'>
                                        <span class='badge'>". $row['num']. "</span>".
                                            $row['name'].
                                    "</a>";
                            echo $html;
                        }
                    }
                ?>
            </div>
            <br />
            <div class="list-group">
                <li class='list-group-item active' id="btn_addBook">添加图书</li>
            </div>
            <div class="list-group">
                <li class='list-group-item active' id="btn_addCategory">添加类别</li>
            </div>
            
        </div>
    </div>
</div>

<div id="addBookPanel">
    <form action="<?=base_url()?>admin/do_addBook" method="post">
        <label>书名</label>
        <input type="text" class="form-control" name="name">
        <br />
        <label>类别</label>
        <select class="form-control" name="category">
            <?php 
                foreach ($category as $row)
                {
                    if ($row['name'] == '全部') continue;
                    echo "<option value=". $row['cid']. ">". $row['name']. "</option>";
                }
            ?>
        </select>
        <br />
        <label>出版社</label>
        <input type="text" class="form-control" name="press">
        <br />
        <label>作者</label>
        <input type="text" class="form-control" name="author">
        <br />
        <label>ISBN</label>
        <input type="text" class="form-control" name="ISBN">
        <br />
        <label>单价</label>
        <input type="text" class="form-control" name="price">
        <br />
        <label>库存</label>
        <input type="text" class="form-control" name="stock">
        <br />
        <p>添加图书成功后在管理页面上传封面</p>
        <button class="btn btn-primary" style="margin: 0;">添加</button>
    </form>
</div>
 
<div id="addCategoryPanel">
    　<form action="<?=base_url()?>admin/do_addCategory" method="post">
        <input type="text" class="form-control" name="name">
        <button class="btn btn-primary" style="margin: 0;">　添加　</button>
    </form>
</div>
 
<div id="addCoverPanel">
    <form action="<?=base_url()?>admin/do_addCover" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="coverForm">
        <input type="text" name="bid" id="bid" style="display:none"/>
        <button type="button" class="btn btn-primary">添加封面</button>
        <input type="file" name="userfile" size="20" style="opacity:0;position:relative;width:91px;height:34px;top:-34px;" onchange="javascript:upload();"/>
    </form>
</div>
 