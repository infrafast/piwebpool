function run()
    retour="";

filter = get(filtration);

if filter == 0 and (temperature) < 28 then
  log('La pompe est à l\'arret et la temperature sous 28°');
end
if (temperature) < 4 then
  set(filtration,(1));
  log('Risque de gel, temperature =');
  log((temperature));
  log('Mise en route de la pompe');
end


    return retour;
end