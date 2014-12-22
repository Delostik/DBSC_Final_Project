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
                            <th width=50px>#</th>
                            <th width=350px>书名</th>
                            <th width=80px>单价</th>
                            <th width=70px>库存</th>
                            <th width=80px>借阅次数</th>
                            <th>借阅记录</th>
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
        </div>
    </div>
</div>

