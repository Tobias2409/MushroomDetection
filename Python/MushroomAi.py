from fastai.vision.all import *

def getLabelFromFile(name):
  return name.split("_")[0]

learner = load_learner("MushroomAi.pkl", cpu=True, pickle_module=pickle)
print(learner.predict(input()))