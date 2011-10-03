$(document).ready(function(){

    /*
     *
     *   Les glissements de cadres dans le form inscription
     *
     */

    // form insciption user
    var fiu = {
        etape : 1,
        error_verif : 0,
        debug : true,
        contenus : {
            1 : {
                nom : "utilisateur",
                champs : {
                    utilisateur : {
                        type: "texte",
                        id  : "insc_user",
                        min : 3,
                        max : 40
                    },
                    password :{
                        type: "texte",
                        id  : "insc_pass",
                        min : 6,
                        max : 17
                    },
                    passconf :{
                        type: "texte",
                        id  : "insc_pass2",
                        min : 6,
                        max : 17,
                        egal: "insc_pass"
                    },
                    mail :{
                        type: "mail",
                        id  : "insc_mail"
                    }
                }
            },
            2 : {
                nom : "avatar",
                champs : {
                    avatar : {
                        type: "fichier",
                        id  : 'insc_avatar',
                        extensions : ["jpg","png"]
                    }
                }
            },
            3 : {
                nom : "etablissement",
                champs : {
                    type_etab : {
                        type: "select",
                        id  : "insc_type_etab"
                    },
                    ville   :{
                        type: "texte",
                        id  : "insc_ville_etab",
                        min : 4
                    },
                    promo : {
                        type: "texte",
                        id  : "insc_promo_etab",
                        min : 3,
                        max : 50
                    }
                }
            }
        },
        etape_suivante : function(){
            if(this.etape < 4){
                if(this.verif()){
                    this.etape++;
                    this.glissement();
                }
            }
        },
        etape_precedente : function(){
            if(this.etape > 1){
                if(this.verif()){
                    this.etape--;
                    this.glissement();
                }
            }
        },
        glissement : function(){
            var distance = "-"+(this.etape-1)*540+"px"
            $("#translider").animate({left:distance},400,"easeOutQuad");
        },
        verif : function(){
            if(this.etape > 0 && this.etape < 4){
                this.error_verif = 0;
                // objet correspondant au contenu d'une etape
                var objetape = this.contenus[this.etape];
                this.debug && console.clear(),
                this.debug && console.log("Vérification de l'étape " + objetape.nom);
                for(var champ in objetape.champs){
                    this.debug && console.log("   Envoi broyeur " + champ);
                    this.broyeur(objetape.champs[champ]);
                }

                // y a t'il une ou des erreurs dans cette verif
                if(this.error_verif == 0)
                    return true;
                else
                    return false;
            } else if(this.etape == 4){
                return true;
            }
        },
        init_element : function(elem){
            $(elem).removeAttr("style");
        },
        broyeur : function(obj){

            var element = document.getElementById(obj.id);
            var error_element = this.error_verif;
            this.init_element(element);

            switch(obj.type){
                case "texte":
                    if(typeof obj.min != "undefined")
                        if(element.value.length < obj.min)
                            this.error_verif++;
                    if(typeof obj.max != "undefined")
                        if(element.value.length > obj.max)
                            this.error_verif++;
                    if(typeof obj.egal != "undefined")
                        if(element.value != document.getElementById(obj.egal).value)
                            this.error_verif++;
                    break;
                case "select":
                    if(element.value == 0)
                        this.error_verif++;
                    break;
                case "mail":
                    var regExpMail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');
                    if(!regExpMail.test(element.value))
                        this.error_verif++;
                    break;
                case "fichier":
                    if(typeof obj.extensions == "object" && obj.extensions.length > 0){
                        var tab = element.value.split(".");
                        tab.reverse();
                        var extension = tab[0];
                        var good_ext = 0;
                        for(var ext in obj.extensions){
                            if(extension == obj.extensions[ext])
                                good_ext++;
                        }
                        if(good_ext == 0)
                            this.error_verif++;
                    }
                    break;
            }
            if(this.error_verif > error_element){
                this.signal(element.id);
            }
        },
        signal : function(id){
            this.debug && console.log("     signaler : " + id);
            var element = document.getElementById(id);
            $(element).animate({backgroundColor:"#04598F"},200);
        }
    }

    $(".insc_btnPrecedent").click(function(){fiu.etape_precedente();});
    $(".insc_btnSuivant").click(function(){fiu.etape_suivante();});










    /*
     *
     *   Le captcha
     *
     */
    $('.QapTcha').QapTcha({
        disabledSubmit:true,
        autoRevert:true
    });
})