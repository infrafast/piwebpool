function run()
    print("\n{FROM LUA");
    filter=get(filtration);
    traite=get(traitement);
    set(filtration,value);
    set(traitement,1);
    filtre = get(filtration);
    print ("filtration=" .. filtration);
    print ("traitement=" .. traitement);
    print ("END LUA}\n");

    return;
end