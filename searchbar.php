    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
          rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script>
        $(function() {
            var stocks  =  [
                { label: 'Google', value: 'GOOG' },
                { label: 'Apple', value: 'AAPL' },
                { label: 'Siemens', value: 'SIEGY' },
                { label: 'Lufthansa', value: 'LHA.DE' }
            ];
            $( "#symbols" ).autocomplete({
                source: stocks
            });
        });
    </script>

<form action="searchbar.php" method="get">
    <div class = "ui-widget">
        <label for = "symbols">Aktien: </label>
        <input id = "symbols" name="symbols">
            <input type="submit" value="Submit">
    </div>
</form>
