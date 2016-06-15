function run()
    if not email('hello world from lua') then retour="email fail" end
    if not log("ceci est un log")  then retour="log fail" end
    if not retour=sms("sent sms")  then retour="sms fail" end
    return retour;
end