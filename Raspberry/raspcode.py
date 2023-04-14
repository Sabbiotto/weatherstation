import adafruit_dht
import time
import mysql.connector
from mysql.connector import Error

sensor = adafruit_dht.DHT11(23)

def dbConnection(hostName, userName, userPassword, dbName):
    connection = None
    try:
        connection = mysql.connector.connect(
            host=hostName,
            user=userName,
            passwd=userPassword,
            database=dbName
        )
    except Error as e:
        print(f"The error '{e}' occurred")

    return connection

def insert(temperature, humidity):
    connection = dbConnection("localhost", "root", "pwd-G0", "weatherstation")
    cursor = connection.cursor()
    query = "INSERT INTO data (temperature, humidity) VALUES (%s, %s)" % (temperature, humidity)
    cursor.execute(query)
    connection.commit()
    print(cursor.rowcount, "Record inserted successfully into sensor table")
    cursor.close()

def select():
    try:
        connection = dbConnection("localhost", "root", "pwd-G0", "weatherstation")
        cursor = connection.cursor(buffered=True)
        query = "SELECT value FROM settings WHERE name = 'time'"
        cursor.execute(query)
        connection.commit()
        record = cursor.fetchall()  
        cursor.close()
        print(record[0][0])
    except Error as e:
        print(f"The error '{e}' occurred")
    return record[0][0]
    
while True:
    try:      
        sensorTime=select()
        temperature = sensor.temperature
        humidity = sensor.humidity
        print("Temp: {} C° Humidity: {}% ".format( temperature, humidity))
        print("Inserting data into database...")
        insert(temperature, humidity)
        
    except RuntimeError as error:
        print(error.args[0])
        time.sleep(5.0)
        continue
    
    except Exception as error:
        sensor.exit()
        raise error
    
    time.sleep(sensorTime)




