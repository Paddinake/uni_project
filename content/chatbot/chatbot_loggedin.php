<link rel="stylesheet" href="botui-master/build/botui.min.css" />
<link rel="stylesheet" href="botui-master/build/botui-theme-default.css" />
<script src="https://cdn.jsdelivr.net/vue/latest/vue.min.js"></script>
<script src="botui-master/build/botui.min.js"></script>


<?php

include '../analysen/funcDB.php';
?>
<script type="text/javascript" src="../analysen/stocks.js"></script>
<script>
    function getNameForSymbol(symbol) {
        var name;
        for (var i = 0; i < stocks.length; i++) {
            if (stocks[i].value == symbol) {
                name = stocks[i].label;
            }
        }
        return name;
    }



</script>

    <div id="my-botui-app">
        <bot-ui></bot-ui>
    </div>





<script>
    var botui = new BotUI('my-botui-app');

    // first ist true beim ersten Aufruf
    function askWhatToDo(first){
        <?php
        $top5array = getTop5($mysqli);
        ?>
        var top1 = "<?php echo $top5array[0]?>";
        var name1 = getNameForSymbol(top1);
        var top2 = "<?php echo $top5array[1]?>";
        var name2 = getNameForSymbol(top2);
        var top3 = "<?php echo $top5array[2]?>";
        var name3 = getNameForSymbol(top3);
        var top4 = "<?php echo $top5array[3]?>";
        var name4 = getNameForSymbol(top4);
        var top5 = "<?php echo $top5array[4]?>";
        var name5 = getNameForSymbol(top5);

        if (!first){
            botui.message.add({
                loading:true,
                delay: 2000,
                content: "Ich hoffe das hat geholfen... kann ich dir sonst noch weiter helfen"
            });
        }

        return botui.action.button({
            action: [
                {
                    text: "Witz",
                    value: 0
                },
                {
                    text: "Nach Aktie Suchen",
                    value: 1
                },
                {
                    text: "Top 5 Suchen aktuell",
                    value: 2
                },
                {
                    text: "Ich würde gerne mit einem Experten reden",
                    value: 3
                }
            ]
        }).then(function(res){
        if(res.value==0){
            return botui.message.add({
                loading:true,
                delay: 2500,
                content: "Was haben Frauen und Tornados gemeinsam: Erst feucht, dann stürmisch" +
                    "und hinterher ist das Haus weg."
            });
        }
        else if(res.value==1){
            window.opener.website.location.href = "../../index.php?content=analysen";
        }
        else if(res.value==2){
            return botui.action.button({
                action: [
                    {
                        text: name1,
                        value: top1
                    },
                    {
                        text: name2,
                        value: top2
                    },
                    {
                        text: name3,
                        value: top3
                    },
                    {
                        text: name4,
                        value: top4
                    },
                    {
                        text: name5,
                        value: top5
                    }

                ]
            }).then(function(res){
                window.opener.website.location.href = "../../index.php?content=analysen&symbol="+res.value;
            });
        }
        else if(res.value==3){
            window.opener.website.location.href = "../../index.php?content=kontakt";
        }
    }).then(function(){
        askWhatToDo(false)
        });
    }

    botui.message.add({
        content: 'Hallo ich bin der Chatbot, wie heißt du?'
    }).then(function() {
        return botui.action.text({
            action: {
                placeholder: 'Name eintragen'
            }
        });
    }).then(function (res) {
        return botui.message.add({
             loading:true,
             // delay: 2500,
             content: 'Schön, dass du hier bist ' + res.value + ' wie kann ich weiter helfen?'
         });
    }).then(function(){
        askWhatToDo(true);
    });




</script>
