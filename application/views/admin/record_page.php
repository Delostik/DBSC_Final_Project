<script>
    function initField() {

    }
    
    $(document).ready(function() {
        $("#btn_addBook").css('cursor', 'pointer');
        $("#btn_addBook").click(function() {
            $("#addPanel").toggle(200);
            event.stopPropagation();
        });
        $("#addPanel").click(function(event) {
            event.stopPropagation();
        });
        $("body").click(function() {
        	$("#addPanel").hide(200);
        });
    });
</script>
<div class="container minh">
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">借阅记录</div>
                <!-- Table -->
                <table  class="table table-hover">
                    <thead>
                        <tr>
                            <th>流水号</th>
                            <th>借书人</th>
                            <th>借阅书名</th>
                            <th>借出时间</th>
                            <th>应还时间</th>
                            <th width=80px>借阅状态</th>
                        </tr>
                    </thead>
                    <?php 
                        if ($record)
                        {
                            foreach ($record as $row)
                            {
                                switch ($row['state'])
                                {
                                    case 0: $state = '<td class=td-gray>已还</td>';break;
                                    case 1: $state = '<td class=td-green>借阅中</td>';break;
                                    case 2: $state = '<td class=td-red>超时未还</td>';break;
                                }
                                echo "<tr><td>". $row['serial']. "</td>
                                          <td>". $row['userName']. "</td>
                                          <td>". $row['bookName']. "</td>
                                          <td>". $row['borrowtime']. "</td>
        	                              <td>". $row['returntime']. "</td>
                                          ". $state. "</tr>";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
        <div class="col-md-3 col-md-pull-9">
            <div class="list-group">
                <a class='list-group-item active' href='<?=base_url()?>admin/bookManage'>返回</a>
            </div>
        </div>
    </div>
</div>
<div id="addPanel">
</div>
