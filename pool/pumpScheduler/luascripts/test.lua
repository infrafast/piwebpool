function run()
    -- value=0;
    print("\n{FROM LUA");
    --print ("setFiltration=" .. value);
    --set(filtration,value);
    -- set(traitement,1);
    -- filtre = get(filtration);
    print ("toto=" .. toto);
    print ("filtration=" .. filtration);
    print ("traitement=" .. traitement);
    if filtration == 0 then
            filtration = 1
    elseif filtration == 1 then
            filtration = 0
    end
    toto="LUA";
    print ("END LUA}\n");

    return;
end