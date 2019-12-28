<link rel="stylesheet" href="botui-master/build/botui.min.css" />
<link rel="stylesheet" href="botui-master/build/botui-theme-default.css" />
<script src="https://cdn.jsdelivr.net/vue/latest/vue.min.js"></script>
<script src="botui-master/build/botui.min.js"></script>


    <div id="my-botui-app">
        <bot-ui></bot-ui>
    </div>



<script>
    var botui = new BotUI('my-botui-app');

    // first ist true beim ersten Aufruf
    function askWhatToDo(first){
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
                    text: "Empfehlung",
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
            return botui.message.add({
                delay: 2500,
                content: "sollten wir mal implementieren"
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
             delay: 2500,
             content: 'Schön, dass du hier bist ' + res.value + ' wie kann ich weiter helfen?'
         });
    }).then(function(){
        askWhatToDo(true);
    });




</script>
