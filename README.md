---------------------------------------------------------
# WELCOME TO PIWEB SWIMMING POOL MANAGER v0.9
---------------------------------------------------------

![measures](https://github.com/infrafast/piwebpool/raw/gh-pages/wiki/measures.png)

The first full open source Raspberry PI PHP web-based application that automates the control of swimming pool with following features:

    - real time water quality measurement (PH, ORP, Temperature)
    - controls up to 4 power outlets
    - history (graphs) of commands and measures
    - weather forecast 
    - recommendation / advise on water treatment
    - customizable notifications by email, sms or other channel throught standard API
    - scheduler that control filtration aoccrding to water temperature
    - can be controlled over your iPhone or any mobile device
    - provide unlimited configuratio capabilities with a graphical scripting front end, no need to know programming
    - notifications (SMS, email, or smartphone)
    - Interfaces with Domoticz and any other home automation system thru a simple HTTP API
    - Compatible with Smartphone browser and applications

    
    
---------------------------------------------------------
# LINKS
---------------------------------------------------------
SETUP: refer to [wiki setup page](https://github.com/infrafast/piwebpool/wiki/Setup)   
BUGS, TODO LIST and ROADMAP: refer to [github issues](https://github.com/infrafast/piwebpool/issues)   

-------------------------------------------------------------------
GIT AND SSH KEY USAGE QUICK GUIDE
-------------------------------------------------------------------
git status
git add -A .                 
git status
git commit -a -m "comment"   
git push origin master       

git tag -a v1.4 -m "my version 1.4"
git tag
git show v1.4

git push --follow-tags 
git push --tags                    push all tags 

git rm --cached <file>
------------------------------------------------

ssh-keygen -t rsa -b 4096 -C "info@infrafast.com"  
eval "$(ssh-agent -s)"   
ssh-add ~/.ssh/id_rsa  
more ~/.ssh/id_rsa.pub -> copy in github  
git clone git@github.com:infrafast/piwebpool.git  