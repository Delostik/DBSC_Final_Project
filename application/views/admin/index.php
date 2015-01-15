<script>
    $(document).ready(function() {
        $('#search_btn').click(function() {
            window.location.assign("<?=base_url()?>admin?key=" + $("#keyword").val());
        })

    });
</script>

<div class="container minh center">
    <form>
        <style>
            .input-group {
            	width: 70%;
            	margin: 10px auto;
            }
        </style>
        <div class="input-group">
            <form>
                <input type="text" class="form-control" id="keyword" name="key" placeholder="输入借书用户名">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="search_btn">　　Go!　　</button>
                </span>
            </form>
        </div>
    </form>
    <hr />
    <div class="center">
        <table class="table table-hover" style="width: 800px;margin: 0 auto;">
            <thead>
                <th>书名</th>
                <th>借阅日期</th>
                <th>应还日期</th>
                <th>操作</th>
            </thead>
            <?php 
                if ($record)
                {
                    foreach ($record as $item)
                    {
                        echo "<tr><td>". $item['bookName']."</td><td>". $item['borrowtime']. "</td><td>". $item['returntime']. "</td><td><a href='". base_url(). "admin/returnBook/". $item['serial']. "'><button type='button' class='btn btn-default btn-xs'>　还书　</button></a></td></tr>";
                    }
                }
            ?>
        </table>
    </div>
</div>