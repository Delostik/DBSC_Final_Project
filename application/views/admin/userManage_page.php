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
        </div>
    </div>
</div>

