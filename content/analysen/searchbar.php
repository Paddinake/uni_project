    <script>
        var stocks  =  [
            { label: 'Google', value: 'GOOG' },
            { label: 'Apple', value: 'AAPL' },
            { label: 'Siemens', value: 'SIEGY' },
            { label: 'Lufthansa', value: 'LHA.DE' }
        ];
        $(function() {
            $( "#symbols" ).autocomplete({
                source: stocks
            });
        });
    </script>

<form action="index.php?content=analysen" method="get">
    <div class = "ui-widget">
        <label for = "symbols">Aktien: </label>
        <input type="hidden" name="content" value="analysen">
        <input id = "symbols" name="symbol">
            <input type="submit" value="Submit">
    </div>
</form>
