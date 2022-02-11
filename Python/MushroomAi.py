from fastai.vision.all import *

def getLabelFromFile(name):
  return name.split("_")[0]

learner = load_learner("MushroomAi.pkl", cpu=True, pickle_module=pickle)

import socket

HOST = '127.0.0.1'  # Standard loopback interface address (localhost)
PORT = 65432        # Port to listen on (non-privileged ports are > 1023)

with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
    s.bind((HOST, PORT))
    s.listen()
    while True:
      conn, addr = s.accept()
      with conn:
          print('Connected by', addr)
          while True:
              data = conn.recv(1024).decode()
              if not data:
                  break
              print("../" + data)
              predict = learner.predict("../" + data)
              index = predict[1].item();
              print(predict[0] + " - " + ("{:.2f}".format(predict[2][index].item() * 100) + "%"))
              conn.sendall(bytes(predict[0] + " - " + ("{:.2f}".format(predict[2][index].item() * 100) + "%") , "utf-8"))

