<?php
?>
<script>
    $(document).ready(function() {
        $("#showChat").click(function () {
            $("#chatbot").toggle();
        });
    });
</script>
<style>
    .answer{
        min-height: 50px;
        padding-top: 5px;
        padding-left: 30px;
        text-align: right;
        color:blue;
    }
    #showChat {
        position:absolute;
        bottom:0;
        right:0;
    }
    #chatbot{
        border:2px solid black;
        position:absolute;
        bottom:17%;
        right:10%;
    }
</style>

<input id="showChat" type="image" src="chatbot/chatbot.PNG"/>

<div class="chatbot" id ="chatbot" hidden>
    <div class="chatbot-output" id="chatbot-output">

    </div>
    <br>

    <div class="chatbot-input" style="border:1px solid black; padding-left: 10px; padding-right: 10px;">
        <input type="textarea" id="chat" placeholder="Nachricht an den Chatbot">
        <button onclick="send()"> send</button>
    </div>
</div>

<script>

    function send(){
        var input = $('#chat').val();
        $('#chatbot-output').append("<div class='question'>"+input+"<div>");

        jQuery.ajax({
            type: "POST",
            url: 'chatbot/ajaxHandler.php',
            dataType: 'json',
            data: {functionname: 'main', arguments: [input]},

            success: function (obj) {
                if (!('error' in obj)) {
                    $('#chatbot-output').append("<div class='answer'>"+obj['result'][0]+"</div>");
                    $('#chat').val('');

                    if ($('#chatbot-output').find('div').length>=6) {
                        $('#chatbot-output').find('div').first().remove();
                    }


                }
            }
        });
    }


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


</script>
