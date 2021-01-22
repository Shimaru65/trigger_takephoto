import serial
import RPi.GPIO as IO 
import json
import time 
import requests

ser = serial.Serial(
	port = '/dev/ttyACM0', #�Դ serial port ����������͡��ͧ cognex ��� ���ǵ�駤���������ö��ҹ��Ҩҡ���ͧ���
	baudrate = 9600,
	parity = serial.PARITY_NONE,
	bytesize = serial.EIGHTBITS,
	timeout = 1,
	dsrdtr = True, #�Դ���� dsrdtr ���������ͧ�觤����
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
		  r = requests.post(url,json=qrcode) #�觤�� requests 仵�� URL ���к� type �� Json
		  print(r.status_code) 
		  if r.status_code == 200:  # code 200 ���������� ��� print ��ҷ�����Ѻ��
		    print(r.text)
		  else: 
		    print('no')
		else:
		  print('no data read')
	 
