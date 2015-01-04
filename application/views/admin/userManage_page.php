<script>

    $(document).ready(function() {
        $("#btn_addAdmin").css('cursor', 'pointer');
        $("#btn_addAdmin").click(function() {
            $("#addAdminPanel").toggle(200);
            event.stopPropagation();
        });
        $("#addAdminPanel").click(function(event) {
            event.stopPropagation();
        });
        $("body").click(function() {
        	$("#addAdminPanel").hide(200);
        });
    });
</script>

<div class="container minh">
    <style>
        .minh {
        	min-height: 450px;
        }
    </style>
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">详细信息</div>
                <!-- Table -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>uid</th>
                            <th>用户名</th>
                        </tr>
                    </thead>
                    <?php 
                        if ($users)
                        {
                            $cnt = 0;
                            foreach ($users as $row)
                            {
                                echo "<tr><td>". $row['uid']. "</td>
                                          <td>". $row['userName']. "</td>
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
                    if ($typeList)
                    {
                        foreach ($typeList as $row)
                        {
                            if ($pageType == $row['tid'])
                            {
                                $html = "<a class='list-group-item active' ";
                            }
                            else 
                            {
                                $html = "<a class='list-group-item' ";
                            }
                            $html .= "href='". base_url(). "admin/userManage/". $row['tid']. "'>
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
                <li class='list-group-item active' id="btn_addAdmin">添加管理员</li>
            </div>
            <div class="list-group">
                <a class='list-group-item active' href='<?=base_url()?>admin/addUser'>添加新用户</a>
            </div>
        </div>
    </div>
</div>
<div id="addAdminPanel">
    　<form action="<?=base_url()?>admin/do_addAdmin" method="post">
        <input type="text" class="form-control" name="uid" placeholder="用户uid">
        <button class="btn btn-primary" style="margin: 0;">　添加　</button>
    </form>
</div>
