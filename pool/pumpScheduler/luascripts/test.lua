function run()
    value=0;
    print("\n{FROM LUA");
    print ("setFiltration=" .. value);
    set(filtration,value);
    set(traitement,0);
    filtre = get(filtration);
    print ("getFiltration=" .. filtre);
    print ("END LUA}\n");
    
    return;
end