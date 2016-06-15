function run()
    retour=email('hello world from lua');
    retour=log("ceci est un log");
    retour=sms("sent sms");
    return retour;
end