<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Panel heading</div>
                <div class="panel-body">
                    <p>...</p>
                </div>
                <!-- Table -->
                <table class="table">
                    ...
                </table>
            </div>
        </div>
        <div class="col-md-3 col-md-pull-9">
            <ul class="list-group">
                <?php 
                    if ($category)
                    {
                        foreach ($category as $row)
                        {
                            echo    "<li class='list-group-item'>
                                        <span class='badge'>". $row['num']. "</span>".
                                            $row['name'].
                                    "</li>";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</div>

