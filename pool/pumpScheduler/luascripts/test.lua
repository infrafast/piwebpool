function run()
    filter=getZ(filtration);
    traite=get(traitement);

    if (filter == 0) then
        set(filtration,1);
    else
        set(filtration,0);
    end

    if (traite == 0) then
        set(traitement,1);
    else
        set(traitement,0);
    end
    return "OK LUA";
end