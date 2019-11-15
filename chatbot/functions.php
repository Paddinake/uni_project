<?php

function chatinput($input){
    if (preg_match('(hi|hallo|gude)',strtolower($input))===1){
        return array("Hallo ich bin der Chatbot,wie kann ich dir helfen?", "null");
    }
    if (preg_match('(welche kaufen|was kaufen| etwas empfehlen|was soll ich kaufen)',strtolower($input))===1) {
        return array("Stöber doch mal hier nach ein paar Aktien <a href='index.php?content=analysen'>Analysen</a></br> oder
lass dich im Forum inspirieren <a href='index.php/content=forum'>Forum</a><br>
suche doch direkt hier nach einer Aktie:<form autocomplete='off' action='index.php' method='get'>
    <input type='hidden' name ='content' value='analysen'>
    <div class='autocomplete' style='width:300px; float:right;'>
        <input id='myInput' type='text' name='symbol' placeholder='Name der Aktie'>
    </div>
    <input style='float:right;' type='submit'>
</form>", "searchStock");
    }
    if (preg_match('(Name ändern | Account löschen | Account)',strtolower($input))===1) {
        return array("Alle Einstellungen zu deinem Account kannst du unter <a href='index.php?content=settings'> Einstellungen </a>");
    }
    else{
        return array("ich hab dich nicht verstanden",null);
    }

}
