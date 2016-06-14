function run()
    print("\n{FROM LUA");

    filter=get(filtration);
    traite=get(traitement);

    if (filter == 0) then
        set(filtration,1);
    else
        set(filtration,0)
    end

    set(filtration,value);
    set(traitement,1);


    print ("END LUA}\n");

    return;
end