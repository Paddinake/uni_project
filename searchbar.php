    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
          rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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

<form action="analysen.php" method="get">
    <div class = "ui-widget">
        <label for = "symbols">Aktien: </label>
        <input id = "symbols" name="symbol">
            <input type="submit" value="Submit">
    </div>
</form>
