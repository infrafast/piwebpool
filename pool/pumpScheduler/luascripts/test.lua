function run()
    retour='OK';
    if email('hello world from lua')!=true then 
        retour='EMAIL ERROR';
    end
end