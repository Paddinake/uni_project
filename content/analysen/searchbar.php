<?php
?>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="content/analysen/stocks.js"></script>

<script>
        $(function() {
            $( "#symbols" ).autocomplete({
                autoFocus: true,
                source: stocks
            });
        });
</script>

<form action="" method="get">
    <div class = "ui-widget">
        <label for = "symbols">Aktien: </label>
        <input type="hidden" name="content" value="analysen">
        <input id = "symbols" name="symbol" class="text-uppercase">
            <input type="submit" value="Submit">
    </div>
</form>
