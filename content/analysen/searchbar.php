<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!--Make sure the form has the autocomplete function switched off:-->
<form autocomplete="off" action="index.php" method="get">
    <input type="hidden" name ="content" value="analysen">
    <input type="hidden" name="subanalyse" value="<?php echo $_GET["subanalyse"];?>">
    <div class="autocomplete" style="width:300px; float:right;">
        <input id="myInput" type="text" name="symbol" placeholder="Name der Aktie">
    </div>
    <input style="float:right;" type="submit">
</form>
<script>

    function autocomplete(inp) {
        var bestMatches;
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            jQuery.ajax({
                type: "POST",
                url: 'content/analysen/ajaxHandler.php',
                dataType: 'json',
                data: {functionname: 'JSONRequestSearch', arguments: ["SYMBOL_SEARCH", inp.value]},

                success: function (obj) {
                    if( !('error' in obj) ) {
                        bestMatches = obj.result;
                        var a, b, i, val = inp.value;

                        /*close any already open lists of autocompleted values*/
                        closeAllLists();
                        if (!val) { return false;}
                        currentFocus = -1;
                        /*create a DIV element that will contain the items (values):*/
                        a = document.createElement("DIV");
                        a.setAttribute("id", this.id + "autocomplete-list");
                        a.setAttribute("class", "autocomplete-items");
                        /*append the DIV element as a child of the autocomplete container:*/
                        inp.parentNode.appendChild(a);
                        /*for each item in the array...*/
                        for (i = 0; i < bestMatches.length; i++) {
                            /*create a DIV element for each matching element:*/
                            b = document.createElement("DIV");
                            /*make the matching letters bold:*/
                            //input value ist das Symbol
                            b.innerHTML = bestMatches[i][1];
                            b.innerHTML += "<input type='hidden' value='" + bestMatches[i][0] + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                            b.addEventListener("click", function(e) {
                                /*insert the value for the autocomplete text field:*/
                                inp.value = this.getElementsByTagName("input")[0].value;
                                /*close the list of autocompleted values,
                                 (or any other open lists of autocompleted values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }
                    else {
                        console.log(obj.error);
                    }
                }
            });

        });


        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInput"));
</script>
