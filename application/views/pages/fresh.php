<div class="container center">
<div class="book-container">
    <?php 
        if ($newBook)
        {
            foreach ($newBook as $row)
            {
                echo    "<div class='book-grid'>
                            <div class='book-cover'>
                                <img src='". base_url(). "cover/". $row['pic']. "'/>
                            </div>
                            <div class='book-intro'>
                                <div class='book-title'>". $row['name']. "</div>
                                <hr />
                                    <div class='book-info-detail-line'>". $row['author']. "</div>
                                        <div class='book-info-detail-line'>". $row['press']. "</div>
                                        <div class='book-info-detail-line'>库存：". $row['stock']. "本</div>
                                        <div class='book-info-detail-line'>借阅：". $row['borrow']. "次</div>
                                        <div class='book-info-detail-line'>评分</div>
                                        <div class='book-borrow'>";
                if ($row['stock'])
                {
                    echo                "<button type='button' class='btn btn-primary'><strong>　借阅　</strong></button>";
                }
                else
                {
                    echo                "<button type='button' class='btn btn-danger'><strong>可借日期</strong></button>";
                }
                echo                "</div>
                            </div>
                        </div>";
            }
        }
    ?>
</div>
</div>