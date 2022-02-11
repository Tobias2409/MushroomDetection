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
              print("../" + data)
              if not data:
                  break
              print(learner.predict("../" + data)[0]);
              conn.sendall(bytes("" + learner.predict("../" + data)[0], "utf-8"))

