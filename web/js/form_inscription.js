$(document).ready(function(){




    /*
     *
     *   Les glissements de cadres dans le form inscription
     *
     */

    var etape =1; // etape en cour (ca peut servir plus tard)
    $(".insc_btnSuivant").each(function(i){
        $(this).click(function(){

            if(i <= 2){
                etape++;
                var glissade = ((i+1) * 540);

                $("#translider").stop().animate({
                    left:-glissade+"px"
                },400,"easeOutQuad");
            }
            // console.log("etape " + etape);
        })
    });

    $(".insc_btnPrecedent").each(function(i){
        $(this).click(function(){
            if(i >= 0){
                etape--;
                var glissade = (i * 540);
                $("#translider").stop().animate({
                    left:-glissade+"px"
                },400,"easeOutQuad");
            }
            // console.log("etape " + etape);
        })
    });


     /*
     *
     *   Le captcha
     *
     */
    $('.QapTcha').QapTcha({disabledSubmit:true,autoRevert:true});
})