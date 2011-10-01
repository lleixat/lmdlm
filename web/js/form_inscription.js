$(document).ready(function(){
    $(".insc_btnSuivant").each(function(i){
        $(this).click(function(){

            if(i <= 2){

                var glissade = ((i+1) * 540);

                $("#translider").stop().animate({
                    left:-glissade+"px"
                },800,"easeOutQuad");
            }

        })
    });

    $(".insc_btnPrecedent").each(function(i){
        $(this).click(function(){
            if(i >= 0){
                var glissade = (i * 540);
                $("#translider").stop().animate({
                    left:-glissade+"px"
                },800,"easeOutQuad");
            }
        })
    });
})