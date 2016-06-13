function run()
    print("\n{FROM LUA");
    print(filtration);
    set(filtration,1);
    set(traitement,1);
    filtre = get(filtration);
    print ("getFiltration=" .. filtre);
    print ("END LUA}\n");
    
    return;
end