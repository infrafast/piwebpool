function run()
set(filtration,(not (get(filtration))));
set(traitement,(not (get(traitement))));
sms((temperature));
return "OK LUA";
end