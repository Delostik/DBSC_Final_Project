<script>
    $(document).ready(function() {
        $('#search_btn').click(function() {
            url = "<?=base_url()?>searchapi?key=" + $("#keyword").val();
            $.get(url, function(data) {
                $('#search-result').html(data);
                console.log(data);
            });
        })

    });
</script>

<div class='container minh center'>
    <form>
        <style>
            .input-group {
            	width: 70%;
            	margin: 10px auto;
            }
        </style>
        <div class="input-group">
            <form>
                <input type="text" class="form-control" id="keyword">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="search_btn">　　Go!　　</button>
                </span>
            </form>
        </div>
    </form>
    <hr />
    <div class="book-container">
        <div id="search-result">
        
        </div>
    </div>
</div>