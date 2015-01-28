def median(mylist):
#---------------------------------------------------------------------------------------------
# calcule la médiane d'une liste
#---------------------------------------------------------------------------------------------           
    sorts = sorted(mylist)
    length = len(sorts)
    if not length % 2:
        return (sorts[length / 2] + sorts[length / 2 - 1]) / 2.0
    return sorts[length / 2]


def LectureDistanceMoyenne(GPIO_TRIGGER,GPIO_ECHO,nbMesures):
#---------------------------------------------------------------------------------------------
# Mesure de distance à partir du capteur HC-sr04
# nbMesure : un nb entier qui correspond au nb de mesure à faire pour déterminer une seul valeure
# plus ce nb est élevé, plus la précision augmente mais plus le temps de mesure est long.
# principe : on fait nbMesure. On met chaque résultat dans une liste.
# on retire la valeur la plus petite (j'ai constaté que de temps à autre, on a une valeur nettement trop faible
# puis, on prend la valeur la plus petite. L'idée étant que lorsque la CPU travaille trop,
# on sort un peu tard de la boucle while 
#------------------------------------------------------------------------------------------------ 
    liste=[]
    # je fais autant de mesures que demandée et je les place dans liste
    for i in range(nbMesures):
        liste.append(LectureDistance(GPIO_TRIGGER,GPIO_ECHO))

    distance =median(liste)
    return distance
	
def LectureDistance(GPIO_TRIGGER,GPIO_ECHO):
#------------------------------------------------------
# Mesure de distance à partir du capteur HC-sr04
#------------------------------------------------------    
    # Use BCM GPIO references
    # instead of physical pin numbers
    GPIO.setmode(GPIO.BCM)
    # Set pins as output and input
    GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
    GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo

    # Set trigger to False (Low)
    GPIO.output(GPIO_TRIGGER, False)

    # La doc indique de mettre au moins 60ms entre deux "pulse to triger"
    time.sleep(0.06)

    # Send 10us pulse to trigger. cela déclenche une demande de mesure.
    GPIO.output(GPIO_TRIGGER, True)
    time.sleep(0.00001)
    GPIO.output(GPIO_TRIGGER, False)
    start = time.time()

    #while GPIO.input(GPIO_ECHO)==0:
    #    continue
    #start = time.time()

    #while GPIO.input(GPIO_ECHO)==1:
    #    continue
    #stop = time.time()

	while (GPIO.input(GPIO_ECHO)==0 and time.time()-start<0.01):
        # Facultatif 0.00005 seconde correspond à une distance de 0.85 cm donc négligable
        # mais permet ainsi au CPU d'etre un peu libéré. Un peu seulement...
        time.sleep(0.00005) 
        continue
    start = time.time()
    #on récupère ainsi l'heure d'envoie du signal par le capteur
    while (GPIO.input(GPIO_ECHO)==1 and time.time()-start<0.01):
        time.sleep(0.00005)
        continue
    stop = time.time()	

    # Calculate pulse length
    elapsed = stop-start

    # Distance pulse travelled in that time is time
    # multiplied by the speed of sound (cm/s)
    distance = elapsed * 34000

    # That was the distance there and back so halve the value
    distance = distance / 2

    GPIO.cleanup()
    return distance