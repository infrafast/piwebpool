function run()
    retour='OK';
    if not email('hello world from lua') then 
        retour='EMAIL ERROR';
    end
end