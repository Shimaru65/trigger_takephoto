import serial
import RPi.GPIO as IO 
import json
import time 
import requests

ser = serial.Serial(
	port = '/dev/ttyACM0', #เปิด serial port ที่เชื่อมต่อกล้อง cognex ไว้ แล้วตั้งค่าให้สามารถอ่านค่าจากกล้องได่้
	baudrate = 9600,
	parity = serial.PARITY_NONE,
	bytesize = serial.EIGHTBITS,
	timeout = 1,
	dsrdtr = True, #เปิดโหมด dsrdtr เพื่อให้กล้องส่งค่าได้
	rtscts = False,
	xonxoff = True
)
IO.setmode(IO.BOARD) 
IO.setup(16,IO.IN)
while True:
	time.sleep(1)
	if IO.input(16) ==1:
		print(IO.input(16))
	else:
		time.sleep(0.1)
		a='1'
		ser.write(a.encode())
		time.sleep(0.1)
		barcode = ser.read(20)
		time.sleep(0.1)
		b = len(barcode)
		if b > 4:
		  qrcode = {'qrcode' : barcode}
		  url = "URL send to your file server to trig ip camera" #example http://195.157.45.97/fg2090/Takephoto/camera
		  r = requests.post(url,json=qrcode) #ส่งค่า requests ไปตาม URL โดยระบุ type เป็น Json
		  print(r.status_code) 
		  if r.status_code == 200:  # code 200 คือส่งสำเร็จ ให้ print ค่าที่ได้รับมา
		    print(r.text)
		  else: 
		    print('no')
		else:
		  print('no data read')
	 
