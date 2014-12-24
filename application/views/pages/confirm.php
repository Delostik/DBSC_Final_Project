<script>
    $(document).ready(function() {
        $('#confirm').click(function() {
            $('#borrow-result').toggle(200);
            url = '<?=base_url()?>do_borrow/<?=$book['bid']?>';
            console.log(url);
            $.get(url, function(data) {
                if (data == 1) $('#borrow-result').html('借阅成功！');
                else $('#borrow-result').html('借阅失败，请稍后再试');
            });
        });
    });
</script>
<div class='container center minh'>
    <hr />
    <div class='borrow-confirm'>
        <div class='book-grid-lg'>
            <div class='book-cover-lg'>
                <img src='<?=base_url()?>cover/<?=$book['pic']?>'/>
            </div>
            <div class='book-intro-lg'>
                <div class='book-title-lg'><?=$book['name']?></div>
                <hr />
                <div class='book-info-detail-line-lg'><?=$book['author']?></div>
                <div class='book-info-detail-line-lg'><?=$book['press']?></div>
                <div class='book-info-detail-line-lg'>库存：<?=$book['stock']?>本</div>
                <div class='book-info-detail-line-lg'>借阅：<?=$book['borrow']?>次</div>
                <div class='book-info-detail-line-lg'>评分</div>
                <hr/>
                <div class='book-info-detail-line-lg' style="color:red;margin-bottom: 5px;">确认借阅后请在45分钟内到图书馆取书, 借阅时间为30天</div>
                <button type="button" class="btn btn-primary btn-lg" style="margin-left: 300px;" id="confirm"><strong>确认借阅</strong></button>
            </div>
        </div>
    </div>
    <hr/>
    <div class='center'>
        <h1 id="borrow-result">提交中……</h1>
    </div>
</div>

