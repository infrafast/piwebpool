function run()
    print("\n{FROM LUA");

    filter=get(filtration);
    traite=get(traitement);

    if (filter == 0) then
        set(filtration,1);
    else
        set(filtration,0);
    end

    if (traite == 0) then
        set(traitement,1);
    else
        set(traitementA,0);
    end

    print ("END LUA}\n");

    return "OK LUA";
end