<div class="container">
    <div class="jumbotron">
        <h1>iLibrary</h1>  
        <p>　　便捷的网上图书馆</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
    </div>
    <h3><strong>新书上架</strong></h3>
    <?php 
        if (isset($newBook))
        {
            foreach ($newBook as $row)
            {
                echo    "<div class='book-grid'>
                            <div class='book-cover'>";
                if ($row['pic']) echo "<img src='". base_url(). "cover/". $row['pic']. "'/>";
                else             echo "<img src='". base_url(). "cover/0.jpg'/>";
                echo       "</div>
                            <div class='book-intro'>
                                <div class='book-title'>". $row['name']. "</div>
                                <hr />
                                    <div class='book-info-detail-line'>". $row['author']. "</div>
                                        <div class='book-info-detail-line'>". $row['press']. "</div>
                                        <div class='book-info-detail-line'>库存：". $row['stock']. "本</div>
                                        <div class='book-info-detail-line'>借阅：". $row['borrow']. "次</div>
                                        <div class='book-info-detail-line'>评分</div>
                                        <div class='book-borrow'>";
                if (!$userName)
                {
                    echo                    "<button type='button' class='btn btn-info'><strong>请先登录</strong></button>";
                }
                else {
                    if ($row['stock'])
                    {
                        echo                "<a href='". base_url(). "confirm/". $row['bid']. "'><button type='button' class='btn btn-primary'><strong>　借阅　</strong></button></a>";
                    }
                    else
                    {
                        echo                "<button type='button' class='btn btn-danger'><strong>可借日期</strong></button>";
                    }
                }
                echo                "</div>
                                </div>
                            </div>";
            }
        }
    ?>
</div>