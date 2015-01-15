<div class="container minh">
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">借阅记录</div>
                <!-- Table -->
                <style>
                    label {
                    	width: 100px;
                    	display: inline-block;
                    	text-align: right;
                    	padding-right: 10px;
                    }
                    .form-control {
                    	display: inline-block;
                    	width: 400px;
                    }
                </style>
                <div style="margin: 30px;line-height:40px;">
                    <form action="<?=base_url()?>admin/updateInfo" method="post">
                        <input type=hidden class="form-control" value="<?=$info['bid']?>" name="bid"/>
                        <input type=hidden class="form-control" value="<?=$info['cid']?>" name="cid"/>
                        <input type=hidden class="form-control" value="<?=$info['borrow']?>" name="borrow"/>
                        <input type=hidden class="form-control" value="<?=$info['pic']?>" name="pic"/>
                        <label>书名</label>
                        <input type=text class="form-control" value="<?=$info['name']?>" name="name"/>
                        <br />
                        <label>作者</label>
                        <input type=text class="form-control" value="<?=$info['author']?>" name="author"/>
                        <br />
                        <label>出版社</label>
                        <input type=text class="form-control" value="<?=$info['press']?>" name="press"/>
                        <br />
                        <label>ISBN</label>
                        <input type=text class="form-control" value="<?=$info['ISBN']?>" name="ISBN"/>
                        <br />
                        <label>单价</label>
                        <input type=text class="form-control" value="<?=$info['price']?>" name="price"/>
                        <br />
                        <label>库存</label>
                        <input type=text class="form-control" value="<?=$info['stock']?>" name="stock"/>
                        <br />
                        <button type="submit" class="btn btn-primary" style="margin-left: 100px;">　修改　</button>
                    </form>
                </div>
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
