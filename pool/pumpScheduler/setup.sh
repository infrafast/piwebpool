#!/bin/sh
pause(){
 echo press enter    
 sed -n q </dev/tty
}

pause

