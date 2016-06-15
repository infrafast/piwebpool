function run()
    if not email('hello world from lua') then 
        retour="email fail"; 
    end
    if not log("ceci est un log")  then 
        retour=retour .. "log fail"; 
    end
    if not sms("sent sms")  then 
        retour=retour .. "sms fail"; 
    end
    return retour;
end